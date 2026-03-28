@extends('layouts.app')

@section('title', $aboutSetting->title . ' - Sulthan Property')
@section('meta_description', 'Pelajari lebih lanjut tentang visi, misi, dan tim Sulthan Property, developer perumahan terpercaya Anda.')
@section('meta_keywords', 'tentang sulthan property, tentang developer properti, profil sulthan property, developer terpercaya')
@section('og_title', $aboutSetting->title . ' - Sulthan Property')
@section('og_description', 'Pelajari lebih lanjut tentang visi, misi, dan tim Sulthan Property, developer perumahan terpercaya Anda.')

@section('content')
<div class="bg-gradient-to-r from-primary-600 to-primary-800 text-white py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h1 class="text-4xl font-bold">{{ $aboutSetting->title }}</h1>
    </div>
</div>

<section class="py-16 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        {{-- 2-Column Layout --}}
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            {{-- Left Column (60% - 2 columns) --}}
            <div class="lg:col-span-2 space-y-8">
                {{-- Company Description --}}
                @if($aboutSetting->description)
                <div class="bg-white rounded-xl shadow-lg p-8">
                    <h2 class="text-3xl font-bold text-gray-900 mb-6">Siapa Kami</h2>
                    <div class="prose prose-lg max-w-none text-gray-700 leading-relaxed [&>p]:mb-4">
                        {!! $aboutSetting->description !!}
                    </div>
                </div>
                @endif

                {{-- Vision & Mission --}}
                @if($aboutSetting->vision || $aboutSetting->mission)
                <div class="bg-white rounded-xl shadow-lg p-8">
                    <h2 class="text-3xl font-bold text-gray-900 mb-6">Visi & Misi</h2>
                    <div class="space-y-6">
                        @if($aboutSetting->vision)
                        <div>
                            <h3 class="text-xl font-bold text-primary-600 mb-2">Visi</h3>
                            <div class="text-gray-700 prose max-w-none">
                                {!! $aboutSetting->vision !!}
                            </div>
                        </div>
                        @endif

                        @if($aboutSetting->mission)
                        <div>
                            <h3 class="text-xl font-bold text-primary-600 mb-2">Misi</h3>
                            <div class="text-gray-700 prose max-w-none [&>ul]:list-disc [&>ul]:pl-5 [&>ul>li]:pl-2 [&>ol]:list-decimal [&>ol]:pl-5 [&>ol>li]:pl-2">
                                {!! $aboutSetting->mission !!}
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
                @endif

                {{-- Why Choose Us --}}
                @if($aboutSetting->why_choose_us && count($aboutSetting->why_choose_us) > 0)
                <div class="bg-white rounded-xl shadow-lg p-8">
                    <h2 class="text-3xl font-bold text-gray-900 mb-6">Mengapa Memilih Kami?</h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        @foreach($aboutSetting->why_choose_us as $reason)
                        <div class="flex items-start">
                            <div class="flex-shrink-0">
                                <div class="w-12 h-12 bg-primary-100 rounded-lg flex items-center justify-center">
                                    <x-icon :name="'heroicon-o-' . ($reason['icon'] ?? 'check-circle')" class="w-6 h-6 text-primary-600" />
                                </div>
                            </div>
                            <div class="ml-4">
                                <h3 class="text-lg font-bold text-gray-900 mb-1">{{ $reason['title'] }}</h3>
                                <p class="text-gray-600">{{ $reason['description'] }}</p>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endif
            </div>

            {{-- Right Column (40% - 1 column) --}}
            <div class="lg:col-span-1 space-y-8">
                {{-- Office Photo --}}
                @if($aboutSetting->office_photo)
                <div class="bg-white rounded-xl shadow-lg overflow-hidden">
                    <img src="{{ get_image_url($aboutSetting->office_photo) }}" alt="Kantor Sulthan Property" class="w-full h-64 object-cover">
                </div>
                @endif

                {{-- Contact Information --}}
                <div class="bg-white rounded-xl shadow-lg p-8">
                    <h2 class="text-2xl font-bold text-gray-900 mb-6">Hubungi Kami</h2>
                    <div class="space-y-4">
                        @if($aboutSetting->office_address)
                        <div class="flex items-start">
                            <svg class="w-6 h-6 text-primary-600 mt-1 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                            <div class="ml-3">
                                <p class="text-sm font-semibold text-gray-900">Alamat</p>
                                <p class="text-gray-600">{{ $aboutSetting->office_address }}</p>
                            </div>
                        </div>
                        @endif

                        @if($aboutSetting->office_phone)
                        <div class="flex items-start">
                            <svg class="w-6 h-6 text-primary-600 mt-1 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                            </svg>
                            <div class="ml-3">
                                <p class="text-sm font-semibold text-gray-900">Telepon</p>
                                <a href="tel:{{ $aboutSetting->office_phone }}" class="text-primary-600 hover:text-primary-700">{{ $aboutSetting->office_phone }}</a>
                            </div>
                        </div>
                        @endif

                        @if($aboutSetting->office_email)
                        <div class="flex items-start">
                            <svg class="w-6 h-6 text-primary-600 mt-1 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                            </svg>
                            <div class="ml-3">
                                <p class="text-sm font-semibold text-gray-900">Email</p>
                                <a href="mailto:{{ $aboutSetting->office_email }}" class="text-primary-600 hover:text-primary-700">{{ $aboutSetting->office_email }}</a>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>

                {{-- Google Maps --}}
                @if($aboutSetting->maps_embed_url)
                <div class="bg-white rounded-xl shadow-lg overflow-hidden">
                    <div class="aspect-[4/3]">
                        <iframe 
                            src="{{ $aboutSetting->maps_embed_url }}" 
                            width="100%" 
                            height="100%" 
                            style="border:0;" 
                            allowfullscreen="" 
                            loading="lazy" 
                            referrerpolicy="no-referrer-when-downgrade"
                            class="w-full h-full">
                        </iframe>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
</section>
@endsection
