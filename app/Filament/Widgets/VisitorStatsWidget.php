<?php

namespace App\Filament\Widgets;

use App\Models\PageVisit;
use Filament\Widgets\ChartWidget;
use Carbon\Carbon;

class VisitorStatsWidget extends ChartWidget
{
    protected ?string $heading = 'Statistik Pengunjung Website';
    
    protected static ?int $sort = 2;
    
    protected int | string | array $columnSpan = 'full';

    public ?string $filter = 'daily';
    
    protected ?string $maxHeight = '300px';

    protected function getData(): array
    {
        $filter = $this->filter;

        if ($filter === 'monthly') {
            // Last 12 months
            $data = [];
            $labels = [];
            
            for ($i = 11; $i >= 0; $i--) {
                $date = Carbon::now()->subMonths($i);
                $count = PageVisit::whereYear('visited_at', $date->year)
                    ->whereMonth('visited_at', $date->month)
                    ->count();
                
                $labels[] = $date->format('M Y');
                $data[] = $count;
            }
        } else {
            // Last 30 days
            $data = [];
            $labels = [];
            
            for ($i = 29; $i >= 0; $i--) {
                $date = Carbon::now()->subDays($i);
                $count = PageVisit::whereDate('visited_at', $date->toDateString())->count();
                
                $labels[] = $date->format('d M');
                $data[] = $count;
            }
        }

        return [
            'datasets' => [
                [
                    'label' => 'Pengunjung',
                    'data' => $data,
                    'borderColor' => '#3b82f6',
                    'backgroundColor' => 'rgba(59, 130, 246, 0.1)',
                    'fill' => true,
                ],
            ],
            'labels' => $labels,
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }

    protected function getFilters(): ?array
    {
        return [
            'daily' => '30 Hari Terakhir',
            'monthly' => '12 Bulan Terakhir',
        ];
    }

    protected function getOptions(): array
    {
        return [
            'scales' => [
                'y' => [
                    'beginAtZero' => true,
                    'min' => 0,
                ],
            ],
        ];
    }
}
