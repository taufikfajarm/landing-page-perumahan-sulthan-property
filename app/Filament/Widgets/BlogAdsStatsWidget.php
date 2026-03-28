<?php

namespace App\Filament\Widgets;

use App\Models\BlogAd;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class BlogAdsStatsWidget extends StatsOverviewWidget
{
    protected function getStats(): array
    {
        $totalAds = BlogAd::count();
        $activeAds = BlogAd::active()->count();
        $totalViews = BlogAd::sum('views_count');
        $totalClicks = BlogAd::sum('clicks_count');
        $avgCtr = $totalViews > 0 ? round(($totalClicks / $totalViews) * 100, 2) : 0;

        return [
            Stat::make('Total Iklan Blog', $totalAds)
                ->description($activeAds . ' iklan aktif')
                ->descriptionIcon('heroicon-o-check-circle')
                ->color('success'),
            
            Stat::make('Total Views', number_format($totalViews))
                ->description('Tampilan iklan')
                ->descriptionIcon('heroicon-o-eye')
                ->color('info'),
            
            Stat::make('Total Clicks', number_format($totalClicks))
                ->description('Klik tombol WhatsApp')
                ->descriptionIcon('heroicon-o-cursor-arrow-rays')
                ->color('warning'),
            
            Stat::make('Rata-rata CTR', $avgCtr . '%')
                ->description('Click-through rate')
                ->descriptionIcon('heroicon-o-chart-bar')
                ->color($avgCtr >= 5 ? 'success' : ($avgCtr >= 2 ? 'warning' : 'danger')),
        ];
    }
}
