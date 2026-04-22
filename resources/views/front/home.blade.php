@extends('front.layouts.master')

@section('title', $seo->meta_title ?? config('app.name'))
@section('description', $seo->meta_description ?? '')
@section('keywords', $seo->meta_keywords ?? '')

@section('content')

{{-- Hero Slider (techtalk style) --}}
@if($sliderBlogs->count() > 0)
<section class="hero-section">
    <div class="container">
        <div class="swiper hero-swiper">
            <div class="swiper-wrapper">
                @foreach($sliderBlogs as $blog)
                    <div class="swiper-slide">
                        <a href="{{ route('front.blog.detail', $blog->slug) }}" class="hero-slide">
                            <div class="hero-slide-bg">
                                @if($blog->image)
                                    <img src="{{ asset('storage/' . $blog->image) }}" alt="{{ $blog->title }}">
                                @else
                                    <div class="hero-slide-placeholder"></div>
                                @endif
                            </div>
                            <div class="hero-slide-content">
                                <span class="hero-slide-date">{{ $blog->created_at->translatedFormat('d.m.Y') }}</span>
                                <h2 class="hero-slide-title">{{ $blog->title }}</h2>
                                <span class="hero-slide-btn">
                                    {{ word('read_more', 'Daha çox oxu') }}
                                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <path d="M5 12h14M12 5l7 7-7 7"/>
                                    </svg>
                                </span>
                            </div>
                        </a>
                    </div>
                @endforeach
            </div>
            <div class="hero-swiper-pagination"></div>
        </div>
    </div>
</section>
@endif

{{-- Category Sections with Sliders --}}
@foreach($homeCategories as $category)
    @if($category->blogs->count() > 0)
    <section class="category-section" data-aos="fade-up">
        <div class="container">
            <div class="category-header">
                <h2 class="category-title">{{ $category->name }}</h2>
                <a href="{{ route('front.blogs.category', $category->slug) }}" class="category-more-btn">
                    {{ word('more', 'Daha çox') }}
                </a>
            </div>

            <div class="swiper blog-swiper">
                <div class="swiper-wrapper">
                    @foreach($category->blogs as $blog)
                        <div class="swiper-slide">
                            <article class="blog-card-v2">
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
                        </div>
                    @endforeach
                </div>
                <div class="blog-swiper-pagination"></div>
            </div>
        </div>
    </section>
    @endif
@endforeach

{{-- If no categories selected, show latest posts --}}
@if($homeCategories->isEmpty() && $sliderBlogs->isEmpty())
<section class="py-4">
    <div class="container">
        <h2 class="section-title" data-aos="fade-up">{{ word('latest_posts', 'Son Yazılar') }}</h2>
        <p class="text-center text-muted">{{ word('no_categories_selected', 'Ana səhifə üçün kateqoriya seçilməyib. Admin paneldən kateqoriyaları seçin.') }}</p>
    </div>
</section>
@endif

@endsection
