<?php

namespace App\Filament\Resources\BlogAds\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class BlogAdForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('title')
                    ->required()
                    ->maxLength(255)
                    ->columnSpanFull(),
                
                Select::make('housing_id')
                    ->relationship('housing', 'name')
                    ->searchable()
                    ->preload()
                    ->nullable()
                    ->label('Perumahan'),
                
                Select::make('marketing_id')
                    ->relationship('marketing', 'name')
                    ->searchable()
                    ->preload()
                    ->required()
                    ->label('Marketing'),
                
                FileUpload::make('image')
                    ->image()
                    ->required()
                    ->disk('public')
                    ->directory('blog-ads')
                    ->visibility('public')
                    ->imageEditor()
                    ->helperText('Ukuran yang disarankan: Banner (1200x400px atau rasio 3:1) atau Card (400x400px)')
                    ->columnSpanFull(),
                
                Select::make('ad_type')
                    ->options([
                        'banner' => 'Banner',
                        'card' => 'Card'
                    ])
                    ->default('card')
                    ->required()
                    ->label('Tipe Iklan'),
                
                Toggle::make('is_active')
                    ->default(true)
                    ->label('Aktif'),
            ]);
    }
}
