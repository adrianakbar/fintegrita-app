<?php

namespace App\Filament\Widgets;

use App\Models\Invoice;
use App\Models\Payment;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class RevenueStatsWidget extends BaseWidget
{
    protected static ?int $sort = 1;
    protected static ?string $pollingInterval = '60s';

    protected function getStats(): array
    {
        $monthStart = now()->startOfMonth();

        $paidThisMonth = (float) Payment::where('status', 'verified')
            ->where('paid_at', '>=', $monthStart)
            ->sum('amount');

        $paidLastMonth = (float) Payment::where('status', 'verified')
            ->whereBetween('paid_at', [now()->subMonth()->startOfMonth(), now()->subMonth()->endOfMonth()])
            ->sum('amount');

        $delta = $paidLastMonth > 0
            ? round(($paidThisMonth - $paidLastMonth) / $paidLastMonth * 100)
            : ($paidThisMonth > 0 ? 100 : 0);

        $outstanding = (float) Invoice::whereIn('status', ['sent', 'partial'])
            ->get()
            ->sum(fn ($inv) => max(0, (float) $inv->total - (float) $amountPaid = (float) $inv->amount_paid));

        $overdue = Invoice::whereIn('status', ['sent', 'partial'])
            ->whereDate('due_date', '<', now())
            ->count();

        $unverified = Payment::where('status', 'pending')->count();

        return [
            Stat::make('Pendapatan Bulan Ini', 'Rp '.number_format($paidThisMonth, 0, ',', '.'))
                ->description(($delta >= 0 ? '+' : '').$delta.'% vs bulan lalu')
                ->descriptionIcon($delta >= 0 ? 'heroicon-m-arrow-trending-up' : 'heroicon-m-arrow-trending-down')
                ->color($delta >= 0 ? 'success' : 'danger')
                ->chart($this->last6Months()),

            Stat::make('Piutang Belum Tertagih', 'Rp '.number_format($outstanding, 0, ',', '.'))
                ->description($overdue.' invoice lewat jatuh tempo')
                ->descriptionIcon('heroicon-m-clock')
                ->color($overdue > 0 ? 'warning' : 'success'),

            Stat::make('Payment Menunggu Verifikasi', $unverified.' payment')
                ->description('Perlu dicek tim finance')
                ->descriptionIcon('heroicon-m-bell-alert')
                ->color($unverified > 0 ? 'danger' : 'gray'),
        ];
    }

    /** Total payment verified 6 bulan terakhir untuk sparkline. */
    protected function last6Months(): array
    {
        $data = [];
        for ($i = 5; $i >= 0; $i--) {
            $data[] = (float) Payment::where('status', 'verified')
                ->whereBetween('paid_at', [now()->subMonths($i)->startOfMonth(), now()->subMonths($i)->endOfMonth()])
                ->sum('amount');
        }

        return $data;
    }
}
