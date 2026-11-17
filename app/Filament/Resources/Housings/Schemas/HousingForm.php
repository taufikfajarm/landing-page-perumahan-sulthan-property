<?php

namespace App\Filament\Resources\Housings\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;

class HousingForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                // 1. Informasi Utama & Legalitas
                Section::make('Informasi Utama & Legalitas')
                    ->description('Identitas perumahan, developer pengembang, dan status sertifikat')
                    ->columns(2)
                    ->schema([
                        TextInput::make('name')
                            ->label('Nama Perumahan')
                            ->required()
                            ->live(onBlur: true)
                            ->afterStateUpdated(fn ($state, callable $set) => $set('slug', Str::slug($state))),
                        TextInput::make('slug')
                            ->label('Slug URL')
                            ->required()
                            ->unique(ignoreRecord: true),
                        TextInput::make('developer_name')
                            ->label('Developer / Pengembang')
                            ->default('PT. Hanaan Jaya Abadi')
                            ->placeholder('PT. Hanaan Jaya Abadi')
                            ->helperText('Nama PT Developer resmi perumahan'),
                        TextInput::make('certificate_type')
                            ->label('Status Legalitas / Sertifikat')
                            ->default('SHM & PBG (Split)')
                            ->placeholder('Contoh: SHM & PBG (Sudah Pecah)')
                            ->helperText('Status kepemilikan tanah dan izin bangunan'),
                        Select::make('status')
                            ->label('Status Unit')
                            ->options([
                                'ready' => 'Ready / Tersedia',
                                'soldout' => 'Sold Out (Habis)',
                            ])
                            ->default('ready')
                            ->required(),
                        Toggle::make('is_featured')
                            ->label('Tampilkan di Homepage (Unggulan)')
                            ->default(false),
                        TextInput::make('badge_text')
                            ->label('Custom Badge Text')
                            ->placeholder('Contoh: Subsidi Siap Huni, Promo Bebas DP')
                            ->helperText('Kosongkan untuk memakai badge status bawaan'),
                        Select::make('badge_type')
                            ->label('Warna Custom Badge')
                            ->options([
                                'success' => 'Hijau (Success)',
                                'danger' => 'Merah (Danger)',
                                'warning' => 'Kuning (Warning)',
                                'info' => 'Biru (Info)',
                                'primary' => 'Indigo (Primary)',
                            ])
                            ->default('success'),
                        Textarea::make('description')
                            ->label('Deskripsi Lengkap Perumahan')
                            ->rows(5)
                            ->helperText('Tulis informasi factual: tipe rumah yang ada, lokasi, keunggulan konstruksi, dan fasilitas lingkungan.')
                            ->columnSpanFull(),
                    ]),

                // 2. Lokasi & Aksesibilitas
                Section::make('Lokasi & Aksesibilitas')
                    ->description('Titik koordinat GPS dan estimasi waktu tempuh ke fasilitas umum')
                    ->columns(2)
                    ->schema([
                        TextInput::make('location')
                            ->label('Alamat Lengkap / Wilayah')
                            ->required()
                            ->placeholder('Jl. Pangeran Diponegoro, Pesantunan, Brebes')
                            ->columnSpanFull(),
                        TextInput::make('location_url')
                            ->label('Google Maps URL')
                            ->url()
                            ->placeholder('https://maps.app.goo.gl/...'),
                        TextInput::make('latitude')
                            ->label('Latitude')
                            ->numeric()
                            ->minValue(-90)
                            ->maxValue(90)
                            ->placeholder('-6.868088')
                            ->helperText('Koordinat garis lintang Google Maps'),
                        TextInput::make('longitude')
                            ->label('Longitude')
                            ->numeric()
                            ->minValue(-180)
                            ->maxValue(180)
                            ->placeholder('109.029150')
                            ->helperText('Koordinat garis bujur Google Maps'),

                        Repeater::make('accessPoints')
                            ->relationship('accessPoints')
                            ->label('Daftar Waktu Tempuh & Akses Penting')
                            ->schema([
                                TextInput::make('destination')
                                    ->label('Destinasi / Titik Penting')
                                    ->required()
                                    ->placeholder('e.g., Alun-Alun Brebes, Stasiun Kereta, Gerbang Tol'),
                                TextInput::make('duration_minutes')
                                    ->label('Estimasi Tempuh')
                                    ->numeric()
                                    ->required()
                                    ->suffix('menit')
                                    ->minValue(1)
                                    ->placeholder('Contoh: 5'),
                                TextInput::make('order')
                                    ->label('Urutan')
                                    ->numeric()
                                    ->default(0)
                                    ->helperText('Urutan tampil'),
                            ])
                            ->orderColumn('order')
                            ->reorderable()
                            ->collapsible()
                            ->itemLabel(fn (array $state): ?string => isset($state['destination']) ? ($state['duration_minutes'] ?? '') . ' mnt ke ' . $state['destination'] : null)
                            ->columnSpanFull()
                            ->defaultItems(0),
                    ]),

                // 3. Media, Denah & Siteplan
                Section::make('Media, Denah & Siteplan')
                    ->description('Gambar utama, video tour, brosur PDF, dan integrasi denah interaktif')
                    ->columns(2)
                    ->schema([
                        FileUpload::make('featured_image')
                            ->label('Foto Utama Kawasan Perumahan')
                            ->image()
                            ->disk('public')
                            ->acceptedFileTypes(['image/jpeg', 'image/jpg', 'image/png', 'image/webp'])
                            ->maxSize(5120)
                            ->directory('housing-images')
                            ->imageEditor()
                            ->imageResizeMode('cover')
                            ->imageResizeTargetWidth('1200')
                            ->columnSpanFull(),
                        TextInput::make('video_url')
                            ->label('Link Video Tour / YouTube / Instagram')
                            ->url()
                            ->placeholder('https://www.youtube.com/watch?v=...'),
                        FileUpload::make('brochure_file')
                            ->label('File Brosur (PDF / Image)')
                            ->disk('public')
                            ->acceptedFileTypes(['application/pdf', 'image/jpeg', 'image/png'])
                            ->maxSize(10240)
                            ->directory('housing-brochures')
                            ->helperText('Pengunjung dapat mengunduh brosur resmi ini'),
                        TextInput::make('siteplan_sip_id')
                            ->label('ID Proyek SIP (Siteplan Interaktif)')
                            ->numeric()
                            ->placeholder('Contoh: 3')
                            ->helperText('Masukkan ID Proyek dari SIP Sulthan Property untuk menampilkan kavling interaktif realtime')
                            ->columnSpanFull(),
                        FileUpload::make('site_plan')
                            ->label('Foto Siteplan Cadangan (Statis)')
                            ->image()
                            ->disk('public')
                            ->acceptedFileTypes(['image/jpeg', 'image/jpg', 'image/png'])
                            ->maxSize(5120)
                            ->directory('site-plans')
                            ->imageEditor()
                            ->imageResizeMode('contain')
                            ->imageResizeTargetWidth('1400')
                            ->columnSpanFull(),
                    ]),

                // 4. Fasilitas Perumahan
                Section::make('Fasilitas Kawasan')
                    ->description('Fasilitas internal dalam kawasan perumahan')
                    ->collapsible()
                    ->schema([
                        Repeater::make('facilities')
                            ->relationship('facilities')
                            ->label('Daftar Fasilitas')
                            ->schema([
                                TextInput::make('name')
                                    ->label('Nama Fasilitas')
                                    ->required()
                                    ->placeholder('e.g., Masjid Jamie, One Gate System, Jalan Cor 8m'),
                                FileUpload::make('icon')
                                    ->label('Icon / Logo Fasilitas')
                                    ->image()
                                    ->disk('public')
                                    ->directory('facility-icons')
                                    ->imageEditor()
                                    ->imageResizeMode('cover')
                                    ->imageResizeTargetWidth('120')
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
                    ]),

                // 5. Optimasi SEO & Metadata Search Engine
                Section::make('Optimasi SEO & Metadata')
                    ->description('Kustomisasi judul dan deskripsi yang tampil pada pencarian Google')
                    ->collapsible()
                    ->schema([
                        TextInput::make('meta_title')
                            ->label('Custom Meta Title (SEO)')
                            ->placeholder('Contoh: Rumah Subsidi Pesantunan Brebes - Almaz de Mansion | Sulthan Property')
                            ->helperText('Maksimal 60 karakter disarankan agar tidak terpotong di Google.')
                            ->columnSpanFull(),
                        Textarea::make('meta_description')
                            ->label('Meta Description (SEO Snippet)')
                            ->rows(3)
                            ->placeholder('Contoh: Dapatkan rumah subsidi berkualitas di Almaz de Mansion Pesantunan Brebes. Cicilan mulai 1 jutaan flat, SHM & PBG split, 5 menit ke Alun-Alun...')
                            ->helperText('Ideal 140 - 160 karakter untuk ringkasan di hasil pencarian Google.')
                            ->columnSpanFull(),
                        TextInput::make('meta_keywords')
                            ->label('Meta Keywords')
                            ->placeholder('rumah subsidi brebes, almaz de mansion, rumah murah pesantunan, kpr flpp brebes')
                            ->helperText('Pisahkan kata kunci dengan tanda koma')
                            ->columnSpanFull(),
                    ]),
            ]);
    }
}
