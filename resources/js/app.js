import './bootstrap';
import 'bootstrap';

document.addEventListener('DOMContentLoaded', () => {
    // --- 1. Preloader Screen Hide (Active ONLY on Initial Web Opening) ---
    const loader = document.getElementById('loading-screen');
    if (loader) {
        const hasVisited = sessionStorage.getItem('mpa_site_opened');

        if (!hasVisited) {
            // Initial Web Opening Animation (Cinematic 6s Opening Experience)
            sessionStorage.setItem('mpa_site_opened', 'true');

            const startTime = Date.now();
            const minDuration = 6000; // 6 seconds minimum duration

            const hideFullLoader = () => {
                const elapsedTime = Date.now() - startTime;
                const remainingTime = Math.max(0, minDuration - elapsedTime);

                setTimeout(() => {
                    loader.classList.add('preloader-fade-out');
                    setTimeout(() => {
                        loader.style.display = 'none';
                    }, 800);
                }, remainingTime);
            };

            if (document.readyState === 'complete') {
                hideFullLoader();
            } else {
                window.addEventListener('load', hideFullLoader);
                setTimeout(hideFullLoader, 8000);
            }
        } else {
            // Disable preloader completely on all subsequent page clicks / menu navigation
            loader.style.display = 'none';
        }
    }

    // --- 1B. Hero Background Slider Loop (4 Real Project Photos) ---
    const heroSlides = document.querySelectorAll('.hero-slide');
    if (heroSlides.length > 1) {
        let currentHeroIndex = 0;
        setInterval(() => {
            heroSlides[currentHeroIndex].classList.remove('active');
            currentHeroIndex = (currentHeroIndex + 1) % heroSlides.length;
            heroSlides[currentHeroIndex].classList.add('active');
        }, 5000); // Transition every 5 seconds
    }

    // --- 2. Sticky Navbar Scroll Effect ---
    const navbar = document.querySelector('.custom-navbar');
    if (navbar) {
        window.addEventListener('scroll', () => {
            navbar.style.border = 'none';
            navbar.style.borderBottom = 'none';
            navbar.style.outline = 'none';
            if (window.scrollY > 50) {
                navbar.classList.add('shadow-lg');
                navbar.style.padding = '0.55rem 0';
                navbar.style.backgroundColor = '#0f172a'; // 100% Solid Opaque Dark Navy
            } else {
                navbar.classList.remove('shadow-lg');
                navbar.style.padding = '0.8rem 0';
                navbar.style.backgroundColor = '#0f172a'; // 100% Solid Opaque Dark Navy
            }
        });
    }

    // --- 3. Scroll Reveal Animations (Intersection Observer) ---
    const revealElements = document.querySelectorAll('.reveal');
    const revealObserver = new IntersectionObserver((entries, observer) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('active');
                observer.unobserve(entry.target);
            }
        });
    }, {
        threshold: 0.1,
        rootMargin: '0px 0px -50px 0px'
    });

    revealElements.forEach(el => revealObserver.observe(el));

    // --- 4. Animated Statistics Counter ---
    const statsSection = document.querySelector('.stat-section');
    const statNumbers = document.querySelectorAll('.stat-number');

    const animateStats = () => {
        statNumbers.forEach(stat => {
            const target = parseInt(stat.getAttribute('data-target'), 10);
            if (isNaN(target)) return;

            let count = 0;
            const duration = 2000; // 2 seconds
            const increment = target / (duration / 16); // ~60fps

            const updateCount = () => {
                count += increment;
                if (count < target) {
                    stat.innerText = Math.floor(count) + (stat.getAttribute('data-suffix') || '');
                    requestAnimationFrame(updateCount);
                } else {
                    stat.innerText = target + (stat.getAttribute('data-suffix') || '');
                }
            };
            updateCount();
        });
    };

    if (statsSection && statNumbers.length > 0) {
        const statsObserver = new IntersectionObserver((entries, observer) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    animateStats();
                    observer.unobserve(entry.target);
                }
            });
        }, {
            threshold: 0.2
        });
        statsObserver.observe(statsSection);
    }

    // --- 5. Back to Top Button ---
    const backToTopBtn = document.getElementById('back-to-top-btn');
    if (backToTopBtn) {
        window.addEventListener('scroll', () => {
            if (window.scrollY > 400) {
                backToTopBtn.classList.add('visible');
            } else {
                backToTopBtn.classList.remove('visible');
            }
        });

        backToTopBtn.addEventListener('click', () => {
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        });
    }

    // --- 6. Ripple Effect for Buttons ---
    const rippleButtons = document.querySelectorAll('.btn-ripple');
    rippleButtons.forEach(button => {
        button.addEventListener('click', function (e) {
            let x = e.clientX - e.target.getBoundingClientRect().left;
            let y = e.clientY - e.target.getBoundingClientRect().top;
            
            let ripple = document.createElement('span');
            ripple.style.left = x + 'px';
            ripple.style.top = y + 'px';
            ripple.classList.add('ripple-span'); // CSS could style this locally if needed
            
            this.appendChild(ripple);
            
            setTimeout(() => {
                ripple.remove();
            }, 600);
        });
    });

    // --- 7. Project Showcase Filters ---
    const filterButtons = document.querySelectorAll('.filter-btn');
    const projectCards = document.querySelectorAll('.project-showcase-item');

    if (filterButtons.length > 0 && projectCards.length > 0) {
        filterButtons.forEach(button => {
            button.addEventListener('click', () => {
                // Remove active class from other buttons
                filterButtons.forEach(btn => btn.classList.remove('active'));
                button.classList.add('active');

                const filterValue = button.getAttribute('data-filter');

                projectCards.forEach(card => {
                    if (filterValue === 'all') {
                        card.style.display = 'block';
                        // Trigger fade in animation
                        card.classList.add('reveal', 'active');
                    } else {
                        const categories = card.getAttribute('data-category').toLowerCase().split(',');
                        if (categories.includes(filterValue.toLowerCase())) {
                            card.style.display = 'block';
                        } else {
                            card.style.display = 'none';
                        }
                    }
                });
            });
        });
    }
});


