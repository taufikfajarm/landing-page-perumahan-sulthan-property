<?php

namespace App\Filament\Resources\HousingTypes\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\KeyValue;
use Filament\Forms\Components\Repeater;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;
use App\Models\Housing;

class HousingTypeForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('housing_id')
                    ->label('Perumahan')
                    ->options(Housing::pluck('name', 'id'))
                    ->required()
                    ->searchable(),
                TextInput::make('name')
                    ->label('Nama Tipe')
                    ->required()
                    ->live(onBlur: true)
                    ->afterStateUpdated(fn ($state, callable $set) => $set('slug', Str::slug($state))),
                TextInput::make('slug')
                    ->required()
                    ->unique(ignoreRecord: true),
                FileUpload::make('floor_plan')
                    ->label('Denah Rumah')
                    ->image()
                    ->disk('public')
                    ->acceptedFileTypes(['image/jpeg', 'image/jpg', 'image/png'])
                    ->maxSize(5120)
                    ->directory('floor-plans')
                    ->imageEditor()
                    ->columnSpanFull(),
                
                FileUpload::make('image_tampak_depan')
                    ->label('Foto Tampak Depan')
                    ->image()
                    ->disk('public')
                    ->directory('gallery')
                    ->acceptedFileTypes(['image/jpeg', 'image/jpg', 'image/png'])
                    ->maxSize(5120)
                    ->imageEditor(),
                
                FileUpload::make('image_ruang_tamu')
                    ->label('Foto Ruang Tamu')
                    ->image()
                    ->disk('public')
                    ->directory('gallery')
                    ->acceptedFileTypes(['image/jpeg', 'image/jpg', 'image/png'])
                    ->maxSize(5120)
                    ->imageEditor(),
                
                FileUpload::make('image_kamar')
                    ->label('Foto Kamar Tidur')
                    ->image()
                    ->disk('public')
                    ->directory('gallery')
                    ->acceptedFileTypes(['image/jpeg', 'image/jpg', 'image/png'])
                    ->maxSize(5120)
                    ->imageEditor(),
                
                FileUpload::make('image_dapur')
                    ->label('Foto Kamar Mandi')
                    ->image()
                    ->disk('public')
                    ->directory('gallery')
                    ->acceptedFileTypes(['image/jpeg', 'image/jpg', 'image/png'])
                    ->maxSize(5120)
                    ->imageEditor(),
                
                Repeater::make('custom_images')
                    ->label('Foto Ruangan Lainnya (Opsional)')
                    ->schema([
                        TextInput::make('room_name')
                            ->label('Nama Ruangan')
                            ->placeholder('Contoh: Teras, Garasi, Dapur'),
                        FileUpload::make('image')
                            ->label('Foto')
                            ->image()
                            ->disk('public')
                            ->directory('gallery')
                            ->acceptedFileTypes(['image/jpeg', 'image/jpg', 'image/png'])
                            ->maxSize(5120)
                            ->imageEditor(),
                    ])
                    ->columns(2)
                    ->addActionLabel('Tambah Ruangan')
                    ->collapsible()
                    ->columnSpanFull(),
                
                TextInput::make('land_size')
                    ->label('Luas Tanah (m²)')
                    ->numeric()
                    ->suffix('m²'),
                TextInput::make('building_size')
                    ->label('Luas Bangunan (m²)')
                    ->numeric()
                    ->suffix('m²'),
                TextInput::make('bedrooms')
                    ->label('Kamar Tidur')
                    ->required()
                    ->numeric()
                    ->default(0),
                TextInput::make('bathrooms')
                    ->label('Kamar Mandi')
                    ->required()
                    ->numeric()
                    ->default(0),
                TextInput::make('price')
                    ->label('Harga')
                    ->numeric()
                    ->prefix('Rp'),
                KeyValue::make('specifications')
                    ->label('Spesifikasi Detail')
                    ->keyLabel('Item')
                    ->valueLabel('Deskripsi')
                    ->columnSpanFull(),
                
                // Installment Plans Section
                Repeater::make('installmentPlans')
                    ->label('Estimasi Angsuran')
                    ->relationship('installmentPlans')
                    ->schema([
                        TextInput::make('tenor_years')
                            ->label('Tenor (Tahun)')
                            ->required()
                            ->numeric()
                            ->placeholder('1, 2, 3, 5, 10, dll'),
                        
                        TextInput::make('monthly_payment')
                            ->label('Angsuran per Bulan')
                            ->required()
                            ->numeric()
                            ->prefix('Rp')
                            ->placeholder('5000000'),
                        
                        Select::make('dp_type')
                            ->label('Tipe DP')
                            ->options([
                                'percentage' => 'Persentase (%)',
                                'nominal' => 'Nominal (Rp)',
                            ])
                            ->default('percentage')
                            ->live(),
                        
                        TextInput::make('dp_value')
                            ->label(fn ($get) => $get('dp_type') === 'percentage' ? 'DP (%)' : 'DP (Rp)')
                            ->numeric()
                            ->prefix(fn ($get) => $get('dp_type') === 'nominal' ? 'Rp' : null)
                            ->suffix(fn ($get) => $get('dp_type') === 'percentage' ? '%' : null)
                            ->placeholder(fn ($get) => $get('dp_type') === 'percentage' ? '10' : '50000000'),
                        
                        TextInput::make('sort_order')
                            ->label('Urutan')
                            ->numeric()
                            ->default(0),
                    ])
                    ->columns(5)
                    ->defaultItems(0)
                    ->addActionLabel('Tambah Tenor')
                    ->collapsible()
                    ->columnSpanFull(),
                
                // Bank Partners Section
                Select::make('bankPartners')
                    ->label('Kerjasama Bank')
                    ->relationship('bankPartners', 'name')
                    ->multiple()
                    ->preload()
                    ->helperText('Pilih bank-bank yang bekerjasama untuk tipe ini')
                    ->columnSpanFull(),
                
                // Promo Section
                TextInput::make('promo_title')
                    ->label('Judul Promo (Opsional)')
                    ->maxLength(255)
                    ->placeholder('Contoh: Cashback 10 Juta')
                    ->columnSpanFull(),
                
                TextInput::make('promo_description')
                    ->label('Deskripsi Promo (Opsional)')
                    ->placeholder('Cashback 10 juta untuk 10 pembeli pertama!')
                    ->columnSpanFull(),
                
                \Filament\Forms\Components\DatePicker::make('promo_valid_until')
                    ->label('Berlaku Hingga (Opsional)')
                    ->helperText('Kosongkan jika tidak ada batas waktu')
                    ->columnSpanFull(),
            ]);
    }
}
