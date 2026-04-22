@extends('front.layouts.master')

@section('title', $blog->meta_title ?? $blog->title)
@section('description', $blog->meta_description ?? $blog->short_description ?? Str::limit(strip_tags($blog->description), 160))
@section('keywords', $blog->meta_keywords ?? '')
@section('og_type', 'article')
@section('og_image', asset('storage/' . $blog->image))

@php
    $videoId = null;
    if ($blog->youtube_video && preg_match('/(?:youtube\.com\/(?:[^\/]+\/.+\/|(?:v|e(?:mbed)?)\/|.*[?&]v=)|youtu\.be\/)([^"&?\/\s]{11})/', $blog->youtube_video, $match)) {
        $videoId = $match[1];
    }
@endphp

@section('content')

<article class="article-page">
    <div class="container">
        {{-- Breadcrumb --}}
        <nav class="article-breadcrumb">
            <a href="{{ route('front.home') }}">{{ word('nav_home', 'Ana Səhifə') }}</a>
            <span>/</span>
            @if($blog->category)
                <a href="{{ route('front.blogs.category', $blog->category->slug) }}">{{ $blog->category->name }}</a>
                <span>/</span>
            @endif
            <span class="current">{{ Str::limit($blog->title, 50) }}</span>
        </nav>

        <div class="article-layout">
            {{-- Main Content --}}
            <main class="article-main">
                {{-- Header --}}
                <header class="article-header">
                    <h1 class="article-title">{{ $blog->title }}</h1>
                    <div class="article-meta">
                        @if($blog->category)
                            <a href="{{ route('front.blogs.category', $blog->category->slug) }}" class="article-category">{{ $blog->category->name }}</a>
                        @endif
                        <span class="article-date">{{ $blog->created_at->translatedFormat('d.m.Y') }}</span>
                        <span class="article-views">{{ number_format($blog->view ?? 0) }} {{ word('views', 'Baxış') }}</span>
                    </div>
                </header>

                {{-- Featured Media --}}
                @if($videoId)
                    <div class="article-media">
                        <div class="video-container" id="videoContainer">
                            <img src="https://img.youtube.com/vi/{{ $videoId }}/maxresdefault.jpg" alt="{{ $blog->title }}">
                            <button class="video-play" onclick="playVideo('{{ $videoId }}')">
                                <svg viewBox="0 0 68 48" width="68" height="48">
                                    <path d="M66.52 7.74c-.78-2.93-2.49-5.41-5.42-6.19C55.79.13 34 0 34 0S12.21.13 6.9 1.55c-2.93.78-4.63 3.26-5.42 6.19C.06 13.05 0 24 0 24s.06 10.95 1.48 16.26c.78 2.93 2.49 5.41 5.42 6.19C12.21 47.87 34 48 34 48s21.79-.13 27.1-1.55c2.93-.78 4.64-3.26 5.42-6.19C67.94 34.95 68 24 68 24s-.06-10.95-1.48-16.26z" fill="#f00"/>
                                    <path d="M45 24L27 14v20" fill="#fff"/>
                                </svg>
                            </button>
                        </div>
                    </div>
                @elseif($blog->image)
                    <figure class="article-media">
                        <img src="{{ asset('storage/' . $blog->image) }}" alt="{{ $blog->img_alt ?? $blog->title }}">
                    </figure>
                @endif

                {{-- Content --}}
                <div class="article-content">
                    {!! $blog->description !!}
                </div>

                {{-- Share --}}
                <div class="article-share">
                    <span class="share-label">{{ word('share', 'Paylaş') }}:</span>
                    <div class="share-buttons">
                        <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(url()->current()) }}" target="_blank" class="share-btn share-facebook" title="Facebook">
                            <svg width="20" height="20" fill="currentColor" viewBox="0 0 24 24"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
                        </a>
                        <a href="https://t.me/share/url?url={{ urlencode(url()->current()) }}&text={{ urlencode($blog->title) }}" target="_blank" class="share-btn share-telegram" title="Telegram">
                            <svg width="20" height="20" fill="currentColor" viewBox="0 0 24 24"><path d="M11.944 0A12 12 0 0 0 0 12a12 12 0 0 0 12 12 12 12 0 0 0 12-12A12 12 0 0 0 12 0a12 12 0 0 0-.056 0zm4.962 7.224c.1-.002.321.023.465.14a.506.506 0 0 1 .171.325c.016.093.036.306.02.472-.18 1.898-.962 6.502-1.36 8.627-.168.9-.499 1.201-.82 1.23-.696.065-1.225-.46-1.9-.902-1.056-.693-1.653-1.124-2.678-1.8-1.185-.78-.417-1.21.258-1.91.177-.184 3.247-2.977 3.307-3.23.007-.032.014-.15-.056-.212s-.174-.041-.249-.024c-.106.024-1.793 1.14-5.061 3.345-.48.33-.913.49-1.302.48-.428-.008-1.252-.241-1.865-.44-.752-.245-1.349-.374-1.297-.789.027-.216.325-.437.893-.663 3.498-1.524 5.83-2.529 6.998-3.014 3.332-1.386 4.025-1.627 4.476-1.635z"/></svg>
                        </a>
                        <a href="https://wa.me/?text={{ urlencode($blog->title . ' ' . url()->current()) }}" target="_blank" class="share-btn share-whatsapp" title="WhatsApp">
                            <svg width="20" height="20" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
                        </a>
                        <button class="share-btn share-copy" onclick="copyLink()" title="{{ word('copy_link', 'Linki kopyala') }}">
                            <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><rect x="9" y="9" width="13" height="13" rx="2"/><path d="M5 15H4a2 2 0 01-2-2V4a2 2 0 012-2h9a2 2 0 012 2v1"/></svg>
                        </button>
                    </div>
                </div>
            </main>

            {{-- Sidebar --}}
            <aside class="article-sidebar">
                <div class="sidebar-widget">
                    <h3 class="sidebar-title">{{ word('most_read', 'Ən çox oxunanlar') }}</h3>
                    <div class="sidebar-posts">
                        @foreach($mostReadBlogs as $post)
                            <a href="{{ route('front.blog.detail', $post->slug) }}" class="sidebar-post">
                                <div class="sidebar-post-image">
                                    @if($post->image)
                                        <img src="{{ asset('storage/' . $post->image) }}" alt="{{ $post->title }}">
                                    @else
                                        <div class="sidebar-post-placeholder"></div>
                                    @endif
                                </div>
                                <div class="sidebar-post-content">
                                    <span class="sidebar-post-date">{{ $post->created_at->translatedFormat('d.m.Y') }}</span>
                                    <h4>{{ $post->title }}</h4>
                                </div>
                            </a>
                        @endforeach
                    </div>
                </div>
            </aside>
        </div>
    </div>
