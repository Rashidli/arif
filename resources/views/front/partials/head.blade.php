{{-- Google Fonts - Poppins --}}
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

{{-- AOS Animation Library --}}
<link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">

{{-- Swiper Slider --}}
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css">

{{-- Main Stylesheet --}}
<link rel="stylesheet" href="{{ asset('front/css/style.css') }}?v={{ time() }}">

{{-- Favicon --}}
@if($favicon ?? null)
    <link rel="icon" type="image/png" href="{{ asset('storage/' . $favicon->image) }}">
@else
    <link rel="icon" type="image/png" href="{{ asset('front/images/favicon.png') }}">
@endif
