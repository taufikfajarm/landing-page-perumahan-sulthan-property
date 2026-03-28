@extends('layouts.app')

@section('title', $type->name . ' - ' . $housing->name . ' - Sulthan Property')
@section('meta_description', 'Detail tipe rumah ' . $type->name . ' di perumahan ' . $housing->name . ' oleh Sulthan Property. Luas tanah: ' . $type->land_size . 'm2. Harga mulai ' . $type->formatted_price)
@section('meta_keywords', 'tipe rumah ' . $type->name . ', perumahan ' . $housing->name . ', rumah murah sulthan property, KPR ' . $housing->location)
@section('og_title', $type->name . ' - ' . $housing->name . ' - Sulthan Property')
@section('og_description', 'Detail tipe perumahan ' . $type->name . ' dari proyek ' . $housing->name . ' Sulthan Property. Cek spesifikasi lengkap dan estimasi angsurannya sekarang.')

@section('content')
<div class="bg-gradient-to-r from-primary-600 to-primary-800 text-white py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <nav class="text-primary-100 mb-4">
            <a href="{{ route('housing.index') }}" class="hover:text-white">Perumahan</a>
            <span class="mx-2">/</span>
            <a href="{{ route('housing.show', $housing->slug) }}" class="hover:text-white">{{ $housing->name }}</a>
            <span class="mx-2">/</span>
            <span class="text-white">{{ $type->name }}</span>
        </nav>
        <h1 class="text-4xl font-bold">{{ $type->name }}</h1>
        <p class="text-primary-100">{{ $housing->name }}</p>
    </div>
</div>

