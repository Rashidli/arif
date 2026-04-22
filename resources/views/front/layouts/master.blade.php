<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="robots" content="index, follow">

    {{-- SEO Title --}}
    <title>@yield('title', $seo->meta_title ?? config('app.name'))</title>
    <meta name="description" content="@yield('description', $seo->meta_description ?? '')">
    <meta name="keywords" content="@yield('keywords', $seo->meta_keywords ?? '')">

    {{-- Canonical URL --}}
    <link rel="canonical" href="{{ url()->current() }}">

    {{-- Hreflang for multi-language --}}
    @include('front.partials.hreflang')

    {{-- Open Graph / Facebook --}}
    <meta property="og:type" content="@yield('og_type', 'website')">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:title" content="@yield('title', $seo->meta_title ?? config('app.name'))">
    <meta property="og:description" content="@yield('description', $seo->meta_description ?? '')">
    <meta property="og:site_name" content="{{ config('app.name') }}">
    <meta property="og:locale" content="{{ app()->getLocale() }}_{{ strtoupper(app()->getLocale()) }}">
    @hasSection('og_image')
        <meta property="og:image" content="@yield('og_image')">
    @elseif($logo ?? null)
        <meta property="og:image" content="{{ asset('storage/' . $logo->image) }}">
    @endif

    {{-- Twitter Card --}}
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="@yield('title', $seo->meta_title ?? config('app.name'))">
    <meta name="twitter:description" content="@yield('description', $seo->meta_description ?? '')">
    @hasSection('og_image')
        <meta name="twitter:image" content="@yield('og_image')">
    @endif

    {{-- Head includes (fonts, css, favicon) --}}
    @include('front.partials.head')

    {{-- Page specific styles --}}
    @stack('styles')
</head>
<body>
    {{-- Header --}}
    @include('front.partials.header')

    {{-- Main Content --}}
    <main>
        @yield('content')
    </main>

    {{-- Footer --}}
    @include('front.partials.footer')

    {{-- Back to Top Button --}}
    <button id="backToTop" aria-label="Yuxarı qayıt">
        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <path d="M18 15l-6-6-6 6"/>
        </svg>
    </button>

    {{-- Scripts --}}
    @include('front.partials.scripts')

    {{-- Page specific scripts --}}
    @stack('scripts')
</body>
</html>
