@extends('front.layouts.master')

@section('title', $seo->meta_title ?? word('contact_title', 'Əlaqə'))
@section('description', $seo->meta_description ?? '')
@section('keywords', $seo->meta_keywords ?? '')

@section('content')

<section class="contact-section">
    <div class="container">
        {{-- Breadcrumb --}}
        <nav class="breadcrumb" data-aos="fade-up">
            <a href="{{ route('front.home') }}">{{ word('nav_home', 'Ana Səhifə') }}</a>
            <span class="breadcrumb-separator">/</span>
            <span class="breadcrumb-current">{{ word('nav_contact', 'Əlaqə') }}</span>
        </nav>

        <div class="contact-grid">
            {{-- Contact Info --}}
            <div class="contact-info" data-aos="fade-right">
                <div>
                    <h1 class="contact-info-title">{{ word('contact_title', 'Bizimlə Əlaqə') }}</h1>
                    <p class="contact-info-desc">{{ word('contact_desc', 'Suallarınız və ya təklifləriniz varsa, bizimlə əlaqə saxlayın. Ən qısa zamanda cavab verəcəyik.') }}</p>
                </div>

                @foreach($contactItems ?? [] as $item)
                    <div class="contact-item">
                        <div class="contact-item-icon">
                            @if($item->icon)
                                {!! $item->icon !!}
                            @else
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/>
                                    <circle cx="12" cy="10" r="3"/>
                                </svg>
                            @endif
                        </div>
                        <div class="contact-item-content">
                            <h4>{{ $item->title }}</h4>
                            <p>{{ $item->value }}</p>
                        </div>
                    </div>
                @endforeach

                {{-- Social Links --}}
                @if($socials->count() > 0)
                    <div class="contact-item">
                        <div class="contact-item-icon">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <circle cx="12" cy="12" r="10"/>
                                <line x1="2" y1="12" x2="22" y2="12"/>
                                <path d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"/>
                            </svg>
                        </div>
                        <div class="contact-item-content">
                            <h4>{{ word('social_networks', 'Sosial Şəbəkələr') }}</h4>
                            <div class="social-links" style="margin-top: 8px;">
                                @foreach($socials as $social)
                                    <a href="{{ $social->url }}" target="_blank" rel="noopener" class="social-link" style="background: var(--primary);" title="{{ $social->name }}">
                                        {!! $social->icon !!}
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    </div>
                @endif
            </div>

            {{-- Contact Form --}}
            <div class="contact-form" data-aos="fade-left">
                @if(session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif

                @if($errors->any())
                    <div class="alert alert-error">
                        <ul style="margin: 0; padding-left: 20px;">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('front.contact.submit') }}" method="POST" data-validate>
                    @csrf
                    <div class="form-group">
                        <label class="form-label" for="name">{{ word('form_name', 'Ad Soyad') }} *</label>
                        <input type="text" id="name" name="name" class="form-control @error('name') error @enderror"
                               value="{{ old('name') }}" required>
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="surname">{{ word('form_surname', 'Soyad') }}</label>
                        <input type="text" id="surname" name="surname" class="form-control @error('surname') error @enderror"
                               value="{{ old('surname') }}">
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="email">{{ word('form_email', 'E-poçt') }} *</label>
                        <input type="email" id="email" name="email" class="form-control @error('email') error @enderror"
                               value="{{ old('email') }}" required>
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="subject">{{ word('form_subject', 'Mövzu') }} *</label>
                        <input type="text" id="subject" name="subject" class="form-control @error('subject') error @enderror"
                               value="{{ old('subject') }}" required>
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="message">{{ word('form_message', 'Mesaj') }} *</label>
                        <textarea id="message" name="message" class="form-control @error('message') error @enderror"
                                  rows="5" required>{{ old('message') }}</textarea>
                    </div>

                    <button type="submit" class="btn btn-primary btn-lg btn-block">
                        {{ word('form_submit', 'Göndər') }}
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <line x1="22" y1="2" x2="11" y2="13"/>
                            <polygon points="22 2 15 22 11 13 2 9 22 2"/>
                        </svg>
                    </button>
                </form>
            </div>
        </div>
    </div>
</section>

@endsection
