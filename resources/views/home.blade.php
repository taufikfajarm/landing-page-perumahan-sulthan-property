@extends('layouts.app')

@section('title', 'Sulthan Property - Perumahan Berkualitas dengan Harga Terjangkau di Jawa Tengah')
@section('meta_description', 'Sulthan Property developer properti terpercaya. Kami menyediakan perumahan subsidi dan komersil berkualitas dengan lokasi strategis, harga terjangkau, dan nilai investasi tinggi.')
@section('meta_keywords', 'perumahan subsidi, rumah murah, perumahan elit, perumahan brebes, developer properti jawa tengah, beli rumah KPR, sulthan property, investasi rumah')
@section('og_title', 'Sulthan Property - Perumahan Berkualitas')
@section('og_description', 'Temukan hunian impian Anda bersama Sulthan Property. Kualitas bangunan terbaik, proses KPR mudah, dan lokasi strategis.')

@section('content')
{{-- Hero Section --}}
@if($heroSection)
<section class="bg-white pt-8 pb-10 lg:pt-12 lg:pb-14 relative overflow-hidden lg:min-h-[calc(100vh-64px)] flex items-center">
    <!-- Background Blob Elements -->
    <div class="absolute top-10 left-10 w-72 h-72 bg-primary-100 rounded-full mix-blend-multiply filter blur-[96px] opacity-40 pointer-events-none"></div>
    <div class="absolute bottom-10 right-10 w-96 h-96 bg-orange-100 rounded-full mix-blend-multiply filter blur-[128px] opacity-40 pointer-events-none"></div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 w-full relative z-10">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 lg:gap-8 xl:gap-16 items-center">
            
            <!-- Left Content: Text & CTAs -->
            <div class="lg:col-span-6 text-center lg:text-left" data-scroll="fade-right">
                @if($heroSection->tagline)
                <span class="inline-block text-xs text-primary-700 font-semibold tracking-widest uppercase bg-primary-50 px-4 py-1.5 rounded-full mb-4">
                    {{ $heroSection->tagline }}
                </span>
                @else
                <span class="inline-block text-xs text-primary-700 font-semibold tracking-widest uppercase bg-primary-50 px-4 py-1.5 rounded-full mb-4">
                    Developer Properti Terpercaya
                </span>
                @endif
                
                <h1 class="text-3xl md:text-4xl lg:text-4xl xl:text-5xl font-['Raleway'] font-bold text-gray-900 leading-tight tracking-tight mb-4">
                    {{ $heroSection->title }}
                </h1>
                
                <p class="text-base md:text-lg text-gray-600 leading-relaxed max-w-xl mx-auto lg:mx-0 mb-6">
                    {{ $heroSection->description }}
                </p>
                
                <div class="flex flex-row flex-wrap justify-center lg:justify-start items-center gap-3">
                    <a href="{{ route('marketing.index') }}" class="inline-block bg-primary-600 text-white px-6 py-3 rounded-full font-semibold hover:bg-primary-700 transition shadow-lg hover:shadow-primary-600/30 text-sm md:text-base">
                        Hubungi Kami
                    </a>
                    <a href="#contact-form" class="inline-block bg-white text-gray-800 px-6 py-3 rounded-full font-semibold border border-gray-200 hover:border-gray-300 hover:bg-gray-50 transition shadow-sm text-sm md:text-base">
                        Dapatkan E-brosur
                    </a>
                </div>
            </div>

            <!-- Right Content: Slider & Stats -->
            <div class="lg:col-span-6 relative w-full mt-10 lg:mt-0" data-scroll="fade-left" data-scroll-delay="200">
                @if($heroSection->images->count() > 0)
                <div class="relative pr-4 pb-4">
                    <!-- Main Image Container -->
                    <div class="relative w-full aspect-[4/3] rounded-[2rem] overflow-hidden shadow-2xl bg-gray-100 border border-gray-100">
                        <div class="swiper hero-swiper h-full w-full">
                            <div class="swiper-wrapper">
                                @foreach($heroSection->images as $image)
                                <div class="swiper-slide">
                                    <img src="{{ get_image_url($image->image_path) }}" alt="{{ $heroSection->title }}" class="w-full h-full object-cover" loading="eager" fetchpriority="high" width="800" height="600">
                                </div>
                                @endforeach
                            </div>
                            @if($heroSection->images->count() > 1)
                            <!-- Pagination -->
                            <div class="swiper-pagination !bottom-6"></div>
                            @endif
                        </div>
                    </div>

                    <!-- Floating Stats Card (Referencing provided image) -->
                    <div class="hidden sm:block absolute -right-4 -bottom-6 bg-white p-6 rounded-[2rem] shadow-[0_20px_40px_rgba(0,0,0,0.12)] border border-gray-50 z-10 w-72" data-scroll="zoom-in" data-scroll-delay="500">
                        <!-- Top Right Arrow Icon Container -->
                        <div role="button" aria-label="Informasi Unit Terjual" class="absolute -top-4 -right-4 w-12 h-12 bg-primary-600 rounded-full flex items-center justify-center text-white shadow-lg shadow-primary-600/40 cursor-pointer hover:scale-105 transition transform">
                            <svg class="w-6 h-6 transform rotate-45" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18"/>
                            </svg>
                        </div>
                        
                        <h3 class="text-3xl font-extrabold text-gray-900 mb-1">200+</h3>
                        <p class="text-sm font-semibold text-gray-600 mb-4">Unit Terjual</p>
                        
                        <!-- Avatars -->
                        <div class="flex items-center gap-4">
                            <div class="flex -space-x-3">
                                <div class="w-10 h-10 rounded-full border-[2.5px] border-white bg-gray-100 flex items-center justify-center shadow-sm">
                                    <svg class="w-5 h-5 text-gray-400" fill="currentColor" viewBox="0 0 24 24">
                                        <path fill-rule="evenodd" d="M7.5 6a4.5 4.5 0 119 0 4.5 4.5 0 01-9 0zM3.751 20.105a8.25 8.25 0 0116.498 0 .75.75 0 01-.437.695A18.683 18.683 0 0112 22.5c-2.786 0-5.433-.608-7.812-1.7a.75.75 0 01-.437-.695z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                                <div class="w-10 h-10 rounded-full border-[2.5px] border-white bg-gray-200 flex items-center justify-center shadow-sm">
                                    <svg class="w-5 h-5 text-gray-500" fill="currentColor" viewBox="0 0 24 24">
                                        <path fill-rule="evenodd" d="M7.5 6a4.5 4.5 0 119 0 4.5 4.5 0 01-9 0zM3.751 20.105a8.25 8.25 0 0116.498 0 .75.75 0 01-.437.695A18.683 18.683 0 0112 22.5c-2.786 0-5.433-.608-7.812-1.7a.75.75 0 01-.437-.695z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                                <div class="w-10 h-10 rounded-full border-[2.5px] border-white bg-gray-300 flex items-center justify-center shadow-sm">
                                    <svg class="w-5 h-5 text-gray-600" fill="currentColor" viewBox="0 0 24 24">
                                        <path fill-rule="evenodd" d="M7.5 6a4.5 4.5 0 119 0 4.5 4.5 0 01-9 0zM3.751 20.105a8.25 8.25 0 0116.498 0 .75.75 0 01-.437.695A18.683 18.683 0 0112 22.5c-2.786 0-5.433-.608-7.812-1.7a.75.75 0 01-.437-.695z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                            </div>
                            <div role="button" aria-label="Tambah Unit" class="w-8 h-8 border border-gray-200 rounded-full flex justify-center items-center text-gray-400 hover:bg-gray-50 cursor-pointer transition">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>
                @endif
            </div>

        </div>
    </div>
