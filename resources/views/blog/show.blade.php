@extends('layouts.app')

@section('title', $blog->meta_title ?: $blog->title)
@section('meta_description', $blog->meta_description ?: $blog->excerpt)
@section('meta_keywords', $blog->meta_keywords)

{{-- Enhanced Open Graph Tags --}}
<meta property="og:type" content="article">
<meta property="og:title" content="{{ $blog->meta_title ?: $blog->title }}">
<meta property="og:description" content="{{ $blog->meta_description ?: $blog->excerpt }}">
<meta property="og:url" content="{{ url()->current() }}">
<meta property="og:site_name" content="Sulthan Property">
@if($blog->featured_image)
<meta property="og:image" content="{{ get_image_url($blog->featured_image) }}">
<meta property="og:image:width" content="1200">
<meta property="og:image:height" content="630">
@endif
<meta property="article:published_time" content="{{ $blog->published_at->toIso8601String() }}">
<meta property="article:author" content="Sulthan Property">

{{-- Twitter Card Tags --}}
<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:title" content="{{ $blog->meta_title ?: $blog->title }}">
<meta name="twitter:description" content="{{ $blog->meta_description ?: $blog->excerpt }}">
@if($blog->featured_image)
<meta name="twitter:image" content="{{ get_image_url($blog->featured_image) }}">
@endif


