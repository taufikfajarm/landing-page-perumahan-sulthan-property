@extends('layouts.app')

@php
    $metaTitle = $housing->meta_title ?: ($housing->name . ' - Rumah Subsidi & Komersil di Pesantunan Brebes | Sulthan Property');
    $metaDescription = $housing->meta_description ?: 'Dapatkan hunian berkualitas di ' . $housing->name . ' Pesantunan Brebes oleh ' . ($housing->developer_name ?: 'PT. Hanaan Jaya Abadi') . '. Angsuran KPR subsidi flat mulai Rp 1 jutaan/bulan, legalitas SHM & PBG siap split, 5 menit dari Alun-Alun Brebes.';
    $metaKeywords = $housing->meta_keywords ?: 'almaz de mansion, perumahan ' . $housing->name . ', rumah subsidi brebes, perumahan pesantunan brebes, rumah kpr flpp brebes, rumah murah brebes, pt hanaan jaya abadi';
    $featuredImageUrl = $housing->featured_image ? get_image_url($housing->featured_image) : asset('images/og-image.jpg');
    
    // Hitung range harga untuk schema & hero
    $minPrice = $housing->types->min('price');
    $maxPrice = $housing->types->max('price');
    $priceDisplay = $minPrice ? 'Mulai Rp ' . number_format($minPrice, 0, ',', '.') : 'Hubungi Marketing';
@endphp

@section('title', $metaTitle)
@section('meta_description', $metaDescription)
@section('meta_keywords', $metaKeywords)
@section('og_title', $metaTitle)
@section('og_description', $metaDescription)
@section('og_image', $featuredImageUrl)
@section('twitter_title', $metaTitle)
@section('twitter_description', $metaDescription)
@section('twitter_image', $featuredImageUrl)

@push('seo')
{{-- Structured Data: BreadcrumbList + SingleFamilyResidence + FAQPage --}}
<script type="application/ld+json">
{
    "@@context": "https://schema.org",
    "@@graph": [
        {
            "@@type": "BreadcrumbList",
            "itemListElement": [
                {
                    "@@type": "ListItem",
                    "position": 1,
                    "name": "Beranda",
                    "item": "{{ route('home') }}"
                },
                {
                    "@@type": "ListItem",
                    "position": 2,
                    "name": "Pilihan Perumahan",
                    "item": "{{ route('housing.index') }}"
                },
                {
                    "@@type": "ListItem",
                    "position": 3,
                    "name": "{{ $housing->name }}",
                    "item": "{{ url()->current() }}"
                }
            ]
        },
        {
            "@@type": ["SingleFamilyResidence", "RealEstateListing"],
            "@@id": "{{ url()->current() }}#residence",
            "name": "{{ $housing->name }}",
            "description": "{{ addslashes($metaDescription) }}",
            "url": "{{ url()->current() }}",
            "image": "{{ $featuredImageUrl }}",
            "telephone": "+6287849759572",
            @if($housing->developer_name)
            "provider": {
                "@@type": "RealEstateAgent",
                "name": "{{ $housing->developer_name }}",
                "url": "{{ url('/') }}"
            },
            @endif
            @if($housing->latitude && $housing->longitude)
            "geo": {
                "@@type": "GeoCoordinates",
                "latitude": {{ (float) $housing->latitude }},
                "longitude": {{ (float) $housing->longitude }}
            },
            @endif
            "address": {
                "@@type": "PostalAddress",
                "streetAddress": "{{ $housing->location }}",
                "addressLocality": "Brebes",
                "addressRegion": "Jawa Tengah",
                "postalCode": "52212",
                "addressCountry": "ID"
            },
            @if($minPrice)
            "offers": {
                "@@type": "AggregateOffer",
                "priceCurrency": "IDR",
                "lowPrice": {{ (int) $minPrice }},
                @if($maxPrice && $maxPrice > $minPrice)
                "highPrice": {{ (int) $maxPrice }},
                @endif
                "offerCount": "{{ $housing->types->count() }}",
                "availability": "https://schema.org/InStock"
            },
            @endif
            "amenityFeature": [
                @foreach($housing->facilities as $index => $facility)
                {
                    "@@type": "LocationFeatureSpecification",
                    "name": "{{ $facility->name }}",
                    "value": true
                }@if(!$loop->last),@endif
                @endforeach
            ]
        },
        {
            "@@type": "FAQPage",
            "mainEntity": [
                {
                    "@@type": "Question",
                    "name": "Berapa cicilan per bulan untuk perumahan di {{ $housing->name }}?",
                    "acceptedAnswer": {
                        "@@type": "Answer",
                        "text": "Untuk unit subsidi Tipe 30/60 program KPR FLPP, angsuran tetap (flat) mulai dari Rp 1.070.000 per bulan untuk tenor 20 tahun, Rp 1.285.000 per bulan tenor 15 tahun, dan Rp 1.730.000 per bulan tenor 10 tahun dengan bunga subsidi fixed 5%."
                    }
                },
                {
                    "@@type": "Question",
                    "name": "Bagaimana status legalitas dan sertifikat tanah di {{ $housing->name }}?",
                    "acceptedAnswer": {
                        "@@type": "Answer",
                        "text": "Seluruh unit memiliki status legalitas pasti dengan Sertifikat Hak Milik (SHM) dan Persetujuan Bangunan Gedung (PBG) yang telah siap split/pecah per kavling untuk proses akad kredit resmi."
                    }
                },
                {
                    "@@type": "Question",
                    "name": "Apa saja syarat utama pengajuan KPR Subsidi di Brebes?",
                    "acceptedAnswer": {
                        "@@type": "Answer",
                        "text": "Syarat KPR Subsidi FLPP antara lain: WNI usia minimal 21 tahun/menikah, belum pernah memiliki rumah sebelumnya, penghasilan pokok maksimal sesuai batas ketentuan pemerintah, serta lolos verifikasi SLIK OJK/BI Checking."
                    }
                },
                {
                    "@@type": "Question",
                    "name": "Berapa jarak {{ $housing->name }} ke fasilitas umum Kota Brebes?",
                    "acceptedAnswer": {
                        "@@type": "Answer",
                        "text": "Lokasi berada di Pesantunan Brebes dengan akses sangat cepat: 3 menit ke Alun-Alun & Masjid Agung Brebes, 4 menit ke Pasar Induk Brebes, 5 menit ke Stasiun Kereta Brebes, 5 menit ke RSUD Brebes, dan 7 menit ke Gerbang Tol Brebes Barat."
                    }
                },
                {
                    "@@type": "Question",
                    "name": "Bagaimana cara melakukan survey lokasi dan konsultasi berkas?",
                    "acceptedAnswer": {
                        "@@type": "Answer",
                        "text": "Anda dapat menghubungi tim marketing Sulthan Property secara langsung melalui WhatsApp untuk membuat jadwal kunjungan lokasi tanpa dipungut biaya, serta mendapatkan bantuan pemeriksaan berkas KPR."
                    }
                }
            ]
        }
    ]
}
</script>
@endpush