</article>

{{-- Related Posts Grid --}}
@if($relatedBlogs->count() > 0)
<section class="related-section">
    <div class="container">
        <h2 class="section-title">{{ $blog->category->name ?? word('related_posts', 'Oxşar Yazılar') }}</h2>
        <div class="blog-grid-v2">
            @foreach($relatedBlogs as $related)
                <article class="blog-card-v2">
                    <a href="{{ route('front.blog.detail', $related->slug) }}" class="blog-card-v2-link">
                        <div class="blog-card-v2-image">
                            @if($related->image)
                                <img src="{{ asset('storage/' . $related->image) }}" alt="{{ $related->title }}" loading="lazy">
                            @else
                                <div class="blog-card-v2-placeholder"></div>
                            @endif
                        </div>
                        <div class="blog-card-v2-body">
                            <div class="blog-card-v2-meta">
                                <span class="blog-card-v2-date">{{ $related->created_at->translatedFormat('d.m.Y') }}</span>
                                <span class="blog-card-v2-views">
                                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/>
                                        <circle cx="12" cy="12" r="3"/>
                                    </svg>
                                    {{ number_format($related->view ?? 0) }} {{ word('views_short', 'Baxış') }}
                                </span>
                            </div>
                            <h3 class="blog-card-v2-title">{{ $related->title }}</h3>
                            <p class="blog-card-v2-excerpt">{{ Str::limit($related->short_description ?? strip_tags($related->description), 100) }}</p>
                            <div class="blog-card-v2-footer">
                                <span class="blog-card-v2-category">{{ $related->category->name ?? '' }}</span>
                                <span class="blog-card-v2-arrow">
                                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <path d="M5 12h14M12 5l7 7-7 7"/>
                                    </svg>
                                </span>
                            </div>
                        </div>
                    </a>
                </article>
            @endforeach
        </div>
    </div>
</section>
@endif

<script>
function playVideo(videoId) {
    const container = document.getElementById('videoContainer');
    container.innerHTML = '<iframe src="https://www.youtube.com/embed/' + videoId + '?autoplay=1&rel=0" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>';
}

function copyLink() {
    navigator.clipboard.writeText(window.location.href).then(function() {
        alert('{{ word("link_copied", "Link kopyalandı!") }}');
    });
}
</script>

@endsection
