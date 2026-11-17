<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use App\Models\DiningTable;
use Endroid\QrCode\Bacon\MatrixFactory;
use Endroid\QrCode\ErrorCorrectionLevel;
use Endroid\QrCode\QrCode;
use Illuminate\Http\Response;
use Illuminate\View\View;

class TableQrController extends Controller
{
    public function show(DiningTable $table): View
    {
        $menuUrl = $this->publicMenuUrl($table);

        return view('owner.tables.qr', compact('table', 'menuUrl'));
    }

    public function image(DiningTable $table): Response
    {
        $url = $this->publicMenuUrl($table);

        $qrCode = QrCode::create($url)
            ->setErrorCorrectionLevel(ErrorCorrectionLevel::High)
            ->setMargin(0)
            ->setSize(350);

        $matrix = (new MatrixFactory())->create($qrCode);
        $blockCount = $matrix->getBlockCount();
        $quietZone = 4;
        $viewBoxSize = $blockCount + ($quietZone * 2);
        $paths = [];

        for ($row = 0; $row < $blockCount; $row++) {
            for ($column = 0; $column < $blockCount; $column++) {
                if ($matrix->getBlockValue($row, $column) === 1) {
                    $x = $column + $quietZone;
                    $y = $row + $quietZone;
                    $paths[] = "M{$x} {$y}h1v1h-1z";
                }
            }
        }

        $svg = sprintf(
            '<svg xmlns="http://www.w3.org/2000/svg" width="350" height="350" viewBox="0 0 %1$d %1$d" shape-rendering="crispEdges"><rect width="%1$d" height="%1$d" fill="#fff"/><path d="%2$s" fill="#000"/></svg>',
            $viewBoxSize,
            implode('', $paths)
        );

        return response($svg, 200, [
            'Content-Type' => 'image/svg+xml; charset=UTF-8',
            'Cache-Control' => 'no-store',
            'X-Content-Type-Options' => 'nosniff',
        ]);
    }

    private function publicMenuUrl(DiningTable $table): string
    {
        $baseUrl = rtrim((string) config('app.public_menu_url'), '/');

        if ($baseUrl === '') {
            $baseUrl = request()->getSchemeAndHttpHost();
        }

        return $baseUrl . route('menu.show', ['table' => $table->qr_token], false);
    }
}
