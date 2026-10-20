<?php

namespace App\Filament\Widgets;

use App\Models\Payment;
use Filament\Widgets\ChartWidget;

class RevenueChartWidget extends ChartWidget
{
    protected static ?string $heading = 'Pendapatan 12 Bulan Terakhir';
    protected static ?int $sort = 2;
    protected static ?string $pollingInterval = '5m';
    protected static ?string $maxHeight = '280px';

    protected function getData(): array
    {
        $labels = [];
        $data = [];
        $colors = [];

        for ($i = 11; $i >= 0; $i--) {
            $month = now()->subMonths($i);
            $labels[] = $month->translatedFormat('M y');

            $sum = (float) Payment::where('status', 'verified')
                ->whereBetween('paid_at', [$month->copy()->startOfMonth(), $month->copy()->endOfMonth()])
                ->sum('amount');

            $data[] = round($sum / 1000); // ribuan, biar sumbu ringkas
            $colors[] = $i === 0 ? '#DF2C8B' : '#BD187455';
        }

        return [
            'datasets' => [
                [
                    'label' => 'Verified (ribuan Rp)',
                    'data' => $data,
                    'backgroundColor' => $colors,
                    'borderRadius' => 6,
                ],
            ],
            'labels' => $labels,
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }
}
