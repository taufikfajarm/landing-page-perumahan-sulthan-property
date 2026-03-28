<?php

namespace App\Filament\Resources\Marketings\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\FileUpload;
use Filament\Schemas\Schema;

class MarketingForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->label('Nama')
                    ->required(),
                FileUpload::make('photo')
                    ->label('Foto')
                    ->image()
                    ->disk('public')
                    ->acceptedFileTypes(['image/jpeg', 'image/jpg', 'image/png'])
                    ->maxSize(2048)
                    ->directory('marketing')
                    ->imageEditor()
                    ->avatar()
                    ->columnSpanFull(),
                TextInput::make('phone')
                    ->label('No. WhatsApp')
                    ->tel()
                    ->required()
                    ->helperText('Format: 08xxx atau 628xxx'),
                TextInput::make('position')
                    ->label('Posisi'),
                TextInput::make('order')
                    ->label('Urutan Tampilan')
                    ->numeric()
                    ->default(0)
                    ->required(),
                Toggle::make('is_active')
                    ->label('Aktif')
                    ->default(true),
            ]);
    }
}
