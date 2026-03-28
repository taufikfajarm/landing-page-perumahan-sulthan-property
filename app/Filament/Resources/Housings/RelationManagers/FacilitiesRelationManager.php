<?php

namespace App\Filament\Resources\Housings\RelationManagers;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class FacilitiesRelationManager extends RelationManager
{
    protected static string $relationship = 'facilities';

    protected static ?string $recordTitleAttribute = 'name';

    protected static ?string $title = 'Fasilitas';

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->label('Nama Fasilitas')
                    ->required()
                    ->placeholder('e.g., Masjid, Security 24 Jam, Taman Bermain'),
                FileUpload::make('icon')
                    ->label('Icon/Gambar')
                    ->image()
                    ->disk('public')
                    ->directory('facility-icons')
                    ->imageEditor()
                    ->maxSize(2048)
                    ->helperText('Upload icon atau gambar fasilitas (opsional)'),
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
                TextColumn::make('name')
                    ->label('Nama Fasilitas')
                    ->searchable()
                    ->sortable(),
                ImageColumn::make('icon')
                    ->label('Icon')
                    ->disk('public')
                    ->square()
                    ->defaultImageUrl(url('/images/default-facility-icon.png')),
                TextColumn::make('order')
                    ->label('Urutan')
                    ->sortable(),
            ])
            ->defaultSort('order')
            ->reorderable('order');
    }
}