@section('content')
{{-- Breadcrumb Navigation --}}
<div class="bg-gray-100 border-b border-gray-200">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-3">
        <nav class="flex items-center text-xs font-medium text-gray-500 space-x-2" aria-label="Breadcrumb">
            <a href="{{ route('home') }}" class="hover:text-primary-600 transition">Beranda</a>
            <svg class="w-3.5 h-3.5 text-gray-400" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"/></svg>
            <a href="{{ route('housing.index') }}" class="hover:text-primary-600 transition">Pilihan Perumahan</a>
            <svg class="w-3.5 h-3.5 text-gray-400" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"/></svg>
            <span class="text-gray-900 font-semibold truncate">{{ $housing->name }}</span>
        </nav>
    </div>
</div>

{{-- Hero Section --}}
<section class="relative bg-gradient-to-b from-gray-900 via-gray-900 to-slate-900 text-white pt-10 pb-16 overflow-hidden">
    <div class="absolute inset-0 opacity-20 pointer-events-none bg-[radial-gradient(#38bdf8_1px,transparent_1px)] [background-size:24px_24px]"></div>
    
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        {{-- Badge Capsules --}}
        <div class="flex flex-wrap items-center gap-2.5 mb-4">
            @if($housing->developer_name)
            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-white/10 text-white border border-white/15 backdrop-blur-sm">
                <svg class="w-3.5 h-3.5 text-primary-400" fill="currentColor" viewBox="0 0 20 20"><path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"/></svg>
                <span>Developer: {{ $housing->developer_name }}</span>
            </span>
            @endif

            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-emerald-500/20 text-emerald-300 border border-emerald-500/30">
                <svg class="w-3.5 h-3.5 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                <span>{{ $housing->certificate_type ?: 'SHM & PBG Split' }}</span>
            </span>

            @if($housing->badge_text)
                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold uppercase tracking-wider bg-primary-600 text-white shadow-sm">
                    {{ $housing->badge_text }}
                </span>
            @elseif($housing->status === 'ready')
                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-emerald-600 text-white shadow-sm">
                    <span class="w-2 h-2 rounded-full bg-white animate-pulse"></span>
                    <span>Unit Tersedia</span>
                </span>
            @else
                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold uppercase bg-rose-600 text-white shadow-sm">
                    Sold Out
                </span>
            @endif
        </div>

        {{-- Heading & Subheading --}}
        <div class="max-w-4xl">
            <h1 class="text-3xl sm:text-4xl lg:text-5xl font-extrabold tracking-tight text-white mb-3">
                {{ $housing->name }}
            </h1>
            
            <div class="flex flex-wrap items-center gap-x-4 gap-y-2 text-sm sm:text-base text-gray-300 mb-6">
                @if($housing->location_url)
                <a href="{{ $housing->location_url }}" target="_blank" rel="noopener noreferrer" class="inline-flex items-center text-primary-300 hover:text-white transition group underline decoration-primary-400/50 underline-offset-4">
                    <svg class="w-4 h-4 mr-1.5 text-primary-400 group-hover:scale-110 transition flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                    <span>{{ $housing->location }}</span>
                    <span class="ml-1.5 text-xs bg-primary-900/60 text-primary-200 border border-primary-500/30 px-2 py-0.5 rounded">Buka Maps ↗</span>
                </a>
                @else
                <div class="flex items-center text-gray-300">
                    <svg class="w-4 h-4 mr-1.5 text-primary-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                    <span>{{ $housing->location }}</span>
                </div>
                @endif

                <span class="hidden sm:inline text-gray-500">•</span>
                <span class="inline-flex items-center gap-1 text-emerald-400 text-xs sm:text-sm font-medium">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    <span>Hanya 3 Menit ke Alun-Alun Brebes</span>
                </span>
            </div>
        </div>

        {{-- Quick Fact Metrics Strip --}}
        <div class="grid grid-cols-2 sm:grid-cols-4 gap-3 sm:gap-4 pt-4 border-t border-white/10">
            <div class="bg-white/5 border border-white/10 rounded-xl p-3 sm:p-4 backdrop-blur-xs">
                <span class="block text-[11px] uppercase tracking-wider text-gray-400 font-semibold mb-1">Harga Unit</span>
                <span class="text-base sm:text-lg font-black text-white leading-tight">{{ $priceDisplay }}</span>
            </div>

            <div class="bg-white/5 border border-white/10 rounded-xl p-3 sm:p-4 backdrop-blur-xs">
                <span class="block text-[11px] uppercase tracking-wider text-gray-400 font-semibold mb-1">Angsuran KPR FLPP</span>
                <span class="text-base sm:text-lg font-black text-emerald-400 leading-tight">Mulai 1,07 Jt/bln</span>
            </div>

            <div class="bg-white/5 border border-white/10 rounded-xl p-3 sm:p-4 backdrop-blur-xs">
                <span class="block text-[11px] uppercase tracking-wider text-gray-400 font-semibold mb-1">Pilihan Tipe</span>
                <span class="text-base sm:text-lg font-black text-white leading-tight">30/60 & 45/74</span>
            </div>

            <div class="bg-white/5 border border-white/10 rounded-xl p-3 sm:p-4 backdrop-blur-xs">
                <span class="block text-[11px] uppercase tracking-wider text-gray-400 font-semibold mb-1">Lebar Jalan Lingkungan</span>
                <span class="text-base sm:text-lg font-black text-amber-300 leading-tight">Row 8 Meter Cor</span>
            </div>
        </div>
    </div>
</section>

{{-- Sticky Quick Anchor Navigation --}}
<div class="sticky top-[72px] z-40 bg-white/95 backdrop-blur-md border-b border-gray-200 shadow-xs hidden md:block">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center space-x-6 overflow-x-auto py-3 text-xs sm:text-sm font-semibold text-gray-600 no-scrollbar">
            <a href="#tentang" class="hover:text-primary-600 whitespace-nowrap transition py-1">Tentang Kawasan</a>
            <a href="#tipe-rumah" class="hover:text-primary-600 whitespace-nowrap transition py-1">Pilihan Tipe & KPR</a>
            @if(!empty($housing->siteplan_sip_id) || $housing->site_plan)
            <a href="#siteplan" class="hover:text-primary-600 whitespace-nowrap transition py-1 flex items-center gap-1.5">
                <span>Siteplan Realtime</span>
                <span class="w-2 h-2 rounded-full bg-emerald-500 animate-ping"></span>
            </a>
            @endif
            <a href="#fasilitas" class="hover:text-primary-600 whitespace-nowrap transition py-1">Fasilitas</a>
            <a href="#akses" class="hover:text-primary-600 whitespace-nowrap transition py-1">Akses Lokasi</a>
            <a href="#bank-kpr" class="hover:text-primary-600 whitespace-nowrap transition py-1">Bank Rekanan</a>
            <a href="#faq" class="hover:text-primary-600 whitespace-nowrap transition py-1">Tanya Jawab (FAQ)</a>
        </div>
    </div>
</div>

