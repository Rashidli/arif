{{-- AOS Animation --}}
<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>

{{-- Swiper Slider --}}
<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>

{{-- Main JavaScript --}}
<script src="{{ asset('front/js/main.js') }}?v={{ time() }}"></script>

<script>
    // Initialize AOS
    AOS.init({
        duration: 800,
        easing: 'ease-out-cubic',
        once: true,
        offset: 50
    });

    // Initialize Hero Swiper (techtalk style)
    if (document.querySelector('.hero-swiper')) {
        new Swiper('.hero-swiper', {
            slidesPerView: 1,
            spaceBetween: 0,
            loop: true,
            autoplay: {
                delay: 5000,
                disableOnInteraction: false,
            },
            pagination: {
                el: '.hero-swiper-pagination',
                clickable: true,
            },
            effect: 'fade',
            fadeEffect: {
                crossFade: true
            }
        });
    }

    // Initialize Blog Swiper sliders (techtalk style - 3 cards with pagination)
    document.querySelectorAll('.blog-swiper').forEach(el => {
        new Swiper(el, {
            slidesPerView: 1.1,
            spaceBetween: 16,
            grabCursor: true,
            pagination: {
                el: el.querySelector('.blog-swiper-pagination'),
                clickable: true,
            },
            breakpoints: {
                640: {
                    slidesPerView: 2,
                    spaceBetween: 20,
                },
                1024: {
                    slidesPerView: 3,
                    spaceBetween: 24,
                }
            }
        });
    });
</script>
