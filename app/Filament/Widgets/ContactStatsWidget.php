<?php

namespace App\Filament\Widgets;

use App\Models\Contact;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class ContactStatsWidget extends BaseWidget
{
    protected static ?int $sort = 1;

    protected function getStats(): array
    {
        $todayCount = Contact::whereDate('created_at', today())->count();
        $monthCount = Contact::whereYear('created_at', now()->year)
            ->whereMonth('created_at', now()->month)
            ->count();

        return [
            Stat::make('Pesan Hari Ini', $todayCount)
                ->description('Pesan masuk hari ini')
                ->descriptionIcon('heroicon-m-envelope')
                ->color('success'),
            Stat::make('Pesan Bulan Ini', $monthCount)
                ->description('Total pesan bulan ' . now()->format('F'))
                ->descriptionIcon('heroicon-m-calendar')
                ->color('info'),
        ];
    }
}
