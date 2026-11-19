<?php

namespace App\Filament\Resources\Contacts\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class ContactForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->label('Nama Pengirim')
                    ->required(),
                TextInput::make('email')
                    ->label('Alamat Email')
                    ->email()
                    ->required(),
                TextInput::make('phone')
                    ->label('Nomor WhatsApp / HP')
                    ->tel()
                    ->required(),
                Toggle::make('is_read')
                    ->label('Sudah Dilihat')
                    ->helperText('Status otomatis aktif saat detail pesan dibuka')
                    ->default(false)
                    ->required(),
                Textarea::make('message')
                    ->label('Isi Pesan')
                    ->required()
                    ->rows(6)
                    ->columnSpanFull(),
            ]);
    }
}