</section>
@endif

<section class="py-20 bg-slate-50 relative overflow-hidden">
    <div class="absolute top-20 right-0 w-96 h-96 bg-primary-200 rounded-full mix-blend-multiply filter blur-[128px] opacity-40"></div>
    <div class="absolute bottom-10 left-0 w-96 h-96 bg-orange-200 rounded-full mix-blend-multiply filter blur-[128px] opacity-40"></div>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12" data-scroll="fade-up">
            <h2 class="text-3xl md:text-4xl font-['Raleway'] font-bold text-gray-900 mb-4">Proyek Perumahan Kami</h2>
            <p class="text-gray-600 text-lg">Pilihan perumahan terbaik untuk keluarga Anda</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @forelse($featuredHousings as $housing)
            <div class="bg-white/70 backdrop-blur-xl border border-white/50 rounded-3xl shadow-[0_8px_30px_rgb(0,0,0,0.04)] overflow-hidden hover:shadow-[0_20px_40px_rgb(0,0,0,0.08)] hover:bg-white/90 transition transform hover:-translate-y-2 relative z-10" data-scroll="fade-up" data-scroll-delay="{{ $loop->index * 150 }}">
                <div class="relative h-48 bg-gray-200">
                    @if($housing->featured_image)
                    <img src="{{ get_image_url($housing->featured_image) }}" alt="{{ $housing->name }}" class="w-full h-full object-cover" loading="lazy" width="400" height="192">
                    @elseif($housing->site_plan)
                    <img src="{{ get_image_url($housing->site_plan) }}" alt="{{ $housing->name }}" class="w-full h-full object-cover" loading="lazy" width="400" height="192">
                    @else
                    <div class="w-full h-full flex items-center justify-center text-gray-400">
                        <svg class="w-16 h-16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                        </svg>
                    </div>
                    @endif
                    
                    <div class="absolute top-4 right-4">
                        @if($housing->badge_text)
                            @php
                                $badgeColors = [
                                    'success' => 'bg-green-500',
                                    'danger' => 'bg-red-500',
                                    'warning' => 'bg-yellow-500',
                                    'info' => 'bg-blue-500',
                                    'primary' => 'bg-indigo-600',
                                ];
                                $badgeClass = $badgeColors[$housing->badge_type] ?? 'bg-green-500';
                            @endphp
                            <span class="{{ $badgeClass }} text-white px-3 py-1 rounded-full text-sm font-semibold">{{ $housing->badge_text }}</span>
                        @else
                            @if($housing->status === 'ready')
                            <span class="bg-green-500 text-white px-3 py-1 rounded-full text-sm font-semibold">Ready</span>
                            @else
                            <span class="bg-red-500 text-white px-3 py-1 rounded-full text-sm font-semibold">Sold Out</span>
                            @endif
                        @endif
                    </div>
                </div>
                
                <div class="p-6">
                    <h3 class="text-xl font-bold text-gray-900 mb-2">{{ $housing->name }}</h3>
                    
                    @if($housing->location_url)
                    <a href="{{ $housing->location_url }}" target="_blank" rel="noopener noreferrer" class="flex items-center text-primary-600 hover:text-primary-700 mb-3 w-full">
                        <svg class="w-5 h-5 mr-1 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                        </svg>
                        <span class="truncate">{{ $housing->location }}</span>
                    </a>
                    @else
                    <p class="text-gray-600 mb-3 flex items-center w-full">
                        <svg class="w-5 h-5 mr-1 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                        </svg>
                        <span class="truncate">{{ $housing->location }}</span>
                    </p>
                    @endif
                    
                    <p class="text-gray-600 mb-4 line-clamp-2">{{ Str::limit($housing->description, 100) }}</p>
                    
                    <a href="{{ route('housing.show', $housing->slug) }}" class="inline-block bg-primary-600 text-white px-6 py-2 rounded-lg hover:bg-primary-700 transition">
                        Lihat Detail
                    </a>
                </div>
            </div>
            @empty
            <div class="col-span-3 text-center py-12">
                <p class="text-gray-600">Belum ada proyek perumahan tersedia.</p>
            </div>
            @endforelse
        </div>

        @if($featuredHousings->count() > 0)
        <div class="text-center mt-12">
            <a href="{{ route('housing.index') }}" class="inline-block bg-primary-600 text-white px-8 py-3.5 rounded-full font-semibold hover:bg-primary-700 transition shadow-lg hover:shadow-primary-600/30">
                Lihat Semua Perumahan
            </a>
        </div>
        @endif
    </div>
