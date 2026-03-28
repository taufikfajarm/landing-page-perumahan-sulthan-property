<?php

namespace App\Filament\Widgets;

use App\Models\Marketing;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;
use Illuminate\Database\Eloquent\Builder;

class MarketingWhatsAppStatsWidget extends BaseWidget
{
    protected static ?int $sort = 4;
    
    protected int | string | array $columnSpan = 'full';
    
    protected string $view = 'filament.widgets.marketing-whatsapp-stats-widget';

    public string $filterPeriod = 'month';

    public function table(Table $table): Table
    {
        return $table
            ->query(
                Marketing::query()
                    ->withCount([
                        'whatsappClicks' => function (Builder $query) {
                            if ($this->filterPeriod === 'month') {
                                $query->thisMonth();
                            }
                        }
                    ])
                    ->orderBy('whatsapp_clicks_count', 'desc')
            )
            ->columns([
                TextColumn::make('name')
                    ->label('Nama Marketing')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('phone')
                    ->label('No. WhatsApp')
                    ->formatStateUsing(fn ($state) => $state ? '+62 ' . ltrim($state, '0') : '-'),
                TextColumn::make('whatsapp_clicks_count')
                    ->label('Total Klik')
                    ->badge()
                    ->color('success')
                    ->sortable(),
            ])
            ->paginated(false)
            ->poll('10s');
    }
}
