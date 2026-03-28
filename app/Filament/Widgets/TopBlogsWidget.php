<?php

namespace App\Filament\Widgets;

use App\Models\Blog;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class TopBlogsWidget extends BaseWidget
{
    protected static ?string $heading = 'Top 5 Blog Terpopuler';
    
    protected static ?int $sort = 3;
    
    protected int | string | array $columnSpan = 'full';

    public function table(Table $table): Table
    {
        return $table
            ->query(
                Blog::query()
                    ->orderBy('views', 'desc')
                    ->limit(5)
            )
            ->columns([
                TextColumn::make('title')
                    ->label('Judul Blog')
                    ->searchable()
                    ->limit(50),
                TextColumn::make('views')
                    ->label('Views')
                    ->sortable()
                    ->badge()
                    ->color('success'),
                TextColumn::make('published_at')
                    ->label('Dipublikasikan')
                    ->date('d M Y')
                    ->sortable(),
            ])
            ->paginated(false);
    }
}
