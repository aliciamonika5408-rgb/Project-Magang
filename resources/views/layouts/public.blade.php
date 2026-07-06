<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'PT Multi Power Abadi - Engineering & Construction')</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <!-- Styles & Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    @yield('styles')
    
    <!-- Instant Preloader Blocker for Page Navigation -->
    <script>
        if (sessionStorage.getItem('mpa_site_opened')) {
            document.write('<style>#loading-screen { display: none !important; opacity: 0 !important; visibility: hidden !important; }</style>');
        }
    </script>
</head>
<body>

    <!-- Loading Preloader Screen (Active ONLY on First Web Opening) -->
    <div id="loading-screen" class="d-flex flex-column align-items-center justify-content-center">
        <div class="preloader-logo-wrapper text-center main-opening-content">
            <div class="preloader-img-container position-relative mb-3">
                <i class="bi bi-house-door-fill loader-house-icon"></i>
            </div>
            <div class="fs-4 fw-bold text-white mb-1" style="letter-spacing: 2px;">PT. MULTI POWER ABADI</div>
            <div class="preloader-progress-bar mt-4 mx-auto">
                <div class="preloader-progress-fill"></div>
            </div>
        </div>
    </div>

    <!-- Header / Navbar -->
    <nav class="navbar navbar-expand-lg custom-navbar fixed-top border-0" id="mainNavbar" style="border: none !important; outline: none !important;">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center me-lg-4" href="{{ route('home') }}">
                <span class="fw-bold text-white mb-0" style="font-size: 1.35rem; letter-spacing: 2px; color: #ffffff !important; text-shadow: 0 2px 8px rgba(0,0,0,0.4);">PT. MULTI POWER ABADI</span>
            </a>
            <button class="navbar-toggler border-0 text-white" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <i class="bi bi-list fs-1"></i>
            </button>
            <div class="collapse navbar-collapse border-0" id="navbarNav" style="border: none !important; outline: none !important;">
                <ul class="navbar-nav ms-auto align-items-center">
                    <li class="nav-item">
                        <a class="nav-link {{ Route::is('home') ? 'active' : '' }}" href="{{ route('home') }}">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ Route::is('public.services.*') ? 'active' : '' }}" href="{{ route('public.services.index') }}">Services</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ Route::is('public.projects.*') ? 'active' : '' }}" href="{{ route('public.projects.index') }}">Projects</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link {{ Route::is('public.contact') ? 'active' : '' }}" href="{{ route('public.contact') }}">Contact</a>
                    </li>
                    <li class="nav-item ms-lg-3 mt-3 mt-lg-0">
                        <a href="{{ route('public.quotation') }}" class="btn btn-accent btn-ripple text-white px-4 py-2 shadow fw-semibold">
                            Request Quotation
                        </a>
                    </li>
                    @if (Route::has('login'))
                        @auth
                            <li class="nav-item ms-lg-2 mt-2 mt-lg-0">
                                <a href="{{ route('dashboard') }}" class="btn btn-outline-white btn-sm text-white py-2">Dashboard</a>
                            </li>
                        @endauth
                    @endif
                </ul>
            </div>
        </div>
    </nav>

    <!-- Page Wrapper -->
    <div class="page-transition-wrapper" style="padding-top: 0;">
        @yield('content')
    </div>



    <!-- Back to Top Button -->
    <button id="back-to-top-btn" class="back-to-top" title="Kembali ke Atas">
        <i class="bi bi-arrow-up-short"></i>
    </button>

    <!-- ============================================================
         FOOTER SECTION — 4 KOLOM PREMIUM & LOKASI PETA
         ============================================================ -->
    <footer class="custom-footer mt-0" id="mainFooter">
        <!-- Background image with red overlay -->
        <div class="footer-bg-overlay"></div>
        <div class="footer-bg-img"></div>

        <div class="container footer-content position-relative">

            <!-- TOP: 3 columns -->
            <div class="row g-4 g-lg-5 pt-5 pb-4">

                <!-- COL 1: Profil PT (4/12 width) -->
                <div class="col-lg-4 col-md-6 footer-col reveal" style="transition-delay:0.1s;">
                    <div class="footer-col-inner">
                        <div class="footer-brand-mark mb-3">
                            <span class="footer-brand-icon"><i class="bi bi-building-fill-gear"></i></span>
                        </div>
                        <h5 class="footer-heading">PT. Multi Power Abadi</h5>
                        <p class="footer-desc">
                            Spesialis Engineering, Fabrikasi Baja, Konstruksi Gudang &amp; Steel Erection. Berkomitmen menghadirkan standar bangunan industri terbaik di Indonesia.
                        </p>
                        <!-- Social Icons -->
                        <div class="footer-socials mt-4">
                            <a href="#" class="footer-social-btn" aria-label="Instagram" title="Instagram">
                                <i class="bi bi-instagram"></i>
                            </a>
                            <a href="#" class="footer-social-btn" aria-label="TikTok" title="TikTok">
                                <i class="bi bi-tiktok"></i>
                            </a>
                            <a href="#" class="footer-social-btn" aria-label="Facebook" title="Facebook">
                                <i class="bi bi-facebook"></i>
                            </a>
                            <a href="#" class="footer-social-btn" aria-label="YouTube" title="YouTube">
                                <i class="bi bi-youtube"></i>
                            </a>
                            <a href="#" class="footer-social-btn" aria-label="LinkedIn" title="LinkedIn">
                                <i class="bi bi-linkedin"></i>
                            </a>
                        </div>
                    </div>
                </div>

                <!-- COL 2: Kontak Kami (4/12 width) -->
                <div class="col-lg-4 col-md-6 footer-col reveal" style="transition-delay:0.2s;">
                    <div class="footer-col-inner">
                        <h5 class="footer-heading">
                            <span class="footer-heading-icon"><i class="bi bi-headset"></i></span>
                            Kontak Kami
                        </h5>
                        <div class="footer-divider"></div>
                        <ul class="footer-contact-list">
                            <li>
                                <a href="https://wa.me/628112728250" target="_blank" rel="noopener noreferrer" class="footer-contact-item">
                                    <span class="footer-contact-icon footer-icon-wa">
                                        <i class="bi bi-whatsapp"></i>
                                    </span>
                                    <div>
                                        <span class="footer-contact-label">WhatsApp</span>
                                        <span class="footer-contact-value">+62 811-272-825</span>
                                    </div>
                                </a>
                            </li>
                            <li>
                                <a href="mailto:multipowerabadi@gmail.com" class="footer-contact-item">
                                    <span class="footer-contact-icon footer-icon-mail">
                                        <i class="bi bi-envelope-fill"></i>
                                    </span>
                                    <div>
                                        <span class="footer-contact-label">Email</span>
                                        <span class="footer-contact-value" style="word-break: break-all;">multipowerabadi@gmail.com</span>
                                    </div>
                                </a>
                            </li>
                            <li>
                                <div class="footer-contact-item no-link">
                                    <span class="footer-contact-icon footer-icon-time">
                                        <i class="bi bi-clock-fill"></i>
                                    </span>
                                    <div>
                                        <span class="footer-contact-label">Jam Operasional</span>
                                        <span class="footer-contact-value">24 Jam</span>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>

                <!-- COL 3: Alamat Lengkap (4/12 width) -->
                <div class="col-lg-4 col-md-6 footer-col reveal" style="transition-delay:0.3s;">
                    <div class="footer-col-inner">
                        <h5 class="footer-heading">
                            <span class="footer-heading-icon"><i class="bi bi-geo-alt-fill"></i></span>
                            Alamat Kantor
                        </h5>
                        <div class="footer-divider"></div>
                        <div class="footer-address-box">
                            <p class="footer-address-text mb-2" style="font-size: 0.85rem; line-height: 1.6; color: rgba(255,255,255,0.85);">
                                <strong>PT. Multi Power Abadi</strong><br>
                                Jl. Gn. Anyar Tambak IV No.50, Gn. Anyar Tambak, Kec. Gn. Anyar, Surabaya, Jawa Timur 60294
                            </p>
                            <a href="https://maps.google.com/?q=Jl.+Gn.+Anyar+Tambak+IV+No.50,+Surabaya" target="_blank" rel="noopener noreferrer" class="footer-address-link text-danger fw-semibold" style="font-size: 0.82rem;">
                                <i class="bi bi-box-arrow-up-right me-1"></i>Petunjuk Arah (Google Maps)
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- GOOGLE MAPS LOCATION (COMPACT CARD AT BOTTOM) -->
            <div class="row my-4 reveal" style="transition-delay: 0.4s;">
                <div class="col-12">
                    <div class="rounded-4 overflow-hidden shadow-lg border-0 position-relative" style="height: 250px;">
                        <iframe
                            src="https://maps.google.com/maps?q=Jl.%20Gn.%20Anyar%20Tambak%20IV%20No.50%2C%20Gn.%20Anyar%20Tambak%2C%20Kec.%20Gn.%20Anyar%2C%20Surabaya%2C%20Jawa%20Timur%2060294&t=&z=17&ie=UTF8&iwloc=&output=embed"
                            width="100%"
                            height="100%"
                            style="border:0; display:block;"
                            allowfullscreen=""
                            loading="lazy"
                            referrerpolicy="no-referrer-when-downgrade"
                            title="Lokasi PT Multi Power Abadi — Surabaya">
                        </iframe>
                    </div>
                </div>
            </div>

            <!-- DIVIDER -->
            <div class="footer-bottom-divider"></div>

            <!-- BOTTOM BAR -->
            <div class="footer-bottom-bar">
                <div class="row align-items-center">
                    <div class="col-md-6 text-center text-md-start mb-2 mb-md-0">
                        <p class="footer-copyright mb-0">
                            &copy; {{ date('Y') }} <strong>PT Multi Power Abadi</strong>. All rights reserved.
                        </p>
                    </div>
                    <div class="col-md-6 text-center text-md-end">
                        <nav class="footer-bottom-nav" aria-label="Footer bottom navigation">
                            <a href="{{ route('home') }}">Home</a>
                            <span class="footer-nav-sep">·</span>
                            <a href="{{ route('public.services.index') }}">Services</a>
                            <span class="footer-nav-sep">·</span>
                            <a href="{{ route('public.projects.index') }}">Projects</a>
                            <span class="footer-nav-sep">·</span>
                            <a href="{{ route('public.contact') }}">Contact</a>
                        </nav>
                    </div>
                </div>
            </div>

        </div>
    </footer>

    <!-- Toast Notification Template -->
    <div class="toast-container position-fixed bottom-0 start-0 p-3" style="z-index: 11000;">
        <div id="statusToast" class="toast custom-toast" role="alert" aria-live="assertive" aria-atomic="true" data-bs-delay="5000">
            <div class="toast-header bg-dark text-white border-0">
                <strong class="me-auto"><i class="bi bi-info-circle-fill text-warning me-2"></i>Notifikasi</strong>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
            <div class="toast-body" id="toastMessage">
                Pesan notifikasi di sini.
            </div>
        </div>
    </div>

    <!-- Bootstrap Bundle JS -->
    @yield('scripts')
    
    <script>
        // ================================================
        // NAVBAR: Tambahkan kelas 'scrolled' saat scroll
        // ================================================
        (function () {
            const navbar = document.getElementById('mainNavbar');
            if (!navbar) return;
            const onScroll = () => {
                navbar.classList.toggle('scrolled', window.scrollY > 60);
            };
            window.addEventListener('scroll', onScroll, { passive: true });
            onScroll();
        })();

        // ================================================
        // SCROLL REVEAL ANIMATION — IntersectionObserver
        // ================================================
        (function () {
            const revealEls = document.querySelectorAll('.reveal, .reveal-heading');
            if (!revealEls.length) return;

            const observer = new IntersectionObserver((entries) => {
                entries.forEach((entry) => {
                    if (entry.isIntersecting) {
                        const el = entry.target;
                        el.classList.add('revealed');
                        observer.unobserve(el);
                    }
                });
            }, {
                threshold: 0.12,
                rootMargin: '0px 0px -50px 0px'
            });

            revealEls.forEach((el) => observer.observe(el));
        })();

        // ================================================
        // HERO PARTICLES — debu melayang (Canvas)
        // ================================================
        (function () {
            const canvas = document.getElementById('hero-particles');
            if (!canvas) return;
            const ctx = canvas.getContext('2d');
            let particles = [];
            let raf;

            function resize() {
                canvas.width  = canvas.offsetWidth;
                canvas.height = canvas.offsetHeight;
            }

            function createParticle() {
                return {
                    x: Math.random() * canvas.width,
                    y: Math.random() * canvas.height,
                    r: Math.random() * 1.8 + 0.4,
                    vx: (Math.random() - 0.5) * 0.4,
                    vy: -(Math.random() * 0.5 + 0.1),
                    alpha: Math.random() * 0.5 + 0.1,
                    life: Math.random() * 200 + 80,
                    age: 0,
                    hue: Math.random() < 0.6 ? 0 : 15   // red or warm white
                };
            }

            function init() {
                particles = [];
                for (let i = 0; i < 90; i++) {
                    const p = createParticle();
                    p.age = Math.floor(Math.random() * p.life);
                    particles.push(p);
                }
            }

            function draw() {
                ctx.clearRect(0, 0, canvas.width, canvas.height);
                for (let i = particles.length - 1; i >= 0; i--) {
                    const p = particles[i];
                    p.x  += p.vx;
                    p.y  += p.vy;
                    p.age++;
                    const lifeRatio = p.age / p.life;
                    const alpha = p.alpha * (1 - lifeRatio);
                    ctx.save();
                    ctx.globalAlpha = alpha;
                    ctx.beginPath();
                    ctx.arc(p.x, p.y, p.r, 0, Math.PI * 2);
                    ctx.fillStyle = p.hue === 0
                        ? `rgba(255,80,80,${alpha})`
                        : `rgba(255,210,180,${alpha})`;
                    ctx.fill();
                    ctx.restore();
                    if (p.age >= p.life) {
                        particles[i] = createParticle();
                    }
                }
                raf = requestAnimationFrame(draw);
            }

            resize();
            init();
            draw();
            window.addEventListener('resize', () => { resize(); init(); }, { passive: true });
        })();

        // JS Toast Notification Helper (dynamic message display)
        function showToast(message, isSuccess = true) {
            const toastEl = document.getElementById('statusToast');
            const toastMessage = document.getElementById('toastMessage');
            
            toastMessage.textContent = message;
            
            if (!isSuccess) {
                toastEl.style.backgroundColor = '#dc3545'; // red for error
            } else {
                toastEl.style.backgroundColor = '#0F2D5C'; // navy for success
            }
            
            const toast = new bootstrap.Toast(toastEl);
            toast.show();
        }

        // Show session success messages if set in Laravel
        @if (session('success'))
            document.addEventListener('DOMContentLoaded', () => {
                showToast("{{ session('success') }}", true);
            });
        @endif
        @if (session('error'))
            document.addEventListener('DOMContentLoaded', () => {
                showToast("{{ session('error') }}", false);
            });
        @endif
</body>
</html>
