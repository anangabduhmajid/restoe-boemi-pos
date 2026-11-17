<x-app-layout>

    <!-- PAGE INTRO -->
    <section class="mb-10">

        <div class="flex flex-wrap items-end justify-between gap-5">

            <div>
                <p class="rb-label mb-3">
                    {{ now()->format('l, d F Y') }}
                </p>

                <h1 class="rb-serif text-3xl md:text-[42px] leading-tight">
                    Welcome back,<br>
                    {{ auth()->user()->name }}.
                </h1>

                <p class="text-sm text-[#76543A] mt-4">
                    Here's what's happening at Restoe Boemi today.
                </p>
            </div>

            <div class="flex items-center gap-3 border-l-2 border-[#710014] pl-4 py-1">
                <span class="w-2 h-2 rounded-full bg-green-700"></span>

                <div>
                    <p class="text-xs font-semibold">Store Operational</p>
                    <p class="text-[10px] text-[#76543A] mt-1">
                        Business overview
                    </p>
                </div>
            </div>

        </div>

        <div class="mt-8 border-t border-[#B38F6F]"></div>

        <div class="flex justify-between items-center mt-3">
            <p class="rb-label">Daily performance</p>

            <span class="text-[9px] uppercase tracking-widest text-[#710014] border border-[#B38F6F] px-3 py-1">
                Live Data
            </span>
        </div>

    </section>


    <!-- STATISTICS -->
    <section class="mb-14 grid min-w-0 grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-4">

        @foreach ($stats as $stat)

        <div class="min-w-0 rounded-2xl border border-[#E5D6C3] border-t-2 border-t-[#710014] bg-[#FFFDF8] p-4 shadow-sm">
            <p class="min-w-0 break-words text-xs font-semibold uppercase tracking-wide text-[#76543A]">
                {{ $stat['label'] }}
            </p>

            <p class="mt-4 min-w-0 break-words font-serif text-2xl text-[#161616] md:text-[27px]">
                {{ $stat['value'] }}
            </p>

            <p class="mt-2 break-words text-[11px] leading-5 text-[#76543A]">
                {{ $stat['description'] }}
            </p>

        </div>

        @endforeach


    </section>


    <!-- AI BUSINESS ASSISTANT -->
    <section id="business-assistant" class="mb-14">

        <div class="bg-[#F5EFE6] border border-[#B38F6F] rounded-sm p-6 md:p-8">

            <div class="flex flex-wrap justify-between items-start gap-5">
                <div>
                    <p class="text-[10px] uppercase tracking-[0.25em] text-[#710014] font-semibold">
                        Restoe Boemi Intelligence
                    </p>

                    <h2 class="rb-serif text-2xl md:text-3xl mt-3 text-[#211D1A]">
                        AI Business Assistant
                    </h2>

                    <p class="text-sm text-[#76543A] mt-3 max-w-xl">
                        Dapatkan insight penjualan dan rekomendasi bisnis
                        berdasarkan transaksi yang sudah dikonfirmasi.
                    </p>
                </div>

                <div class="flex items-center gap-2 text-xs text-[#76543A]">
                    <span class="w-2 h-2 rounded-full bg-green-700"></span>
                    Local AI · Ollama
                </div>
            </div>

            <div class="mt-7 border-t border-[#B38F6F] pt-6">

                <button
                    type="button"
                    id="analyzeBusinessButton"
                    class="bg-[#710014] hover:bg-[#570010] text-white px-6 py-3 text-xs uppercase tracking-widest font-semibold transition disabled:opacity-50">
                    Analisis Bisnis Sekarang
                </button>

                <p id="aiStatus" class="text-xs text-[#76543A] mt-4" aria-live="polite">
                    AI siap menganalisis data penjualan hari ini.
                </p>

                <div id="aiResult" class="hidden mt-6 bg-white border border-[#D8C5AE] p-5 md:p-7">
                    <div id="aiBusinessStats" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-7">
                    </div>
                    <div id="aiBusinessDetails"></div>
                    <p class="text-[10px] uppercase tracking-widest text-[#710014] font-semibold mb-4">
                        Business Insights · AI Recommendations
                    </p>


                    <div id="aiAnalysis" class="text-sm leading-7 text-[#211D1A] whitespace-pre-line"></div>
                </div>

                <!-- ASK AI -->
                <div class="mt-8 border-t border-[#B38F6F] pt-6">

                    <p class="text-[10px] uppercase tracking-widest text-[#710014] font-semibold mb-3">
                        Ask Your Business Assistant
                    </p>

                    <form id="aiQuestionForm" class="flex flex-col md:flex-row gap-3">
                        @csrf

                        <input
                            type="text"
                            id="aiQuestion"
                            name="question"
                            maxlength="500"
                            placeholder="Contoh: Menu apa yang paling laris hari ini?"
                            class="block w-full md:flex-1 min-w-0 h-12 border border-[#B38F6F] bg-white text-[#211D1A] px-4 py-3 text-sm placeholder:text-[#9B8875] focus:outline-none focus:ring-2 focus:ring-[#710014] focus:border-[#710014]" required>

                        <button
                            type="submit"
                            id="askAiButton"
                            class="bg-[#211D1A] hover:bg-[#710014] text-white px-6 py-3 text-xs uppercase tracking-widest font-semibold transition disabled:opacity-50">
                            Tanya AI
                        </button>
                    </form>
                    <div id="aiAnswerData" class="hidden mt-5 bg-[#F5EFE6] border border-[#D8C5AE] p-5">
                        <p class="text-[10px] uppercase tracking-widest text-[#710014] font-semibold mb-4">
                            Data Bisnis · 7 Hari Terakhir
                        </p>

                        <div id="aiAnswerFacts" class="grid grid-cols-1 sm:grid-cols-2 gap-4"></div>
                    </div>
                    <div id="aiAnswerBox" class="hidden mt-5 bg-white border border-[#D8C5AE] p-5" aria-live="polite">
                        <p class="text-[10px] uppercase tracking-widest text-[#710014] font-semibold mb-3">
                            AI Response
                        </p>

                        <div id="aiAnswer" class="text-sm leading-7 text-[#211D1A] whitespace-pre-line"></div>
                    </div>

                </div>

            </div>

        </div>

    </section>


    <!-- REVENUE AND BEST SELLERS -->

    <section class="grid grid-cols-1 xl:grid-cols-3 gap-10 mb-14">

        <!-- REVENUE -->
        <div class="xl:col-span-2">

            <div class="flex flex-wrap justify-between items-end border-b border-[#B38F6F] pb-4 mb-6">

                <div>
                    <p class="rb-label">Financial performance</p>

                    <h2 class="rb-serif text-2xl mt-2">
                        Revenue Overview
                    </h2>
                </div>

                <p class="text-[10px] text-[#76543A]">
                    Last 7 days
                </p>

            </div>

            <div class="flex items-end justify-between gap-3 h-52 border-b border-[#B38F6F] px-2">

                @foreach ($weeklyRevenue as $revenue)

                <div class="flex-1 h-full flex flex-col justify-end items-center">

                    <p class="text-[9px] text-[#76543A] mb-2 hidden sm:block">
                        {{ number_format($revenue['amount'] / 1000000, 1) }}M
                    </p>

                    <div
                        class="rb-chart-bar {{ $revenue['day'] === 'SAT' ? 'highlight' : '' }} w-full max-w-12 rounded-t-sm"
                        style="height: {{ $revenue['height'] }}%">
                    </div>

                    <p class="text-[9px] text-[#76543A] mt-3 mb-2">
                        {{ $revenue['day'] }}
                    </p>

                </div>

                @endforeach

            </div>

            <p class="text-[10px] text-[#76543A] mt-4">
                Revenue based on confirmed payments over the last 7 days. </p>

        </div>


        <!-- BEST SELLERS -->
        <div>

            <div class="border-b border-[#B38F6F] pb-4 mb-6">

                <p class="rb-label">Product performance</p>

                <h2 class="rb-serif text-2xl mt-2">
                    Best Sellers
                </h2>

            </div>

            <div class="space-y-6">

                @foreach ($bestSellers as $index => $product)

                <div class="flex gap-4 items-start">

                    <span class="rb-serif text-2xl text-[#B38F6F]">
                        {{ str_pad($index + 1, 2, '0', STR_PAD_LEFT) }}
                    </span>

                    <div class="flex-1 min-w-0">

                        <p class="text-sm font-semibold">
                            {{ $product['name'] }}
                        </p>

                        <p class="text-[10px] text-[#76543A] mt-1">
                            {{ $product['category'] }}
                        </p>

                        <div class="flex items-center gap-3 mt-3">

                            <div class="h-1 flex-1 bg-[#E5D6C3]">
                                <div
                                    class="h-full bg-[#710014]"
                                    style="width: {{ ($product['sold'] / 32) * 100 }}%">
                                </div>
                            </div>

                            <span class="text-[10px] text-[#76543A] whitespace-nowrap">
                                {{ $product['sold'] }} sold
                            </span>

                        </div>

                    </div>

                </div>

                @endforeach

            </div>

            <p class="text-[10px] text-[#76543A] mt-7">
                Ranking based on paid menu quantities today.
            </p>

        </div>

    </section>


    <!-- RECENT ORDERS -->
    <section>

        <div class="flex flex-wrap justify-between items-end border-b border-[#B38F6F] pb-4 mb-5">

            <div>
                <p class="rb-label">Restaurant operations</p>

                <h2 class="rb-serif text-2xl mt-2">
                    Recent Orders
                </h2>
            </div>

            <p class="text-[10px] text-[#76543A]">
                Latest paid transactions
            </p>

        </div>

        <div class="overflow-x-auto">

            <table class="w-full text-left min-w-[650px]">

                <thead>
                    <tr class="text-[9px] uppercase tracking-[.15em] text-[#76543A] border-b border-[#E5D6C3]">
                        <th class="py-4 font-medium">Order ID</th>
                        <th class="py-4 font-medium">Customer</th>
                        <th class="py-4 font-medium">Time</th>
                        <th class="py-4 font-medium">Table</th>
                        <th class="py-4 font-medium">Total</th>
                        <th class="py-4 font-medium">Status</th>
                    </tr>
                </thead>

                <tbody>

                    @foreach ($orders as $order)

                    <tr class="border-b border-[#E5D6C3] hover:bg-[#EEE4D6] transition">

                        <td class="py-5 text-xs font-semibold text-[#710014]">
                            {{ $order['id'] }}
                        </td>

                        <td class="py-5 text-xs">
                            {{ $order['customer'] }}
                        </td>

                        <td class="py-5 text-xs text-[#76543A]">
                            {{ $order['time'] }}
                        </td>

                        <td class="py-5 text-xs text-[#76543A]">
                            {{ $order['table'] }}
                        </td>

                        <td class="py-5 text-xs font-semibold">
                            Rp {{ number_format($order['total'], 0, ',', '.') }}
                        </td>

                        <td class="py-5">

                            @if ($order['status'] === 'Completed')
                            <span class="text-[10px] text-green-800">● Completed</span>
                            @elseif ($order['status'] === 'Preparing')
                            <span class="text-[10px] text-amber-800">● Preparing</span>
                            @else
                            <span class="text-[10px] text-[#76543A]">● Waiting</span>
                            @endif

                        </td>

                    </tr>

                    @endforeach

                </tbody>

            </table>

        </div>

    </section>

    <script>
        document.addEventListener('DOMContentLoaded', function() {

            const button = document.getElementById('analyzeBusinessButton');
            const status = document.getElementById('aiStatus');
            const result = document.getElementById('aiResult');
            const analysis = document.getElementById('aiAnalysis');
            const businessStats = document.getElementById('aiBusinessStats');

            const formatRupiah = (value) => {
                return new Intl.NumberFormat('id-ID', {
                    style: 'currency',
                    currency: 'IDR',
                    maximumFractionDigits: 0
                }).format(value || 0);
            };
            if (!button) return;

            button.addEventListener('click', async function() {

                button.disabled = true;
                button.textContent = 'Sedang Menganalisis...';

                status.textContent = 'Menghubungkan ke AI lokal Ollama...';
                result.classList.add('hidden');
                analysis.textContent = '';

                try {
                    const response = await fetch(
                        @json(route('owner.business-assistant.analyze')), {
                            method: 'GET',
                            headers: {
                                'Accept': 'application/json'
                            },
                            credentials: 'same-origin'
                        }
                    );

                    const data = await response.json();

                    if (!response.ok || !data.success) {
                        throw new Error(
                            data.message || 'AI gagal melakukan analisis.'
                        );
                    }

                    const stats = data.data;

                    const today = stats.penjualan_hari_ini;
                    const weekly = stats.penjualan_tujuh_hari;

                    const statCards = [{
                            label: 'Penjualan Hari Ini',
                            value: formatRupiah(today.total_penjualan),
                            detail: `${today.jumlah_transaksi} transaksi`
                        },
                        {
                            label: 'Penjualan 7 Hari',
                            value: formatRupiah(weekly.total_penjualan),
                            detail: `${weekly.jumlah_transaksi} transaksi`
                        },
                        {
                            label: 'Rata-rata Penjualan Harian',
                            value: formatRupiah(weekly.rata_rata_penjualan_harian),
                            detail: 'Berdasarkan 7 hari kalender'
                        },
                        {
                            label: 'Rata-rata per Transaksi',
                            value: formatRupiah(weekly.rata_rata_nilai_transaksi),
                            detail: 'Nilai rata-rata transaksi'
                        }
                    ];

                    businessStats.innerHTML = statCards.map(stat => `
    <div class="border border-[#D8C5AE] bg-[#F5EFE6] p-4">
        <p class="text-[10px] uppercase tracking-widest text-[#76543A]">
            ${stat.label}
        </p>
        <p class="text-lg font-semibold text-[#710014] mt-2">
            ${stat.value}
        </p>
        <p class="text-xs text-[#76543A] mt-1">
            ${stat.detail}
        </p>
    </div>
`).join('');
                    const orderTypes = stats.performa_jenis_pesanan || [];
                    const bestSellers = stats.lima_menu_terlaris || [];

                    const detailContainer = document.getElementById('aiBusinessDetails');

                    if (detailContainer) {
                        const orderTypeNames = {
                            dine_in: 'Dine-in',
                            takeaway: 'Takeaway'
                        };

                        detailContainer.innerHTML = `
        <div class="grid grid-cols-1 md:grid-cols-2 gap-5 mb-7">

            <div class="border border-[#D8C5AE] p-5">
                <h4 class="text-xs uppercase tracking-widest text-[#710014] font-semibold mb-4">
                    Performa Jenis Pesanan
                </h4>

                ${orderTypes.length ? orderTypes.map(item => `
                    <div class="flex justify-between gap-3 py-3 border-b border-[#E9DED2] last:border-0">
                        <div>
                            <p class="text-sm font-semibold text-[#211D1A]">
                                ${orderTypeNames[item.jenis_pesanan] || item.jenis_pesanan}
                            </p>
                            <p class="text-xs text-[#76543A] mt-1">
                                ${item.jumlah_transaksi} transaksi
                            </p>
                        </div>
                        <p class="text-sm font-semibold text-[#710014]">
                            ${formatRupiah(item.total_penjualan)}
                        </p>
                    </div>
                `).join('') : `
                    <p class="text-sm text-[#76543A]">Belum ada transaksi.</p>
                `}
            </div>

            <div class="border border-[#D8C5AE] p-5">
                <h4 class="text-xs uppercase tracking-widest text-[#710014] font-semibold mb-4">
                    Lima Menu Terlaris
                </h4>

                ${bestSellers.length ? bestSellers.map((item, index) => `
                    <div class="flex justify-between gap-3 py-3 border-b border-[#E9DED2] last:border-0">
                        <div>
                            <p class="text-sm font-semibold text-[#211D1A]">
                                ${index + 1}. ${item.nama_menu}
                            </p>
                            <p class="text-xs text-[#76543A] mt-1">
                                ${item.jumlah_terjual} item terjual
                            </p>
                        </div>
                        <p class="text-sm font-semibold text-[#710014]">
                            ${formatRupiah(item.total_penjualan)}
                        </p>
                    </div>
                `).join('') : `
                    <p class="text-sm text-[#76543A]">Belum ada penjualan menu.</p>
                `}
            </div>

        </div>
    `;
                    }
                    analysis.textContent = data.analysis || 'AI belum memberikan insight.';
                    result.classList.remove('hidden');

                    status.textContent =
                        'Analisis berhasil dibuat berdasarkan data penjualan tujuh hari terakhir.';
                } catch (error) {
                    status.textContent = error.message ||
                        'Terjadi kesalahan saat menghubungi AI.';
                } finally {
                    button.disabled = false;
                    button.textContent = 'Analisis Bisnis Sekarang';
                }

            });


            // TANYA AI BUSINESS ASSISTANT
            const questionForm = document.getElementById('aiQuestionForm');
            const questionInput = document.getElementById('aiQuestion');
            const askButton = document.getElementById('askAiButton');
            const answerBox = document.getElementById('aiAnswerBox');
            const answerText = document.getElementById('aiAnswer');
            const answerData = document.getElementById('aiAnswerData');
            const answerFacts = document.getElementById('aiAnswerFacts');

            if (questionForm) {
                questionForm.addEventListener('submit', async function(event) {
                    event.preventDefault();

                    const question = questionInput.value.trim();
                    if (!question) return;

                    askButton.disabled = true;
                    askButton.textContent = 'Memproses...';

                    answerBox.classList.remove('hidden');
                    answerText.textContent = 'AI sedang memikirkan jawaban...';

                    if (answerData) answerData.classList.add('hidden');

                    try {
                        const response = await fetch(
                            @json(route('owner.business-assistant.ask')), {
                                method: 'POST',
                                headers: {
                                    'Accept': 'application/json',
                                    'Content-Type': 'application/json',
                                    'X-CSRF-TOKEN': questionForm.querySelector('[name="_token"]').value
                                },
                                credentials: 'same-origin',
                                body: JSON.stringify({
                                    question: question
                                })
                            }
                        );

                        const data = await response.json();

                        if (!response.ok || !data.success) {
                            throw new Error(data.message || 'AI gagal menjawab pertanyaan.');
                        }

                        const facts = data.facts;

                        if (facts && answerFacts && answerData) {
                            const factCards = [{
                                    label: 'Total Penjualan',
                                    value: formatRupiah(facts.total_penjualan_7_hari),
                                    detail: `${facts.jumlah_transaksi_7_hari} transaksi`
                                },
                                {
                                    label: 'Dine-in',
                                    value: formatRupiah(facts.dine_in.penjualan),
                                    detail: `${facts.dine_in.transaksi} transaksi`
                                },
                                {
                                    label: 'Takeaway',
                                    value: formatRupiah(facts.takeaway.penjualan),
                                    detail: `${facts.takeaway.transaksi} transaksi`
                                }
                            ];

                            const menuList = (facts.lima_menu_terlaris || []).map((menu, index) => `
                    <div class="flex justify-between gap-3 py-3 border-b border-[#E9DED2] last:border-0">
                        <div>
                            <p class="text-sm font-semibold text-[#211D1A]">
                                ${index + 1}. ${menu.nama_menu}
                            </p>
                            <p class="text-xs text-[#76543A] mt-1">
                                ${menu.jumlah_terjual} item terjual
                            </p>
                        </div>
                        <p class="text-sm font-semibold text-[#710014]">
                            ${formatRupiah(menu.total_penjualan)}
                        </p>
                    </div>
                `).join('');

                            answerFacts.innerHTML = `
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 sm:col-span-2">
                        ${factCards.map(item => `
                            <div class="border border-[#D8C5AE] bg-white p-4">
                                <p class="text-[10px] uppercase tracking-widest text-[#76543A]">
                                    ${item.label}
                                </p>
                                <p class="text-lg font-semibold text-[#710014] mt-2">
                                    ${item.value}
                                </p>
                                <p class="text-xs text-[#76543A] mt-1">
                                    ${item.detail}
                                </p>
                            </div>
                        `).join('')}
                    </div>

                    <div class="sm:col-span-2 border border-[#D8C5AE] bg-white p-4 mt-2">
                        <p class="text-[10px] uppercase tracking-widest text-[#710014] font-semibold mb-2">
                            Lima Menu Terlaris
                        </p>
                        ${menuList || '<p class="text-sm text-[#76543A]">Belum ada penjualan menu.</p>'}
                    </div>
                `;

                            answerData.classList.remove('hidden');
                        }

                        answerText.textContent = data.answer || 'AI belum memberikan rekomendasi.';
                        questionInput.value = '';

                    } catch (error) {
                        answerText.textContent = error.message || 'Terjadi kesalahan saat menghubungi AI.';
                    } finally {
                        askButton.disabled = false;
                        askButton.textContent = 'Tanya AI';
                    }
                });
            }

        });
    </script>

</x-app-layout>