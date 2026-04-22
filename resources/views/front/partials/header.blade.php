<header class="header" id="header">
    {{-- Top Bar: Logo + Search + Language --}}
    <div class="header-top">
        <div class="container">
            <div class="header-top-inner">
                {{-- Logo --}}
                <a href="{{ route('front.home') }}" class="logo">
                    @if($logo ?? null)
                        <img src="{{ asset('storage/' . $logo->image) }}" alt="{{ config('app.name') }}">
                    @else
                        <span class="logo-text">{{ config('app.name') }}</span>
                    @endif
                </a>

                {{-- Search Box --}}
                <form action="{{ route('front.blogs') }}" method="GET" class="header-search">
                    <input type="text" name="search" placeholder="{{ word('search_placeholder', 'Axtar...') }}" value="{{ request('search') }}">
                    <button type="submit">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <circle cx="11" cy="11" r="8"/>
                            <path d="M21 21l-4.35-4.35"/>
                        </svg>
                    </button>
                </form>

                {{-- Right Side: Language + Mobile Menu --}}
                <div class="header-top-right">
                    {{-- Language Switcher --}}
                    <div class="lang-switcher">
                        <button class="lang-current">
                            {{ strtoupper(app()->getLocale()) }}
                            <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M6 9l6 6 6-6"/>
                            </svg>
                        </button>
                        <div class="lang-dropdown">
                            @foreach(['az' => 'AZ', 'en' => 'EN', 'ru' => 'RU'] as $code => $name)
                                <a href="{{ LaravelLocalization::localizeURL(url()->current(), $code) }}"
                                   class="lang-item {{ app()->getLocale() == $code ? 'active' : '' }}">
                                    {{ $name }}
                                </a>
                            @endforeach
                        </div>
                    </div>

                    {{-- Mobile Menu Toggle --}}
                    <button class="mobile-toggle" id="mobileToggle" aria-label="Menu">
                        <span></span>
                        <span></span>
                        <span></span>
                    </button>
                </div>
            </div>
        </div>
    </div>

    {{-- Bottom Bar: Navigation --}}
    <div class="header-nav">
        <div class="container">
            <nav class="nav-desktop">
                <a href="{{ route('front.home') }}" class="nav-link {{ request()->routeIs('front.home') ? 'active' : '' }}">
                    {{ word('nav_home', 'Ana Səhifə') }}
                </a>
                @foreach($categories ?? [] as $category)
                    <a href="{{ route('front.blogs.category', $category->slug) }}"
                       class="nav-link {{ request()->is('*/' . $category->slug) || request()->is($category->slug) ? 'active' : '' }}">
                        {{ $category->name }}
                    </a>
                @endforeach
                <a href="{{ route('front.contact') }}" class="nav-link {{ request()->routeIs('front.contact') ? 'active' : '' }}">
                    {{ word('nav_contact', 'Əlaqə') }}
                </a>
            </nav>
        </div>
    </div>

    {{-- Mobile Menu --}}
    <div class="mobile-menu" id="mobileMenu">
        <nav class="mobile-nav">
            <a href="{{ route('front.home') }}" class="mobile-nav-link">{{ word('nav_home', 'Ana Səhifə') }}</a>
            @foreach($categories ?? [] as $category)
                <a href="{{ route('front.blogs.category', $category->slug) }}" class="mobile-nav-link">
                    {{ $category->name }}
                </a>
            @endforeach
            <a href="{{ route('front.contact') }}" class="mobile-nav-link">{{ word('nav_contact', 'Əlaqə') }}</a>
        </nav>
        <div class="mobile-lang">
            @foreach(['az' => 'AZ', 'en' => 'EN', 'ru' => 'RU'] as $code => $name)
                <a href="{{ LaravelLocalization::localizeURL(url()->current(), $code) }}"
                   class="mobile-lang-item {{ app()->getLocale() == $code ? 'active' : '' }}">
                    {{ $name }}
                </a>
            @endforeach
        </div>
    </div>
</header>
