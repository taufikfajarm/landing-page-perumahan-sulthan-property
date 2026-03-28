<?php

namespace App\Filament\Resources\AboutSettingResource\Tables;

use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class AboutSettingsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('title')
                    ->label('Judul')
                    ->searchable(),
                TextColumn::make('office_address')
                    ->label('Alamat')
                    ->searchable()
                    ->limit(50),
                TextColumn::make('updated_at')
                    ->label('Terakhir Diupdate')
                    ->dateTime()
                    ->sortable(),
            ]);
    }
}
