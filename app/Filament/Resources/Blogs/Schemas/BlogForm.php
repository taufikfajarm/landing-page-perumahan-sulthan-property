<?php

namespace App\Filament\Resources\Blogs\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\RichEditor;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;

class BlogForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('title')
                    ->label('Judul')
                    ->required()
                    ->live(onBlur: true)
                    ->afterStateUpdated(fn ($state, callable $set) => $set('slug', Str::slug($state)))
                    ->columnSpanFull(),
                TextInput::make('slug')
                    ->required()
                    ->unique(ignoreRecord: true)
                    ->columnSpanFull(),
                Textarea::make('excerpt')
                    ->label('Ringkasan')
                    ->rows(3)
                    ->columnSpanFull(),
                RichEditor::make('content')
                    ->label('Konten')
                    ->required()
                    ->columnSpanFull(),
                FileUpload::make('featured_image')
                    ->label('Gambar Utama')
                    ->image()
                    ->disk('public')
                    ->acceptedFileTypes(['image/jpeg', 'image/jpg', 'image/png', 'image/webp'])
                    ->maxSize(5120)
                    ->directory('blog-images')
                    ->imageEditor()
                    ->columnSpanFull(),
                
                // SEO Fields
                TextInput::make('meta_title')
                    ->label('Meta Title')
                    ->helperText('Kosongkan untuk menggunakan judul artikel'),
                Textarea::make('meta_description')
                    ->label('Meta Description')
                    ->rows(2)
                    ->helperText('Kosongkan untuk menggunakan ringkasan')
                    ->columnSpanFull(),
                TextInput::make('meta_keywords')
                    ->label('Meta Keywords')
                    ->helperText('Pisahkan dengan koma'),
                
                // Publishing
                Toggle::make('is_published')
                    ->label('Publikasikan')
                    ->default(false),
                DateTimePicker::make('published_at')
                    ->label('Tanggal Publikasi')
                    ->default(now()),
                TextInput::make('views')
                    ->label('Jumlah Views')
                    ->numeric()
                    ->default(0)
                    ->disabled()
                    ->dehydrated(false),
            ]);
    }
}
