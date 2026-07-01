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
</head>
<body>

    <!-- Loading Preloader Screen -->
    <div id="loading-screen">
        <div class="loader-spinner"></div>
        <div class="loader-text">MULTI POWER ABADI</div>
    </div>

    <!-- Header / Navbar -->
    <nav class="navbar navbar-expand-lg custom-navbar fixed-top">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center" href="{{ route('home') }}">
                <div class="d-flex flex-column">
                    <span class="fs-5 fw-bold" style="color: var(--text-dark); line-height: 1.2;">PT. MULTI POWER ABADI</span>
                    <span style="font-size: 0.65rem; color: var(--text-muted); letter-spacing: 1.5px; text-transform: uppercase;">Steel, Construction & Fabrication</span>
                </div>
            </a>
            <button class="navbar-toggler border-0 text-white" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <i class="bi bi-list fs-1"></i>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
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
                        <a class="nav-link {{ Route::is('public.clients') ? 'active' : '' }}" href="{{ route('public.clients') }}">Clients</a>
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
    <div class="page-transition-wrapper" style="margin-top: 80px;">
        @yield('content')
    </div>

    <!-- Floating Elements -->
    <!-- WhatsApp Chat Link -->
    <a href="https://wa.me/6281234567890?text=Halo%20PT%20Multi%20Power%20Abadi,%20saya%20tertarik%20dengan%20layanan%20konstruksi%20Anda." target="_blank" class="floating-whatsapp" title="Hubungi Kami via WhatsApp">
        <i class="bi bi-whatsapp"></i>
    </a>

    <!-- Back to Top Button -->
    <button id="back-to-top-btn" class="back-to-top" title="Kembali ke Atas">
        <i class="bi bi-arrow-up-short"></i>
    </button>

    <!-- Footer Section -->
    <footer class="custom-footer mt-0">
        <div class="container">
            <div class="row g-4">
                <div class="col-lg-4">
                    <h5 class="text-white fw-bold mb-3">Multi Power Abadi</h5>
                    <p class="mb-4 text-muted">Premium Engineering, Procurement, Fabrikasi Baja, Konstruksi Gudang, dan Steel Erection. Berkomitmen menghadirkan kualitas bangunan kelas industri.</p>
                    <div class="d-flex gap-3">
                        <a href="#" class="text-white fs-5"><i class="bi bi-facebook"></i></a>
                        <a href="#" class="text-white fs-5"><i class="bi bi-twitter-x"></i></a>
                        <a href="#" class="text-white fs-5"><i class="bi bi-linkedin"></i></a>
                        <a href="#" class="text-white fs-5"><i class="bi bi-instagram"></i></a>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4">
                    <h5 class="text-white fw-bold mb-3">Layanan Kami</h5>
                    <ul class="list-unstyled">
                        <li class="mb-2"><a href="{{ route('public.services.index') }}" class="text-muted text-decoration-none">Konstruksi Gudang</a></li>
                        <li class="mb-2"><a href="{{ route('public.services.index') }}" class="text-muted text-decoration-none">Konstruksi Baja & Fabrikasi</a></li>
                        <li class="mb-2"><a href="{{ route('public.services.index') }}" class="text-muted text-decoration-none">Steel Erection</a></li>
                        <li class="mb-2"><a href="{{ route('public.services.index') }}" class="text-muted text-decoration-none">Bangunan Industri</a></li>
                    </ul>
                </div>
                <div class="col-md-6 col-lg-4">
                    <h5 class="text-white fw-bold mb-3">Kontak & Jam Kerja</h5>
                    <p class="mb-2 text-muted"><i class="bi bi-geo-alt-fill me-2"></i>Kuningan Center, Jakarta Selatan, DKI Jakarta</p>
                    <p class="mb-2 text-muted"><i class="bi bi-telephone-fill me-2"></i>+62 21 555 1234</p>
                    <p class="mb-3 text-muted"><i class="bi bi-envelope-fill me-2"></i>info@multipowerabadi.co.id</p>
                    <p class="mb-2 text-muted">Senin - Jumat: 08.00 - 17.00 WIB</p>
                    <p class="mb-0 text-muted">Sabtu: 09.00 - 13.00 WIB</p>
                </div>
            </div>
            <div class="custom-footer-bottom text-center mt-5 pt-4 border-top border-secondary">
                <p class="mb-0 text-muted">&copy; {{ date('Y') }} PT Multi Power Abadi. All rights reserved.</p>
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
</body>
</html>
