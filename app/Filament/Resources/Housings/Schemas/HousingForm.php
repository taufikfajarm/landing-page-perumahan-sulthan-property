<?php

namespace App\Filament\Resources\Housings\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\FileUpload;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;

class HousingForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->required()
                    ->live(onBlur: true)
                    ->afterStateUpdated(fn ($state, callable $set) => $set('slug', Str::slug($state))),
                TextInput::make('slug')
                    ->required()
                    ->unique(ignoreRecord: true),
                TextInput::make('location')
                    ->required()
                    ->label('Lokasi'),
                TextInput::make('location_url')
                    ->url()
                    ->label('Google Maps URL')
                    ->placeholder('https://maps.google.com/...'),
                FileUpload::make('featured_image')
                    ->label('Foto Utama Perumahan')
                    ->image()
                    ->disk('public')
                    ->acceptedFileTypes(['image/jpeg', 'image/jpg', 'image/png'])
                    ->maxSize(5120)
                    ->directory('housing-images')
                    ->imageEditor()
                    ->columnSpanFull(),
                Textarea::make('description')
                    ->label('Deskripsi')
                    ->rows(4)
                    ->columnSpanFull(),
                Select::make('status')
                    ->options(['ready' => 'Ready', 'soldout' => 'Sold Out'])
                    ->default('ready')
                    ->required(),
                TextInput::make('badge_text')
                    ->label('Custom Badge Text')
                    ->placeholder('e.g., Promo Spesial, Diskon 10%, Limited')
                    ->helperText('Kosongkan untuk menggunakan badge status default (Ready/Sold Out)'),
                Select::make('badge_type')
                    ->label('Badge Type')
                    ->options([
                        'success' => 'Success (Green)',
                        'danger' => 'Danger (Red)',
                        'warning' => 'Warning (Yellow)',
                        'info' => 'Info (Blue)',
                        'primary' => 'Primary (Indigo)',
                    ])
                    ->default('success')
                    ->helperText('Pilih warna badge yang sesuai'),
                Toggle::make('is_featured')
                    ->label('Tampilkan di Homepage')
                    ->default(false),
                TextInput::make('siteplan_sip_id')
                    ->label('ID Proyek SIP (Siteplan Interactive)')
                    ->numeric()
                    ->placeholder('Contoh: 1')
                    ->helperText('Isi dengan ID dari sistem SIP untuk menampilkan siteplan interaktif. Kosongkan untuk menggunakan gambar.')
                    ->columnSpanFull(),
                FileUpload::make('site_plan')
                    ->label('Foto Site Plan (Statis)')
                    ->image()
                    ->disk('public')
                    ->acceptedFileTypes(['image/jpeg', 'image/jpg', 'image/png'])
                    ->maxSize(5120)
                    ->directory('site-plans')
                    ->imageEditor()
                    ->columnSpanFull(),
                
                \Filament\Forms\Components\Repeater::make('facilities')
                    ->relationship('facilities')
                    ->label('Fasilitas')
                    ->schema([
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
                            ->maxSize(2048),
                        TextInput::make('order')
                            ->label('Urutan')
                            ->numeric()
                            ->default(0)
                            ->helperText('Urutan tampilan'),
                    ])
                    ->orderColumn('order')
                    ->reorderable()
                    ->collapsible()
                    ->itemLabel(fn (array $state): ?string => $state['name'] ?? null)
                    ->columnSpanFull()
                    ->defaultItems(0),
                
                \Filament\Forms\Components\Repeater::make('accessPoints')
                    ->relationship('accessPoints')
                    ->label('Akses Lokasi')
                    ->schema([
                        TextInput::make('destination')
                            ->label('Tujuan')
                            ->required()
                            ->placeholder('e.g., Pasar Brebes, Stasiun Brebes'),
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
                            ->helperText('Urutan tampilan'),
                    ])
                    ->orderColumn('order')
                    ->reorderable()
                    ->collapsible()
                    ->itemLabel(fn (array $state): ?string => $state['destination'] ?? null)
                    ->columnSpanFull()
                    ->defaultItems(0),
            ]);
    }
}
