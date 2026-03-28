<?php

namespace App\Filament\Resources\ProsesAkads\Schemas;

use Filament\Schemas\Schema;

class ProsesAkadForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                \Filament\Forms\Components\TextInput::make('title')
                    ->label('Judul')
                    ->required()
                    ->placeholder('e.g., Proses Akad Pelanggan Kami')
                    ->columnSpanFull(),
                \Filament\Forms\Components\Textarea::make('description')
                    ->label('Deskripsi')
                    ->rows(3)
                    ->columnSpanFull(),
                \Filament\Forms\Components\Toggle::make('is_active')
                    ->label('Aktif')
                    ->default(true)
                    ->helperText('Hanya satu Proses Akad yang aktif akan ditampilkan'),
                
                \Filament\Forms\Components\FileUpload::make('images')
                    ->label('Foto Akad')
                    ->image()
                    ->multiple()
                    ->reorderable()
                    ->panelLayout('grid')
                    ->disk('public')
                    ->directory('proses-akad')
                    ->imageEditor()
                    ->maxSize(5120)
                    ->maxFiles(30)
                    ->columnSpanFull()
                    ->helperText('Pilih beberapa foto sekaligus (maksimal 30 foto). Disarankan minimal 6 foto untuk tampilan slider yang optimal.'),
            ]);
    }
}
