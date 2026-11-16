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
            $startDate = Carbon::now()->subMonths(11)->startOfMonth();
            $counts = PageVisit::where('visited_at', '>=', $startDate)
                ->selectRaw('SUBSTR(visited_at, 1, 7) as ym, count(*) as count')
                ->groupBy('ym')
                ->pluck('count', 'ym');

            $data = [];
            $labels = [];
            for ($i = 11; $i >= 0; $i--) {
                $date = Carbon::now()->subMonths($i);
                $key = $date->format('Y-m');
                $labels[] = $date->format('M Y');
                $data[] = (int) ($counts[$key] ?? 0);
            }
        } else {
            $startDate = Carbon::now()->subDays(29)->startOfDay();
            $counts = PageVisit::where('visited_at', '>=', $startDate)
                ->selectRaw('DATE(visited_at) as dt, count(*) as count')
                ->groupBy('dt')
                ->pluck('count', 'dt');

            $data = [];
            $labels = [];
            for ($i = 29; $i >= 0; $i--) {
                $date = Carbon::now()->subDays($i);
                $key = $date->toDateString();
                $labels[] = $date->format('d M');
                $data[] = (int) ($counts[$key] ?? 0);
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
