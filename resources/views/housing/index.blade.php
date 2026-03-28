@extends('layouts.app')

@section('title', 'Pilihan Perumahan - Sulthan Property')
@section('meta_description', 'Brosur dan pilihan perumahan dari Sulthan Property. Temukan rumah impian Anda dengan harga terbaik, desain modern, dan fasilitas lengkap.')
@section('meta_keywords', 'pilihan perumahan, rumah modern, perumahan murah, jual rumah, sulthan property, beli perumahan baru')
@section('og_title', 'Pilihan Perumahan - Sulthan Property')
@section('og_description', 'Brosur dan pilihan perumahan dari Sulthan Property. Temukan rumah impian Anda dengan harga terbaik, desain modern, dan fasilitas lengkap.')

@section('content')
<div class="bg-gradient-to-r from-primary-600 to-primary-800 text-white py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h1 class="text-4xl font-bold mb-2">Pilihan Perumahan</h1>
        <p class="text-primary-100">Temukan rumah impian Anda</p>
    </div>
</div>

<section class="py-12 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @forelse($housings as $housing)
            <div class="bg-white rounded-xl shadow-lg overflow-hidden hover:shadow-2xl transition transform hover:-translate-y-2">
                <div class="relative h-56 bg-gray-200">
                    @if($housing->featured_image)
                    <img src="{{ get_image_url($housing->featured_image) }}" alt="{{ $housing->name }}" class="w-full h-full object-cover">
                    @elseif($housing->site_plan)
                    <img src="{{ get_image_url($housing->site_plan) }}" alt="{{ $housing->name }}" class="w-full h-full object-cover">
                    @else
                    <div class="w-full h-full flex items-center justify-center text-gray-400">
                        <svg class="w-20 h-20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                        </svg>
                    </div>
                    @endif
                    
                    {{-- Status Badge --}}
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
                            <span class="{{ $badgeClass }} text-white px-4 py-2 rounded-full text-sm font-bold shadow-lg">{{ $housing->badge_text }}</span>
                        @else
                            @if($housing->status === 'ready')
                            <span class="bg-green-500 text-white px-4 py-2 rounded-full text-sm font-bold shadow-lg">Ready</span>
                            @else
                            <span class="bg-red-500 text-white px-4 py-2 rounded-full text-sm font-bold shadow-lg">Sold Out</span>
                            @endif
                        @endif
                    </div>
                </div>
                
                <div class="p-6">
                    <h3 class="text-2xl font-bold text-gray-900 mb-3">{{ $housing->name }}</h3>
                    
                    @if($housing->location_url)
                    <a href="{{ $housing->location_url }}" target="_blank" class="inline-flex items-center text-primary-600 hover:text-primary-700 mb-4 font-medium line-clamp-1">
                        <svg class="w-5 h-5 mr-2 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                        </svg>
                        <span class="line-clamp-1">{{ $housing->location }}</span>
                    </a>
                    @else
                    <p class="text-gray-600 mb-4 flex items-center line-clamp-1">
                        <svg class="w-5 h-5 mr-2 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                        </svg>
                        <span class="line-clamp-1">{{ $housing->location }}</span>
                    </p>
                    @endif
                    
                    <p class="text-gray-600 mb-6 line-clamp-3">{{ $housing->description }}</p>
                    
                    <a href="{{ route('housing.show', $housing->slug) }}" class="block w-full text-center bg-primary-600 text-white px-6 py-3 rounded-lg hover:bg-primary-700 transition font-semibold">
                        Lihat Detail
                    </a>
                </div>
            </div>
            @empty
            <div class="col-span-3 text-center py-20">
                <svg class="w-24 h-24 mx-auto text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                </svg>
                <p class="text-gray-500 text-lg">Belum ada perumahan tersedia saat ini.</p>
            </div>
            @endforelse
        </div>
    </div>
</section>
@endsection
