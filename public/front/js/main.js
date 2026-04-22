/**
 * Main JavaScript
 * With smooth animations and interactions
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

    // ================================
    // Enhanced Animations & Effects
    // ================================

    // Parallax effect for hero images
    const heroImages = document.querySelectorAll('.hero-slide-bg img');
    if (heroImages.length > 0) {
        window.addEventListener('scroll', function() {
            const scrolled = window.pageYOffset;
            heroImages.forEach(img => {
                img.style.transform = `translateY(${scrolled * 0.3}px)`;
            });
        });
    }

    // Magnetic effect for buttons
    const magneticBtns = document.querySelectorAll('.hero-slide-btn, .btn-primary');
    magneticBtns.forEach(btn => {
        btn.addEventListener('mousemove', function(e) {
            const rect = btn.getBoundingClientRect();
            const x = e.clientX - rect.left - rect.width / 2;
            const y = e.clientY - rect.top - rect.height / 2;
            btn.style.transform = `translate(${x * 0.2}px, ${y * 0.2}px)`;
        });

        btn.addEventListener('mouseleave', function() {
            btn.style.transform = 'translate(0, 0)';
        });
    });

    // Tilt effect for cards
    const tiltCards = document.querySelectorAll('.blog-card-v2');
    tiltCards.forEach(card => {
        card.addEventListener('mousemove', function(e) {
            const rect = card.getBoundingClientRect();
            const x = e.clientX - rect.left;
            const y = e.clientY - rect.top;
            const centerX = rect.width / 2;
            const centerY = rect.height / 2;
            const rotateX = (y - centerY) / 20;
            const rotateY = (centerX - x) / 20;

            card.style.transform = `perspective(1000px) rotateX(${rotateX}deg) rotateY(${rotateY}deg) translateY(-8px)`;
        });

        card.addEventListener('mouseleave', function() {
            card.style.transform = 'perspective(1000px) rotateX(0) rotateY(0) translateY(0)';
        });
    });

    // Smooth reveal on scroll
    const revealElements = document.querySelectorAll('.section-title, .page-title, .article-title');

    const revealObserver = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('revealed');
            }
        });
    }, { threshold: 0.1 });

    revealElements.forEach(el => revealObserver.observe(el));

    // Counter animation for view counts
    const viewCounters = document.querySelectorAll('.blog-card-v2-views, .article-views');

    const counterObserver = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                const el = entry.target;
                const text = el.textContent;
                const match = text.match(/[\d,]+/);
                if (match) {
                    const target = parseInt(match[0].replace(/,/g, ''));
                    animateCounter(el, target, text);
                }
                counterObserver.unobserve(el);
            }
        });
    }, { threshold: 0.5 });

    viewCounters.forEach(el => counterObserver.observe(el));

    function animateCounter(el, target, originalText) {
        const duration = 1000;
        const start = 0;
        const startTime = performance.now();

        function update(currentTime) {
            const elapsed = currentTime - startTime;
            const progress = Math.min(elapsed / duration, 1);
            const easeProgress = 1 - Math.pow(1 - progress, 3);
            const current = Math.floor(start + (target - start) * easeProgress);

            el.textContent = originalText.replace(/[\d,]+/, current.toLocaleString());

            if (progress < 1) {
                requestAnimationFrame(update);
            }
        }

        requestAnimationFrame(update);
    }

    // Ripple effect for category tabs
    const rippleElements = document.querySelectorAll('.category-tab, .pagination-page, .pagination-btn');
    rippleElements.forEach(el => {
        el.addEventListener('click', function(e) {
            const rect = el.getBoundingClientRect();
            const x = e.clientX - rect.left;
            const y = e.clientY - rect.top;

            const ripple = document.createElement('span');
            ripple.className = 'ripple-effect';
            ripple.style.left = x + 'px';
            ripple.style.top = y + 'px';

            el.appendChild(ripple);

            setTimeout(() => ripple.remove(), 600);
        });
    });

    // Cursor follower (optional - subtle)
    const cursor = document.createElement('div');
    cursor.className = 'cursor-follower';
    document.body.appendChild(cursor);

    let cursorVisible = false;
    document.addEventListener('mousemove', function(e) {
        if (!cursorVisible) {
            cursor.style.opacity = '1';
            cursorVisible = true;
        }
        cursor.style.left = e.clientX + 'px';
        cursor.style.top = e.clientY + 'px';
    });

    // Enlarge cursor on hover
    const hoverTargets = document.querySelectorAll('a, button, .blog-card-v2');
    hoverTargets.forEach(target => {
        target.addEventListener('mouseenter', () => cursor.classList.add('cursor-hover'));
        target.addEventListener('mouseleave', () => cursor.classList.remove('cursor-hover'));
    });

    // Typing effect for search placeholder
    const searchInput = document.querySelector('.header-search input');
    if (searchInput) {
        const placeholders = ['Axtar...', 'Texnologiya', 'Proqramlaşdırma', 'Dizayn'];
        let placeholderIndex = 0;
        let charIndex = 0;
        let isDeleting = false;
        let typingSpeed = 100;

        function typeEffect() {
            const currentPlaceholder = placeholders[placeholderIndex];

            if (isDeleting) {
                searchInput.placeholder = currentPlaceholder.substring(0, charIndex - 1);
                charIndex--;
                typingSpeed = 50;
            } else {
                searchInput.placeholder = currentPlaceholder.substring(0, charIndex + 1);
                charIndex++;
                typingSpeed = 100;
            }

            if (!isDeleting && charIndex === currentPlaceholder.length) {
                isDeleting = true;
                typingSpeed = 2000; // Pause at end
            } else if (isDeleting && charIndex === 0) {
                isDeleting = false;
                placeholderIndex = (placeholderIndex + 1) % placeholders.length;
                typingSpeed = 500; // Pause before new word
            }

            setTimeout(typeEffect, typingSpeed);
        }

        // Start typing effect after a delay
        setTimeout(typeEffect, 2000);
    }

    // Smooth page transitions
    document.querySelectorAll('a:not([target="_blank"]):not([href^="#"]):not([href^="javascript"])').forEach(link => {
        link.addEventListener('click', function(e) {
            const href = this.getAttribute('href');
            if (href && !href.startsWith('http') || href.includes(window.location.hostname)) {
                e.preventDefault();
                document.body.classList.add('page-transition');
                setTimeout(() => {
                    window.location.href = href;
                }, 300);
            }
        });
    });

});
