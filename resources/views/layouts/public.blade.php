<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="shortcut icon" type="image/png" href="{{ asset('images/logo-mpa-favicon.png') }}">

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

    <!-- Custom Navigation Styles (White text with white animated underline) -->
    <style>
        .custom-navbar .nav-link {
            color: #ffffff !important;
            position: relative !important;
            text-shadow: none !important;
        }
        
        .custom-navbar .nav-link::after {
            content: "" !important;
            display: block !important;
            position: absolute !important;
            width: 0 !important;
            height: 2px !important;
            bottom: 0px !important;
            left: 50% !important;
            background-color: #ffffff !important;
            transition: all 0.3s ease !important;
            transform: translateX(-50%) !important;
            border: none !important;
        }
        
        .custom-navbar .nav-link:hover::after,
        .custom-navbar .nav-link.active::after {
            width: calc(100% - 2rem) !important;
        }

        /* Faded page header banner red background overlay */
        .page-header-banner {
            background: linear-gradient(135deg, rgba(220, 38, 38, 0.25) 0%, rgba(15, 23, 42, 0.75) 100%), url('/images/page-header-bg.jpg') center/cover no-repeat !important;
        }

        /* Navbar background color override (Bright Red globally) */
        .custom-navbar,
        .custom-navbar.shadow-lg,
        .custom-navbar.scrolled,
        #mainNavbar {
            background-color: #dc2626 !important;
            background: #dc2626 !important;
        }
    </style>
    
    <!-- Instant Theme Initialization Script (Prevents FOUC) -->
    <script>
        (function() {
            const savedTheme = localStorage.getItem('mpa_theme');
            if (savedTheme) {
                document.documentElement.setAttribute('data-theme', savedTheme);
            } else if (window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches) {
                document.documentElement.setAttribute('data-theme', 'dark');
            } else {
                document.documentElement.setAttribute('data-theme', 'light');
            }
        })();
    </script>

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
                <img src="{{ asset('images/logo-mpa-premium.png') }}" alt="Logo" class="logo-navbar-img">
            </a>
            <div class="d-flex align-items-center gap-2">
                <!-- Theme Toggle Button (Immediately Visible on Mobile Header Top Corner) -->
                <button type="button" class="theme-toggle-btn d-lg-none" title="Ganti Mode Tampilan" aria-label="Toggle theme">
                    <i class="bi bi-moon-fill"></i>
                </button>
                <button class="navbar-toggler border-0 text-white" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <i class="bi bi-list fs-1"></i>
                </button>
            </div>
            <div class="collapse navbar-collapse border-0" id="navbarNav" style="border: none !important; outline: none !important;">
                <ul class="navbar-nav ms-auto align-items-start align-items-lg-center">
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
                    <li class="nav-item ms-lg-3 mt-3 mt-lg-0 d-flex align-items-center gap-2">
                        <button type="button" class="theme-toggle-btn d-none d-lg-inline-flex" title="Ganti Mode Tampilan" aria-label="Toggle theme">
                            <i class="bi bi-moon-fill"></i>
                        </button>
                        <a href="{{ route('public.quotation') }}" class="btn btn-accent btn-ripple text-white px-4 py-2 shadow fw-semibold">
                            Request Quotation
                        </a>
                    </li>

                </ul>
            </div>
        </div>
    </nav>

    <!-- Page Wrapper -->
    <div class="page-transition-wrapper" style="padding-top: 0;">
        @yield('content')
    </div>



    <!-- Floating WhatsApp Button -->
    <a href="https://wa.me/62811272825" target="_blank" rel="noopener noreferrer" class="floating-whatsapp" title="Hubungi Kami di WhatsApp">
        <i class="bi bi-whatsapp"></i>
    </a>

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
                            Kontraktor Spesialis Engineering, Fabrikasi Workshop Mandiri, &amp; Steel Erection Berstandar Mutu SNI. Mitra Tepercaya Pembangunan Gudang, Pabrik, &amp; Bangunan Industri Masa Depan.
                        </p>
                        <!-- Social Icons -->
                        <div class="footer-socials mt-4">
                            <a href="https://www.instagram.com/multipowerabadi/" target="_blank" rel="noopener noreferrer" class="footer-social-btn" aria-label="Instagram" title="Instagram">
                                <i class="bi bi-instagram"></i>
                            </a>
                            <a href="https://www.tiktok.com/@multipowerabadi" target="_blank" rel="noopener noreferrer" class="footer-social-btn" aria-label="TikTok" title="TikTok">
                                <i class="bi bi-tiktok"></i>
                            </a>
                            <a href="https://www.facebook.com/people/PT-MULTI-POWER-ABADI/100067681392488/" target="_blank" rel="noopener noreferrer" class="footer-social-btn" aria-label="Facebook" title="Facebook">
                                <i class="bi bi-facebook"></i>
                            </a>
                            <a href="https://www.youtube.com/@RuangMPA" target="_blank" rel="noopener noreferrer" class="footer-social-btn" aria-label="YouTube" title="YouTube">
                                <i class="bi bi-youtube"></i>
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
                                <a href="https://wa.me/62811272825" target="_blank" rel="noopener noreferrer" class="footer-contact-item">
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
    </script>

