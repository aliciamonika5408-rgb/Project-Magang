<?php
/**
 * Konversi Native PHP dari resources/views/public/projects/index.blade.php
 * 
 * Mempertahankan tampilan, HTML, CSS, JS, dan fitur 100% presisi.
 * Dapat dijalankan langsung di XAMPP / PHP native tanpa Laravel / Blade engine.
 */

declare(strict_types=1);

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once dirname(__DIR__, 2) . '/native_helpers.php';
require_once dirname(__DIR__, 4) . '/native/db.php';


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
        if ($pattern === 'public.projects.*' || $pattern === 'public.projects.index') {
            return str_contains($path, 'projects');
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

// ---------------------------------------------------------------------------
// Data & Fallback Projects Data
// ---------------------------------------------------------------------------

$categories = ['Mezzanine', 'Gedung', 'Pabrik', 'Gudang'];

$search = request('search');
$category = request('category');

$sql = "SELECT * FROM projects WHERE 1=1";
$params = [];

if (!empty($search)) {
    $sql .= " AND (title LIKE ? OR location LIKE ? OR description LIKE ?)";
    $params[] = '%' . $search . '%';
    $params[] = '%' . $search . '%';
    $params[] = '%' . $search . '%';
}

if (!empty($category) && $category !== 'all') {
    $sql .= " AND category = ?";
    $params[] = $category;
}

$sql .= " ORDER BY created_at DESC";

try {
    $projects = db_select($sql, $params);
} catch (Throwable $e) {
    $projects = [];
}

$staticProjects = [
    [
        'title' => 'Konstruksi Mezzanine – PT Kosmetika Global Indonesia',
        'category' => 'Mezzanine',
        'location' => 'Jl. Rungkut Industri III No. 9, Kel. Kutisari, Kec. Tenggilis Mejoyo, Surabaya',
        'year' => 2024,
        'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.',
        'image' => asset('images/konstruksi-mezzanine-kosmetika.jpg')
    ],
    [
        'title' => 'Konstruksi Mezzanine – PT Hore Indonesia Sehat',
        'category' => 'Mezzanine',
        'location' => 'Jl. Raya Bambe BLOK K-06, Area Sawah, Bambe, Driyorejo, Gresik Regency',
        'year' => 2025,
        'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.',
        'image' => asset('images/konstruksi-mezzanine-hore.jpg')
    ],
    [
        'title' => 'Pembangunan Gedung Kantor dengan Struktur Baja - PT Telekomunikasi Indonesia',
        'category' => 'Gedung',
        'location' => 'Jl. Margorejo Indah No. 56A/136, Margorejo, Wonocolo, Surabaya',
        'year' => 2025,
        'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.',
        'image' => asset('images/pembangunan-gedung-telkom.jpg')
    ]
];

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

        .btn-navy {
            background-color: #0f2d5c;
            color: #ffffff;
        }
        .btn-navy:hover {
            background-color: #0b2247;
            color: #ffffff;
        }

        /* Project Card Styling */
        .project-card-clickable {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        .project-card-clickable:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0,0,0,0.15) !important;
        }
        .project-card-img {
            transition: transform 0.5s ease;
        }
        .project-card-clickable:hover .project-card-img {
            transform: scale(1.05);
        }
        .bg-gradient-navy {
            background: linear-gradient(to top, rgba(15, 45, 92, 0.95) 0%, rgba(15, 45, 92, 0.4) 60%, rgba(0, 0, 0, 0) 100%);
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
                        <a class="nav-link active" href="<?= e(route('public.projects.index')) ?>">Projects</a>
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
                <h1 class="display-4 fw-bold mb-2 text-white">Portfolio Proyek</h1>
                <p class="lead text-white-50 mx-auto" style="max-width: 600px;">
                    Dokumentasi pekerjaan konstruksi gudang logistik, fabrikasi besi baja, dan ereksi struktur industri.
                </p>
            </div>
        </div>

        <!-- Search & Filtering Bar -->
        <div class="py-4 bg-light border-bottom border-light">
            <div class="container">
                <form action="<?= e(route('public.projects.index')) ?>" method="GET" class="row g-3 align-items-center">
                    <!-- Search Input -->
                    <div class="col-md-5">
                        <div class="input-group bg-white rounded-3 shadow-sm border overflow-hidden">
                            <span class="input-group-text bg-white border-0 text-muted"><i class="bi bi-search"></i></span>
                            <input type="text" name="search" class="form-control border-0 py-2 px-1" placeholder="Cari nama proyek, lokasi..." value="<?= e(request('search')) ?>">
                        </div>
                    </div>
                    
                    <!-- Category Filter Selection -->
                    <div class="col-md-4">
                        <div class="input-group bg-white rounded-3 shadow-sm border overflow-hidden">
                            <span class="input-group-text bg-white border-0 text-muted"><i class="bi bi-filter"></i></span>
                            <select name="category" class="form-select border-0 py-2 px-1" onchange="this.form.submit()">
                                <option value="all">Semua Kategori</option>
                                <?php foreach ($categories as $category): ?>
                                    <option value="<?= e($category) ?>" <?= request('category') == $category ? 'selected' : '' ?>><?= e($category) ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    
                    <!-- Action Button -->
                    <div class="col-md-3">
                        <button type="submit" class="btn btn-navy btn-ripple w-100 py-2 text-white shadow fw-semibold">Cari & Filter</button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Projects Grid Showcase -->
        <div class="py-5 bg-white">
            <div class="container py-3">
                <div class="row g-4">
                    <?php if (!empty($projects)): ?>
                        <?php foreach ($projects as $index => $project): ?>
                            <?php
                            $isObj = is_object($project);
                            $title = $isObj ? $project->title : ($project['title'] ?? '');
                            $category = $isObj ? $project->category : ($project['category'] ?? '');
                            $location = $isObj ? $project->location : ($project['location'] ?? '');
                            $year = $isObj ? $project->year : ($project['year'] ?? '');
                            $description = $isObj ? ($project->description ?: 'Proyek konstruksi baja oleh PT Multi Power Abadi.') : ($project['description'] ?? '');
                            $rawImg = $isObj ? $project->image : ($project['image'] ?? '');
                            $image = $rawImg 
                                ? (str_starts_with($rawImg, 'http') ? $rawImg : asset('storage/' . $rawImg))
                                : ($category === 'Mezzanine' ? asset('images/konstruksi-mezzanine-kosmetika.jpg') : asset('images/gudang-pabrik.jpg'));
                            $delay = 0.1 * (($index % 3) + 1);
                            ?>
                            <div class="col-md-6 col-lg-4 reveal" style="transition-delay: <?= e((string) $delay) ?>s;">
                                <div class="project-card project-card-clickable border-0 rounded-4 overflow-hidden position-relative shadow-sm"
                                     style="height: 310px; cursor: pointer;"
                                     data-title="<?= e($title) ?>"
                                     data-category="<?= e($category) ?>"
                                     data-location="<?= e($location) ?>"
                                     data-year="<?= e((string) $year) ?>"
                                     data-description="<?= e($description) ?>"
                                     data-image="<?= e($image) ?>"
                                     onclick="openProjectPopup(this)">
                                    <img src="<?= e($image) ?>" 
                                         class="project-card-img w-100 h-100 object-fit-cover" 
                                         alt="<?= e($title) ?>">
                                    <div class="project-card-overlay p-4 position-absolute bottom-0 start-0 w-100 h-100 d-flex flex-column justify-content-end bg-gradient-navy">
                                        <span class="project-card-category badge bg-danger text-white fw-semibold text-uppercase text-xs mb-2 align-self-start shadow-sm" style="letter-spacing: 0.8px;"><?= e($category) ?></span>
                                        <h4 class="project-card-title text-white fw-bold my-1" style="font-size: 1.2rem;"><?= e($title) ?></h4>
                                        <div class="project-card-location text-white-50 small">
                                            <i class="bi bi-geo-alt-fill text-danger me-1"></i> <?= e($location) ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <?php foreach ($staticProjects as $item): ?>
                            <div class="col-md-6 col-lg-4 reveal">
                                <div class="project-card project-card-clickable border-0 rounded-4 overflow-hidden position-relative shadow-sm"
                                     style="height: 310px; cursor: pointer;"
                                     data-title="<?= e($item['title']) ?>"
                                     data-category="<?= e($item['category']) ?>"
                                     data-location="<?= e($item['location']) ?>"
                                     data-year="<?= e((string) $item['year']) ?>"
                                     data-description="<?= e($item['description']) ?>"
                                     data-image="<?= e($item['image']) ?>"
                                     onclick="openProjectPopup(this)">
                                    <img src="<?= e($item['image']) ?>" class="project-card-img w-100 h-100 object-fit-cover" alt="<?= e($item['title']) ?>">
                                    <div class="project-card-overlay p-4 position-absolute bottom-0 start-0 w-100 h-100 d-flex flex-column justify-content-end bg-gradient-navy">
                                        <span class="project-card-category badge bg-danger text-white fw-semibold text-uppercase text-xs mb-2 align-self-start shadow-sm" style="letter-spacing: 0.8px;"><?= e($item['category']) ?></span>
                                        <h4 class="project-card-title text-white fw-bold my-1" style="font-size: 1.2rem;"><?= e($item['title']) ?></h4>
                                        <div class="project-card-location text-white-50 small">
                                            <i class="bi bi-geo-alt-fill text-danger me-1"></i> <?= e($item['location']) ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>

                <?php if (is_object($projects) && method_exists($projects, 'links')): ?>
                    <div class="d-flex justify-content-center mt-5">
                        <?= $projects->links('pagination::bootstrap-5') ?>
                    </div>
                <?php endif; ?>
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

        // Project Detail Popup Modal Functions
        function openProjectPopup(el){
            var card = el.closest('.project-card-clickable');
            if(!card) return;
            var img = card.getAttribute('data-image') || '';
            var title = card.getAttribute('data-title') || '';
            var category = card.getAttribute('data-category') || '';
            var location = card.getAttribute('data-location') || '';
            var year = card.getAttribute('data-year') || '';
            var desc = card.getAttribute('data-description') || '';

            document.getElementById('popup-img').src = img;
            document.getElementById('popup-category').textContent = category;
            document.getElementById('popup-title').textContent = title;
            document.getElementById('popup-meta').innerHTML = '<span><i class="bi bi-geo-alt-fill"></i> ' + location + '</span>';
            document.getElementById('popup-desc').textContent = desc;

            document.getElementById('project-popup').classList.add('show');
            document.body.style.overflow = 'hidden';
        }
        function closeProjectPopup(){
            document.getElementById('project-popup').classList.remove('show');
            document.body.style.overflow = '';
        }
        document.addEventListener('keydown', function(e){
            if(e.key === 'Escape') closeProjectPopup();
        });
    </script>
</body>
</html>