</section>

<section class="py-20 bg-blue-50/50 relative overflow-hidden">
    <div class="absolute left-1/2 top-1/2 -translate-x-1/2 -translate-y-1/2 w-full h-[500px] bg-gradient-to-r from-primary-200/30 to-purple-200/30 blur-[100px] rounded-full point-events-none"></div>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12" data-scroll="fade-up">
            <h2 class="text-3xl md:text-4xl font-['Raleway'] font-bold text-gray-900 mb-4">Mengapa Pilih Kami?</h2>
            <p class="text-gray-600 text-lg">Keunggulan yang kami tawarkan untuk Anda</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
            <div class="bg-white/60 backdrop-blur-xl border border-white/60 p-8 rounded-3xl shadow-[0_8px_30px_rgb(0,0,0,0.04)] hover:shadow-[0_20px_40px_rgb(0,0,0,0.08)] hover:bg-white/80 transition-all text-center relative z-10 group" data-scroll="fade-up" data-scroll-delay="0">
                <div class="w-16 h-16 bg-primary-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-2">Lokasi Strategis</h3>
                <p class="text-gray-600">Dekat dengan pusat kota, sekolah, dan fasilitas umum</p>
            </div>

            <div class="bg-white/60 backdrop-blur-xl border border-white/60 p-8 rounded-3xl shadow-[0_8px_30px_rgb(0,0,0,0.04)] hover:shadow-[0_20px_40px_rgb(0,0,0,0.08)] hover:bg-white/80 transition-all text-center relative z-10 group" data-scroll="fade-up" data-scroll-delay="150">
                <div class="w-16 h-16 bg-primary-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-2">Kualitas Terbaik</h3>
                <p class="text-gray-600">Material berkualitas dan konstruksi yang kokoh</p>
            </div>

            <div class="bg-white/60 backdrop-blur-xl border border-white/60 p-8 rounded-3xl shadow-[0_8px_30px_rgb(0,0,0,0.04)] hover:shadow-[0_20px_40px_rgb(0,0,0,0.08)] hover:bg-white/80 transition-all text-center relative z-10 group" data-scroll="fade-up" data-scroll-delay="300">
                <div class="w-16 h-16 bg-primary-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-2">Harga Terjangkau</h3>
                <p class="text-gray-600">Harga kompetitif dengan skema pembayaran fleksibel</p>
            </div>

            <div class="bg-white/60 backdrop-blur-xl border border-white/60 p-8 rounded-3xl shadow-[0_8px_30px_rgb(0,0,0,0.04)] hover:shadow-[0_20px_40px_rgb(0,0,0,0.08)] hover:bg-white/80 transition-all text-center relative z-10 group" data-scroll="fade-up" data-scroll-delay="450">
                <div class="w-16 h-16 bg-primary-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/>
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-2">Nilai Investasi Tinggi</h3>
                <p class="text-gray-600">Properti dengan prospek nilai jual yang terus meningkat</p>
            </div>
        </div>
    </div>