<!-- Project Detail Popup Modal -->
<div id="project-popup" class="project-popup-backdrop" onclick="if(event.target===this)closeProjectPopup()">
    <div class="project-popup-card">
        <button type="button" class="project-popup-close" onclick="closeProjectPopup()" title="Tutup (ESC)">&times;</button>
        <div class="project-popup-scroll">
            <div class="project-popup-img-wrap">
                <img id="popup-img" src="" alt="Proyek" class="project-popup-img">
                <span id="popup-category" class="project-popup-badge"></span>
            </div>
            <div class="project-popup-body">
                <h3 id="popup-title" class="project-popup-title"></h3>
                <div id="popup-meta" class="project-popup-meta"></div>
                <p id="popup-desc" class="project-popup-desc"></p>
            </div>
        </div>
    </div>
</div>

<style>
.project-popup-backdrop{position:fixed;top:0;left:0;width:100%;height:100%;background:rgba(10,20,40,.78);backdrop-filter:blur(6px);-webkit-backdrop-filter:blur(6px);z-index:99999;display:flex;align-items:center;justify-content:center;opacity:0;visibility:hidden;transition:opacity .3s,visibility .3s;padding:1.5rem}
.project-popup-backdrop.show{opacity:1;visibility:visible}
.project-popup-card{background:#fff;border-radius:20px;overflow:hidden;max-width:520px;width:100%;box-shadow:0 20px 60px rgba(0,0,0,.4);transform:scale(.9) translateY(20px);transition:transform .35s cubic-bezier(.2,.9,.3,1.2),opacity .3s;opacity:0;position:relative;max-height:88vh;display:flex;flex-direction:column}
.project-popup-backdrop.show .project-popup-card{transform:scale(1) translateY(0);opacity:1}
.project-popup-close{position:absolute;top:12px;right:12px;z-index:10;background:rgba(0,0,0,.55);color:#fff;border:none;width:36px;height:36px;border-radius:50%;font-size:1.4rem;line-height:1;cursor:pointer;transition:all .25s;display:flex;align-items:center;justify-content:center;backdrop-filter:blur(4px)}
.project-popup-close:hover{background:#dc2626;transform:rotate(90deg) scale(1.1)}
.project-popup-scroll{overflow-y:auto;max-height:88vh}
.project-popup-img-wrap{position:relative;width:100%;height:280px;overflow:hidden}
.project-popup-img{width:100%;height:100%;object-fit:cover;display:block}
.project-popup-badge{position:absolute;bottom:16px;left:16px;background:#dc2626;color:#fff;font-size:.7rem;font-weight:700;text-transform:uppercase;letter-spacing:1px;padding:5px 14px;border-radius:20px}
.project-popup-body{padding:1.5rem 1.8rem 2rem}
.project-popup-title{font-size:1.35rem;font-weight:800;color:#0f2d5c;margin:0 0 .6rem}
.project-popup-meta{display:flex;gap:1rem;flex-wrap:wrap;margin-bottom:1rem;font-size:.85rem;color:#6b7280}
.project-popup-meta i{color:#dc2626;margin-right:3px}
.project-popup-desc{font-size:.92rem;line-height:1.75;color:#4b5563;margin:0;white-space:pre-line}
@media(max-width:576px){.project-popup-card{max-width:95%;border-radius:16px}.project-popup-img-wrap{height:200px}.project-popup-body{padding:1.2rem 1.3rem 1.5rem}}
</style>

<script>
function openProjectPopup(el){
    var card=el.closest('.project-card-clickable');
    if(!card)return;
    var img=card.getAttribute('data-image')||'';
    var title=card.getAttribute('data-title')||'';
    var category=card.getAttribute('data-category')||'';
    var location=card.getAttribute('data-location')||'';
    var year=card.getAttribute('data-year')||'';
    var desc=card.getAttribute('data-description')||'';

    document.getElementById('popup-img').src=img;
    document.getElementById('popup-category').textContent=category;
    document.getElementById('popup-title').textContent=title;
    document.getElementById('popup-meta').innerHTML='<span><i class="bi bi-geo-alt-fill"></i> '+location+'</span>';
    document.getElementById('popup-desc').textContent=desc;

    document.getElementById('project-popup').classList.add('show');
    document.body.style.overflow='hidden';
}
function closeProjectPopup(){
    document.getElementById('project-popup').classList.remove('show');
    document.body.style.overflow='';
}
document.addEventListener('keydown',function(e){if(e.key==='Escape')closeProjectPopup()});
</script>
</body>
</html>

