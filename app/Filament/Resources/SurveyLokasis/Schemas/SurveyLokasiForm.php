<?php

namespace App\Filament\Resources\SurveyLokasis\Schemas;

use Filament\Schemas\Schema;

class SurveyLokasiForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                \Filament\Forms\Components\TextInput::make('title')
                    ->label('Judul')
                    ->required()
                    ->placeholder('e.g., Segera Jadwalkan Survey Lokasi dan Dapatkan Penawaran Menariknya')
                    ->columnSpanFull(),
                \Filament\Forms\Components\Textarea::make('description_1')
                    ->label('Deskripsi Paragraf 1')
                    ->required()
                    ->rows(4)
                    ->columnSpanFull(),
                \Filament\Forms\Components\Textarea::make('description_2')
                    ->label('Deskripsi Paragraf 2')
                    ->rows(4)
                    ->columnSpanFull(),
                \Filament\Forms\Components\TextInput::make('button_url')
                    ->label('URL Tombol')
                    ->placeholder('e.g., /marketing atau https://wa.me/...')
                    ->helperText('URL tujuan saat tombol "Survey Sekarang" diklik'),
                \Filament\Forms\Components\Toggle::make('is_active')
                    ->label('Aktif')
                    ->default(true)
                    ->helperText('Hanya satu Survey Lokasi yang aktif akan ditampilkan'),
                
                \Filament\Forms\Components\Repeater::make('images')
                    ->relationship('images')
                    ->label('Gambar (Maksimal 4)')
                    ->schema([
                        \Filament\Forms\Components\FileUpload::make('image_path')
                            ->label('Gambar')
                            ->image()
                            ->disk('public')
                            ->directory('survey-lokasi')
                            ->imageEditor()
                            ->required()
                            ->maxSize(5120),
                        \Filament\Forms\Components\TextInput::make('order')
                            ->label('Urutan')
                            ->numeric()
                            ->default(0)
                            ->helperText('Urutan tampilan gambar (0-3)'),
                    ])
                    ->orderColumn('order')
                    ->reorderable()
                    ->collapsible()
                    ->itemLabel(fn (array $state): ?string => 'Gambar ' . (($state['order'] ?? 0) + 1))
                    ->columnSpanFull()
                    ->defaultItems(4)
                    ->minItems(1)
                    ->maxItems(4)
                    ->helperText('Tambahkan maksimal 4 gambar untuk ditampilkan dalam grid.'),
            ]);
    }
}