</section>

{{-- Survey Lokasi Section --}}
@if($surveyLokasi)
<section class="py-20 bg-white relative overflow-hidden">
    <div class="absolute right-0 top-0 w-1/2 h-full bg-gradient-to-l from-orange-50/50 to-transparent pointer-events-none"></div>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
            {{-- Images Grid --}}
            <div class="grid grid-cols-2 gap-3 lg:gap-2" data-scroll="fade-right">
                @foreach($surveyLokasi->images->take(4) as $index => $image)
                <div class="aspect-square lg:aspect-[4/3] overflow-hidden
                    @if($index === 0) rounded-tl-none rounded-tr-3xl rounded-bl-3xl rounded-br-3xl
                    @elseif($index === 1) rounded-tl-3xl rounded-tr-none rounded-bl-3xl rounded-br-3xl
                    @elseif($index === 2) rounded-tl-3xl rounded-tr-3xl rounded-bl-none rounded-br-3xl
                    @else rounded-tl-3xl rounded-tr-3xl rounded-bl-3xl rounded-br-none
                    @endif
                    shadow-lg hover:shadow-xl transition-shadow duration-300">
                    <img src="{{ get_image_url($image->image_path) }}" 
                         alt="Survey Lokasi {{ $index + 1 }}" 
                         class="w-full h-full object-cover hover:scale-105 transition-transform duration-300" loading="lazy" width="400" height="300">
                </div>
                @endforeach
            </div>

            {{-- Content --}}
            <div class="space-y-6 bg-white/70 backdrop-blur-xl border border-white/50 p-8 md:p-12 rounded-3xl shadow-[0_8px_30px_rgb(0,0,0,0.04)] relative z-10" data-scroll="fade-left" data-scroll-delay="200">
                
                <h2 class="text-2xl md:text-3xl lg:text-4xl font-['Raleway'] font-bold text-gray-900 leading-tight">
                    {{ $surveyLokasi->title }}
                </h2>
                
                <p class="text-gray-600 leading-relaxed">
                    {{ $surveyLokasi->description_1 }}
                </p>
                
                @if($surveyLokasi->description_2)
                <p class="text-gray-600 leading-relaxed">
                    {{ $surveyLokasi->description_2 }}
                </p>
                @endif
                
                @if($surveyLokasi->button_url)
                <div class="pt-4">
                    <a href="{{ $surveyLokasi->button_url }}" 
                       class="inline-block bg-primary-600 text-white px-8 py-3.5 rounded-full font-semibold hover:bg-primary-700 transition shadow-lg hover:shadow-primary-600/30">
                        Survey Sekarang
                    </a>
                </div>
                @endif
            </div>
        </div>
    </div>
</section>
@endif

{{-- Project Locations Map Section --}}
@if($allHousings->count() > 0)
<section class="py-20 bg-slate-50 relative overflow-hidden" id="project-locations">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12" data-scroll="fade-up">
            <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">Lokasi Proyek Kami</h2>
            <p class="text-gray-600 text-lg">Temukan properti idaman Anda di lokasi strategis</p>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            {{-- Map Container --}}
            <div class="lg:col-span-2 bg-white rounded-3xl p-4 shadow-[0_8px_30px_rgb(0,0,0,0.04)]" data-scroll="fade-right">
                <div id="project-map" class="w-full h-[500px] rounded-2xl relative z-0"></div>
            </div>

            {{-- Projects List --}}
            <div class="bg-white rounded-3xl p-6 shadow-[0_8px_30px_rgb(0,0,0,0.04)] h-[500px] flex flex-col" data-scroll="fade-left">
                <h3 class="text-xl font-bold text-gray-900 mb-4 pb-4 border-b border-gray-100">Daftar Proyek</h3>
                <div class="overflow-y-auto pr-2 space-y-4 flex-1 custom-scrollbar" id="project-list-container">
                    @foreach($allHousings as $index => $housing)
                    <div class="project-list-item group cursor-pointer p-4 rounded-2xl border border-gray-100 hover:border-primary-200 hover:bg-primary-50 transition-all duration-300" data-index="{{ $index }}">
                        <div class="flex gap-4">
                            <img src="{{ get_image_url($housing->featured_image) }}" alt="{{ $housing->name }}" class="w-16 h-16 rounded-xl object-cover shadow-sm group-hover:scale-105 transition-transform duration-300" loading="lazy">
                            <div class="flex-1">
                                <h4 class="font-bold text-gray-900 group-hover:text-primary-600 transition-colors">{{ $housing->name }}</h4>
                                <p class="text-xs text-gray-500 mt-1 line-clamp-2 flex items-start gap-1">
                                    <svg class="w-3.5 h-3.5 text-primary-500 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                    <span>{{ $housing->location }}</span>
                                </p>
                                <div class="mt-2 text-[10px] font-bold px-2 py-1 {{ $housing->status == 'ready' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }} rounded-md inline-block uppercase tracking-wider">
                                    {{ $housing->status == 'ready' ? 'Tersedia' : 'Terjual' }}
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</section>

