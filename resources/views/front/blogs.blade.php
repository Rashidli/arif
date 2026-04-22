@extends('front.layouts.master')

@section('title', $currentTag->name ?? $currentCategory->name ?? $seo->meta_title ?? word('blogs_title', 'Bloq'))
@section('description', $seo->meta_description ?? '')
@section('keywords', $seo->meta_keywords ?? '')

@section('content')

<section class="blog-page">
    <div class="container">
        {{-- Page Header --}}
        <div class="page-header">
            {{-- Breadcrumb --}}
            <nav class="page-breadcrumb">
                <a href="{{ route('front.home') }}">{{ word('nav_home', 'Ana Səhifə') }}</a>
                <span>/</span>
                @if($currentCategory ?? null)
                    <a href="{{ route('front.blogs') }}">{{ word('nav_blogs', 'Bloq') }}</a>
                    <span>/</span>
                    <span>{{ $currentCategory->name }}</span>
                @elseif($currentTag ?? null)
                    <a href="{{ route('front.blogs') }}">{{ word('nav_blogs', 'Bloq') }}</a>
                    <span>/</span>
                    <span>#{{ $currentTag->name }}</span>
                @elseif(request('search'))
                    <span>{{ word('search', 'Axtarış') }}</span>
                @else
                    <span>{{ word('nav_blogs', 'Bloq') }}</span>
                @endif
            </nav>

            {{-- Page Title --}}
            <h1 class="page-title">
                @if($currentCategory ?? null)
                    {{ $currentCategory->name }}
                @elseif($currentTag ?? null)
                    #{{ $currentTag->name }}
                @elseif(request('search'))
                    "{{ request('search') }}" {{ word('search_results', 'üçün nəticələr') }}
                @else
                    {{ word('all_posts', 'Bütün Yazılar') }}
                @endif
            </h1>
        </div>

        {{-- Category Tabs --}}
        <div class="category-tabs">
            <a href="{{ route('front.blogs') }}" class="category-tab {{ !$currentCategory && !$currentTag && !request('search') ? 'active' : '' }}">
                {{ word('all', 'Hamısı') }}
            </a>
            @foreach($categories as $category)
                <a href="{{ route('front.blogs.category', $category->slug) }}"
                   class="category-tab {{ $currentCategory && $currentCategory->id == $category->id ? 'active' : '' }}">
                    {{ $category->name }}
                </a>
            @endforeach
        </div>

        {{-- Active Filter Badge --}}
        @if(request('search'))
            <div class="search-badge">
                <span>"{{ request('search') }}"</span>
                <a href="{{ route('front.blogs') }}">&times;</a>
            </div>
        @endif

        {{-- Blog Grid --}}
        @if($blogs->count() > 0)
            <div class="blog-grid-v2">
                @foreach($blogs as $blog)
                    <article class="blog-card-v2" data-aos="fade-up" data-aos-delay="{{ ($loop->index % 3) * 50 }}">
                        <a href="{{ route('front.blog.detail', $blog->slug) }}" class="blog-card-v2-link">
                            <div class="blog-card-v2-image">
                                @if($blog->image)
                                    <img src="{{ asset('storage/' . $blog->image) }}" alt="{{ $blog->img_alt ?? $blog->title }}" loading="lazy">
                                @else
                                    <div class="blog-card-v2-placeholder"></div>
                                @endif
                            </div>
                            <div class="blog-card-v2-body">
                                <div class="blog-card-v2-meta">
                                    <span class="blog-card-v2-date">{{ $blog->created_at->translatedFormat('d.m.Y') }}</span>
                                    <span class="blog-card-v2-views">
                                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                            <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/>
                                            <circle cx="12" cy="12" r="3"/>
                                        </svg>
                                        {{ number_format($blog->view ?? 0) }} {{ word('views_short', 'Baxış') }}
                                    </span>
                                </div>
                                <h3 class="blog-card-v2-title">{{ $blog->title }}</h3>
                                <p class="blog-card-v2-excerpt">{{ Str::limit($blog->short_description ?? strip_tags($blog->description), 100) }}</p>
                                <div class="blog-card-v2-footer">
                                    <span class="blog-card-v2-category">{{ $blog->category->name ?? '' }}</span>
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

            {{-- Pagination --}}
            @if($blogs->hasPages())
                <div class="pagination-wrapper">
                    @if($blogs->onFirstPage())
                        <span class="pagination-btn disabled">&larr;</span>
                    @else
                        <a href="{{ $blogs->previousPageUrl() }}" class="pagination-btn">&larr;</a>
                    @endif

                    <div class="pagination-pages">
                        @foreach($blogs->getUrlRange(1, $blogs->lastPage()) as $page => $url)
                            <a href="{{ $url }}" class="pagination-page {{ $page == $blogs->currentPage() ? 'active' : '' }}">
                                {{ $page }}
                            </a>
                        @endforeach
                    </div>

                    @if($blogs->hasMorePages())
                        <a href="{{ $blogs->nextPageUrl() }}" class="pagination-btn">&rarr;</a>
                    @else
                        <span class="pagination-btn disabled">&rarr;</span>
                    @endif
                </div>
            @endif
        @else
            <div class="no-results">
                <svg width="64" height="64" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                    <circle cx="11" cy="11" r="8"/>
                    <path d="M21 21l-4.35-4.35"/>
                </svg>
                <h3>{{ word('no_results_title', 'Nəticə tapılmadı') }}</h3>
                <p>{{ word('no_results_desc', 'Axtarış sorğunuza uyğun məqalə tapılmadı.') }}</p>
                <a href="{{ route('front.blogs') }}" class="btn-back">
                    {{ word('view_all_posts', 'Bütün yazılara bax') }}
                </a>
            </div>
        @endif
    </div>
</section>

@endsection
