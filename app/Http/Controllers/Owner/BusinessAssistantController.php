<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use App\Services\OllamaService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BusinessAssistantController extends Controller
{
    /**
     * Mengambil data bisnis dan menghitung statistik menggunakan Laravel.
     */
    private function getBusinessData(): array
    {
        $today = now()->toDateString();
        $sevenDaysAgo = now()->subDays(6)->toDateString();

        $paidOrders = DB::table('orders')
            ->where('payment_status', 'paid')
            ->whereNotNull('paid_at')
            ->where('status', '!=', 'cancelled');

        // Penjualan hari ini
        $todaySales = (float) (clone $paidOrders)
            ->whereDate('paid_at', $today)
            ->sum('total');

        $todayTransactions = (int) (clone $paidOrders)
            ->whereDate('paid_at', $today)
            ->count();

        // Penjualan tujuh hari
        $weeklySales = (float) (clone $paidOrders)
            ->whereDate('paid_at', '>=', $sevenDaysAgo)
            ->sum('total');

        $weeklyTransactions = (int) (clone $paidOrders)
            ->whereDate('paid_at', '>=', $sevenDaysAgo)
            ->count();

        // Rata-rata harian berdasarkan tujuh hari kalender
        $dailyAverage = $weeklySales / 7;

        // Rata-rata nilai setiap transaksi
        $transactionAverage = $weeklyTransactions > 0
            ? $weeklySales / $weeklyTransactions
            : 0;

        // Penjualan harian selama tujuh hari
        $dailySales = collect(range(6, 0))
            ->map(function ($daysAgo) use ($paidOrders) {
                $date = now()->subDays($daysAgo);

                $sales = (float) (clone $paidOrders)
                    ->whereDate('paid_at', $date->toDateString())
                    ->sum('total');

                $transactions = (int) (clone $paidOrders)
                    ->whereDate('paid_at', $date->toDateString())
                    ->count();

                return [
                    'tanggal' => $date->format('d-m-Y'),
                    'penjualan' => $sales,
                    'transaksi' => $transactions,
                ];
            })->values()->toArray();

        // Performa dine-in dan takeaway
        $orderTypes = (clone $paidOrders)
            ->whereDate('paid_at', '>=', $sevenDaysAgo)
            ->select(
                'order_type',
                DB::raw('COUNT(*) as total_transactions'),
                DB::raw('SUM(total) as total_sales')
            )
            ->groupBy('order_type')
            ->get()
            ->map(function ($item) {
                return [
                    'jenis_pesanan' => $item->order_type,
                    'jumlah_transaksi' => (int) $item->total_transactions,
                    'total_penjualan' => (float) $item->total_sales,
                ];
            })->values()->toArray();

        // Menu terlaris
        $bestSellers = DB::table('order_items')
            ->join('orders', 'orders.id', '=', 'order_items.order_id')
            ->where('orders.payment_status', 'paid')
            ->whereNotNull('orders.paid_at')
            ->where('orders.status', '!=', 'cancelled')
            ->whereDate('orders.paid_at', '>=', $sevenDaysAgo)
            ->select(
                'order_items.menu_name',
                DB::raw('SUM(order_items.quantity) as total_sold'),
                DB::raw('SUM(order_items.subtotal) as total_revenue')
            )
            ->groupBy('order_items.menu_name')
            ->orderByDesc('total_sold')
            ->limit(5)
            ->get()
            ->map(function ($item) {
                return [
                    'nama_menu' => $item->menu_name,
                    'jumlah_terjual' => (int) $item->total_sold,
                    'total_penjualan' => (float) $item->total_revenue,
                ];
            })->values()->toArray();

        // Total diskon
        $totalDiscount = (float) (clone $paidOrders)
            ->whereDate('paid_at', '>=', $sevenDaysAgo)
            ->sum('discount');

        return [
            'tanggal_analisis' => $today,

            'penjualan_hari_ini' => [
                'total_penjualan' => $todaySales,
                'jumlah_transaksi' => $todayTransactions,
            ],

            'penjualan_tujuh_hari' => [
                'total_penjualan' => $weeklySales,
                'jumlah_transaksi' => $weeklyTransactions,
                'rata_rata_penjualan_harian' => round($dailyAverage, 2),
                'rata_rata_nilai_transaksi' => round($transactionAverage, 2),
            ],

            'penjualan_harian' => $dailySales,
            'performa_jenis_pesanan' => $orderTypes,
            'lima_menu_terlaris' => $bestSellers,
            'total_diskon_tujuh_hari' => $totalDiscount,
        ];
    }


    /**
     * Analisis bisnis otomatis untuk tombol "Analisis Bisnis Sekarang".
     */
    public function analyze(OllamaService $ollama)
    {
        $businessData = $this->getBusinessData();

        $salesToday = (float) $businessData['penjualan_hari_ini']['total_penjualan'];
        $salesWeek = (float) $businessData['penjualan_tujuh_hari']['total_penjualan'];
        $transactionsToday = (int) $businessData['penjualan_hari_ini']['jumlah_transaksi'];
        $transactionsWeek = (int) $businessData['penjualan_tujuh_hari']['jumlah_transaksi'];

        $topMenus = collect($businessData['lima_menu_terlaris'])
            ->map(function ($menu) {
                return [
                    'nama' => $menu['nama_menu'] ?? 'Tidak diketahui',
                    'jumlah_terjual' => (int) ($menu['jumlah_terjual'] ?? 0),
                    'total_penjualan' => (float) ($menu['total_penjualan'] ?? 0),
                ];
            })->values()->all();

        $prompt = "Kamu adalah konsultan bisnis restoran Restoe Boemi.

Tugasmu hanya memberikan insight dan rekomendasi berdasarkan data yang disediakan Laravel.

DATA:
" . json_encode([
            'selisih_penjualan_hari_ini_dan_rata_rata_harian' =>
            round($salesToday - (float) $businessData['penjualan_tujuh_hari']['rata_rata_penjualan_harian'], 2),
            'transaksi_hari_ini' => $transactionsToday,
            'transaksi_tujuh_hari' => $transactionsWeek,
            'menu_terlaris' => $topMenus,
        ], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) . "

