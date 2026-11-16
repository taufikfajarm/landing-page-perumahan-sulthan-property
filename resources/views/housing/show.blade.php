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
        <a href="{{ $housing->location_url }}" target="_blank" rel="noopener noreferrer" class="inline-flex items-center text-primary-100 hover:text-white">
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
                                <img src="{{ get_image_url($facility->icon) }}" alt="{{ $facility->name }}" class="w-full h-full object-contain" loading="lazy" width="64" height="64">
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
                <div x-data="siteplanViewer('{{ $housing->siteplan_sip_id }}')" class="bg-white rounded-2xl shadow-xl overflow-hidden mb-8 border border-gray-100">
                    
                    {{-- Header & Legenda --}}
                    <div class="px-5 py-4 border-b border-gray-100 flex flex-wrap items-center justify-between gap-3 bg-gray-50/70">
                        <div>
                            <h2 class="text-lg font-bold text-gray-900 leading-tight">Siteplan Interaktif Realtime</h2>
                            <p class="text-xs text-gray-500">Kavling merah menandakan unit sudah terbooking</p>
                        </div>

                        <div class="flex items-center gap-3">
                            <template x-if="data && data.statusBloks">
                                <div class="flex items-center gap-2">
                                    <template x-for="st in data.statusBloks" :key="st.id">
                                        <div class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg text-xs font-semibold border bg-white shadow-xs">
                                            <span class="w-3 h-3 rounded-full border" 
                                                  :style="{ backgroundColor: st.warna, borderColor: isWhite(st.warna) ? '#94a3b8' : st.warna }"></span>
                                            <span x-text="st.nama" class="text-gray-700"></span>
                                            <span x-show="data.stats && data.stats[st.id] !== undefined" 
                                                  class="text-gray-900 font-bold ml-1 pl-1 border-l border-gray-200" 
                                                  x-text="data.stats[st.id]"></span>
                                        </div>
                                    </template>
                                </div>
                            </template>

                            <a href="https://sip.sulthanproperty.com/embed/siteplan/{{ $housing->siteplan_sip_id }}" 
                               target="_blank" 
                               rel="noopener noreferrer" 
                               class="inline-flex items-center gap-1.5 text-xs font-semibold text-primary-600 hover:text-primary-700 bg-primary-50 hover:bg-primary-100 px-3 py-1.5 rounded-lg transition"
                               title="Buka tampilan penuh di tab baru">
                                <span>Buka Penuh</span>
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                            </a>
                        </div>
                    </div>

                    {{-- Container Area Siteplan --}}
                    <div x-ref="siteplanContainer" class="relative w-full overflow-hidden bg-gray-900 flex items-center justify-center min-h-[450px]">
                        {{-- Loading Spinner --}}
                        <div x-show="loading" class="absolute inset-0 flex flex-col items-center justify-center bg-white/90 z-20">
                            <div class="w-10 h-10 border-4 border-primary-500 border-t-transparent rounded-full animate-spin mb-3"></div>
                            <span class="text-sm font-medium text-gray-600">Memuat denah siteplan realtime...</span>
                        </div>

                        {{-- Fallback Gambar jika Error API --}}
                        <div x-show="error && !loading" class="w-full">
                            @if($housing->site_plan)
                            <img src="{{ get_image_url($housing->site_plan) }}" alt="Site Plan {{ $housing->name }}" class="w-full h-auto" loading="lazy">
                            @else
                            <div class="p-12 text-center text-gray-500">
                                Gambar site plan belum tersedia.
                            </div>
                            @endif
                        </div>

                        {{-- Realtime Interactive SVG Canvas --}}
                        <div x-show="!loading && !error && data" class="relative w-full">
                            <template x-if="data && data.proyek && data.proyek.siteplan">
                                <img x-ref="siteplanImage"
                                     :src="data.proyek.siteplan" 
                                     alt="Site Plan {{ $housing->name }}" 
                                     class="w-full h-auto block select-none pointer-events-none"
                                     @load="onImgLoad($event)">
                            </template>

                            {{-- SVG Polygon & Text Layer --}}
                            <svg x-ref="svgOverlay"
                                 :viewBox="`0 0 ${imgDimensions.width} ${imgDimensions.height}`" 
                                 class="absolute inset-0 w-full h-full pointer-events-auto"
                                 preserveAspectRatio="none">
                            </svg>

                            {{-- Hover Tooltip Card --}}
                            <div x-show="hoveredBlok" 
                                 x-cloak
                                 class="absolute z-30 pointer-events-none bg-white/95 backdrop-blur-md border shadow-2xl rounded-xl p-3 min-w-[150px] transition-all duration-75 text-left"
                                 :style="`left: ${tooltip.x}px; top: ${tooltip.y}px; border-color: ${hoveredBlok?.status_warna || '#e2e8f0'};`">
                                <div class="flex items-center justify-between gap-2 mb-1">
                                    <span class="text-[10px] font-bold uppercase tracking-wider text-gray-400">Kavling</span>
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
                <div class="bg-white rounded-xl shadow-lg overflow-hidden mb-8">
                    <img src="{{ get_image_url($housing->site_plan) }}" alt="Site Plan {{ $housing->name }}" class="w-full h-auto" loading="lazy" width="800" height="500">
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

                // Warna booking merah transparan (0.55), saat di-hover lebih pekat (0.85)
                const fill = isHovered 
                    ? (isTersedia ? 'rgba(255, 255, 255, 0.9)' : this.hexToRgba(color, 0.85))
                    : (isTersedia ? 'rgba(255, 255, 255, 0.45)' : this.hexToRgba(color, 0.55));

                const stroke = isHovered ? '#0f172a' : (isTersedia ? '#94a3b8' : color);
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
