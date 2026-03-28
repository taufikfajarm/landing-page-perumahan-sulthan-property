<?php

namespace App\Filament\Resources\AboutSettingResource\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class AboutSettingForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('title')
                    ->label('Judul Halaman')
                    ->required()
                    ->maxLength(255)
                    ->default('Tentang Sulthan Property')
                    ->columnSpanFull(),
                
                RichEditor::make('description')
                    ->label('Deskripsi Perusahaan')
                    ->toolbarButtons([
                        'bold',
                        'italic',
                        'underline',
                        'bulletList',
                        'orderedList',
                    ])
                    ->columnSpanFull(),
                
                RichEditor::make('vision')
                    ->label('Visi')
                    ->toolbarButtons([
                        'bold',
                        'italic',
                        'bulletList',
                    ])
                    ->columnSpanFull(),
                
                RichEditor::make('mission')
                    ->label('Misi')
                    ->toolbarButtons([
                        'bold',
                        'italic',
                        'bulletList',
                        'orderedList',
                    ])
                    ->columnSpanFull(),
                
                FileUpload::make('office_photo')
                    ->label('Foto Kantor')
                    ->image()
                    ->disk('public')
                    ->directory('office')
                    ->imageEditor()
                    ->columnSpanFull(),
                
                TextInput::make('office_address')
                    ->label('Alamat Kantor')
                    ->maxLength(255)
                    ->columnSpanFull(),
                
                TextInput::make('office_phone')
                    ->label('Nomor Telepon')
                    ->tel()
                    ->maxLength(255),
                
                TextInput::make('office_email')
                    ->label('Email')
                    ->email()
                    ->maxLength(255),
                
                Textarea::make('maps_embed_url')
                    ->label('Google Maps Embed URL')
                    ->placeholder('Paste the Google Maps embed iframe URL here')
                    ->helperText('Contoh: https://www.google.com/maps/embed?pb=...')
                    ->rows(3)
                    ->columnSpanFull(),
                
                Repeater::make('why_choose_us')
                    ->label('Alasan Memilih Kami')
                    ->schema([
                        TextInput::make('icon')
                            ->label('Icon (Heroicon name)')
                            ->placeholder('check-circle, map-pin, currency-dollar, etc.')
                            ->helperText('Lihat icon di: https://heroicons.com')
                            ->maxLength(255),
                        
                        TextInput::make('title')
                            ->label('Judul')
                            ->required()
                            ->maxLength(255),
                        
                        Textarea::make('description')
                            ->label('Deskripsi')
                            ->required()
                            ->rows(2),
                    ])
                    ->columns(3)
                    ->defaultItems(0)
                    ->addActionLabel('Tambah Alasan')
                    ->columnSpanFull(),
            ]);
    }
}
