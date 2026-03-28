@extends('layouts.app')

@section('title', $housing->name . ' - Sulthan Property')
@section('meta_description', Str::limit(strip_tags($housing->description), 150))
@section('meta_keywords', 'perumahan ' . $housing->name . ', ' . $housing->location . ', perumahan di ' . $housing->location . ', rumah baru, cicilan KPR')
@section('og_title', $housing->name . ' - Sulthan Property')
@section('og_description', Str::limit(strip_tags($housing->description), 150))
@if($housing->featured_image)
@section('og_image', get_image_url($housing->featured_image))
@section('twitter_image', get_image_url($housing->featured_image))
@endif

@section('content')
<div class="bg-gradient-to-r from-primary-600 to-primary-800 text-white py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h1 class="text-4xl font-bold mb-2">{{ $housing->name }}</h1>
        @if($housing->location_url)
        <a href="{{ $housing->location_url }}" target="_blank" class="inline-flex items-center text-primary-100 hover:text-white">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
            </svg>
            {{ $housing->location }}
        </a>
        @else
        <p class="text-primary-100">{{ $housing->location }}</p>
        @endif
    </div>
</div>

<section class="py-12 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            {{-- Main Content --}}
            <div class="lg:col-span-2">

                {{-- Description --}}
                <div class="bg-white rounded-xl shadow-lg p-8 mb-8">
                    <div class="text-gray-700 leading-relaxed">
                        {{ $housing->description }}
                    </div>
                </div>

                {{-- Available Types --}}
                @if($housing->types->count() > 0)
                <div class="bg-white rounded-xl shadow-lg p-8 mb-8">
                    <h2 class="text-2xl font-bold text-gray-900 mb-6">Pilihan Tipe</h2>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        @foreach($housing->types as $type)
                        <a href="{{ route('housing.type', [$housing->slug, $type->slug]) }}" class="block p-6 border-2 border-gray-200 rounded-lg hover:border-primary-600 hover:shadow-lg transition">
                            <h3 class="text-xl font-bold text-gray-900 mb-2">{{ $type->name }}</h3>
                            <div class="space-y-1 text-gray-600 mb-4">
                                @if($type->land_size)
                                <p>Luas Tanah: {{ $type->land_size }} m²</p>
                                @endif
                                @if($type->building_size)
                                <p>Luas Bangunan: {{ $type->building_size }} m²</p>
                                @endif
                                <p>{{ $type->bedrooms }} KT | {{ $type->bathrooms }} KM</p>
                                @if($type->price)
                                <p class="text-primary-600 font-bold text-lg">Mulai {{ $type->approximate_price }}</p>
                                @endif
                            </div>
                            <span class="inline-block bg-primary-600 text-white px-4 py-2 rounded-lg text-sm font-semibold">
                                Lihat Detail →
                            </span>
                        </a>
                        @endforeach
                    </div>
                </div>
                @endif

                {{-- Facilities Section --}}
                @if($housing->facilities->count() > 0)
                <div class="bg-white rounded-xl shadow-lg p-8 mb-8">
                    <h2 class="text-2xl font-bold text-gray-900 mb-6">Fasilitas</h2>
                    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-6">
                        @foreach($housing->facilities as $facility)
                        <div class="flex flex-col items-center text-center">
                            @if($facility->icon)
                            <div class="w-16 h-16 mb-3 flex items-center justify-center">
                                <img src="{{ get_image_url($facility->icon) }}" alt="{{ $facility->name }}" class="w-full h-full object-contain">
                            </div>
                            @else
                            <div class="w-16 h-16 mb-3 bg-primary-100 rounded-full flex items-center justify-center">
                                <svg class="w-8 h-8 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                </svg>
                            </div>
                            @endif
                            <p class="text-gray-700 font-medium text-sm">{{ $facility->name }}</p>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endif

                {{-- Access Points Section --}}
                @if($housing->accessPoints->count() > 0)
                <div class="bg-white rounded-xl shadow-lg p-8 mb-8">
                    <h2 class="text-2xl font-bold text-gray-900 mb-6">Akses Lokasi</h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-x-6 gap-y-3">
                        @foreach($housing->accessPoints as $accessPoint)
                        <div class="flex items-start text-gray-700">
                            <svg class="w-5 h-5 text-primary-600 mr-3 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <span><strong>{{ $accessPoint->duration_minutes }} menit</strong> ke {{ $accessPoint->destination }}</span>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endif

                {{-- Site Plan --}}
                @if(!empty($housing->siteplan_sip_id))
                <div class="bg-white rounded-xl shadow-lg overflow-hidden mb-8 w-full" style="height: 85vh; min-height: 600px;">
                    <iframe 
                        src="https://sip.sulthanproperty.com/embed/siteplan/{{ $housing->siteplan_sip_id }}" 
                        width="100%" 
                        height="100%" 
                        style="border: none;" 
                        loading="lazy"
                        title="Siteplan Realtime {{ $housing->name }}"
                    ></iframe>
                </div>
                @elseif($housing->site_plan)
                <div class="bg-white rounded-xl shadow-lg overflow-hidden mb-8">
                    <img src="{{ get_image_url($housing->site_plan) }}" alt="Site Plan {{ $housing->name }}" class="w-full">
                </div>
                @endif
            </div>

            {{-- Sidebar --}}
            <div class="lg:col-span-1">
                <div class="bg-white rounded-xl shadow-lg p-6 sticky top-20">
                    <div class="mb-6">
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
                            <span class="{{ $badgeClass }} text-white px-4 py-2 rounded-full text-sm font-bold shadow-lg">{{ $housing->badge_text }}</span>
                        @else
                            @if($housing->status === 'ready')
                            <div class="inline-flex items-center gap-2 bg-gradient-to-r from-green-500 to-emerald-600 text-white px-5 py-2.5 rounded-full shadow-lg shadow-green-500/30 animate-pulse">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                <span class="text-sm font-bold tracking-wide">Available</span>
                            </div>
                            @else
                            <div class="inline-flex items-center gap-2 bg-gradient-to-r from-red-500 to-rose-600 text-white px-5 py-2.5 rounded-full shadow-lg shadow-red-500/30">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                </svg>
                                <span class="text-sm font-bold tracking-wide">Sold Out</span>
                            </div>
                            @endif
                        @endif
                    </div>

                    <h3 class="text-xl font-bold text-gray-900 mb-4">Tertarik?</h3>
                    <p class="text-gray-600 mb-6">Hubungi tim marketing kami untuk informasi lebih lanjut</p>
                    
                    <a href="{{ route('marketing.index') }}" class="block w-full bg-primary-600 text-white text-center px-6 py-3 rounded-lg hover:bg-primary-700 transition font-semibold mb-3">
                        Hubungi Marketing
                    </a>
                    
                    <a href="{{ route('home') }}#contact-form" class="block w-full bg-gray-100 text-gray-700 text-center px-6 py-3 rounded-lg hover:bg-gray-200 transition font-semibold">
                        Dapatkan E-Brosur
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
