<?php

namespace App\Filament\Resources\HeroSections\Schemas;

use Filament\Schemas\Schema;

class HeroSectionForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                \Filament\Forms\Components\TextInput::make('tagline')
                    ->label('Tagline')
                    ->required()
                    ->placeholder('e.g., 🏡 Perumahan Kualitas Terbaik di Brebes')
                    ->helperText('Teks kecil di atas judul'),
                \Filament\Forms\Components\TextInput::make('title')
                    ->label('Judul Utama')
                    ->required()
                    ->placeholder('e.g., Wujudkan Impian Keluarga Anda')
                    ->columnSpanFull(),
                \Filament\Forms\Components\Textarea::make('description')
                    ->label('Deskripsi')
                    ->required()
                    ->rows(4)
                    ->columnSpanFull(),
                \Filament\Forms\Components\Toggle::make('is_active')
                    ->label('Aktif')
                    ->default(true)
                    ->helperText('Hanya satu hero section yang aktif akan ditampilkan'),
                
                \Filament\Forms\Components\Repeater::make('images')
                    ->relationship('images')
                    ->label('Gambar Slider')
                    ->schema([
                        \Filament\Forms\Components\FileUpload::make('image_path')
                            ->label('Gambar')
                            ->image()
                            ->disk('public')
                            ->directory('hero-images')
                            ->imageEditor()
                            ->required()
                            ->maxSize(5120),
                        \Filament\Forms\Components\TextInput::make('order')
                            ->label('Urutan')
                            ->numeric()
                            ->default(0)
                            ->helperText('Urutan tampilan gambar'),
                    ])
                    ->orderColumn('order')
                    ->reorderable()
                    ->collapsible()
                    ->itemLabel(fn (array $state): ?string => 'Gambar ' . ($state['order'] ?? ''))
                    ->columnSpanFull()
                    ->defaultItems(1)
                    ->minItems(1)
                    ->helperText('Tambahkan minimal 1 gambar. Gambar akan ditampilkan sebagai slider otomatis.'),
            ]);
    }
}
