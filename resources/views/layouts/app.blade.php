<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    {{-- SEO Meta Tags --}}
    <title>@yield('title', 'Sulthan Property - Perumahan Murah & Subsidi di Brebes')</title>
    <meta name="description" content="@yield('meta_description', 'Developer perumahan terpercaya di Brebes & Tegal. Menyediakan rumah subsidi & komersil berkualitas, lokasi strategis, DP ringan, dan cicilan mudah.')">
    <meta name="keywords" content="@yield('meta_keywords', 'perumahan brebes, perumahan subsidi brebes, rumah murah brebes, rumah dijual tegal, perumahan tegal, developer properti brebes, KPR rumah subsidi')">
    <meta name="author" content="Sulthan Property">
    <meta name="robots" content="index, follow">
    
    {{-- Canonical URL --}}
    <link rel="canonical" href="{{ url()->current() }}">
    
    {{-- Open Graph / Facebook --}}
    <meta property="og:type" content="website">
    <meta property="og:site_name" content="Sulthan Property">
    <meta property="og:locale" content="id_ID">
    <meta property="og:title" content="@yield('og_title', 'Sulthan Property - Perumahan Berkualitas')">
    <meta property="og:description" content="@yield('og_description', 'Menyediakan perumahan berkualitas dengan lokasi strategis, harga terjangkau, dan nilai investasi tinggi.')">
    <meta property="og:image" content="@yield('og_image', asset('images/og-image.jpg'))">
    <meta property="og:image:width" content="1200">
    <meta property="og:image:height" content="630">
    <meta property="og:url" content="{{ url()->current() }}">
    
    {{-- Twitter Card --}}
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="@yield('twitter_title', 'Sulthan Property')">
    <meta name="twitter:description" content="@yield('twitter_description', 'Perumahan Berkualitas dengan Harga Terjangkau')">
    <meta name="twitter:image" content="@yield('twitter_image', asset('images/og-image.jpg'))">
    
    {{-- Favicon --}}
    <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}">
    
    {{-- JSON-LD Structured Data --}}
    <script type="application/ld+json">
    {
        "@@context": "https://schema.org",
        "@@type": "RealEstateAgent",
        "name": "Sulthan Property",
        "url": "{{ url('/') }}",
        "logo": "{{ asset('favicon.svg') }}",
        "image": "{{ asset('images/og-image.jpg') }}",
        "description": "Developer properti terpercaya di Brebes dan Tegal yang menyediakan perumahan subsidi dan komersil berkualitas dengan lokasi strategis, DP ringan, dan cicilan mudah.",
        "telephone": "+6281280000000",
        "priceRange": "Rp 160.000.000 - Rp 500.000.000",
        "address": {
            "@@type": "PostalAddress",
            "streetAddress": "Jl. Pangeran Diponegoro Pesantunan",
            "addressLocality": "Brebes",
            "addressRegion": "Jawa Tengah",
            "postalCode": "52212",
            "addressCountry": "ID"
        },
        "geo": {
            "@@type": "GeoCoordinates",
            "latitude": -6.8694,
            "longitude": 109.0453
        },
        "openingHoursSpecification": [
            {
                "@@type": "OpeningHoursSpecification",
                "dayOfWeek": ["Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday"],
                "opens": "08:00",
                "closes": "17:00"
            }
        ],
        "sameAs": [
            "https://www.instagram.com/sulthanproperty/",
            "https://www.tiktok.com/@sulthanproperty"
        ]
    }
    </script>
    {{-- Google Fonts Preconnect and Lazy Load --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&family=Raleway:wght@400;500;600;700;800&display=swap" rel="stylesheet" media="print" onload="this.media='all'">
    <noscript>
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&family=Raleway:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    </noscript>

    @stack('seo')
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <style>
        [x-cloak] { display: none !important; }

        /* Scroll Reveal Animations */
        [data-scroll] {
            opacity: 0;
            will-change: transform, opacity;
            transition: opacity 0.7s cubic-bezier(0.16, 1, 0.3, 1),
                        transform 0.7s cubic-bezier(0.16, 1, 0.3, 1);
        }
        [data-scroll].is-visible {
            opacity: 1;
            transform: none !important;
        }
        [data-scroll="fade-up"]   { transform: translateY(40px); }
        [data-scroll="fade-down"] { transform: translateY(-40px); }
        [data-scroll="fade-left"] { transform: translateX(40px); }
        [data-scroll="fade-right"]{ transform: translateX(-40px); }
        [data-scroll="zoom-in"]   { transform: scale(0.92); }
        [data-scroll=""],
        [data-scroll]              { transform: translateY(40px); }
    </style>
    
    @stack('styles')
</head>
<body class="font-sans antialiased" style="background-color: #f7f8fd;">
    {{-- Navigation --}}
    <nav class="sticky top-0 z-50 transition-all duration-300" 
         x-data="{ mobileMenuOpen: false, scrolled: false }" 
         x-init="window.addEventListener('scroll', () => { scrolled = window.scrollY > 50 })"
         :class="scrolled ? 'bg-white/70 backdrop-blur-md shadow-lg' : 'bg-white'">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                {{-- Logo --}}
                <div class="flex-shrink-0">
                    <a href="{{ route('home') }}" class="text-2xl font-bold text-primary-600">
                        Sulthan Property
                    </a>
                </div>

                {{-- Desktop Navigation --}}
                <div class="hidden md:flex space-x-8">
                    <a href="{{ route('home') }}" class="text-gray-700 hover:text-primary-600 px-3 py-2 rounded-md text-sm font-medium transition {{ request()->routeIs('home') ? 'text-primary-600 font-semibold' : '' }}">
                        Home
                    </a>
                    <a href="{{ route('housing.index') }}" class="text-gray-700 hover:text-primary-600 px-3 py-2 rounded-md text-sm font-medium transition {{ request()->routeIs('housing.*') ? 'text-primary-600 font-semibold' : '' }}">
                        Pilihan Perumahan
                    </a>
                    <a href="{{ route('marketing.index') }}" class="text-gray-700 hover:text-primary-600 px-3 py-2 rounded-md text-sm font-medium transition {{ request()->routeIs('marketing.*') ? 'text-primary-600 font-semibold' : '' }}">
                        Marketing
                    </a>
                    <a href="{{ route('blog.index') }}" class="text-gray-700 hover:text-primary-600 px-3 py-2 rounded-md text-sm font-medium transition {{ request()->routeIs('blog.*') ? 'text-primary-600 font-semibold' : '' }}">
                        Blog
                    </a>
                    <a href="{{ route('about') }}" class="text-gray-700 hover:text-primary-600 px-3 py-2 rounded-md text-sm font-medium transition {{ request()->routeIs('about') ? 'text-primary-600 font-semibold' : '' }}">
                        About
                    </a>
                </div>

                {{-- Mobile menu button --}}
                <div class="md:hidden">
                    <button @click="mobileMenuOpen = !mobileMenuOpen" class="text-gray-700 hover:text-primary-600 focus:outline-none" aria-label="Menu Utama" :aria-expanded="mobileMenuOpen.toString()">
                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path x-show="!mobileMenuOpen" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                            <path x-show="mobileMenuOpen" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>
            </div>
        </div>

        {{-- Mobile Navigation --}}
        <div x-show="mobileMenuOpen" x-transition class="md:hidden bg-white border-t">
            <div class="px-2 pt-2 pb-3 space-y-1">
                <a href="{{ route('home') }}" class="block text-gray-700 hover:text-primary-600 hover:bg-gray-50 px-3 py-2 rounded-md text-base font-medium {{ request()->routeIs('home') ? 'text-primary-600 bg-gray-50' : '' }}">
                    Home
                </a>
                <a href="{{ route('housing.index') }}" class="block text-gray-700 hover:text-primary-600 hover:bg-gray-50 px-3 py-2 rounded-md text-base font-medium {{ request()->routeIs('housing.*') ? 'text-primary-600 bg-gray-50' : '' }}">
                    Pilihan Perumahan
                </a>
                <a href="{{ route('marketing.index') }}" class="block text-gray-700 hover:text-primary-600 hover:bg-gray-50 px-3 py-2 rounded-md text-base font-medium {{ request()->routeIs('marketing.*') ? 'text-primary-600 bg-gray-50' : '' }}">
                    Marketing
                </a>
                <a href="{{ route('blog.index') }}" class="block text-gray-700 hover:text-primary-600 hover:bg-gray-50 px-3 py-2 rounded-md text-base font-medium {{ request()->routeIs('blog.*') ? 'text-primary-600 bg-gray-50' : '' }}">
                    Blog
                </a>
                <a href="{{ route('about') }}" class="block text-gray-700 hover:text-primary-600 hover:bg-gray-50 px-3 py-2 rounded-md text-base font-medium {{ request()->routeIs('about') ? 'text-primary-600 bg-gray-50' : '' }}">
                    About
                </a>
            </div>
        </div>
    </nav>

    {{-- Main Content --}}
    <main>
        @yield('content')
    </main>

    {{-- Footer --}}
    <footer class="bg-gray-900 text-white mt-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                {{-- Company Info --}}
                <div class="col-span-1 md:col-span-2" data-scroll="fade-up">
                    <img src="{{ asset('storage/home/sulthanlogo.webp') }}" alt="Sulthan Property Logo" class="h-24 w-auto mb-2" width="288" height="96" loading="lazy">
                    <p class="text-gray-300 mb-4">
                        Menyediakan perumahan berkualitas dengan lokasi strategis, <br>
                        harga terjangkau, dan nilai investasi tinggi.
                    </p>
                </div>

                {{-- Quick Links --}}
                <div data-scroll="fade-up" data-scroll-delay="150">
                    <h4 class="text-lg font-semibold mb-4 text-white">Quick Links</h4>
                    <ul class="space-y-2">
                        <li><a href="{{ route('home') }}" class="text-gray-300 hover:text-primary-400 transition">Home</a></li>
                        <li><a href="{{ route('housing.index') }}" class="text-gray-300 hover:text-primary-400 transition">Pilihan Perumahan</a></li>
                        <li><a href="{{ route('marketing.index') }}" class="text-gray-300 hover:text-primary-400 transition">Marketing</a></li>
                        <li><a href="{{ route('blog.index') }}" class="text-gray-300 hover:text-primary-400 transition">Blog</a></li>
                        <li><a href="{{ route('about') }}" class="text-gray-300 hover:text-primary-400 transition">About</a></li>
                    </ul>
                </div>

                {{-- Contact Info --}}
                <div data-scroll="fade-up" data-scroll-delay="300">
                    <h4 class="text-lg font-semibold mb-4 text-white">Contact</h4>
                    <ul class="space-y-2 text-gray-300">
                        <li>Email: <a href="mailto:hanaanjayaabadi@gmail.com" class="hover:text-primary-400 transition"><!--email_off-->hanaanjayaabadi@gmail.com<!--/email_off--></a></li>
                        <li>Phone: <a href="https://wa.me/6281280000000" target="_blank" rel="noopener noreferrer" class="hover:text-primary-400 transition">+62 812-8000-0000</a></li>
                    </ul>
                    {{-- Follow Us --}}
                    <div class="flex space-x-4 mt-4">
                        {{-- Instagram --}}
                        <a href="https://www.instagram.com/sulthanproperty/" target="_blank" rel="noopener noreferrer" aria-label="Instagram Sulthan Property" class="w-10 h-10 bg-gray-800 hover:bg-gradient-to-r hover:from-purple-500 hover:to-pink-500 rounded-full flex items-center justify-center transition-all duration-300">
                            <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/>
                            </svg>
                        </a>
                        {{-- TikTok --}}
                        <a href="https://www.tiktok.com/@sulthanproperty" target="_blank" rel="noopener noreferrer" aria-label="TikTok Sulthan Property" class="w-10 h-10 bg-gray-800 hover:bg-black rounded-full flex items-center justify-center transition-all duration-300">
                            <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M19.59 6.69a4.83 4.83 0 0 1-3.77-4.25V2h-3.45v13.67a2.89 2.89 0 0 1-5.2 1.74 2.89 2.89 0 0 1 2.31-4.64 2.93 2.93 0 0 1 .88.13V9.4a6.84 6.84 0 0 0-1-.05A6.33 6.33 0 0 0 5 20.1a6.34 6.34 0 0 0 10.86-4.43v-7a8.16 8.16 0 0 0 4.77 1.52v-3.4a4.85 4.85 0 0 1-1-.1z"/>
                            </svg>
                        </a>
                    </div>
                </div>
            </div>

            <div class="border-t border-gray-800 mt-8 pt-8 text-center text-gray-300">
                <p>&copy; {{ date('Y') }} Sulthan Property. All rights reserved.</p>
            </div>
        </div>
    </footer>

    {{-- Scroll Reveal Observer --}}
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const scrollElements = document.querySelectorAll('[data-scroll]');
            if (!scrollElements.length) return;

            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        const el = entry.target;
                        const delay = el.dataset.scrollDelay || 0;
                        const duration = el.dataset.scrollDuration;
                        if (duration) {
                            el.style.transitionDuration = duration + 'ms';
                        }
                        setTimeout(() => {
                            el.classList.add('is-visible');
                        }, delay);
                        observer.unobserve(el);
                    }
                });
            }, {
                threshold: 0.12,
                rootMargin: '0px 0px -40px 0px'
            });

            scrollElements.forEach(el => observer.observe(el));
        });
    </script>

    @stack('scripts')
</body>
</html>