@section('content')
<article class="py-8 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            {{-- Main Content --}}
            <div class="lg:col-span-2">
                {{-- Banner Ad (if type is banner) --}}
                @if($ad && $ad->ad_type === 'banner')
                    <x-blog-ad-banner :ad="$ad" />
                @endif

                {{-- Featured Image --}}
                @if($blog->featured_image)
                <div class="mb-6">
                    <img src="{{ get_image_url($blog->featured_image) }}" alt="{{ $blog->title }}" class="w-full rounded-xl shadow-lg">
                </div>
                @endif

                {{-- Article Header --}}
                <div class="bg-white rounded-xl shadow-md p-8 mb-4">
                    <h1 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4 leading-tight">{{ $blog->title }}</h1>
                    
                    <div class="flex items-center text-sm text-gray-500 mb-4 pb-4 border-b">
                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                        {{ $blog->published_at->translatedFormat('d F Y') }}
                        <span class="mx-2">•</span>
                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                        </svg>
                        Sulthan Property
                        <span class="mx-2">•</span>
                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                        </svg>
                        {{ $blog->views }} views
                    </div>

                    {{-- Article Content --}}
                    <div class="article-content">
                        {!! $blog->content !!}
                    </div>
                </div>

                {{-- Social Share Buttons --}}
                <div class="bg-white rounded-xl shadow-md p-6 mb-6">
                    <h3 class="text-lg font-bold text-gray-900 mb-4">Bagikan Artikel Ini</h3>
                    <div class="flex flex-wrap gap-3">
                        {{-- Facebook --}}
                        <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(url()->current()) }}" 
                           target="_blank" 
                           rel="noopener noreferrer"
                           class="inline-flex items-center gap-2 bg-[#1877F2] text-white px-4 py-2 rounded-lg hover:bg-[#0d65d9] transition">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                            </svg>
                            <span class="font-medium">Facebook</span>
                        </a>

                        {{-- WhatsApp --}}
                        <a href="https://wa.me/?text={{ urlencode($blog->title . ' - ' . url()->current()) }}" 
                           target="_blank" 
                           rel="noopener noreferrer"
                           class="inline-flex items-center gap-2 bg-[#25D366] text-white px-4 py-2 rounded-lg hover:bg-[#1da851] transition">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/>
                            </svg>
                            <span class="font-medium">WhatsApp</span>
                        </a>

                        {{-- Telegram --}}
                        <a href="https://t.me/share/url?url={{ urlencode(url()->current()) }}&text={{ urlencode($blog->title) }}" 
                           target="_blank" 
                           rel="noopener noreferrer"
                           class="inline-flex items-center gap-2 bg-[#0088cc] text-white px-4 py-2 rounded-lg hover:bg-[#0077b5] transition">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M11.944 0A12 12 0 0 0 0 12a12 12 0 0 0 12 12 12 12 0 0 0 12-12A12 12 0 0 0 12 0a12 12 0 0 0-.056 0zm4.962 7.224c.1-.002.321.023.465.14a.506.506 0 0 1 .171.325c.016.093.036.306.02.472-.18 1.898-.962 6.502-1.36 8.627-.168.9-.499 1.201-.82 1.23-.696.065-1.225-.46-1.9-.902-1.056-.693-1.653-1.124-2.678-1.8-1.185-.78-.417-1.21.258-1.91.177-.184 3.247-2.977 3.307-3.23.007-.032.014-.15-.056-.212s-.174-.041-.249-.024c-.106.024-1.793 1.14-5.061 3.345-.48.33-.913.49-1.302.48-.428-.008-1.252-.241-1.865-.44-.752-.245-1.349-.374-1.297-.789.027-.216.325-.437.893-.663 3.498-1.524 5.83-2.529 6.998-3.014 3.332-1.386 4.025-1.627 4.476-1.635z"/>
                            </svg>
                            <span class="font-medium">Telegram</span>
                        </a>

                        {{-- Twitter/X --}}
                        <a href="https://twitter.com/intent/tweet?url={{ urlencode(url()->current()) }}&text={{ urlencode($blog->title) }}" 
                           target="_blank" 
                           rel="noopener noreferrer"
                           class="inline-flex items-center gap-2 bg-[#000000] text-white px-4 py-2 rounded-lg hover:bg-[#333333] transition">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/>
                            </svg>
                            <span class="font-medium">Twitter</span>
                        </a>

                        {{-- Copy Link --}}
                        <button onclick="copyToClipboard('{{ url()->current() }}')" 
                                class="inline-flex items-center gap-2 bg-gray-600 text-white px-4 py-2 rounded-lg hover:bg-gray-700 transition">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"/>
                            </svg>
                            <span class="font-medium">Salin Link</span>
                        </button>
                    </div>
                </div>

                {{-- Tags 
                @if($blog->meta_keywords)
                <div class="bg-white rounded-xl shadow-md p-6">
                    <h3 class="text-lg font-bold text-gray-900 mb-4">Tags</h3>
                    <div class="flex flex-wrap gap-2">
                        @foreach(explode(',', $blog->meta_keywords) as $tag)
                        <a href="{{ route('blog.index', ['tag' => trim($tag)]) }}" class="inline-block bg-gray-100 text-gray-700 px-4 py-2 rounded-full text-sm font-medium hover:bg-primary-100 hover:text-primary-700 transition">
                            {{ trim($tag) }}
                        </a>
                        @endforeach
                    </div>
                </div>
                @endif --}}
            </div>

            {{-- Sidebar --}}
            <div class="lg:col-span-1">
                <div class="sticky top-20 space-y-6">
                    {{-- Popular Posts --}}
                    @if($relatedBlogs->count() > 0)
                    <div class="bg-white rounded-xl shadow-md p-6">
                        <h3 class="text-xl font-bold text-gray-900 mb-4">Popular Posts</h3>
                        <div class="space-y-4">
                            @foreach($relatedBlogs as $related)
                            <a href="{{ route('blog.show', $related->slug) }}" class="group block">
                                <div class="flex gap-3">
                                    @if($related->featured_image)
                                    <img src="{{ get_image_url($related->featured_image) }}" alt="{{ $related->title }}" class="w-20 h-20 object-cover rounded-lg flex-shrink-0 group-hover:opacity-90 transition">
                                    @else
                                    <div class="w-20 h-20 bg-gray-200 rounded-lg flex-shrink-0 flex items-center justify-center">
                                        <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/>
                                        </svg>
                                    </div>
                                    @endif
                                    <div class="flex-1 min-w-0">
                                        <p class="text-xs text-primary-600 mb-1">{{ $related->published_at->translatedFormat('d F Y') }}</p>
                                        <h4 class="font-semibold text-gray-900 group-hover:text-primary-600 transition line-clamp-2 text-sm">{{ $related->title }}</h4>
                                    </div>
                                </div>
                            </a>
                            @endforeach
                        </div>
                    </div>
                    @endif

                    {{-- Promotional Ad (Card only) --}}
                    @if($ad && $ad->ad_type === 'card')
                        <x-blog-ad-card :ad="$ad" />
                    @endif

                    {{-- Tags Cloud --}}
                    @if($blog->meta_keywords)
                    <div class="bg-white rounded-xl shadow-md p-6">
                        <h3 class="text-xl font-bold text-gray-900 mb-4">Tags</h3>
                        <div class="flex flex-wrap gap-2">
                            @foreach(explode(',', $blog->meta_keywords) as $tag)
                            <a href="{{ route('blog.index', ['tag' => trim($tag)]) }}" class="inline-block bg-gray-100 text-gray-700 px-3 py-1 rounded-md text-sm hover:bg-primary-100 hover:text-primary-700 transition">
                                {{ trim($tag) }}
                            </a>
                            @endforeach
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</article>
@endsection

@push('scripts')
<script>
function copyToClipboard(text) {
    // Create temporary textarea
    const textarea = document.createElement('textarea');
    textarea.value = text;
    textarea.style.position = 'fixed';
    textarea.style.opacity = '0';
    document.body.appendChild(textarea);
    
    // Select and copy
    textarea.select();
    textarea.setSelectionRange(0, 99999); // For mobile devices
    
    try {
        document.execCommand('copy');
        
        // Show success notification
        const button = event.target.closest('button');
        const originalText = button.innerHTML;
        button.innerHTML = `
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
            </svg>
            <span class="font-medium">Tersalin!</span>
        `;
        button.classList.add('bg-green-600');
        button.classList.remove('bg-gray-600');
        
        // Reset button after 2 seconds
        setTimeout(() => {
            button.innerHTML = originalText;
            button.classList.remove('bg-green-600');
            button.classList.add('bg-gray-600');
        }, 2000);
    } catch (err) {
        console.error('Failed to copy:', err);
        alert('Gagal menyalin link');
    }
    
    // Remove temporary textarea
    document.body.removeChild(textarea);
}
</script>
@endpush
