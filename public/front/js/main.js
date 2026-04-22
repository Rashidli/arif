/**
 * Main JavaScript
 */

document.addEventListener('DOMContentLoaded', function() {

    // Mobile Menu Toggle
    const mobileToggle = document.getElementById('mobileToggle');
    const mobileMenu = document.getElementById('mobileMenu');
    const body = document.body;

    if (mobileToggle && mobileMenu) {
        mobileToggle.addEventListener('click', function() {
            this.classList.toggle('active');
            mobileMenu.classList.toggle('active');
            body.classList.toggle('menu-open');
        });
    }

    // Search Toggle
    const searchToggle = document.getElementById('searchToggle');
    const searchBar = document.getElementById('searchBar');

    if (searchToggle && searchBar) {
        searchToggle.addEventListener('click', function() {
            searchBar.classList.toggle('active');
            if (searchBar.classList.contains('active')) {
                searchBar.querySelector('input').focus();
            }
        });
    }

    // Header Scroll Effect
    const header = document.getElementById('header');
    let lastScroll = 0;

    window.addEventListener('scroll', function() {
        const currentScroll = window.pageYOffset;

        if (currentScroll > 100) {
            header.classList.add('scrolled');
        } else {
            header.classList.remove('scrolled');
        }

        // Hide/Show on scroll
        if (currentScroll > lastScroll && currentScroll > 200) {
            header.classList.add('hidden');
        } else {
            header.classList.remove('hidden');
        }

        lastScroll = currentScroll;
    });

    // Back to Top
    const backToTop = document.getElementById('backToTop');

    if (backToTop) {
        window.addEventListener('scroll', function() {
            if (window.pageYOffset > 500) {
                backToTop.classList.add('visible');
            } else {
                backToTop.classList.remove('visible');
            }
        });

        backToTop.addEventListener('click', function(e) {
            e.preventDefault();
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        });
    }

    // Dropdown hover for desktop
    const dropdowns = document.querySelectorAll('.nav-dropdown');

    dropdowns.forEach(dropdown => {
        dropdown.addEventListener('mouseenter', function() {
            this.classList.add('active');
        });

        dropdown.addEventListener('mouseleave', function() {
            this.classList.remove('active');
        });
    });

    // Language Switcher
    const langSwitcher = document.querySelector('.lang-switcher');

    if (langSwitcher) {
        langSwitcher.addEventListener('click', function(e) {
            e.stopPropagation();
            this.classList.toggle('active');
        });

        document.addEventListener('click', function() {
            langSwitcher.classList.remove('active');
        });
    }

    // Close mobile menu on resize
    window.addEventListener('resize', function() {
        if (window.innerWidth > 992) {
            mobileMenu?.classList.remove('active');
            mobileToggle?.classList.remove('active');
            body.classList.remove('menu-open');
        }
    });

    // Lazy load images
    const lazyImages = document.querySelectorAll('img[data-src]');

    if ('IntersectionObserver' in window) {
        const imageObserver = new IntersectionObserver((entries, observer) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    const img = entry.target;
                    img.src = img.dataset.src;
                    img.classList.add('loaded');
                    observer.unobserve(img);
                }
            });
        });

        lazyImages.forEach(img => imageObserver.observe(img));
    }

    // Form validation
    const forms = document.querySelectorAll('form[data-validate]');

    forms.forEach(form => {
        form.addEventListener('submit', function(e) {
            const requiredFields = form.querySelectorAll('[required]');
            let isValid = true;

            requiredFields.forEach(field => {
                if (!field.value.trim()) {
                    isValid = false;
                    field.classList.add('error');
                } else {
                    field.classList.remove('error');
                }
            });

            if (!isValid) {
                e.preventDefault();
            }
        });
    });

});
