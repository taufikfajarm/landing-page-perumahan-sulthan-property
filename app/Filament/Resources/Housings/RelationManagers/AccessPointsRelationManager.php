<?php

namespace App\Filament\Resources\Housings\RelationManagers;

use Filament\Forms\Components\TextInput;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class AccessPointsRelationManager extends RelationManager
{
    protected static string $relationship = 'accessPoints';

    protected static ?string $recordTitleAttribute = 'destination';

    protected static ?string $title = 'Akses Lokasi';

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('destination')
                    ->label('Tujuan')
                    ->required()
                    ->placeholder('e.g., Pasar Brebes, Stasiun Brebes, Alun-alun'),
                TextInput::make('duration_minutes')
                    ->label('Waktu Tempuh (menit)')
                    ->numeric()
                    ->required()
                    ->suffix('menit')
                    ->minValue(1)
                    ->placeholder('e.g., 5, 10, 15'),
                TextInput::make('order')
                    ->label('Urutan')
                    ->numeric()
                    ->default(0)
                    ->helperText('Urutan tampilan (semakin kecil semakin awal)'),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('destination')
                    ->label('Tujuan')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('duration_minutes')
                    ->label('Waktu Tempuh')
                    ->suffix(' menit')
                    ->sortable(),
                TextColumn::make('order')
                    ->label('Urutan')
                    ->sortable(),
            ])
            ->defaultSort('order')
            ->reorderable('order');
    }
}
