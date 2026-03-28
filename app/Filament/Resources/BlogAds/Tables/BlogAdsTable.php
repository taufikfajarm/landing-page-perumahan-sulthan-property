<?php

namespace App\Filament\Resources\BlogAds\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;

class BlogAdsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('title')
                    ->searchable()
                    ->sortable()
                    ->label('Judul Iklan'),
                
                TextColumn::make('housing.name')
                    ->searchable()
                    ->sortable()
                    ->label('Perumahan')
                    ->placeholder('Tidak ada'),
                
                TextColumn::make('marketing.name')
                    ->searchable()
                    ->sortable()
                    ->label('Marketing'),
                
                TextColumn::make('marketing.phone')
                    ->label('No. WhatsApp')
                    ->copyable()
                    ->copyMessage('Nomor tersalin!')
                    ->placeholder('-'),
                
                TextColumn::make('ad_type')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'banner' => 'success',
                        'card' => 'info',
                    })
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'banner' => 'Banner',
                        'card' => 'Card',
                    })
                    ->label('Tipe'),
                
                IconColumn::make('is_active')
                    ->boolean()
                    ->label('Aktif'),
                
                TextColumn::make('views_count')
                    ->numeric()
                    ->sortable()
                    ->label('Views')
                    ->badge()
                    ->color('info'),
                
                TextColumn::make('clicks_count')
                    ->numeric()
                    ->sortable()
                    ->label('Clicks')
                    ->badge()
                    ->color('success'),
                
                TextColumn::make('ctr')
                    ->label('CTR')
                    ->sortable(query: function ($query, $direction) {
                        return $query->orderByRaw("(clicks_count / NULLIF(views_count, 0)) {$direction}");
                    })
                    ->formatStateUsing(fn ($record) => $record->ctr . '%')
                    ->badge()
                    ->color(fn ($record) => match(true) {
                        $record->ctr >= 5 => 'success',
                        $record->ctr >= 2 => 'warning',
                        default => 'danger',
                    }),
                
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('ad_type')
                    ->options([
                        'banner' => 'Banner',
                        'card' => 'Card',
                    ])
                    ->label('Tipe Iklan'),
                
                TernaryFilter::make('is_active')
                    ->label('Status Aktif')
                    ->placeholder('Semua')
                    ->trueLabel('Aktif')
                    ->falseLabel('Tidak Aktif'),
                
                SelectFilter::make('marketing')
                    ->relationship('marketing', 'name')
                    ->searchable()
                    ->preload()
                    ->label('Marketing'),
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('created_at', 'desc');
    }
}