<section class="py-12 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            {{-- Main Content --}}
            <div class="lg:col-span-2">
                {{-- Floor Plan --}}
                @if($type->floor_plan)
                <div class="bg-white rounded-xl shadow-lg overflow-hidden mb-8">
                    <img src="{{ get_image_url($type->floor_plan) }}" alt="Denah {{ $type->name }}" class="w-full">
                </div>
                @endif

                {{-- Image Gallery --}}
                @php
                    $galleryImages = [];
                    if($type->image_tampak_depan) $galleryImages[] = ['name' => 'Tampak Depan', 'url' => get_image_url($type->image_tampak_depan)];
                    if($type->image_ruang_tamu) $galleryImages[] = ['name' => 'Ruang Tamu', 'url' => get_image_url($type->image_ruang_tamu)];
                    if($type->image_kamar) $galleryImages[] = ['name' => 'Kamar Tidur', 'url' => get_image_url($type->image_kamar)];
                    if($type->image_dapur) $galleryImages[] = ['name' => 'Kamar Mandi', 'url' => get_image_url($type->image_dapur)];
                    
                    if($type->custom_images && is_array($type->custom_images)) {
                        foreach($type->custom_images as $custom) {
                            if(isset($custom['image']) && isset($custom['room_name'])) {
                                $galleryImages[] = ['name' => $custom['room_name'], 'url' => get_image_url($custom['image'])];
                            }
                        }
                    }
                @endphp

                @if(count($galleryImages) > 0)
                <div class="bg-white rounded-xl shadow-lg p-8 mb-8">
                    <h2 class="text-2xl font-bold text-gray-900 mb-6">Galeri Foto</h2>
                    
                    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                        @foreach($galleryImages as $gallery)
                        <div class="space-y-2">
                            <div class="rounded-lg overflow-hidden shadow-md bg-gray-100">
                                <img src="{{ $gallery['url'] }}" 
                                     alt="{{ $gallery['name'] }}" 
                                     class="w-full h-auto"
                                     loading="lazy">
                            </div>
                            <p class="text-sm text-gray-600 text-center">{{ $gallery['name'] }}</p>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endif

                {{-- Specifications --}}
                <div class="bg-white rounded-xl shadow-lg p-8">
                    <h2 class="text-2xl font-bold text-gray-900 mb-6">Spesifikasi</h2>
                    
                    <div class="grid grid-cols-2 gap-6 mb-8">
                        @if($type->land_size)
                        <div class="border-l-4 border-primary-600 pl-4">
                            <p class="text-gray-600 text-sm">Luas Tanah</p>
                            <p class="text-2xl font-bold text-gray-900">{{ $type->land_size }} m²</p>
                        </div>
                        @endif
                        
                        @if($type->building_size)
                        <div class="border-l-4 border-primary-600 pl-4">
                            <p class="text-gray-600 text-sm">Luas Bangunan</p>
                            <p class="text-2xl font-bold text-gray-900">{{ $type->building_size }} m²</p>
                        </div>
                        @endif
                        
                        <div class="border-l-4 border-primary-600 pl-4">
                            <p class="text-gray-600 text-sm">Kamar Tidur</p>
                            <p class="text-2xl font-bold text-gray-900">{{ $type->bedrooms }}</p>
                        </div>
                        
                        <div class="border-l-4 border-primary-600 pl-4">
                            <p class="text-gray-600 text-sm">Kamar Mandi</p>
                            <p class="text-2xl font-bold text-gray-900">{{ $type->bathrooms }}</p>
                        </div>
                    </div>

                    @if($type->specifications)
                    <div class="border-t pt-6">
                        <h3 class="text-xl font-bold text-gray-900 mb-4">Detail Spesifikasi</h3>
                        <div class="space-y-3">
                            @foreach($type->specifications as $key => $value)
                            <div class="flex justify-between py-2 border-b border-gray-100">
                                <span class="text-gray-600">{{ ucfirst($key) }}</span>
                                <span class="text-gray-900 font-medium">{{ $value }}</span>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    @endif
                </div>
            </div>

            {{-- Sidebar --}}
            <div class="lg:col-span-1">
                <div class="bg-white rounded-xl shadow-lg p-6 sticky top-20">
                    @if($type->price)
                    <div class="mb-6">
                        <p class="text-gray-600 text-sm mb-1">Harga Mulai</p>
                        <p class="text-3xl font-bold text-primary-600">{{ $type->approximate_price }}</p>
                    </div>
                    @endif

                    {{-- Installment Calculator --}}
                    @if($type->installmentPlans && $type->installmentPlans->count() > 0)
                    <div class="border-t border-b py-4 mb-6">
                        <h4 class="text-sm font-bold text-gray-900 mb-3">Estimasi Angsuran</h4>
                        
                        {{-- Tenor Tabs --}}
                        <div class="flex flex-wrap gap-2 mb-3">
                            @foreach($type->installmentPlans as $index => $plan)
                            <button 
                                onclick="showInstallment({{ $index }})"
                                id="tenor-btn-{{ $index }}"
                                class="tenor-btn px-3 py-1.5 text-sm rounded-lg border transition {{ $index === 0 ? 'bg-primary-600 text-white border-primary-600' : 'bg-white text-gray-700 border-gray-300 hover:border-primary-600' }}">
                                {{ $plan->tenor_years }} Tahun
                            </button>
                            @endforeach
                        </div>
                        
                        {{-- Installment Details --}}
                        @foreach($type->installmentPlans as $index => $plan)
                        <div id="installment-{{ $index }}" class="installment-detail {{ $index !== 0 ? 'hidden' : '' }}">
                            <div class="bg-primary-50 rounded-lg p-3 mb-2">
                                <p class="text-xs text-gray-600 mb-1">Angsuran per Bulan</p>
                                <p class="text-xl font-bold text-primary-600">{{ $plan->approximate_monthly_payment }}</p>
                            </div>
                            @if($plan->dp_value)
                            <p class="text-xs text-gray-600">DP: <span class="font-semibold text-gray-900">{{ $plan->formatted_dp }}</span></p>
                            @endif
                        </div>
                        @endforeach
                    </div>
                    @endif

                    {{-- Bank Partners --}}
                    @if($type->bankPartners && $type->bankPartners->count() > 0)
                    <div class="border-t border-b py-4 mb-6">
                        <h4 class="text-sm font-bold text-gray-900 mb-3">Kerjasama Bank</h4>
                        <div class="grid grid-cols-3 gap-2">
                            @foreach($type->bankPartners as $bank)
                            <div class="bg-gray-50 rounded-lg p-2 flex items-center justify-center hover:bg-gray-100 transition">
                                @if($bank->logo)
                                <img src="{{ get_image_url($bank->logo) }}" 
                                     alt="{{ $bank->name }}" 
                                     class="max-h-8 w-auto grayscale hover:grayscale-0 transition"
                                     title="{{ $bank->name }}">
                                @else
                                <span class="text-xs text-gray-600 font-medium">{{ $bank->name }}</span>
                                @endif
                            </div>
                            @endforeach
                        </div>
                    </div>
                    @endif

                    {{-- Promo Badge --}}
                    @if($type->promo_title)
                    <div class="bg-gradient-to-r from-red-500 to-pink-500 text-white rounded-lg p-4 mb-6">
                        <div class="flex items-start">
                            <svg class="w-5 h-5 mr-2 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                            </svg>
                            <div class="flex-1">
                                <h4 class="font-bold text-sm mb-1">{{ $type->promo_title }}</h4>
                                @if($type->promo_description)
                                <p class="text-xs opacity-90">{{ $type->promo_description }}</p>
                                @endif
                                <p class="text-xs opacity-75 mt-1">
                                    @if($type->promo_valid_until)
                                        Berlaku hingga {{ \Carbon\Carbon::parse($type->promo_valid_until)->format('d M Y') }}
                                    @else
                                        Promo Terbatas
                                    @endif
                                </p>
                            </div>
                        </div>
                    </div>
                    @endif

                    <h3 class="text-lg font-bold text-gray-900 mb-3">Tertarik dengan tipe ini?</h3>
                    
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

<script>
function showInstallment(index) {
    // Hide all installment details
    document.querySelectorAll('.installment-detail').forEach(el => el.classList.add('hidden'));
    // Show selected installment
    document.getElementById('installment-' + index).classList.remove('hidden');
    
    // Update button styles
    document.querySelectorAll('.tenor-btn').forEach(btn => {
        btn.classList.remove('bg-primary-600', 'text-white', 'border-primary-600');
        btn.classList.add('bg-white', 'text-gray-700', 'border-gray-300');
    });
    document.getElementById('tenor-btn-' + index).classList.remove('bg-white', 'text-gray-700', 'border-gray-300');
    document.getElementById('tenor-btn-' + index).classList.add('bg-primary-600', 'text-white', 'border-primary-600');
}
</script>
@endsection
