@php
    $locales = ['az', 'en', 'ru'];
    $currentUrl = url()->current();
@endphp

@foreach($locales as $locale)
    <link rel="alternate" hreflang="{{ $locale }}" href="{{ LaravelLocalization::localizeURL($currentUrl, $locale) }}">
@endforeach
<link rel="alternate" hreflang="x-default" href="{{ LaravelLocalization::localizeURL($currentUrl, 'az') }}">