ATURAN:
- Jangan menuliskan nominal uang atau membuat angka baru.
- Jangan menghitung ulang data.
- Jangan menyebut data yang tidak tersedia.
- Jangan menganggap penjualan hari ini mewakili tren mingguan.
- Jangan menyarankan membuka atau mengembangkan menu yang sudah ada tanpa alasan dari data.
- Berikan maksimal 3 insight atau rekomendasi.
- Fokus pada menu terlaris dan peluang evaluasi bisnis.
- Jika transaksi atau data terbatas, jelaskan keterbatasannya.
- Gunakan bahasa Indonesia yang natural, profesional, dan ringkas.
- Jangan memberikan analisis di luar bisnis restoran.

FORMAT:
**Temuan**
Jelaskan maksimal 2 temuan berdasarkan data.

**Rekomendasi**
Berikan maksimal 3 tindakan yang realistis dan relevan.";

        try {
            $analysis = $ollama->chat($prompt);

            return response()->json([
                'success' => true,
                'data' => $businessData,
                'analysis' => $analysis,
            ]);
        } catch (\Throwable $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 503);
        }
    }

    /**
     * Tanya jawab AI berdasarkan data bisnis.
     */
    public function ask(Request $request, OllamaService $ollama)
    {
        $validated = $request->validate([
            'question' => ['required', 'string', 'min:3', 'max:500'],
        ]);

        $businessData = $this->getBusinessData();
        $question = $validated['question'];

        // Fakta dan angka disiapkan oleh Laravel, bukan AI.
        $orderTypes = collect($businessData['performa_jenis_pesanan']);

        $dineIn = $orderTypes->firstWhere('jenis_pesanan', 'dine_in');
        $takeaway = $orderTypes->firstWhere('jenis_pesanan', 'takeaway');

        $facts = [
            'total_penjualan_7_hari' => $businessData['penjualan_tujuh_hari']['total_penjualan'],
            'jumlah_transaksi_7_hari' => $businessData['penjualan_tujuh_hari']['jumlah_transaksi'],
            'dine_in' => [
                'transaksi' => $dineIn['jumlah_transaksi'] ?? 0,
                'penjualan' => $dineIn['total_penjualan'] ?? 0,
            ],
            'takeaway' => [
                'transaksi' => $takeaway['jumlah_transaksi'] ?? 0,
                'penjualan' => $takeaway['total_penjualan'] ?? 0,
            ],
            'lima_menu_terlaris' => $businessData['lima_menu_terlaris'],
        ];

        $prompt = "Kamu adalah konsultan bisnis restoran Restoe Boemi.

DATA FAKTA:
" . json_encode($facts, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) . "

PERTANYAAN OWNER:
{$question}

TUGAS:
Berikan interpretasi dan rekomendasi praktis berdasarkan data tersebut.

ATURAN:
- Jangan menuliskan angka penjualan atau jumlah transaksi.
- Jangan membuat nama menu sendiri.
- Jika menyebut menu, gunakan hanya nama dari data.
- Jangan menyatakan menu atau layanan tidak tersedia tanpa bukti.
- Jangan mengarang kondisi operasional restoran.
- Jangan menyimpulkan tren dari data satu periode.
- Jangan memberi saran tentang fasilitas, staf, atau kondisi restoran yang tidak ada di data.
- Berikan saran yang relevan dengan angka dan menu yang tersedia.
- Jawab singkat dalam bahasa Indonesia profesional.";

        try {
            $answer = $ollama->chat($prompt);

            return response()->json([
                'success' => true,
                'question' => $question,
                'data' => $businessData,
                'facts' => $facts,
                'answer' => $answer,
            ]);
        } catch (\Throwable $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 503);
        }
    }
}