@push('styles')
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin=""/>
<style>
    .custom-scrollbar::-webkit-scrollbar { width: 6px; }
    .custom-scrollbar::-webkit-scrollbar-track { background: #f1f1f1; border-radius: 10px; }
    .custom-scrollbar::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 10px; }
    .custom-scrollbar::-webkit-scrollbar-thumb:hover { background: #94a3b8; }
    .leaflet-popup-content-wrapper { border-radius: 16px !important; box-shadow: 0 12px 30px rgba(0,0,0,0.18) !important; padding: 0 !important; overflow: hidden; border: 1px solid rgba(255,255,255,0.8); }
    .leaflet-popup-content { margin: 0 !important; width: 280px !important; }
    .leaflet-popup-close-button { color: #64748b !important; text-shadow: none !important; right: 6px !important; top: 6px !important; z-index: 20; background: rgba(255,255,255,0.8) !important; border-radius: 50% !important; width: 20px !important; height: 20px !important; display: flex !important; align-items: center !important; justify-content: center !important; }
    .leaflet-popup-close-button:hover { color: #0f172a !important; background: #ffffff !important; }
    #project-map { z-index: 10; }
</style>
@endpush

@push('scripts')
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    if (!document.getElementById('project-map')) return;

    // Basis koordinat area Brebes
    const baseLat = -6.8694;
    const baseLng = 109.0453;

    const projects = [
        @foreach($allHousings as $index => $housing)
        @php
            $coords = $housing->coordinates;
            $dbLat = $housing->latitude;
            $dbLng = $housing->longitude;
            $lat = !empty($dbLat) ? $dbLat : ($coords ? $coords['lat'] : -6.8694 + ($index * 0.006) * ($index % 2 === 0 ? 1 : -1));
            $lng = !empty($dbLng) ? $dbLng : ($coords ? $coords['lng'] : 109.0453 + ($index * 0.012) * ($index % 2 === 0 ? 1 : -1));
        @endphp
        {
            id: {{ $housing->id }},
            name: "{{ addslashes($housing->name) }}",
            location: "{{ addslashes($housing->location) }}",
            image: "{{ get_image_url($housing->featured_image) }}",
            url: "{{ route('housing.show', $housing->slug) }}",
            lat: parseFloat("{{ $lat }}"),
            lng: parseFloat("{{ $lng }}")
        }{{ $loop->last ? '' : ',' }}
        @endforeach
    ];

    if (projects.length === 0) return;

    const map = L.map('project-map', {
        scrollWheelZoom: false
    }).setView([baseLat, baseLng], 13);

    // Use Google Maps Tile Layer for Google Maps colorful aesthetic
    L.tileLayer('https://{s}.google.com/vt/lyrs=m&x={x}&y={y}&z={z}', {
        maxZoom: 20,
        subdomains: ['mt0', 'mt1', 'mt2', 'mt3'],
        attribution: '&copy; <a href="https://maps.google.com">Google Maps</a>'
    }).addTo(map);

    // Google Maps style Teardrop Pin in Blue
    const customIcon = L.divIcon({
        className: 'custom-google-pin',
        html: `
            <svg width="34" height="44" viewBox="0 0 32 42" fill="none" xmlns="http://www.w3.org/2000/svg" style="filter: drop-shadow(0px 4px 6px rgba(0, 0, 0, 0.35)); transition: transform 0.2s;">
                <path d="M16 0C7.163 0 0 7.163 0 16c0 12 16 26 16 26s16-14 16-26c0-8.837-7.163-16-16-16z" fill="#0284c7" stroke="#ffffff" stroke-width="1.5"/>
                <circle cx="16" cy="15" r="5.5" fill="#0369a1"/>
            </svg>
        `,
        iconSize: [34, 44],
        iconAnchor: [17, 44],
        popupAnchor: [0, -42]
    });

    const activeIcon = L.divIcon({
        className: 'custom-google-pin-active',
        html: `
            <svg width="42" height="54" viewBox="0 0 32 42" fill="none" xmlns="http://www.w3.org/2000/svg" style="filter: drop-shadow(0px 6px 12px rgba(2, 132, 199, 0.5));">
                <path d="M16 0C7.163 0 0 7.163 0 16c0 12 16 26 16 26s16-14 16-26c0-8.837-7.163-16-16-16z" fill="#0284c7" stroke="#ffffff" stroke-width="2"/>
                <circle cx="16" cy="15" r="6" fill="#ffffff"/>
                <circle cx="16" cy="15" r="3.5" fill="#0284c7"/>
            </svg>
        `,
        iconSize: [42, 54],
        iconAnchor: [21, 54],
        popupAnchor: [0, -52]
    });

    const markers = [];
    const bounds = L.latLngBounds();

    projects.forEach((project, index) => {
        // Sanity check coordinates to prevent zooming out to infinity if invalid numbers are entered
        let validLat = project.lat;
        let validLng = project.lng;
        if (isNaN(validLat) || validLat < -90 || validLat > 90) {
            validLat = baseLat + (index * 0.005);
        }
        if (isNaN(validLng) || validLng < -180 || validLng > 180) {
            validLng = baseLng + (index * 0.005);
        }
        project.lat = validLat;
        project.lng = validLng;

        const marker = L.marker([project.lat, project.lng], {
            icon: customIcon,
            title: project.name
        }).addTo(map);

        // Desain Popup Horizontal Ringkas & Profesional
        const popupContent = `
            <div style="display: flex; width: 280px; background: #ffffff; overflow: hidden; font-family: 'Raleway', sans-serif;">
                <div style="width: 95px; height: 95px; flex-shrink: 0; position: relative;">
                    <img src="${project.image}" alt="${project.name}" style="width: 100%; height: 100%; object-fit: cover;">
                </div>
                <div style="padding: 10px 12px; flex: 1; display: flex; flex-direction: column; justify-content: space-between; overflow: hidden;">
                    <div>
                        <h4 style="font-weight: 700; font-size: 13px; margin: 0 0 3px 0; color: #111827; line-height: 1.2; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">${project.name}</h4>
                        <p style="font-size: 10px; color: #6b7280; margin: 0; line-height: 1.3; display: flex; align-items: center; gap: 3px;">
                            <svg style="width: 10px; height: 10px; color: #0284c7; flex-shrink: 0;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                            <span style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis; display: block; max-width: 130px;">${project.location}</span>
                        </p>
                    </div>
                    <a href="${project.url}" style="display: inline-block; text-align: center; background-color: #0284c7; color: white; text-decoration: none; padding: 5px 8px; border-radius: 6px; font-size: 11px; font-weight: 600; transition: background 0.2s; margin-top: 4px;" onmouseover="this.style.backgroundColor='#0369a1'" onmouseout="this.style.backgroundColor='#0284c7'">Detail Proyek &rarr;</a>
                </div>
            </div>
        `;

        marker.bindPopup(popupContent, {
            autoPan: true,
            autoPanPaddingTopLeft: L.point(30, 80),
            autoPanPaddingBottomRight: L.point(30, 30),
            keepInView: true
        });
        
        // Marker click event to highlight active marker & pan map safely
        marker.on('click', function() {
            markers.forEach(m => m.setIcon(customIcon));
            this.setIcon(activeIcon);
            map.flyTo([project.lat + 0.003, project.lng], 15, { duration: 1.0 });
        });

        markers.push(marker);
        bounds.extend([project.lat, project.lng]);
    });

    if (projects.length > 0) {
        map.fitBounds(bounds, { padding: [50, 50] });
    }

    // Perbaikan untuk mengatasi map abu-abu karena animasi CSS saat map dimuat
    setTimeout(() => {
        map.invalidateSize();
    }, 800);

    const listItems = document.querySelectorAll('.project-list-item');
    listItems.forEach(item => {
        item.addEventListener('click', function() {
            const index = this.getAttribute('data-index');
            const marker = markers[index];
            const project = projects[index];

            // Reset all markers & highlight selected marker
            markers.forEach(m => m.setIcon(customIcon));
            marker.setIcon(activeIcon);

            listItems.forEach(i => {
                i.classList.remove('bg-primary-50', 'border-primary-200');
                i.classList.add('border-gray-100');
            });
            this.classList.remove('border-gray-100');
            this.classList.add('bg-primary-50', 'border-primary-200');

            // Geser posisi tengah sedikit ke utara agar pin berada di bagian bawah & popup memiliki ruang luas di atas
            map.flyTo([project.lat + 0.003, project.lng], 15, {
                duration: 1.2
            });
            
            setTimeout(() => {
                marker.openPopup();
            }, 600);
        });
    });
});
</script>
@endpush
@endif

@if($testimonials->count() > 0)
<section class="py-20 bg-gradient-to-b from-white to-slate-50 relative overflow-hidden">
    <div class="absolute -left-40 top-20 w-96 h-96 bg-blue-100 rounded-full mix-blend-multiply filter blur-[100px] opacity-70"></div>
    <div class="absolute right-0 bottom-0 w-96 h-96 bg-yellow-100 rounded-full mix-blend-multiply filter blur-[100px] opacity-70"></div>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12" data-scroll="fade-up">
            <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">Testimoni Pelanggan</h2>
            <p class="text-gray-600 text-lg">Apa kata mereka tentang kami</p>
        </div>

        <div class="swiper testimonial-swiper" data-scroll="zoom-in" data-scroll-delay="200">
            <div class="swiper-wrapper">
                @foreach($testimonials as $testimonial)
                <div class="swiper-slide">
                    <div class="bg-white/60 backdrop-blur-2xl border border-white/60 p-8 md:p-10 rounded-3xl shadow-[0_8px_30px_rgb(0,0,0,0.04)] max-w-2xl mx-auto relative z-10">
                        <div class="flex items-center mb-4">
                            @if($testimonial->avatar)
                            <img src="{{ get_image_url($testimonial->avatar) }}" alt="{{ $testimonial->name }}" class="w-16 h-16 rounded-full mr-4 object-cover" loading="lazy" width="64" height="64">
                            @else
                            <div class="w-16 h-16 rounded-full bg-primary-100 flex items-center justify-center mr-4">
                                <span class="text-primary-600 font-bold text-xl">{{ substr($testimonial->name, 0, 1) }}</span>
                            </div>
                            @endif
                            <div>
                                <h4 class="font-bold text-gray-900">{{ $testimonial->name }}</h4>
                                @if($testimonial->position)
                                <p class="text-gray-600 text-sm">{{ $testimonial->position }}</p>
                                @endif
                                <div class="text-yellow-400 text-sm">
                                    @for($i = 1; $i <= 5; $i++)
                                        @if($i <= $testimonial->rating)
                                        ★
                                        @else
                                        ☆
                                        @endif
                                    @endfor
                                </div>
                            </div>
                        </div>
                        <p class="text-gray-700 italic">"{{ $testimonial->content }}"</p>
                    </div>
                </div>
                @endforeach
            </div>
            <div class="swiper-pagination mt-8"></div>
        </div>
    </div>
</section>
@endif

{{-- Proses Akad Section --}}
@if($prosesAkad && $prosesAkad->images && count($prosesAkad->images) > 0)
<section class="py-20 bg-slate-50 overflow-hidden relative">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12" data-scroll="fade-up">
            <h2 class="text-3xl md:text-4xl font-['Raleway'] font-bold text-gray-900 mb-4">{{ $prosesAkad->title }}</h2>
            @if($prosesAkad->description)
            <p class="text-gray-600 text-lg max-w-3xl mx-auto">{{ $prosesAkad->description }}</p>
            @endif
        </div>

        {{-- Infinite Slider --}}
        <div class="swiper proses-akad-swiper" data-scroll="fade-up" data-scroll-delay="200">
            <div class="swiper-wrapper">
                @foreach($prosesAkad->images as $image)
                <div class="swiper-slide">
                    <div class="aspect-[4/3] rounded-xl overflow-hidden shadow-lg">
                        <img src="{{ get_image_url($image) }}" 
                             alt="Proses Akad" 
                             class="w-full h-full object-cover" loading="lazy" width="400" height="300">
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</section>
@endif

@if($recentBlogs->count() > 0)
<section class="py-20 bg-white relative overflow-hidden">
    <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-3/4 h-3/4 bg-primary-50 rounded-full blur-[120px] pointer-events-none"></div>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <div class="text-center mb-12" data-scroll="fade-up">
            <h2 class="text-3xl md:text-4xl font-['Raleway'] font-bold text-gray-900 mb-4">Artikel Terbaru</h2>
            <p class="text-gray-800 text-lg">Informasi dan tips seputar properti</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            @foreach($recentBlogs as $blog)
            <article class="bg-white/70 backdrop-blur-xl border border-white/50 rounded-3xl shadow-[0_8px_30px_rgb(0,0,0,0.04)] overflow-hidden hover:shadow-[0_20px_40px_rgb(0,0,0,0.08)] hover:bg-white/90 transition relative z-10 group" data-scroll="fade-up" data-scroll-delay="{{ $loop->index * 150 }}">
                @if($blog->featured_image)
                <img src="{{ get_image_url($blog->featured_image) }}" alt="{{ $blog->title }}" class="w-full h-48 object-cover" loading="lazy" width="400" height="192">
                @else
                <div class="w-full h-48 bg-gray-200 flex items-center justify-center">
                    <svg class="w-16 h-16 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/>
                    </svg>
                </div>
                @endif
                
                <div class="p-6">
                    <div class="flex items-center text-sm text-gray-500 mb-2">
                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                        {{ $blog->published_at->format('d M Y') }}
                        <span class="mx-2">•</span>
                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                        </svg>
                        {{ $blog->views }} views
                    </div>
                    
                    <h3 class="text-xl font-bold text-gray-900 mb-2 line-clamp-2">{{ $blog->title }}</h3>
                    <p class="text-gray-600 mb-4 line-clamp-3">{{ $blog->excerpt }}</p>
                    
                    <a href="{{ route('blog.show', $blog->slug) }}" class="inline-flex items-center text-primary-600 hover:text-primary-700 font-semibold">
                        Baca Selengkapnya
                        <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                        </svg>
                    </a>
                </div>
            </article>
            @endforeach
        </div>

        <div class="text-center mt-12">
            <a href="{{ route('blog.index') }}" class="inline-block bg-primary-600 text-white px-8 py-3.5 rounded-full font-semibold hover:bg-primary-700 transition shadow-lg hover:shadow-primary-600/30">
                Lihat Semua Artikel
            </a>
        </div>
    </div>
</section>
@endif

<section id="contact-form" class="py-24 bg-gradient-to-br from-slate-50 to-blue-50 relative overflow-hidden">
    <div class="absolute top-0 right-0 w-[600px] h-[600px] bg-primary-200 rounded-full mix-blend-multiply filter blur-[150px] opacity-40"></div>
    <div class="absolute bottom-0 left-0 w-[600px] h-[600px] bg-orange-200 rounded-full mix-blend-multiply filter blur-[150px] opacity-40"></div>
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12" data-scroll="fade-up">
            <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">Dapatkan E-Brosur</h2>
            <p class="text-gray-600 text-lg">Isi form di bawah untuk mendapatkan informasi lengkap</p>
        </div>

        <div x-data="{ showSuccessModal: {{ session('success') ? 'true' : 'false' }} }">
            <form action="{{ route('contact.store') }}" method="POST" class="bg-white/60 backdrop-blur-2xl border border-white/60 p-8 md:p-12 rounded-3xl shadow-[0_12px_40px_rgb(0,0,0,0.08)] relative z-10" data-scroll="fade-up" data-scroll-delay="200">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <div>
                        <label for="name" class="block text-gray-700 font-semibold mb-2">Nama Lengkap *</label>
                        <input type="text" id="name" name="name" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent" value="{{ old('name') }}">
                        @error('name')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="phone" class="block text-gray-700 font-semibold mb-2">No. WhatsApp</label>
                        <input type="text" id="phone" name="phone" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent" value="{{ old('phone') }}">
                        @error('phone')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="mb-6">
                    <label for="email" class="block text-gray-700 font-semibold mb-2">Email *</label>
                    <input type="email" id="email" name="email" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent" value="{{ old('email') }}">
                    @error('email')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-6">
                    <label for="message" class="block text-gray-700 font-semibold mb-2">Pesan</label>
                    <textarea id="message" name="message" rows="4" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent">{{ old('message') }}</textarea>
                    @error('message')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <button type="submit" class="w-full bg-primary-600 text-white px-8 py-3 rounded-lg font-semibold hover:bg-primary-700 transition transform hover:scale-105">
                    Kirim Pesan
                </button>
            </form>

            <div x-show="showSuccessModal" 
                 x-cloak
                 @keydown.escape.window="showSuccessModal = false"
                 class="fixed inset-0 z-50 flex items-center justify-center bg-black/40 backdrop-blur-sm p-4"
                 style="display: none;">
                <div @click.away="showSuccessModal = false" 
                     class="bg-white rounded-2xl shadow-2xl max-w-md w-full p-8 transform transition-all">
                    <div class="flex justify-center mb-6">
                        <div class="w-20 h-20 bg-green-100 rounded-full flex items-center justify-center">
                            <svg class="w-12 h-12 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            </svg>
                        </div>
                    </div>

                    <h3 class="text-2xl font-bold text-gray-900 text-center mb-4">Terima Kasih!</h3>
                    <p class="text-gray-700 text-center mb-6 leading-relaxed">
                        Pesan kamu berhasi terkirim. Pastikan No. WhatsApp kamu sudah benar yaa.
                        Kami akan kirim informasi selengkapnya ke WhatsApp kamu.
                    </p>

                    <button @click="showSuccessModal = false" 
                            class="w-full bg-primary-600 text-white px-6 py-3 rounded-lg font-semibold hover:bg-primary-700 transition transform hover:scale-105">
                        Oke
                    </button>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection


