<?php
/**
 * Konversi Native PHP dari resources/views/public/clients.blade.php
 * 
 * Mempertahankan desain, tampilan, HTML, CSS, JavaScript, animasi, dan fitur 100% presisi.
 * Berjalan langsung di PHP native tanpa Laravel / Blade engine.
 */

declare(strict_types=1);

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once dirname(__DIR__) . '/native_helpers.php';


// ---------------------------------------------------------------------------
// Helper Functions (Pengganti Laravel Helper)
// ---------------------------------------------------------------------------

if (!function_exists('e')) {
    function e($value): string
    {
        return htmlspecialchars((string) ($value ?? ''), ENT_QUOTES, 'UTF-8');
    }
}

if (!function_exists('request')) {
    function request(?string $key = null, $default = null)
    {
        if ($key === null) {
            return array_merge($_GET, $_POST);
        }
        return $_GET[$key] ?? $_POST[$key] ?? $default;
    }
}

if (!function_exists('asset')) {
    function asset(string $path): string
    {
        return '/' . ltrim($path, '/');
    }
}

if (!function_exists('route')) {
    function route(string $name, array $params = []): string
    {
        $routes = [
            'home' => '/welcome.php',
            'public.services.index' => '/resources/views/public/services/index.php',
            'public.projects.index' => '/resources/views/public/projects/index.php',
            'public.contact' => '/resources/views/public/contact.php',
            'public.quotation' => '/resources/views/public/quotation.php',
            'public.clients' => '/resources/views/public/clients.php',
        ];

        $url = $routes[$name] ?? '#';
        if (!empty($params)) {
            $url .= '?' . http_build_query($params);
        }
        return $url;
    }
}

if (!function_exists('route_is')) {
    function route_is(string $pattern): bool
    {
        $requestUri = $_SERVER['REQUEST_URI'] ?? '/';
        $path = parse_url($requestUri, PHP_URL_PATH) ?? '/';
        if (str_contains($pattern, 'clients')) {
            return str_contains($path, 'clients');
        }
        return false;
    }
}

if (!function_exists('csrf_token')) {
    function csrf_token(): string
    {
        if (empty($_SESSION['_token'])) {
            $_SESSION['_token'] = bin2hex(random_bytes(32));
        }
        return $_SESSION['_token'];
    }
}

if (!function_exists('env_value')) {
    function env_value(string $key, ?string $default = null): ?string
    {
        static $env = null;
        if ($env === null) {
            $env = [];
            $appRoot = dirname(__DIR__, 2);
            $envFile = $appRoot . '/.env';
            if (is_readable($envFile)) {
                foreach (file($envFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES) as $line) {
                    $line = trim($line);
                    if ($line === '' || str_starts_with($line, '#') || !str_contains($line, '=')) {
                        continue;
                    }
                    list($k, $v) = explode('=', $line, 2);
                    $env[trim($k)] = trim($v, " \t" . "'" . '"');
                }
            }
        }
        return $env[$key] ?? $default;
    }
}

if (!function_exists('get_pdo')) {
    function get_pdo(): ?PDO
    {
        static $pdo = null;
        if ($pdo instanceof PDO) {
            return $pdo;
        }
        try {
            $driver = env_value('DB_CONNECTION', 'sqlite');
            if ($driver === 'sqlite') {
                $appRoot = dirname(__DIR__, 2);
                $database = env_value('DB_DATABASE', 'database/database.sqlite');
                $isWindowsDrive = (strlen($database) >= 2 && ctype_alpha($database[0]) && $database[1] === ':');
                if (!str_starts_with($database, '/') && !$isWindowsDrive) {
                    $database = $appRoot . '/' . $database;
                }
                if (!is_readable($database)) {
                    return null;
                }
                $pdo = new PDO('sqlite:' . $database);
            } else {
                $host = env_value('DB_HOST', '127.0.0.1');
                $port = env_value('DB_PORT', '3306');
                $database = env_value('DB_DATABASE', '');
                $username = env_value('DB_USERNAME', 'root');
                $password = env_value('DB_PASSWORD', '');
                $dsn = "mysql:host={$host};port={$port};dbname={$database};charset=utf8mb4";
                $pdo = new PDO($dsn, $username, $password);
            }
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
        } catch (Throwable $e) {
            return null;
        }
        return $pdo;
    }
}

// ---------------------------------------------------------------------------
// Page Data
// ---------------------------------------------------------------------------

$pageTitle = 'Klien & Rekanan Kerja - PT Multi Power Abadi';

$clients = [];
$pdo = get_pdo();
if ($pdo instanceof PDO) {
    try {
        $clients = $pdo->query('SELECT * FROM clients ORDER BY created_at DESC')->fetchAll();
    } catch (Throwable $e) {
        $clients = [];
    }
}
$vite = vite_assets();
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="<?= e(csrf_token()) ?>">
    <link rel="shortcut icon" type="image/png" href="<?= e(asset('images/logo-mpa-favicon.png')) ?>">

    <title><?= e($pageTitle) ?></title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <!-- CSS/JS dari Vite build (setara @vite Laravel) -->
    <?php foreach ($vite['css'] as $cssFile): ?>
    <link rel="stylesheet" href="<?= e($cssFile) ?>">
    <?php endforeach; ?>

    <!-- Custom Navigation Styles -->
    <style>
        body { font-family: 'Poppins', sans-serif !important; }
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
            background: linear-gradient(135deg, rgba(220, 38, 38, 0.25) 0%, rgba(15, 23, 42, 0.75) 100%), url('<?= e(asset('images/page-header-bg.jpg')) ?>') center/cover no-repeat !important;
        }

        /* Navbar background color override */
        .custom-navbar,
        .custom-navbar.shadow-lg,
        .custom-navbar.scrolled,
        #mainNavbar {
            background-color: #dc2626 !important;
            background: #dc2626 !important;
        }

        .bg-navy {
            background-color: #0f2d5c !important;
        }

        .text-navy {
            color: #0f2d5c !important;
        }

        .btn-navy {
            background-color: #0f2d5c;
            color: #ffffff;
        }
        .btn-navy:hover {
            background-color: #0b2247;
            color: #ffffff;
        }

        .text-xs {
            font-size: 0.75rem;
        }

        .leading-relaxed {
            line-height: 1.625;
        }

        /* Scroll Reveal Animations */
        .reveal {
            opacity: 0;
            transform: translateY(30px);
            transition: opacity 0.6s ease-out, transform 0.6s ease-out;
        }
        .reveal.revealed {
            opacity: 1;
            transform: translateY(0);
        }
        .reveal-left {
            opacity: 0;
            transform: translateX(-30px);
            transition: opacity 0.6s ease-out, transform 0.6s ease-out;
        }
        .reveal-left.revealed {
            opacity: 1;
            transform: translateX(0);
        }
        .reveal-right {
            opacity: 0;
            transform: translateX(30px);
            transition: opacity 0.6s ease-out, transform 0.6s ease-out;
        }
        .reveal-right.revealed {
            opacity: 1;
            transform: translateX(0);
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

    <!-- Loading Preloader Screen -->
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
            <a class="navbar-brand d-flex align-items-center me-lg-4" href="<?= e(route('home')) ?>">
                <img src="<?= e(asset('images/logo-mpa-premium.png')) ?>" alt="Logo" class="logo-navbar-img" style="height: 42px;">
            </a>
            <div class="d-flex align-items-center gap-2">
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
                        <a class="nav-link" href="<?= e(route('home')) ?>">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= e(route('public.services.index')) ?>">Services</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= e(route('public.projects.index')) ?>">Projects</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= e(route('public.contact')) ?>">Contact</a>
                    </li>
                    <li class="nav-item ms-lg-3 mt-3 mt-lg-0 d-flex align-items-center gap-2">
                        <button type="button" class="theme-toggle-btn d-none d-lg-inline-flex" title="Ganti Mode Tampilan" aria-label="Toggle theme">
                            <i class="bi bi-moon-fill"></i>
                        </button>
                        <a href="<?= e(route('public.quotation')) ?>" class="btn btn-danger btn-ripple text-white px-4 py-2 shadow fw-semibold" style="background-color: #dc2626; border: 1.5px solid #ffffff;">
                            Request Quotation
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Page Wrapper -->
    <div class="page-transition-wrapper" style="padding-top: 0;">
        
        <!-- Page Header -->
        <div class="page-header-banner text-white position-relative overflow-hidden d-flex align-items-center" style="padding-top: 170px; padding-bottom: 160px; min-height: 400px;">
            <div class="container text-center">
                <h1 class="display-4 fw-bold mb-2 text-white">Klien &amp; Rekanan</h1>
                <p class="lead text-white-50 mx-auto" style="max-width: 600px;">
                    Mitra kerja industri dan korporasi yang telah mempercayakan konstruksi bangunannya kepada kami.
                </p>
            </div>
        </div>

        <!-- Partner Logotypes Grid -->
        <div class="py-5 bg-light">
            <div class="container py-3">
                <div class="text-center mb-5 reveal">
                    <h2 class="fw-bold text-navy">Dipercaya Oleh Berbagai Perusahaan</h2>
                    <p class="text-muted">Kami menjalin kemitraan erat dengan berbagai pengembang properti komersial, penyedia logistik, dan manufaktur berskala nasional.</p>
                </div>

                <div class="row g-4 justify-content-center">
                    <?php if (!empty($clients)): ?>
                        <?php foreach ($clients as $client): ?>
                            <?php
                            $isObj = is_object($client);
                            $name = $isObj ? $client->name : ($client['name'] ?? '');
                            $logoPath = $isObj ? $client->logo_path : ($client['logo_path'] ?? '');
                            $imgSrc = str_starts_with($logoPath, 'http') ? $logoPath : asset('storage/' . $logoPath);
                            ?>
                            <div class="col-6 col-sm-4 col-md-3 col-lg-2 reveal">
                                <div class="bg-white border rounded-4 p-3 d-flex align-items-center justify-content-center shadow-sm" style="height: 100px; transition: transform 0.3s;" onmouseover="this.style.transform='translateY(-4px)'" onmouseout="this.style.transform='translateY(0)'">
                                    <img src="<?= e($imgSrc) ?>" class="img-fluid object-fit-contain" style="max-height: 70px;" alt="<?= e($name) ?>">
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <!-- Fallback clients -->
                        <?php for ($i = 1; $i <= 8; $i++): ?>
                            <div class="col-6 col-sm-4 col-md-3 col-lg-2 reveal">
                                <div class="bg-white border rounded-4 p-3 d-flex align-items-center justify-content-center shadow-sm" style="height: 100px;">
                                    <h6 class="fw-bold text-muted mb-0">PARTNER <?= $i ?></h6>
                                </div>
                            </div>
                        <?php endfor; ?>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <!-- Testimonials Carousel Section -->
        <div class="py-5 bg-white">
            <div class="container py-3">
                <div class="text-center mb-5 reveal">
                    <span class="text-uppercase fw-bold text-warning" style="letter-spacing: 2px;">Testimoni</span>
                    <h2 class="mt-2 fw-bold text-navy">Apa Kata Mereka Tentang Kami?</h2>
                </div>

                <div class="row g-4">
                    <div class="col-md-6 reveal reveal-left">
                        <div class="bg-light p-4 rounded-4 border shadow-sm h-100 position-relative">
                            <span class="position-absolute top-0 end-0 m-3 text-warning fs-1"><i class="bi bi-quote"></i></span>
                            <p class="text-muted leading-relaxed mb-4">"PT Multi Power Abadi berhasil merampungkan gudang logistik kami seluas 8.500 m2 di Karawang lebih cepat 3 minggu dari jadwal rencana kontrak kerja. Kualitas pengelasan baja rapi, lurus, dan lulus inspeksi lapangan."</p>
                            <h5 class="fw-bold text-navy mb-1">Budi Santoso</h5>
                            <span class="text-warning text-xs fw-semibold">Operations Director, PT Logistik Nusantara</span>
                        </div>
                    </div>
                    
                    <div class="col-md-6 reveal reveal-right" style="transition-delay: 0.2s;">
                        <div class="bg-light p-4 rounded-4 border shadow-sm h-100 position-relative">
                            <span class="position-absolute top-0 end-0 m-3 text-warning fs-1"><i class="bi bi-quote"></i></span>
                            <p class="text-muted leading-relaxed mb-4">"Pekerjaan steel erection dan fabrikasi baja di workshop mereka dilakukan sangat presisi. Seluruh kolom baja terpancang tegak tanpa ada kesalahan lubang angkur baut pondasi. Sangat direkomendasikan."</p>
                            <h5 class="fw-bold text-navy mb-1">Ir. Hendra Wijaya</h5>
                            <span class="text-warning text-xs fw-semibold">Project Director, Wijaya Property Indonesia</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <!-- Floating WhatsApp Button -->
    <a href="https://wa.me/62811272825" target="_blank" rel="noopener noreferrer" class="floating-whatsapp" title="Hubungi Kami di WhatsApp" style="position: fixed; bottom: 30px; right: 30px; z-index: 9999; background: #25d366; color: white; border-radius: 50%; width: 55px; height: 55px; display: flex; align-items: center; justify-content: center; font-size: 1.8rem; box-shadow: 0 5px 15px rgba(0,0,0,0.2); text-decoration: none;">
        <i class="bi bi-whatsapp"></i>
    </a>

    <!-- Back to Top Button -->
    <button id="back-to-top-btn" class="back-to-top" title="Kembali ke Atas" style="position: fixed; bottom: 95px; right: 30px; z-index: 9999; background: #0f2d5c; color: white; border: none; border-radius: 50%; width: 45px; height: 45px; display: none; align-items: center; justify-content: center; font-size: 1.4rem; box-shadow: 0 5px 15px rgba(0,0,0,0.2); cursor: pointer;">
        <i class="bi bi-arrow-up-short"></i>
    </button>

    <!-- Footer Section -->
    <footer class="custom-footer mt-0 text-white" id="mainFooter" style="background-color: #0f172a; position: relative;">
        <div class="container footer-content position-relative py-5">
            <div class="row g-4 g-lg-5 pt-3 pb-4">
                <!-- COL 1: Profil PT -->
                <div class="col-lg-4 col-md-6">
                    <div class="footer-brand-mark mb-3">
                        <span class="fs-2 text-danger"><i class="bi bi-building-fill-gear"></i></span>
                    </div>
                    <h5 class="fw-bold text-white mb-3">PT. Multi Power Abadi</h5>
                    <p class="text-white-50 small" style="line-height: 1.6;">
                        Kontraktor Spesialis Engineering, Fabrikasi Workshop Mandiri, &amp; Steel Erection Berstandar Mutu SNI. Mitra Tepercaya Pembangunan Gudang, Pabrik, &amp; Bangunan Industri Masa Depan.
                    </p>
                    <div class="d-flex gap-2 mt-4">
                        <a href="https://www.instagram.com/multipowerabadi/" target="_blank" rel="noopener noreferrer" class="btn btn-outline-light btn-sm rounded-circle" aria-label="Instagram"><i class="bi bi-instagram"></i></a>
                        <a href="https://www.tiktok.com/@multipowerabadi" target="_blank" rel="noopener noreferrer" class="btn btn-outline-light btn-sm rounded-circle" aria-label="TikTok"><i class="bi bi-tiktok"></i></a>
                        <a href="https://www.facebook.com/people/PT-MULTI-POWER-ABADI/100067681392488/" target="_blank" rel="noopener noreferrer" class="btn btn-outline-light btn-sm rounded-circle" aria-label="Facebook"><i class="bi bi-facebook"></i></a>
                        <a href="https://www.youtube.com/@RuangMPA" target="_blank" rel="noopener noreferrer" class="btn btn-outline-light btn-sm rounded-circle" aria-label="YouTube"><i class="bi bi-youtube"></i></a>
                    </div>
                </div>

                <!-- COL 2: Kontak Kami -->
                <div class="col-lg-4 col-md-6">
                    <h5 class="fw-bold text-white mb-3">
                        <i class="bi bi-headset me-2 text-danger"></i>Kontak Kami
                    </h5>
                    <ul class="list-unstyled small text-white-50">
                        <li class="mb-3 d-flex align-items-center gap-2">
                            <i class="bi bi-whatsapp text-success fs-5"></i>
                            <div>
                                <strong class="d-block text-white">WhatsApp</strong>
                                <a href="https://wa.me/62811272825" target="_blank" class="text-white-50 text-decoration-none">+62 811-272-825</a>
                            </div>
                        </li>
                        <li class="mb-3 d-flex align-items-center gap-2">
                            <i class="bi bi-envelope-fill text-warning fs-5"></i>
                            <div>
                                <strong class="d-block text-white">Email</strong>
                                <a href="mailto:multipowerabadi@gmail.com" class="text-white-50 text-decoration-none">multipowerabadi@gmail.com</a>
                            </div>
                        </li>
                        <li class="d-flex align-items-center gap-2">
                            <i class="bi bi-clock-fill text-info fs-5"></i>
                            <div>
                                <strong class="d-block text-white">Jam Operasional</strong>
                                <span>24 Jam</span>
                            </div>
                        </li>
                    </ul>
                </div>

                <!-- COL 3: Alamat Lengkap -->
                <div class="col-lg-4 col-md-6">
                    <h5 class="fw-bold text-white mb-3">
                        <i class="bi bi-geo-alt-fill me-2 text-danger"></i>Alamat Kantor
                    </h5>
                    <p class="text-white-50 small mb-2" style="line-height: 1.6;">
                        <strong class="text-white">PT. Multi Power Abadi</strong><br>
                        Jl. Gn. Anyar Tambak IV No.50, Gn. Anyar Tambak, Kec. Gn. Anyar, Surabaya, Jawa Timur 60294
                    </p>
                    <a href="https://maps.google.com/?q=Jl.+Gn.+Anyar+Tambak+IV+No.50,+Surabaya" target="_blank" rel="noopener noreferrer" class="text-danger fw-semibold small text-decoration-none">
                        <i class="bi bi-box-arrow-up-right me-1"></i>Petunjuk Arah (Google Maps)
                    </a>
                </div>
            </div>

            <!-- Google Maps Embed Card -->
            <div class="row my-4">
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

            <!-- Bottom Copyright Bar -->
            <div class="border-top border-secondary pt-4 mt-4 text-center text-md-between d-md-flex align-items-center">
                <p class="small text-white-50 mb-2 mb-md-0">
                    &copy; <?= date('Y') ?> <strong class="text-white">PT Multi Power Abadi</strong>. All rights reserved.
                </p>
                <nav class="small">
                    <a href="<?= e(route('home')) ?>" class="text-white-50 text-decoration-none mx-2">Home</a>
                    <a href="<?= e(route('public.services.index')) ?>" class="text-white-50 text-decoration-none mx-2">Services</a>
                    <a href="<?= e(route('public.projects.index')) ?>" class="text-white-50 text-decoration-none mx-2">Projects</a>
                    <a href="<?= e(route('public.contact')) ?>" class="text-white-50 text-decoration-none mx-2">Contact</a>
                </nav>
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

    <!-- Bootstrap 5 JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        // Navbar Scroll Script
        (function () {
            const navbar = document.getElementById('mainNavbar');
            if (!navbar) return;
            const onScroll = () => {
                navbar.classList.toggle('scrolled', window.scrollY > 60);
            };
            window.addEventListener('scroll', onScroll, { passive: true });
            onScroll();
        })();

        // Scroll Reveal Animation (IntersectionObserver)
        (function () {
            const revealEls = document.querySelectorAll('.reveal, .reveal-left, .reveal-right');
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

        // Back to Top Button Script
        (function () {
            const backToTopBtn = document.getElementById('back-to-top-btn');
            if (!backToTopBtn) return;
            window.addEventListener('scroll', () => {
                if (window.scrollY > 300) {
                    backToTopBtn.style.display = 'flex';
                } else {
                    backToTopBtn.style.display = 'none';
                }
            });
            backToTopBtn.addEventListener('click', () => {
                window.scrollTo({ top: 0, behavior: 'smooth' });
            });
        })();
    </script>
</body>
</html>