{{-- Main Content Body --}}
<section class="py-10 bg-slate-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 items-start">
            
            {{-- Main Column (2 cols) --}}
            <div class="lg:col-span-2 space-y-8">
                
                {{-- Featured Image / Visual Gallery --}}
                @if($housing->featured_image)
                <div class="relative bg-white rounded-2xl shadow-md overflow-hidden border border-gray-200 group">
                    <img src="{{ get_image_url($housing->featured_image) }}" 
                         alt="{{ $housing->name }} - Kawasan Perumahan Subsidi Pesantunan Brebes" 
                         class="w-full h-[320px] sm:h-[420px] object-cover group-hover:scale-[1.01] transition duration-500" 
                         loading="eager" 
                         width="1200" 
                         height="600">
                    
                    <div class="absolute inset-0 bg-gradient-to-t from-gray-950/80 via-transparent to-transparent flex items-end p-6">
                        <div class="text-white">
                            <span class="text-xs uppercase tracking-widest font-bold text-primary-300">Foto Kawasan Resmi</span>
                            <h2 class="text-xl sm:text-2xl font-bold leading-tight drop-shadow-sm">{{ $housing->name }}</h2>
                            <p class="text-xs sm:text-sm text-gray-200 mt-1">Pesantunan, Wanasari, Kabupaten Brebes</p>
                        </div>
                    </div>

                    @if($housing->video_url)
                    <a href="{{ $housing->video_url }}" target="_blank" rel="noopener noreferrer" class="absolute top-4 right-4 inline-flex items-center gap-2 bg-rose-600 hover:bg-rose-700 text-white text-xs font-bold px-3.5 py-2 rounded-full shadow-lg transition active:scale-95">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M8 5v14l11-7z"/></svg>
                        <span>Tonton Video Tur</span>
                    </a>
                    @endif
                </div>
                @endif

                {{-- 1. Tentang Kawasan & Standar Mutu Bangunan (Antislop grounded copy) --}}
                <div id="tentang" class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6 sm:p-8 scroll-mt-28">
                    <div class="flex items-center gap-3 mb-5">
                        <div class="w-10 h-10 rounded-xl bg-primary-100 text-primary-700 flex items-center justify-center font-bold">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                        </div>
                        <div>
                            <h2 class="text-xl sm:text-2xl font-bold text-gray-900 leading-tight">Tentang {{ $housing->name }}</h2>
                            <p class="text-xs text-gray-500">Legalitas resmi, spesifikasi teruji, dan akses strategis di Brebes</p>
                        </div>
                    </div>

                    {{-- Deskripsi Faktual --}}
                    <div class="prose max-w-none text-gray-700 text-sm sm:text-base leading-relaxed space-y-4">
                        @if(!empty($housing->description))
                            {!! nl2br(e($housing->description)) !!}
                        @else
                            <p><strong>{{ $housing->name }}</strong> merupakan kawasan hunian yang dikembangkan oleh <strong>{{ $housing->developer_name ?: 'PT. Hanaan Jaya Abadi' }}</strong> di Pesantunan, Brebes. Dirancang dengan akses jalan lebar dan tata kelola lingkungan terpadu untuk memberikan kepastian hunian bagi keluarga dan investasi jangka panjang.</p>
                        @endif
                    </div>

                    {{-- 4 Pilar Kepastian & Jaminan Konsumen --}}
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mt-6 pt-6 border-t border-gray-100">
                        <div class="flex items-start gap-3 p-3.5 rounded-xl bg-slate-50 border border-slate-100">
                            <div class="w-8 h-8 rounded-lg bg-emerald-100 text-emerald-700 flex items-center justify-center flex-shrink-0 mt-0.5">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                            </div>
                            <div>
                                <h3 class="text-xs font-bold text-gray-900 uppercase tracking-wide">Legalitas Siap Akad</h3>
                                <p class="text-xs text-gray-600 mt-0.5">Sertifikat Hak Milik (SHM) dan PBG sudah dipecah per kavling, bebas sengketa.</p>
                            </div>
                        </div>

                        <div class="flex items-start gap-3 p-3.5 rounded-xl bg-slate-50 border border-slate-100">
                            <div class="w-8 h-8 rounded-lg bg-blue-100 text-blue-700 flex items-center justify-center flex-shrink-0 mt-0.5">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                            </div>
                            <div>
                                <h3 class="text-xs font-bold text-gray-900 uppercase tracking-wide">Infrastruktur Lengkap</h3>
                                <p class="text-xs text-gray-600 mt-0.5">Jalan cor beton selebar 8 meter, saluran drainase tertata, dan jaringan listrik PLN siap pakai.</p>
                            </div>
                        </div>

                        <div class="flex items-start gap-3 p-3.5 rounded-xl bg-slate-50 border border-slate-100">
                            <div class="w-8 h-8 rounded-lg bg-amber-100 text-amber-700 flex items-center justify-center flex-shrink-0 mt-0.5">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            </div>
                            <div>
                                <h3 class="text-xs font-bold text-gray-900 uppercase tracking-wide">KPR Subsidi Pemerintah</h3>
                                <p class="text-xs text-gray-600 mt-0.5">Bunga tetap (flat) 5% sampai lunas melalui program FLPP bank rekanan terpercaya.</p>
                            </div>
                        </div>

                        <div class="flex items-start gap-3 p-3.5 rounded-xl bg-slate-50 border border-slate-100">
                            <div class="w-8 h-8 rounded-lg bg-indigo-100 text-indigo-700 flex items-center justify-center flex-shrink-0 mt-0.5">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/></svg>
                            </div>
                            <div>
                                <h3 class="text-xs font-bold text-gray-900 uppercase tracking-wide">Akses Pusat Kota</h3>
                                <p class="text-xs text-gray-600 mt-0.5">Hanya 3 - 5 menit dari Alun-Alun, Stasiun Kereta Api, dan RSUD Brebes.</p>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- 2. Pilihan Tipe Rumah & Detail Simulasi KPR --}}
                @if($housing->types->count() > 0)
                <div id="tipe-rumah" class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6 sm:p-8 scroll-mt-28">
                    <div class="flex items-center justify-between flex-wrap gap-4 mb-6">
                        <div>
                            <span class="text-xs font-bold uppercase tracking-wider text-primary-600">Pilihan Unit Hunian</span>
                            <h2 class="text-xl sm:text-2xl font-bold text-gray-900 leading-tight">Tipe Rumah & Skema Angsuran</h2>
                        </div>
                        <span class="text-xs text-gray-500 bg-gray-100 px-3 py-1 rounded-full font-medium">Tersedia {{ $housing->types->count() }} Pilihan Tipe</span>
                    </div>

                    <div class="space-y-6">
                        @foreach($housing->types as $type)
                        <div class="border border-gray-200 rounded-xl overflow-hidden hover:border-primary-500 hover:shadow-md transition bg-white">
                            {{-- Header Card Tipe --}}
                            <div class="p-5 sm:p-6 bg-gradient-to-r from-gray-50 to-white border-b border-gray-100 flex flex-wrap items-center justify-between gap-4">
                                <div>
                                    <div class="flex items-center gap-2 mb-1">
                                        <h3 class="text-xl font-bold text-gray-900">Tipe {{ $type->name }}</h3>
                                        @if(stripos($type->name, 'subsidi') !== false)
                                        <span class="px-2.5 py-0.5 rounded-full text-[11px] font-bold bg-emerald-100 text-emerald-800 border border-emerald-200">KPR Subsidi FLPP</span>
                                        @else
                                        <span class="px-2.5 py-0.5 rounded-full text-[11px] font-bold bg-blue-100 text-blue-800 border border-blue-200">Komersil</span>
                                        @endif
                                    </div>
                                    <p class="text-xs text-gray-500">{{ $housing->name }} • Pesantunan Brebes</p>
                                </div>

                                <div class="text-right">
                                    <span class="text-xs text-gray-500 block">Harga Mulai</span>
                                    <span class="text-xl sm:text-2xl font-extrabold text-primary-600">
                                        {{ $type->price ? 'Rp ' . number_format($type->price, 0, ',', '.') : $type->approximate_price }}
                                    </span>
                                </div>
                            </div>

                            {{-- Body: Spesifikasi & Simulasi KPR --}}
                            <div class="p-5 sm:p-6 grid grid-cols-1 md:grid-cols-2 gap-6 items-start">
                                {{-- Kolom Spesifikasi & Denah --}}
                                <div class="space-y-4">
                                    {{-- Mini Spec Badges --}}
                                    <div class="grid grid-cols-2 sm:grid-cols-4 gap-2 text-center">
                                        <div class="p-2.5 bg-gray-50 rounded-lg border border-gray-100">
                                            <span class="text-[10px] uppercase font-semibold text-gray-400 block">Luas Tanah</span>
                                            <span class="text-sm font-bold text-gray-800">{{ $type->land_size ? $type->land_size . ' m²' : '-' }}</span>
                                        </div>
                                        <div class="p-2.5 bg-gray-50 rounded-lg border border-gray-100">
                                            <span class="text-[10px] uppercase font-semibold text-gray-400 block">Luas Bangunan</span>
                                            <span class="text-sm font-bold text-gray-800">{{ $type->building_size ? $type->building_size . ' m²' : '-' }}</span>
                                        </div>
                                        <div class="p-2.5 bg-gray-50 rounded-lg border border-gray-100">
                                            <span class="text-[10px] uppercase font-semibold text-gray-400 block">Kamar Tidur</span>
                                            <span class="text-sm font-bold text-gray-800">{{ $type->bedrooms }} Ruang</span>
                                        </div>
                                        <div class="p-2.5 bg-gray-50 rounded-lg border border-gray-100">
                                            <span class="text-[10px] uppercase font-semibold text-gray-400 block">Kamar Mandi</span>
                                            <span class="text-sm font-bold text-gray-800">{{ $type->bathrooms }} Ruang</span>
                                        </div>
                                    </div>

                                    @if($type->promo_title)
                                    <div class="p-3 bg-amber-50 border border-amber-200 rounded-lg flex items-start gap-2.5 text-xs text-amber-900">
                                        <svg class="w-4 h-4 text-amber-600 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"/></svg>
                                        <div>
                                            <span class="font-bold">Promo Aktif:</span> {{ $type->promo_title }}
                                            @if($type->promo_description)
                                            <p class="text-amber-800 mt-0.5">{{ $type->promo_description }}</p>
                                            @endif
                                        </div>
                                    </div>
                                    @endif

                                    @if($type->floor_plan)
                                    <div class="border border-gray-200 rounded-lg overflow-hidden bg-gray-50 text-center">
                                        <img src="{{ get_image_url($type->floor_plan) }}" alt="Denah Rumah Tipe {{ $type->name }}" class="w-full max-h-48 object-contain mx-auto" loading="lazy">
                                        <span class="block py-1 text-[11px] font-semibold text-gray-500 bg-gray-100">Denah Tata Ruang Tipe {{ $type->name }}</span>
                                    </div>
                                    @endif
                                </div>

                                {{-- Kolom Simulasi Angsuran KPR --}}
                                <div class="bg-slate-50 border border-slate-200 rounded-xl p-4 sm:p-5 flex flex-col justify-between h-full">
                                    <div>
                                        <div class="flex items-center justify-between mb-3">
                                            <h4 class="text-xs font-bold uppercase tracking-wider text-gray-700">Estimasi Angsuran KPR</h4>
                                            <span class="text-[10px] font-semibold bg-emerald-100 text-emerald-800 px-2 py-0.5 rounded">Bunga Tetap FLPP 5%</span>
                                        </div>

                                        @if($type->installmentPlans && $type->installmentPlans->count() > 0)
                                        <div class="space-y-2 mb-4">
                                            @foreach($type->installmentPlans->sortBy('tenor_years') as $plan)
                                            <div class="flex items-center justify-between p-2.5 rounded-lg bg-white border border-gray-200/80 text-xs">
                                                <div class="flex items-center gap-2">
                                                    <span class="w-2 h-2 rounded-full bg-primary-600"></span>
                                                    <span class="font-medium text-gray-700">Tenor {{ $plan->tenor_years }} Tahun</span>
                                                </div>
                                                <div class="text-right">
                                                    <span class="font-bold text-gray-900 text-sm">Rp {{ number_format($plan->monthly_payment, 0, ',', '.') }}</span>
                                                    <span class="text-[10px] text-gray-500 block">/ bulan (flat)</span>
                                                </div>
                                            </div>
                                            @endforeach
                                        </div>
                                        @else
                                        <p class="text-xs text-gray-500 mb-4">Simulasi KPR fleksibel menyesuaikan DP dan tenor bank pilihan Anda.</p>
                                        @endif
                                    </div>

                                    <div class="pt-3 border-t border-slate-200 flex flex-col sm:flex-row items-center gap-2.5">
                                        <a href="{{ route('housing.type', [$housing->slug, $type->slug]) }}" 
                                           class="w-full sm:w-auto flex-1 inline-flex items-center justify-center gap-1.5 bg-primary-600 hover:bg-primary-700 text-white px-4 py-2.5 rounded-lg text-xs font-bold transition shadow-xs">
                                            <span>Lihat Spesifikasi Lengkap</span>
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                                        </a>

                                        @if(isset($marketings) && $marketings->first())
                                        <a href="{{ $marketings->first()->whatsapp_link }}?text={{ urlencode('Halo Sulthan Property, saya ingin konsultasi KPR Tipe ' . $type->name . ' di ' . $housing->name) }}"
                                           target="_blank"
                                           rel="noopener noreferrer"
                                           class="w-full sm:w-auto inline-flex items-center justify-center gap-1.5 bg-emerald-600 hover:bg-emerald-700 text-white px-4 py-2.5 rounded-lg text-xs font-bold transition shadow-xs">
                                            <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
                                            <span>Ajukan Tipe Ini</span>
                                        </a>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endif

                {{-- 3. Site Plan Interaktif Realtime --}}
                @if(!empty($housing->siteplan_sip_id))
                <div id="siteplan" x-data="siteplanViewer('{{ $housing->siteplan_sip_id }}')" class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden scroll-mt-28">
                    {{-- Header & Capsule Legend Bar --}}
                    <div class="px-5 py-4 border-b border-gray-100 flex flex-wrap items-center justify-between gap-4 bg-white">
                        <div>
                            <div class="flex items-center gap-2">
                                <span class="relative flex h-2.5 w-2.5">
                                    <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                                    <span class="relative inline-flex rounded-full h-2.5 w-2.5 bg-emerald-500"></span>
                                </span>
                                <h2 class="text-lg font-bold text-gray-900 leading-tight">Siteplan Interaktif Realtime</h2>
                            </div>
                            <p class="text-xs text-gray-500 mt-0.5">Status ketersediaan kavling terhubung langsung ke sistem database SIP</p>
                        </div>

                        <div class="flex items-center flex-wrap gap-2.5">
                            <template x-if="data && data.statusBloks">
                                <div class="flex items-center gap-2">
                                    <template x-for="st in data.statusBloks" :key="st.id">
                                        <div class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full text-xs font-semibold border shadow-xs transition-all"
                                             :class="isWhite(st.warna) ? 'bg-emerald-50/90 border-emerald-200 text-emerald-900' : 'bg-rose-50/90 border-rose-200 text-rose-900'">
                                            <span class="w-2.5 h-2.5 rounded-full" 
                                                  :class="isWhite(st.warna) ? 'bg-emerald-500 ring-2 ring-emerald-200' : 'bg-rose-500 ring-2 ring-rose-200'"></span>
                                            <span x-text="st.nama"></span>
                                            <span x-show="data.stats && data.stats[st.id] !== undefined" 
                                                  class="inline-flex items-center justify-center min-w-[20px] px-1.5 py-0.5 rounded-full text-[11px] font-black text-white"
                                                  :class="isWhite(st.warna) ? 'bg-emerald-600' : 'bg-rose-600'"
                                                  x-text="data.stats[st.id]"></span>
                                        </div>
                                    </template>
                                </div>
                            </template>

                            <a href="https://sip.sulthanproperty.com/embed/siteplan/{{ $housing->siteplan_sip_id }}" 
                               target="_blank" 
                               rel="noopener noreferrer" 
                               class="inline-flex items-center gap-1.5 text-xs font-semibold text-gray-700 hover:text-primary-600 bg-gray-50 hover:bg-gray-100 border border-gray-200 px-3.5 py-1.5 rounded-full transition shadow-xs active:scale-95"
                               title="Buka tampilan penuh di tab baru">
                                <span>Buka Penuh</span>
                                <svg class="w-3.5 h-3.5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                            </a>
                        </div>
                    </div>

                    {{-- Canvas Container --}}
                    <div x-ref="siteplanContainer" class="relative w-full overflow-hidden bg-gray-950 flex items-center justify-center min-h-[420px]">
                        {{-- Loading --}}
                        <div x-show="loading" class="absolute inset-0 flex flex-col items-center justify-center bg-white/90 z-20">
                            <div class="w-10 h-10 border-4 border-primary-500 border-t-transparent rounded-full animate-spin mb-3"></div>
                            <span class="text-sm font-medium text-gray-700">Menghubungkan ke server denah kavling...</span>
                        </div>

                        {{-- Fallback Gambar jika Error --}}
                        <div x-show="error && !loading" class="w-full">
                            @if($housing->site_plan)
                            <img src="{{ get_image_url($housing->site_plan) }}" alt="Site Plan {{ $housing->name }}" class="w-full h-auto" loading="lazy">
                            @else
                            <div class="p-12 text-center text-gray-400 text-sm">
                                Denah siteplan sedang dalam sinkronisasi sistem.
                            </div>
                            @endif
                        </div>

                        {{-- Interactive SVG Overlay --}}
                        <div x-show="!loading && !error && data" class="relative w-full">
                            <template x-if="data && data.proyek && data.proyek.siteplan">
                                <img x-ref="siteplanImage"
                                     :src="data.proyek.siteplan" 
                                     alt="Siteplan Denah {{ $housing->name }}" 
                                     class="w-full h-auto block select-none pointer-events-none"
                                     @load="onImgLoad($event)">
                            </template>

                            <svg x-ref="svgOverlay"
                                 :viewBox="`0 0 ${imgDimensions.width} ${imgDimensions.height}`" 
                                 class="absolute inset-0 w-full h-full pointer-events-auto"
                                 preserveAspectRatio="none">
                            </svg>

                            {{-- Floating Hover Tooltip --}}
                            <div x-show="hoveredBlok" 
                                 x-cloak
                                 class="absolute z-30 pointer-events-none bg-white/95 backdrop-blur-md border shadow-xl rounded-xl p-3 min-w-[150px] transition-all duration-75 text-left"
                                 :style="`left: ${tooltip.x}px; top: ${tooltip.y}px; border-color: ${hoveredBlok?.status_warna || '#cbd5e1'};`">
                                <div class="flex items-center justify-between gap-2 mb-1">
                                    <span class="text-[10px] font-bold uppercase tracking-wider text-gray-400">Nomor Kavling</span>
                                    <span class="w-2.5 h-2.5 rounded-full" :style="`background-color: ${hoveredBlok?.status_warna || '#94a3b8'};`"></span>
                                </div>
                                <div class="text-xl font-extrabold text-gray-900 leading-none mb-1.5" x-text="hoveredBlok?.nama"></div>
                                <div class="inline-block px-2 py-0.5 rounded text-[11px] font-bold text-white mb-2"
                                     :style="`background-color: ${hoveredBlok?.status_warna || '#ef4444'};`"
                                     x-text="hoveredBlok?.status_nama"></div>
                                <div class="text-xs text-gray-600 border-t border-gray-100 pt-1.5 flex justify-between">
                                    <span>Tipe:</span>
                                    <span class="font-bold text-gray-800" x-text="hoveredBlok?.tipe || '-'"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @elseif($housing->site_plan)
                <div id="siteplan" class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden p-6 scroll-mt-28">
                    <h2 class="text-xl font-bold text-gray-900 mb-4">Denah Kawasan (Siteplan)</h2>
                    <img src="{{ get_image_url($housing->site_plan) }}" alt="Site Plan {{ $housing->name }}" class="w-full h-auto rounded-lg" loading="lazy" width="800" height="500">
                </div>
                @endif

                {{-- 4. Fasilitas Kawasan --}}
                @if($housing->facilities->count() > 0)
                <div id="fasilitas" class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6 sm:p-8 scroll-mt-28">
                    <div class="flex items-center gap-3 mb-6">
                        <div class="w-10 h-10 rounded-xl bg-emerald-100 text-emerald-700 flex items-center justify-center font-bold">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"/></svg>
                        </div>
                        <div>
                            <span class="text-xs font-bold uppercase tracking-wider text-emerald-600">Kenyamanan Lingkungan</span>
                            <h2 class="text-xl sm:text-2xl font-bold text-gray-900 leading-tight">Fasilitas Dalam Kawasan</h2>
                        </div>
                    </div>

                    <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-5 gap-4">
                        @foreach($housing->facilities as $facility)
                        <div class="flex flex-col items-center text-center p-4 rounded-xl bg-slate-50 border border-slate-100 hover:border-primary-200 hover:bg-white hover:shadow-xs transition">
                            @if($facility->icon)
                            <div class="w-14 h-14 mb-3 flex items-center justify-center">
                                <img src="{{ get_image_url($facility->icon) }}" alt="{{ $facility->name }}" class="w-full h-full object-contain" loading="lazy" width="56" height="56">
                            </div>
                            @else
                            <div class="w-14 h-14 mb-3 bg-primary-50 text-primary-600 rounded-full flex items-center justify-center">
                                <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                            </div>
                            @endif
                            <p class="text-gray-900 font-bold text-xs sm:text-sm">{{ $facility->name }}</p>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endif

                {{-- 5. Aksesibilitas & Estimasi Jarak Tempuh --}}
                @if($housing->accessPoints->count() > 0)
                <div id="akses" class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6 sm:p-8 scroll-mt-28">
                    <div class="flex items-center justify-between flex-wrap gap-4 mb-6">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-xl bg-blue-100 text-blue-700 flex items-center justify-center font-bold">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            </div>
                            <div>
                                <span class="text-xs font-bold uppercase tracking-wider text-blue-600">Aksesibilitas Cepat</span>
                                <h2 class="text-xl sm:text-2xl font-bold text-gray-900 leading-tight">Waktu Tempuh ke Fasilitas Publik</h2>
                            </div>
                        </div>

                        @if($housing->location_url)
                        <a href="{{ $housing->location_url }}" target="_blank" rel="noopener noreferrer" class="inline-flex items-center gap-1.5 text-xs font-bold text-primary-600 hover:text-primary-700 bg-primary-50 px-3.5 py-2 rounded-lg border border-primary-100 transition">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"/></svg>
                            <span>Buka Rute Navigasi</span>
                        </a>
                        @endif
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 sm:gap-4">
                        @foreach($housing->accessPoints->sortBy('order') as $accessPoint)
                        <div class="flex items-center justify-between p-3.5 rounded-xl bg-slate-50 border border-slate-100 hover:bg-white hover:border-gray-200 transition">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-full bg-primary-100 text-primary-700 flex items-center justify-center flex-shrink-0">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/></svg>
                                </div>
                                <span class="text-xs sm:text-sm font-semibold text-gray-800">{{ $accessPoint->destination }}</span>
                            </div>
                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-bold bg-blue-50 text-blue-700 border border-blue-200">
                                {{ $accessPoint->duration_minutes }} Menit
                            </span>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endif

                {{-- 6. Bank Rekanan KPR Terpercaya --}}
                <div id="bank-kpr" class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6 sm:p-8 scroll-mt-28">
                    <div class="flex items-center gap-3 mb-6">
                        <div class="w-10 h-10 rounded-xl bg-primary-100 text-primary-700 flex items-center justify-center font-bold">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/></svg>
                        </div>
                        <div>
                            <span class="text-xs font-bold uppercase tracking-wider text-primary-600">Kerjasama Pembiayaan KPR</span>
                            <h2 class="text-xl sm:text-2xl font-bold text-gray-900 leading-tight">Bank Rekanan Resmi</h2>
                        </div>
                    </div>

                    <p class="text-xs sm:text-sm text-gray-600 mb-6 leading-relaxed">
                        Sulthan Property bermitra dengan bank-bank BUMN dan Bank Daerah resmi untuk memfasilitasi pengajuan KPR Subsidi FLPP maupun KPR Komersil dengan suku bunga kompetitif dan proses berkas yang didampingi hingga akad kredit.
                    </p>

                    @php
                        // Ambil bank partner dari tipe unit yang terdaftar
                        $partnerBanks = $housing->types->flatMap->bankPartners->unique('id');
                    @endphp

                    @if($partnerBanks->count() > 0)
                    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-6 gap-3 sm:gap-4">
                        @foreach($partnerBanks as $bank)
                        <div class="p-3 rounded-xl bg-slate-50 border border-slate-100 flex flex-col items-center justify-center text-center hover:bg-white hover:shadow-xs transition min-h-[90px]">
                            @if($bank->logo)
                            <img src="{{ get_image_url($bank->logo) }}" alt="KPR {{ $bank->name }}" class="max-h-9 max-w-full object-contain mb-1.5" loading="lazy">
                            @endif
                            <span class="text-[11px] font-bold text-gray-700">{{ $bank->name }}</span>
                        </div>
                        @endforeach
                    </div>
                    @endif
                </div>

                {{-- 7. Tanya Jawab Seputar Almaz de Mansion (FAQ Accordion Native Alpine.js) --}}
                <div id="faq" class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6 sm:p-8 scroll-mt-28">
                    <div class="flex items-center gap-3 mb-6">
                        <div class="w-10 h-10 rounded-xl bg-purple-100 text-purple-700 flex items-center justify-center font-bold">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        </div>
                        <div>
                            <span class="text-xs font-bold uppercase tracking-wider text-purple-600">Informasi Penting Konsumen</span>
                            <h2 class="text-xl sm:text-2xl font-bold text-gray-900 leading-tight">Tanya Jawab (FAQ)</h2>
                        </div>
                    </div>

                    <div x-data="{ activeAccordion: null }" class="space-y-3">
                        {{-- FAQ 1 --}}
                        <div class="border border-gray-200 rounded-xl overflow-hidden">
                            <button @click="activeAccordion = (activeAccordion === 1 ? null : 1)" 
                                    class="w-full flex items-center justify-between p-4 sm:p-5 text-left font-bold text-sm sm:text-base text-gray-900 bg-gray-50 hover:bg-gray-100 transition">
                                <span>Berapa kisaran cicilan bulanan KPR di {{ $housing->name }}?</span>
                                <svg class="w-5 h-5 text-gray-500 transition-transform duration-200" :class="activeAccordion === 1 ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                            </button>
                            <div x-show="activeAccordion === 1" x-collapse class="p-4 sm:p-5 text-xs sm:text-sm text-gray-700 leading-relaxed bg-white border-t border-gray-100">
                                Untuk unit subsidi Tipe 30/60 dengan program KPR FLPP pemerintah, angsuran bersifat flat (tidak naik selama tenor) mulai dari Rp 1.070.000/bulan untuk tenor 20 tahun, Rp 1.285.000/bulan untuk 15 tahun, dan Rp 1.730.000/bulan untuk 10 tahun.
                            </div>
                        </div>

                        {{-- FAQ 2 --}}
                        <div class="border border-gray-200 rounded-xl overflow-hidden">
                            <button @click="activeAccordion = (activeAccordion === 2 ? null : 2)" 
                                    class="w-full flex items-center justify-between p-4 sm:p-5 text-left font-bold text-sm sm:text-base text-gray-900 bg-gray-50 hover:bg-gray-100 transition">
                                <span>Bagaimana kepastian legalitas dan status tanah kavling?</span>
                                <svg class="w-5 h-5 text-gray-500 transition-transform duration-200" :class="activeAccordion === 2 ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                            </button>
                            <div x-show="activeAccordion === 2" x-collapse class="p-4 sm:p-5 text-xs sm:text-sm text-gray-700 leading-relaxed bg-white border-t border-gray-100">
                                Legalitas tanah dan bangunan sudah berstatus Sertifikat Hak Milik (SHM) serta Persetujuan Bangunan Gedung (PBG) yang telah siap split per kavling, sehingga Anda mendapatkan kepastian hukum saat proses akad dan balik nama.
                            </div>
                        </div>

                        {{-- FAQ 3 --}}
                        <div class="border border-gray-200 rounded-xl overflow-hidden">
                            <button @click="activeAccordion = (activeAccordion === 3 ? null : 3)" 
                                    class="w-full flex items-center justify-between p-4 sm:p-5 text-left font-bold text-sm sm:text-base text-gray-900 bg-gray-50 hover:bg-gray-100 transition">
                                <span>Apa saja syarat untuk mengajukan KPR Subsidi FLPP?</span>
                                <svg class="w-5 h-5 text-gray-500 transition-transform duration-200" :class="activeAccordion === 3 ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                            </button>
                            <div x-show="activeAccordion === 3" x-collapse class="p-4 sm:p-5 text-xs sm:text-sm text-gray-700 leading-relaxed bg-white border-t border-gray-100">
                                Syarat utama antara lain: WNI berusia minimal 21 tahun atau sudah menikah, belum pernah memiliki rumah atas nama sendiri, penghasilan bulanan sesuai ambang batas subsidi pemerintah, dan memiliki riwayat kredit lancar (BI Checking / SLIK OJK bersih). Tim kami siap membantu verifikasi berkas Anda secara gratis.
                            </div>
                        </div>

                        {{-- FAQ 4 --}}
                        <div class="border border-gray-200 rounded-xl overflow-hidden">
                            <button @click="activeAccordion = (activeAccordion === 4 ? null : 4)" 
                                    class="w-full flex items-center justify-between p-4 sm:p-5 text-left font-bold text-sm sm:text-base text-gray-900 bg-gray-50 hover:bg-gray-100 transition">
                                <span>Apakah lokasi perumahan aman dan bebas banjir?</span>
                                <svg class="w-5 h-5 text-gray-500 transition-transform duration-200" :class="activeAccordion === 4 ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                            </button>
                            <div x-show="activeAccordion === 4" x-collapse class="p-4 sm:p-5 text-xs sm:text-sm text-gray-700 leading-relaxed bg-white border-t border-gray-100">
                                Kawasan Pesantunan ini dirancang dengan elevasi tanah yang aman dari genangan serta didukung saluran drainase terpadu. Lingkungan perumahan juga telah dihuni dan terpelihara dengan baik.
                            </div>
                        </div>

                        {{-- FAQ 5 --}}
                        <div class="border border-gray-200 rounded-xl overflow-hidden">
                            <button @click="activeAccordion = (activeAccordion === 5 ? null : 5)" 
                                    class="w-full flex items-center justify-between p-4 sm:p-5 text-left font-bold text-sm sm:text-base text-gray-900 bg-gray-50 hover:bg-gray-100 transition">
                                <span>Bagaimana cara booking unit dan survei ke lokasi?</span>
                                <svg class="w-5 h-5 text-gray-500 transition-transform duration-200" :class="activeAccordion === 5 ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                            </button>
                            <div x-show="activeAccordion === 5" x-collapse class="p-4 sm:p-5 text-xs sm:text-sm text-gray-700 leading-relaxed bg-white border-t border-gray-100">
                                Anda cukup menghubungi tim marketing Sulthan Property melalui tombol WhatsApp di halaman ini. Tim kami akan mendampingi Anda langsung ke lokasi proyek untuk melihat unit contoh serta memilih nomor kavling di denah siteplan.
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            {{-- Sidebar Column (1 col, Sticky) --}}
            <div class="lg:col-span-1 space-y-6 lg:sticky lg:top-28">
                
                {{-- Card Aksi & Informasi Pembelian --}}
                <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6">
                    <div class="mb-5 pb-5 border-b border-gray-100">
                        <span class="text-xs font-bold uppercase tracking-wider text-primary-600 block mb-1">Peluang Hunian Terbaik</span>
                        <div class="text-2xl font-black text-gray-900 leading-tight">
                            {{ $priceDisplay }}
                        </div>
                        <p class="text-xs text-gray-500 mt-1">Angsuran tetap mulai Rp 1,07 Juta / bulan</p>
                    </div>

                    {{-- WhatsApp Primary Action --}}
                    @php
                        $leadMarketing = (isset($marketings) && $marketings->isNotEmpty()) ? $marketings->first() : null;
                        $waUrl = $leadMarketing ? $leadMarketing->whatsapp_link : 'https://wa.me/6287849759572';
                        $waText = urlencode("Halo Sulthan Property, saya berminat dengan perumahan " . $housing->name . " di Pesantunan Brebes. Mohon info ketersediaan unit dan simulasi angsuran.");
                    @endphp

                    <div class="space-y-3 mb-6">
                        <a href="{{ $waUrl }}?text={{ $waText }}" 
                           target="_blank" 
                           rel="noopener noreferrer" 
                           class="w-full inline-flex items-center justify-center gap-2 bg-emerald-600 hover:bg-emerald-700 text-white font-bold py-3.5 px-4 rounded-xl shadow-md shadow-emerald-600/20 transition active:scale-98 text-sm">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
                            <span>Konsultasi WhatsApp Cepat</span>
                        </a>

                        <a href="{{ route('marketing.index') }}" 
                           class="w-full inline-flex items-center justify-center gap-2 bg-slate-900 hover:bg-slate-800 text-white font-semibold py-3 px-4 rounded-xl transition text-xs">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                            <span>Pilih Tim Marketing</span>
                        </a>

                        @if($housing->brochure_file)
                        <a href="{{ get_image_url($housing->brochure_file) }}" 
                           download 
                           target="_blank" 
                           class="w-full inline-flex items-center justify-center gap-2 bg-gray-100 hover:bg-gray-200 text-gray-800 font-semibold py-2.5 px-4 rounded-xl transition text-xs border border-gray-200">
                            <svg class="w-4 h-4 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                            <span>Unduh Brosur Resmi (PDF)</span>
                        </a>
                        @else
                        <a href="{{ route('home') }}#contact-form" 
                           class="w-full inline-flex items-center justify-center gap-2 bg-gray-100 hover:bg-gray-200 text-gray-800 font-semibold py-2.5 px-4 rounded-xl transition text-xs border border-gray-200">
                            <svg class="w-4 h-4 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                            <span>Minta Brosur Lengkap</span>
                        </a>
                        @endif
                    </div>

                    {{-- Info Singkat Jam Buka --}}
                    <div class="text-[11px] text-gray-500 bg-gray-50 p-3 rounded-lg space-y-1">
                        <div class="flex items-center justify-between">
                            <span>Layanan Survey:</span>
                            <span class="font-bold text-gray-700">Senin - Minggu</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span>Jam Operasional:</span>
                            <span class="font-bold text-gray-700">08.00 - 17.00 WIB</span>
                        </div>
                        <p class="text-gray-400 pt-1 border-t border-gray-200/60">Gratis konsultasi berkas & survey lokasi bersama tim marketing resmi.</p>
                    </div>
                </div>

                {{-- Card Tim Marketing --}}
                @if(isset($marketings) && $marketings->count() > 0)
                <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6">
                    <h3 class="text-sm font-bold text-gray-900 mb-4 flex items-center justify-between">
                        <span>Tim Marketing Resmi</span>
                        <a href="{{ route('marketing.index') }}" class="text-xs text-primary-600 hover:underline">Semua</a>
                    </h3>

                    <div class="space-y-3">
                        @foreach($marketings as $member)
                        <div class="flex items-center justify-between p-3 rounded-xl bg-slate-50 border border-slate-100">
                            <div class="flex items-center gap-3">
                                @if($member->photo)
                                <img src="{{ get_image_url($member->photo) }}" alt="{{ $member->name }}" class="w-10 h-10 rounded-full object-cover border border-gray-200" loading="lazy">
                                @else
                                <div class="w-10 h-10 rounded-full bg-primary-100 text-primary-700 flex items-center justify-center font-bold text-sm">
                                    {{ substr($member->name, 0, 1) }}
                                </div>
                                @endif
                                <div>
                                    <h4 class="text-xs font-bold text-gray-900 leading-tight">{{ $member->name }}</h4>
                                    <p class="text-[11px] text-gray-500">{{ $member->position ?: 'Property Consultant' }}</p>
                                </div>
                            </div>

                            <a href="{{ $member->whatsapp_link }}?text={{ $waText }}" 
                               target="_blank" 
                               rel="noopener noreferrer" 
                               class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-emerald-500 hover:bg-emerald-600 text-white transition shadow-xs"
                               title="Chat WhatsApp {{ $member->name }}">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
                            </a>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endif

            </div>

        </div>
    </div>
