<?php

namespace App\Filament\Resources\BankPartners\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class BankPartnerForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->label('Nama Bank')
                    ->required()
                    ->maxLength(255)
                    ->columnSpanFull(),
                
                FileUpload::make('logo')
                    ->label('Logo Bank')
                    ->image()
                    ->disk('public')
                    ->directory('bank-logos')
                    ->imageEditor()
                    ->helperText('Ukuran optimal: 200x80px (landscape) atau 100x100px (square)')
                    ->columnSpanFull(),
                
                Toggle::make('is_active')
                    ->label('Aktif')
                    ->default(true)
                    ->helperText('Bank yang aktif akan ditampilkan di halaman tipe rumah'),
                
                TextInput::make('sort_order')
                    ->label('Urutan Tampilan')
                    ->numeric()
                    ->default(0)
                    ->helperText('Semakin kecil angka, semakin awal ditampilkan'),
            ]);
    }
}