</section>
@endsection

@if(!empty($housing->siteplan_sip_id))
@push('scripts')
<script>
function siteplanViewer(sipId) {
    return {
        loading: true,
        error: false,
        data: null,
        hoveredBlok: null,
        tooltip: { x: 0, y: 0 },
        imgDimensions: { width: 1714, height: 2336 },
        init() {
            fetch('https://sip.sulthanproperty.com/api/public/siteplan/' + sipId)
                .then(res => {
                    if (!res.ok) throw new Error('Network error: ' + res.status);
                    return res.json();
                })
                .then(json => {
                    this.data = json;
                    this.loading = false;
                    this.$nextTick(() => {
                        this.syncDimensions();
                        this.renderSvg();
                        this.attachEvents();
                    });
                })
                .catch(err => {
                    console.warn('Gagal memuat API SIP siteplan:', err);
                    this.error = true;
                    this.loading = false;
                });
        },
        syncDimensions() {
            const img = this.$refs.siteplanImage;
            if (img && img.naturalWidth && img.naturalHeight) {
                this.imgDimensions = {
                    width: img.naturalWidth,
                    height: img.naturalHeight
                };
            }
        },
        onImgLoad(e) {
            if (e.target.naturalWidth && e.target.naturalHeight) {
                this.imgDimensions = {
                    width: e.target.naturalWidth,
                    height: e.target.naturalHeight
                };
            }
            this.renderSvg();
            this.attachEvents();
        },
        pathToPoints(path) {
            if (!path) return '';
            const nums = path.match(/-?[\d.]+/g);
            if (!nums || nums.length < 8) return '';
            return `${nums[0]},${nums[1]} ${nums[2]},${nums[3]} ${nums[4]},${nums[5]} ${nums[6]},${nums[7]}`;
        },
        getCenter(path) {
            if (!path) return { x: 0, y: 0 };
            const nums = path.match(/-?[\d.]+/g);
            if (!nums || nums.length < 8) return { x: 0, y: 0 };
            return {
                x: (parseFloat(nums[0]) + parseFloat(nums[2]) + parseFloat(nums[4]) + parseFloat(nums[6])) / 4,
                y: (parseFloat(nums[1]) + parseFloat(nums[3]) + parseFloat(nums[5]) + parseFloat(nums[7])) / 4
            };
        },
        isWhite(color) {
            return !color || color.toLowerCase() === '#ffffff' || color.toLowerCase() === '#fff' || color.toLowerCase() === 'white';
        },
        hexToRgba(hex, alpha) {
            if (!hex) return `rgba(239, 68, 68, ${alpha})`;
            const clean = hex.replace('#', '');
            const r = parseInt(clean.substring(0, 2), 16) || 239;
            const g = parseInt(clean.substring(2, 4), 16) || 68;
            const b = parseInt(clean.substring(4, 6), 16) || 68;
            return `rgba(${r}, ${g}, ${b}, ${alpha})`;
        },
        renderSvg() {
            const svg = this.$refs.svgOverlay;
            if (!svg || !this.data || !this.data.bloks) return;

            const width = this.imgDimensions.width;
            const height = this.imgDimensions.height;
            svg.setAttribute('viewBox', `0 0 ${width} ${height}`);
            svg.setAttribute('preserveAspectRatio', 'none');

            const fontSize = Math.max(12, Math.round(width * 0.012));
            let html = '';

            this.data.bloks.forEach(blok => {
                const points = this.pathToPoints(blok.svg_path);
                if (!points) return;

                const isHovered = this.hoveredBlok && this.hoveredBlok.id === blok.id;
                const color = blok.status_warna || (blok.status_id === 1 ? '#ffffff' : '#ef4444');
                const isTersedia = this.isWhite(color);

                // Warna booking merah transparan (0.60), saat di-hover lebih pekat (0.85)
                const fill = isHovered 
                    ? (isTersedia ? 'rgba(255, 255, 255, 0.95)' : this.hexToRgba(color, 0.85))
                    : (isTersedia ? 'rgba(255, 255, 255, 0.50)' : this.hexToRgba(color, 0.60));

                const stroke = isHovered ? '#0f172a' : (isTersedia ? '#10b981' : color);
                const strokeWidth = isHovered ? 2.5 : 1.5;
                const center = this.getCenter(blok.svg_path);

                html += `
                    <g class="cursor-pointer" data-blok-id="${blok.id}">
                        <polygon points="${points}" 
                                 fill="${fill}" 
                                 stroke="${stroke}" 
                                 stroke-width="${strokeWidth}" 
                                 stroke-linejoin="round" 
                                 style="transition: all 0.15s ease;" />
                        <text x="${center.x}" y="${center.y + (fontSize * 0.35)}" 
                              text-anchor="middle" 
                              font-weight="800" 
                              font-size="${fontSize}px" 
                              fill="#0f172a" 
                              style="font-family: inherit; paint-order: stroke; stroke: #ffffff; stroke-width: 3px; stroke-linejoin: round; pointer-events: none; user-select: none;">
                            ${blok.nama}
                        </text>
                    </g>
                `;
            });

            svg.innerHTML = html;
        },
        attachEvents() {
            const svg = this.$refs.svgOverlay;
            if (!svg) return;

            const handleEvent = (e) => {
                const group = e.target.closest('g[data-blok-id]');
                if (!group) {
                    if (e.type === 'mouseleave') {
                        this.hoveredBlok = null;
                        this.renderSvg();
                    }
                    return;
                }
                const id = parseInt(group.getAttribute('data-blok-id'));
                const blok = this.data.bloks.find(b => b.id === id);
                if (blok && (!this.hoveredBlok || this.hoveredBlok.id !== blok.id)) {
                    this.hoveredBlok = blok;
                    this.renderSvg();
                }

                if (blok && this.$refs.siteplanContainer) {
                    const rect = this.$refs.siteplanContainer.getBoundingClientRect();
                    const clientX = e.clientX || (e.touches && e.touches[0]?.clientX) || 0;
                    const clientY = e.clientY || (e.touches && e.touches[0]?.clientY) || 0;
                    this.tooltip = {
                        x: Math.min(Math.max(10, clientX - rect.left), rect.width - 220),
                        y: Math.max(10, clientY - rect.top - 100)
                    };
                }
            };

            svg.onmousemove = handleEvent;
            svg.onmouseleave = handleEvent;
            svg.onclick = handleEvent;
            svg.ontouchstart = (e) => {
                if (e.touches && e.touches[0]) handleEvent(e.touches[0]);
            };
        }
    };
}
</script>
@endpush
@endif
