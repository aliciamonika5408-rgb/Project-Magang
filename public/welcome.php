<?php
/**
 * Konversi native PHP dari welcome.blade.php
 *
 * Layout publik dan konten halaman digabung dalam satu file.
 * Helper asset(), route(), route_is(), csrf_token(), session_get() menggantikan helper Laravel.
 * Data otherServices dan projects diambil via PDO; fallback ke data statis jika gagal.
 */

declare(strict_types=1);

define('APP_ROOT', basename(__DIR__) === 'public' ? dirname(__DIR__) : dirname(__DIR__, 2));
require_once dirname(__DIR__) . '/resources/views/native_helpers.php';


if (!function_exists('str_ends_with')) {
    function str_ends_with(string $haystack, string $needle): bool
    {
        if ($needle === '') {
            return true;
        }
        return substr($haystack, -strlen($needle)) === $needle;
    }
}

if (!function_exists('str_starts_with')) {
    function str_starts_with(string $haystack, string $needle): bool
    {
        if ($needle === '') {
            return true;
        }
        return strncmp($haystack, $needle, strlen($needle)) === 0;
    }
}

if (!function_exists('str_contains')) {
    function str_contains(string $haystack, string $needle): bool
    {
        if ($needle === '') {
            return true;
        }
        return strpos($haystack, $needle) !== false;
    }
}

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// ---------------------------------------------------------------------------
// Helper functions (pengganti fasilitas Laravel)
// ---------------------------------------------------------------------------

function e($value): string
{
    return htmlspecialchars((string) $value, ENT_QUOTES, 'UTF-8');
}

function asset(string $path): string
{
    return '/' . ltrim($path, '/');
}

function storage_asset(string $path): string
{
    return asset('storage/' . ltrim($path, '/'));
}

function route(string $name): string
{
    static $routes = [
        'home' => '/',
        'public.services.index' => '/services',
        'public.projects.index' => '/projects',
        'public.contact' => '/contact',
        'public.quotation' => '/request-quotation',
    ];

    return $routes[$name] ?? '#';
}

function route_is(string $pattern): bool
{
    $requestUri = isset($_SERVER['REQUEST_URI']) ? $_SERVER['REQUEST_URI'] : '/';
    $path = parse_url($requestUri, PHP_URL_PATH);
    $path = is_string($path) && $path !== '' ? $path : '/';
    $path = rtrim($path, '/') ?: '/';

    $map = [
        'home' => ['/', '/welcome.php', '/index.php'],
        'public.services.index' => '/services',
        'public.projects.index' => '/projects',
        'public.contact' => '/contact',
        'public.quotation' => '/request-quotation',
    ];

    if ($pattern === 'home') {
        return in_array($path, $map['home'], true);
    }

    if (str_ends_with($pattern, '.*')) {
        $base = substr($pattern, 0, -2);
        $prefix = $map[$base . '.index'] ?? null;
        if ($prefix === null) {
            return false;
        }
        return $path === $prefix || str_starts_with($path, $prefix . '/');
    }

    $exact = $map[$pattern] ?? null;

    return $exact !== null && $path === $exact;
}

function csrf_token(): string
{
    if (empty($_SESSION['_token'])) {
        $_SESSION['_token'] = bin2hex(random_bytes(32));
    }

    return $_SESSION['_token'];
}

function session_get(string $key): ?string
{
    $value = $_SESSION[$key] ?? null;

    return is_string($value) ? $value : null;
}

function env_value(string $key, ?string $default = null): ?string
{
    static $env = null;

    if ($env === null) {
        $env = [];
        $envFile = APP_ROOT . '/.env';

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

function get_pdo(): ?PDO
{
    static $pdo = null;

    if ($pdo instanceof PDO) {
        return $pdo;
    }

    try {
        $driver = env_value('DB_CONNECTION', 'sqlite');

        if ($driver === 'sqlite') {
            $database = env_value('DB_DATABASE', 'database/database.sqlite');
            $isWindowsDrive = (strlen($database) >= 2 && ctype_alpha($database[0]) && $database[1] === ':');
            if (!str_starts_with($database, '/') && !$isWindowsDrive) {
                $database = APP_ROOT . '/' . $database;
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

/** Memuat CSS/JS dari Vite build (sama seperti @vite di Laravel). */
function vite_assets(): array
{
    $manifestPath = APP_ROOT . '/public/build/manifest.json';
    $css = [];
    $js = [];

    if (is_readable($manifestPath)) {
        $manifest = json_decode((string) file_get_contents($manifestPath), true);
        if (is_array($manifest)) {
            if (!empty($manifest['resources/css/app.css']['file'])) {
                $css[] = '/build/' . ltrim($manifest['resources/css/app.css']['file'], '/');
            }
            if (!empty($manifest['resources/js/app.js']['file'])) {
                $js[] = '/build/' . ltrim($manifest['resources/js/app.js']['file'], '/');
            }
        }
    }

    if ($css === []) {
        $css[] = 'https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css';
    }

    if ($js === []) {
        $js[] = 'https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js';
    }

    return ['css' => $css, 'js' => $js];
}

// ---------------------------------------------------------------------------
// Data (pengganti PublicController::home)
// ---------------------------------------------------------------------------

$otherServices = [];
$projects = [];

$pdo = get_pdo();
if ($pdo instanceof PDO) {
    try {
        $otherServices = $pdo->query(
            'SELECT * FROM other_services ORDER BY created_at DESC'
        )->fetchAll();
        $projects = $pdo->query(
            'SELECT * FROM projects ORDER BY created_at DESC LIMIT 6'
        )->fetchAll();
    } catch (Throwable $e) {
        $otherServices = [];
        $projects = [];
    }
}

$pageTitle = 'PT Multi Power Abadi - Konstruksi Baja, Gudang & Bangunan Industri';
$vite = vite_assets();

// ---------------------------------------------------------------------------
// Konten halaman utama
// ---------------------------------------------------------------------------

$heroImage1 = e(asset('images/hero-1.jpg'));
$heroImage2 = e(asset('images/hero-2.jpg'));
$heroImage3 = e(asset('images/hero-3.jpg'));
$heroImage4 = e(asset('images/hero-4.png'));

ob_start();
?>
<style>
    .transition-hover-card {
        transition: transform 0.3s cubic-bezier(0.4, 0, 0.2, 1), box-shadow 0.3s cubic-bezier(0.4, 0, 0.2, 1) !important;
    }
    .transition-hover-card:hover {
        transform: translateY(-6px) !important;
        box-shadow: 0 15px 30px rgba(0, 0, 0, 0.08) !important;
        border-color: rgba(255, 193, 7, 0.25) !important;
    }
</style>
<!-- Hero Section -->
<section id="home" class="hero-section overflow-hidden position-relative d-flex align-items-center justify-content-center" style="min-height: 85vh;">
    <!-- Animated Moving Background Slider (4 Real Project Photos) -->
    <div class="hero-bg-slider position-absolute top-0 start-0 w-100 h-100" style="z-index: 1;">
        <div class="hero-slide active" style="background-image: url('<?php echo $heroImage1; ?>');"></div>
        <div class="hero-slide" style="background-image: url('<?php echo $heroImage2; ?>');"></div>
        <div class="hero-slide" style="background-image: url('<?php echo $heroImage3; ?>');"></div>
        <div class="hero-slide" style="background-image: url('<?php echo $heroImage4; ?>');"></div>
    </div>
    <!-- Gradient Overlay for Contrast -->
    <div class="hero-overlay position-absolute top-0 start-0 w-100 h-100" style="z-index: 2; background: linear-gradient(135deg, rgba(15, 23, 42, 0.92) 0%, rgba(15, 23, 42, 0.82) 50%, rgba(13, 0, 0, 0.88) 100%);"></div>
    <!-- Animated moving red light glow -->
    <div class="hero-red-light"></div>
    <!-- Dust particles canvas -->
    <canvas id="hero-particles"></canvas>

    <div class="container hero-content text-start position-relative" style="z-index: 5; margin-top: -25px;">
        <div class="row justify-content-start">
            <div class="col-lg-10 col-xl-9 text-start">
                <span class="badge bg-danger text-white px-3 py-2 rounded-pill text-uppercase fw-semibold mb-3 d-inline-block shadow-sm" style="letter-spacing: 1.5px; font-size: 0.82rem;">
                    <i class="bi bi-shield-fill-check me-1"></i> Kontraktor Konstruksi Baja Terpercaya
                </span>
                <h1 class="hero-title display-5 text-white fw-bold mb-4" style="letter-spacing: -1px; line-height: 1.25;">
                    Konstruksi Baja Profesional<br class="d-none d-md-block">
                    Untuk Gudang, Pabrik, dan Bangunan Industri
                </h1>

                <div class="d-flex flex-wrap justify-content-start gap-3 reveal" style="transition-delay: 0.5s;">
                    <a href="<?= e(route('public.quotation')) ?>" class="btn btn-accent btn-lg btn-ripple shadow-lg px-4 text-white fw-semibold" style="transition: transform 0.3s ease, box-shadow 0.3s ease;">
                        <i class="bi bi-file-earmark-text-fill me-2"></i>Minta Penawaran Proyek
                    </a>
                    <a href="https://wa.me/62811272825" target="_blank" rel="noopener noreferrer" class="btn btn-outline-white btn-lg btn-ripple px-4 fw-semibold">
                        <i class="bi bi-whatsapp me-2"></i>Konsultasi Gratis
                    </a>
                </div>
            </div>
        </div>
    </div>
    <!-- Scroll Down Indicator -->
    <div class="position-absolute bottom-0 start-50 translate-middle-x mb-4 text-center reveal" style="z-index: 7; transition-delay: 0.8s;">
        <a href="#stats" class="text-white text-decoration-none">
            <div class="d-flex flex-column align-items-center">
                <span class="text-white-50 text-uppercase small mb-2" style="letter-spacing: 2px;">Jelajahi Solusi</span>
                <i class="bi bi-chevron-down fs-4 animate-bounce"></i>
            </div>
        </a>
    </div>
</section>

<!-- Statistics Grid — Premium Dark -->
<section id="stats" class="py-0 position-relative stat-section" style="z-index: 10; margin-top: -55px; margin-bottom: 25px;">
    <div class="container">
        <div class="stats-premium rounded-4 p-3 shadow-lg">
            <div class="row g-0">
                <div class="col-6 col-md-3 reveal" style="transition-delay:0.1s;">
                    <div class="stat-premium-card">
                        <div class="stat-premium-number stat-number" data-target="12" data-suffix="+">0</div>
                        <div class="stat-premium-label">Tahun Pengalaman</div>
                    </div>
                </div>
                <div class="col-6 col-md-3 reveal" style="transition-delay:0.2s;">
                    <div class="stat-premium-card">
                        <div class="stat-premium-number stat-number" data-target="1250" data-suffix="+">0</div>
                        <div class="stat-premium-label">Proyek Terbangun</div>
                    </div>
                </div>
                <div class="col-6 col-md-3 reveal" style="transition-delay:0.3s;">
                    <div class="stat-premium-card">
                        <div class="stat-premium-number stat-number" data-target="32" data-suffix="">0</div>
                        <div class="stat-premium-label">Kota di Indonesia</div>
                    </div>
                </div>
                <div class="col-6 col-md-3 reveal" style="transition-delay:0.4s;">
                    <div class="stat-premium-card">
                        <div class="stat-premium-number stat-number" data-target="100" data-suffix="%">0</div>
                        <div class="stat-premium-label">Komitmen Mutu &amp; K3</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- About / Intro Section -->
<section id="about" class="py-5 bg-light">
    <div class="container py-4">
        <div class="row align-items-center g-5">
            <div class="col-lg-6 reveal reveal-left">
                <div class="position-relative overflow-hidden rounded-4 shadow-lg h-100" style="min-height: 420px;">
                    <img src="<?= e(asset('images/layanan-baja-bg.jpg')) ?>" class="position-absolute top-0 start-0 w-100 h-100 object-fit-cover" alt="Layanan Konstruksi Baja PT Multi Power Abadi" style="z-index: 1;">
                    <div class="position-absolute top-0 start-0 w-100 h-100" style="z-index: 2; background: linear-gradient(135deg, rgba(15, 23, 42, 0.35) 0%, rgba(15, 23, 42, 0.75) 100%);"></div>
                    <div class="position-absolute bottom-0 start-0 bg-danger text-white p-4 rounded-4 m-3 shadow-lg float-effect" style="z-index: 3;">
                        <h4 class="fw-bold mb-0">12+ Tahun Pengalaman</h4>
                        <p class="mb-0 text-sm">Menghadirkan Struktur Baja Industri Berstandar SNI</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 reveal reveal-right" style="transition-delay: 0.2s;">
                <span class="text-uppercase fw-bold text-danger" style="letter-spacing: 2px; font-size: 0.85rem;">TENTANG KAMI</span>
                <h2 class="mt-2 mb-4 display-6 fw-bold text-navy">Spesialis Konstruksi Baja &amp; Bangunan Industri Terpercaya</h2>
                <p class="text-muted mb-3 lead" style="font-size: 1.05rem;">PT. Multi Power Abadi adalah perusahaan kontraktor konstruksi baja yang berfokus pada pembangunan gudang, pabrik, hanggar, dan struktur industri dengan tingkat akurasi rekayasa tinggi.</p>
                <p class="text-muted mb-4">Kami menggabungkan perencanaan rekayasa struktural yang matang, fasilitas fabrikasi workshop mandiri, serta pengawasan *steel erection* di lapangan secara disiplin. Komitmen utama kami adalah memberikan struktur bangunan yang kokoh, tepat waktu, efisien biaya, dan bergaransi penuh demi melindungi investasi jangka panjang Anda.</p>
                <div class="row g-3">
                    <div class="col-sm-6">
                        <div class="d-flex align-items-center gap-2 p-2 rounded-3 bg-white border shadow-sm">
                            <i class="bi bi-shield-check text-danger fs-4"></i>
                            <div>
                                <h6 class="fw-bold text-navy mb-0" style="font-size: 0.9rem;">Material Standar SNI</h6>
                                <small class="text-muted">Kualitas Teruji &amp; Tersertifikasi</small>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="d-flex align-items-center gap-2 p-2 rounded-3 bg-white border shadow-sm">
                            <i class="bi bi-clock-history text-danger fs-4"></i>
                            <div>
                                <h6 class="fw-bold text-navy mb-0" style="font-size: 0.9rem;">Pengerjaan Tepat Waktu</h6>
                                <small class="text-muted">Manajemen Proyek Terkontrol</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Our Services Section -->
<section id="services" class="py-5 bg-white">
    <div class="container py-4">
        <div class="text-center mb-5 reveal">
            <span class="text-uppercase fw-bold text-danger" style="letter-spacing: 2px; font-size: 0.85rem;">LAYANAN UTAMA</span>
            <h2 class="mt-2 display-6 fw-bold text-navy">Solusi Konstruksi Baja Terintegrasi</h2>
            <p class="text-muted mx-auto" style="max-width: 680px;">Setiap layanan dirancang untuk memberikan ketahanan struktur maksimal, efisiensi waktu pembangunan, dan keamanan operasional fasilitas bisnis Anda.</p>
        </div>

        <?php
        $constructionServices = [
            [
                'title' => 'Konstruksi Gudang Baja',
                'desc' => 'Desain & pembangunan gudang bentang lebar tanpa tiang tengah, mengoptimalkan kapasitas penyimpanan dan kelancaran logistik.',
                'icon' => 'bi-building-fill',
                'img' => asset('images/konstruksi-gudang-baja.jpg'),
            ],
            [
                'title' => 'Konstruksi Pabrik Baja',
                'desc' => 'Struktur pabrik industri heavy-duty yang dirancang khusus menahan beban mesin produksi dan crane operasional secara aman.',
                'icon' => 'bi-building-gear',
                'img' => asset('images/konstruksi-pabrik-baja.jpg'),
            ],
            [
                'title' => 'Konstruksi Hanggar Baja',
                'desc' => 'Konstruksi bentang ekstra lebar dengan sistem rangka baja kokoh yang tahan terhadap angin dan cuaca ekstrem.',
                'icon' => 'bi-airplane',
                'img' => asset('images/konstruksi-hanggar-baja.jpg'),
            ],
            [
                'title' => 'Konstruksi Workshop Baja',
                'desc' => 'Fasilitas kerja dan bengkel industri dengan efisiensi tata ruang tinggi, pencahayaan alami, dan sirkulasi udara optimal.',
                'icon' => 'bi-tools',
                'img' => asset('images/konstruksi-workshop-baja.jpg'),
            ],
            [
                'title' => 'Konstruksi Gedung Baja',
                'desc' => 'Sistem struktur baja multilantai yang cepat dibangun, fleksibel untuk ekspansi, serta tahan beban gempa.',
                'icon' => 'bi-building',
                'img' => asset('images/konstruksi-struktur-gedung-baja.png'),
            ],
            [
                'title' => 'Konstruksi Mezzanine Baja',
                'desc' => 'Solusi cepat menambah luas area kerja vertikal tanpa merusak struktur utama bangunan gudang atau pabrik.',
                'icon' => 'bi-layers-half',
                'img' => asset('images/konstruksi-mezzanine-baja.png'),
            ],
            [
                'title' => 'Rangka Atap Baja Bentang Lebar',
                'desc' => 'Pemasangan rangka atap baja bervolume besar yang tahan korosi, kuat menahan beban, dan minim biaya perawatan.',
                'icon' => 'bi-house-gear-fill',
                'img' => asset('images/konstruksi-rangka-atap-baja.jpg'),
            ],
            [
                'title' => 'Renovasi & Perkuatan Struktur',
                'desc' => 'Peningkatan kapasitas beban dan perkuatan struktur baja eksisting agar sesuai dengan kebutuhan operasional baru.',
                'icon' => 'bi-shield-fill-check',
                'img' => 'https://images.unsplash.com/photo-1504307651254-35680f356dfd?q=80&w=600&auto=format&fit=crop',
            ],
        ];
        ?>

        <div class="row g-4">
            <?php foreach ($constructionServices as $index => $item): ?>
                <div class="col-md-6 col-lg-3 reveal" style="transition-delay: <?= e((string) (0.08 * ($index + 1))) ?>s;">
                    <div class="service-card h-100 border rounded-4 shadow-sm overflow-hidden bg-white d-flex flex-column">
                        <div class="card-img-wrapper" style="height: 180px; overflow: hidden; position: relative;">
                            <img src="<?= e($item['img']) ?>" class="w-100 h-100 object-fit-cover transition-zoom" alt="<?= e($item['title']) ?>">
                        </div>
                        <div class="card-body p-4 position-relative d-flex flex-column flex-grow-1 justify-content-between">
                            <div>
                                <div class="service-icon-box mb-3">
                                    <i class="bi <?= e($item['icon']) ?>"></i>
                                </div>
                                <h5 class="card-title fw-bold text-navy mb-2 fs-6" style="line-height: 1.4;"><?= e($item['title']) ?></h5>
                                <p class="text-muted text-sm mb-0" style="font-size: 0.85rem; line-height: 1.5;"><?= e($item['desc']) ?></p>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

        <div class="text-center mt-5 reveal">
            <a href="<?= e(route('public.services.index')) ?>" class="btn btn-accent btn-ripple px-4 py-2.5 text-white fw-semibold shadow-sm">
                Lihat Seluruh Layanan Konstruksi <i class="bi bi-arrow-right ms-1"></i>
            </a>
        </div>
    </div>
</section>

<!-- Layanan Lainnya Section -->
<section id="other-services" class="py-5 bg-light">
    <div class="container py-4">
        <div class="text-center mb-5 reveal">
            <span class="text-uppercase fw-bold text-danger" style="letter-spacing: 2px; font-size: 0.85rem;">SOLUSI PENDUKUNG</span>
            <h2 class="mt-2 display-6 fw-bold text-navy">Layanan Sipil, Interior &amp; Arsitektur</h2>
            <p class="text-muted mx-auto mt-3" style="max-width: 720px; font-size: 0.95rem;">Untuk memberikan kemudahan One-Stop Solution, kami juga melayani pengerjaan sipil, mekanikal-elektrikal, serta penataan interior komersial secara profesional.</p>
        </div>

        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-4 g-4 mt-2">
            <?php if (!empty($otherServices)): ?>
                <?php foreach ($otherServices as $index => $service): ?>
                    <?php
                    $isObj = is_object($service);
                    $title = $isObj ? $service->title : ($service['title'] ?? '');
                    $desc = $isObj ? $service->description : ($service['desc'] ?? $service['description'] ?? '');
                    $icon = $isObj ? $service->icon : ($service['icon'] ?? 'bi-tools');
                    ?>
                    <div class="col reveal" style="transition-delay: <?= e((string) (0.1 * ($index + 1))) ?>s;">
                        <div class="other-service-card h-100 p-4 bg-white rounded-4 border shadow-sm transition-all position-relative overflow-hidden d-flex flex-column">
                            <div class="other-service-icon-box mb-4 d-inline-flex align-items-center justify-content-center rounded-3">
                                <i class="bi <?= e($icon) ?>"></i>
                            </div>
                            <h5 class="fw-bold text-navy mb-3 fs-6" style="line-height: 1.4;"><?= e($title) ?></h5>
                            <p class="text-muted text-sm mb-0 flex-grow-1" style="font-size: 0.88rem; line-height: 1.6;"><?= e($desc) ?></p>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <?php
                $staticOtherServices = [
                    ['title' => 'Renovasi Residensial & Komersial', 'desc' => 'Solusi renovasi gedung kantor, ruko, pabrik, dan fasilitas bisnis dengan pengerjaan rapi serta biaya efisien.', 'icon' => 'bi-house-gear-fill'],
                    ['title' => 'Design & Build Arsitektur', 'desc' => 'Layanan terpadu dari konsep desain arsitektur hingga eksekusi fisik bangunan dalam satu pintu.', 'icon' => 'bi-vector-pen'],
                    ['title' => 'Pekerjaan Sipil & MEP', 'desc' => 'Instalasi mekanikal, elektrikal, plumbing, dan perkerasan lantai beton sesuai regulasi keselamatan.', 'icon' => 'bi-lightning-charge-fill'],
                    ['title' => 'Workshop Custom Interior', 'desc' => 'Produksi furniture custom, partisi kantor, dan interior industri berstandar kualitas tinggi.', 'icon' => 'bi-hammer'],
                ];
                ?>
                <?php foreach ($staticOtherServices as $index => $service): ?>
                    <div class="col reveal" style="transition-delay: <?= e((string) (0.15 * ($index + 1))) ?>s;">
                        <div class="other-service-card h-100 p-4 bg-white rounded-4 border shadow-sm transition-all position-relative overflow-hidden d-flex flex-column">
                            <div class="other-service-icon-box mb-4 d-inline-flex align-items-center justify-content-center rounded-3">
                                <i class="bi <?= e($service['icon']) ?>"></i>
                            </div>
                            <h5 class="fw-bold text-navy mb-3 fs-6" style="line-height: 1.4;"><?= e($service['title']) ?></h5>
                            <p class="text-muted text-sm mb-0 flex-grow-1" style="font-size: 0.88rem; line-height: 1.6;"><?= e($service['desc']) ?></p>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>
</section>

<!-- Why Choose Us -->
<section class="py-5 bg-light">
    <div class="container py-4">
        <div class="text-center mb-5 reveal">
            <span class="text-uppercase fw-bold text-danger" style="letter-spacing: 2px; font-size: 0.85rem;">KEUNGGULAN KAMI</span>
            <h2 class="mt-2 display-6 fw-bold text-navy">Mengapa Memilih PT Multi Power Abadi?</h2>
            <p class="text-muted mx-auto" style="max-width: 650px;">Alasan utama mengapa pengembang properti, penyedia logistik, dan perusahaan manufaktur mempercayakan proyek struktur baja mereka kepada kami.</p>
        </div>
        <div class="row g-4 mt-2">
            <?php
            $whyChooseItems = [
                ['icon' => 'bi-patch-check-fill', 'title' => 'Pengalaman Teruji', 'desc' => 'Berpengalaman lebih dari 12 tahun menyelesaikan ratusan gudang logistik, pabrik, dan gedung baja di berbagai kota Indonesia.'],
                ['icon' => 'bi-people-fill', 'title' => 'Tenaga Ahli Berpengalaman', 'desc' => 'Tim engineer struktur, arsitek, dan pengawas proyek terlatih yang mengutamakan ketelitian teknis dan regulasi K3.'],
                ['icon' => 'bi-layers-fill', 'title' => 'Material Standar SNI', 'desc' => 'Hanya menggunakan material baja WF, H-Beam, dan plat baja resmi bergaransi sertifikat uji tarik terpercaya.'],
                ['icon' => 'bi-alarm-fill', 'title' => 'Pengerjaan Tepat Waktu', 'desc' => 'Fasilitas fabrikasi mandiri dan rantai pasok terintegrasi memastikan pengerjaan proyek tepat waktu tanpa *delay*.'],
                ['icon' => 'bi-shield-fill-exclamation', 'title' => 'Standar Keselamatan K3', 'desc' => 'Penerapan Sistem Manajemen K3 ketat untuk mencapai *Zero Accident* dan menjaga keamanan seluruh pekerja lapangan.'],
                ['icon' => 'bi-award-fill', 'title' => 'Garansi & Layanan Purna Jual', 'desc' => 'Jaminan garansi pemeliharaan pasca serah terima untuk memastikan kepuasan dan ketenangan investasi Anda.'],
            ];
            foreach ($whyChooseItems as $index => $item):
                $delay = 0.1 * ($index + 1);
            ?>
            <div class="col-md-6 col-lg-4 reveal" style="transition-delay: <?= e((string) $delay) ?>s; margin-top: 25px;">
                <div class="bg-white p-4 rounded-4 shadow-sm border h-100 transition-hover-card position-relative" style="padding-top: 2.5rem !important;">
                    <div class="why-choose-icon-box rounded-circle shadow d-flex align-items-center justify-content-center position-absolute" style="width: 50px; height: 50px; top: 0; left: 24px; transform: translateY(-50%); z-index: 10; border: 3px solid #ffffff; background-color: #dc2626; color: #ffffff;">
                        <i class="bi <?= e($item['icon']) ?> fs-4"></i>
                    </div>
                    <div>
                        <h4 class="fw-bold text-navy mb-2 fs-5"><?= e($item['title']) ?></h4>
                        <p class="text-muted mb-0 text-sm" style="line-height: 1.6;"><?= e($item['desc']) ?></p>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- Project Showcase Section -->
<section id="projects" class="py-5 bg-light">
    <div class="container py-4">
        <div class="d-flex flex-wrap justify-content-between align-items-end mb-5 reveal">
            <div>
                <span class="text-uppercase fw-bold text-danger" style="letter-spacing: 2px; font-size: 0.85rem;">REKAM JEJAK PROYEK</span>
                <h2 class="mt-2 display-6 fw-bold text-navy">Dokumentasi Proyek Sukses</h2>
                <p class="text-muted mb-0" style="max-width: 600px;">Bukti keandalan struktur baja dan kepuasan klien di berbagai lokasi industri.</p>
            </div>
            <div class="filter-btn-group d-flex flex-wrap gap-2 mt-3 mt-lg-0">
                <button type="button" class="btn filter-btn active" data-filter="all">Semua Proyek</button>
                <button type="button" class="btn filter-btn" data-filter="Mezzanine">Mezzanine</button>
                <button type="button" class="btn filter-btn" data-filter="Gedung">Gedung Industri</button>
            </div>
        </div>

        <div class="row g-4">
            <?php if (!empty($projects)): ?>
                <?php foreach ($projects as $project): ?>
                    <?php
                    $projectImage = $project->image
                        ? storage_asset($project->image)
                        : ($project->category === 'Mezzanine'
                            ? asset('images/konstruksi-mezzanine-kosmetika.jpg')
                            : asset('images/gudang-pabrik.jpg'));
                    $projectDescription = $project->description ?: 'Proyek konstruksi baja berkualitas tinggi yang diselesaikan tepat waktu oleh PT Multi Power Abadi.';
                    ?>
                    <div class="col-md-6 col-lg-4 project-showcase-item reveal" data-category="<?= e($project->category) ?>">
                        <div class="project-card project-card-clickable border rounded-4 overflow-hidden position-relative shadow-sm"
                             style="height: 290px; cursor: pointer;"
                             data-title="<?= e($project->title) ?>"
                             data-category="<?= e($project->category) ?>"
                             data-location="<?= e($project->location) ?>"
                             data-year="<?= e((string) $project->year) ?>"
                             data-description="<?= e($projectDescription) ?>"
                             data-image="<?= e($projectImage) ?>"
                             onclick="openProjectPopup(this)">
                            <img src="<?= e($projectImage) ?>" class="w-100 h-100 object-fit-cover transition-zoom" alt="<?= e($project->title) ?>">
                            <div class="project-card-overlay p-4 position-absolute bottom-0 start-0 w-100 h-100 d-flex flex-column justify-content-end bg-gradient-navy">
                                <span class="project-card-category badge bg-danger text-white fw-semibold text-uppercase text-xs mb-2 align-self-start shadow-sm" style="letter-spacing: 0.8px;"><?= e($project->category) ?></span>
                                <h4 class="project-card-title text-white fw-bold my-1" style="font-size: 1.15rem;"><?= e($project->title) ?></h4>
                                <div class="project-card-location text-white-50 small">
                                    <i class="bi bi-geo-alt-fill text-danger me-1"></i> <?= e($project->location) ?>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <?php
                $staticProjects = [
                    [
                        'title' => 'Konstruksi Mezzanine Industri – PT Kosmetika Global Indonesia',
                        'category' => 'Mezzanine',
                        'location' => 'Rungkut Industri III, Surabaya',
                        'year' => 2024,
                        'description' => 'Pembangunan struktur mezzanine baja heavy-duty untuk perluasan kapasitas ruang operasional pabrik kosmetik tanpa mengganggu alur kerja eksisting.',
                        'image' => asset('images/konstruksi-mezzanine-kosmetika.jpg'),
                    ],
                    [
                        'title' => 'Konstruksi Mezzanine Logistik – PT Hore Indonesia Sehat',
                        'category' => 'Mezzanine',
                        'location' => 'Kawasan Industri Driyorejo, Gresik',
                        'year' => 2025,
                        'description' => 'Pekerjaan rangka baja mezzanine untuk optimalisasi ruang penyimpanan gudang medis berstandar higienitas tinggi.',
                        'image' => asset('images/konstruksi-mezzanine-hore.jpg'),
                    ],
                    [
                        'title' => 'Gedung Kantor Rangka Baja – PT Telekomunikasi Indonesia',
                        'category' => 'Gedung',
                        'location' => 'Margorejo Indah, Surabaya',
                        'year' => 2025,
                        'description' => 'Pembangunan struktur gedung perkantoran bertingkat berbasis rangka baja kuat, presisi, dan selesai tepat waktu.',
                        'image' => asset('images/pembangunan-gedung-telkom.jpg'),
                    ],
                ];
                ?>
                <?php foreach ($staticProjects as $item): ?>
                    <div class="col-md-6 col-lg-4 project-showcase-item reveal" data-category="<?= e($item['category']) ?>">
                        <div class="project-card project-card-clickable border rounded-4 overflow-hidden position-relative shadow-sm"
                             style="height: 280px; cursor: pointer;"
                             data-title="<?= e($item['title']) ?>"
                             data-category="<?= e($item['category']) ?>"
                             data-location="<?= e($item['location']) ?>"
                             data-year="<?= e((string) $item['year']) ?>"
                             data-description="<?= e($item['description']) ?>"
                             data-image="<?= e($item['image']) ?>"
                             onclick="openProjectPopup(this)">
                            <img src="<?= e($item['image']) ?>" class="w-100 h-100 object-fit-cover transition-zoom" alt="<?= e($item['title']) ?>">
                            <div class="project-card-overlay p-4 position-absolute bottom-0 start-0 w-100 h-100 d-flex flex-column justify-content-end bg-gradient-navy">
                                <span class="project-card-category badge bg-danger text-white fw-semibold text-uppercase text-xs mb-2 align-self-start shadow-sm" style="letter-spacing: 0.8px;"><?= e($item['category']) ?></span>
                                <h4 class="project-card-title text-white fw-bold my-1" style="font-size: 1.15rem;"><?= e($item['title']) ?></h4>
                                <div class="project-card-location text-white-50 small">
                                    <i class="bi bi-geo-alt-fill text-danger me-1"></i> <?= e($item['location']) ?>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>
</section>

<!-- Clients Section -->
<section id="clients" class="py-5 bg-light">
    <div class="container py-5">
        <div class="text-center mb-5 reveal">
            <span class="text-uppercase fw-bold text-danger" style="letter-spacing: 2px; font-size: 0.85rem;">MITRA KAMI</span>
            <h2 class="mt-2 display-6 fw-bold text-navy">Dipercaya Oleh Perusahaan Terkemuka</h2>
            <p class="text-muted mx-auto mt-3" style="max-width: 700px; font-size: 0.95rem;">Kami bangga dapat menjalin hubungan kemitraan jangka panjang dengan berbagai BUMN, penyedia logistik, pengembang properti, dan manufaktur skala nasional.</p>
        </div>

        <?php
        $ourClients = [
            ['name' => 'KSB', 'sub' => 'Pumps & Valves', 'color' => '#00529c', 'icon' => 'bi-gear-wide-connected', 'logo' => asset('images/client-ksb.png')],
            ['name' => 'Surya Pertiwi', 'sub' => 'Sanitary & Building', 'color' => '#dc2626', 'icon' => 'bi-brightness-high-fill', 'logo' => asset('images/client-surya-pertiwi.png')],
            ['name' => 'Telkomsel', 'sub' => 'Telecommunication', 'color' => '#ed1d24', 'icon' => 'bi-reception-4', 'logo' => asset('images/client-telkomsel.png')],
            ['name' => 'ABB', 'sub' => 'Power & Automation', 'color' => '#e11d48', 'icon' => 'bi-lightning-charge-fill', 'logo' => asset('images/client-abb.png')],
            ['name' => 'BNN', 'sub' => 'Republik Indonesia', 'color' => '#1e3a8a', 'icon' => 'bi-shield-shaded', 'logo' => asset('images/client-bnn.png')],
            ['name' => 'Kimia Farma', 'sub' => 'Healthcare & Pharma', 'color' => '#0284c7', 'icon' => 'bi-capsule', 'logo' => asset('images/client-kimia-farma.png')],
            ['name' => 'Telkom Landmark', 'sub' => 'Tower & Property', 'color' => '#dc2626', 'icon' => 'bi-building', 'logo' => asset('images/client-telkom-landmark.png')],
            ['name' => 'UNAIR', 'sub' => 'Airlangga University', 'color' => '#d97706', 'icon' => 'bi-mortarboard-fill', 'logo' => asset('images/client-unair.jpg')],
            ['name' => 'Mandiri Taspen', 'sub' => 'Bank Financial', 'color' => '#1e40af', 'icon' => 'bi-bank2', 'logo' => asset('images/client-mandiri-taspen.png')],
            ['name' => 'KB Bukopin', 'sub' => 'Financial Group', 'color' => '#ca8a04', 'icon' => 'bi-wallet2', 'logo' => asset('images/client-kb-bukopin.png')],
            ['name' => 'TOTO', 'sub' => 'Japan Quality', 'color' => '#0f172a', 'icon' => 'bi-droplet-fill', 'logo' => asset('images/client-toto.png')],
            ['name' => 'Indonesia Sehat', 'sub' => 'Medical Center', 'color' => '#16a34a', 'icon' => 'bi-heart-pulse-fill', 'logo' => asset('images/client-indonesia-sehat.png')],
            ['name' => 'ITS', 'sub' => 'Sepuluh Nopember', 'color' => '#0284c7', 'icon' => 'bi-diagram-3-fill', 'logo' => asset('images/client-its.png')],
            ['name' => 'BKI', 'sub' => 'Classification Soc.', 'color' => '#0369a1', 'icon' => 'bi-anchor', 'logo' => asset('images/client-bki.png')],
            ['name' => 'Angkasa Pura', 'sub' => 'Logistics Services', 'color' => '#0284c7', 'icon' => 'bi-airplane-engines-fill', 'logo' => asset('images/client-angkasa-pura.png')],
            ['name' => 'Piranti', 'sub' => 'Engineering', 'color' => '#dc2626', 'icon' => 'bi-tools', 'logo' => asset('images/client-piranti.png')],
            ['name' => 'Tiket.com', 'sub' => 'Travel & Ticketing', 'color' => '#1d6fe8', 'icon' => 'bi-airplane-fill', 'logo' => asset('images/client-tiket.png')],
            ['name' => 'Mitra', 'sub' => 'Partner', 'color' => '#1e3a8a', 'icon' => 'bi-building', 'logo' => asset('images/client-new18.png')],
            ['name' => 'Grounded Event', 'sub' => 'Coach Dr. Fahmi', 'color' => '#d4a800', 'icon' => 'bi-trophy-fill', 'logo' => asset('images/client-grounded-event.png')],
        ];
        ?>

        <div class="row row-cols-2 row-cols-sm-3 row-cols-md-4 row-cols-lg-4 g-4 justify-content-center">
            <?php foreach ($ourClients as $index => $client): ?>
                <?php $delay = ($index % 8) * 0.05; ?>
                <div class="col reveal" style="transition-delay: <?= e((string) $delay) ?>s;">
                    <div class="client-brand-card">
                        <div class="client-card-inner w-100 h-100 d-flex flex-column align-items-center justify-content-center p-3 text-center">
                            <?php if (!empty($client['logo'])): ?>
                                <img src="<?= e($client['logo']) ?>" alt="<?= e($client['name']) ?>" class="img-fluid client-logo-img">
                            <?php else: ?>
                                <div class="d-flex align-items-center justify-content-center rounded-3 mb-2 shadow-sm" style="width: 48px; height: 48px; background: <?= e($client['color']) ?>12; color: <?= e($client['color']) ?>; font-size: 1.4rem;">
                                    <i class="bi <?= e($client['icon']) ?>"></i>
                                </div>
                                <span class="fw-bold text-navy" style="font-size: 0.95rem; letter-spacing: -0.2px; line-height: 1.2;"><?= e($client['name']) ?></span>
                                <span class="text-muted fw-semibold mt-1" style="font-size: 0.65rem; text-transform: uppercase; letter-spacing: 0.5px;"><?= e($client['sub']) ?></span>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- Call to Action Section -->
<section class="py-5 bg-light">
    <div class="container">
        <div class="position-relative overflow-hidden rounded-4 shadow-lg text-center p-4 p-md-5 reveal" style="background-image: url('https://images.unsplash.com/photo-1541888946425-d81bb19240f5?q=80&w=1600&auto=format&fit=crop'); background-size: cover; background-position: center; z-index: 1;">
            <div class="position-absolute top-0 start-0 w-100 h-100" style="background: rgba(15, 23, 42, 0.94); z-index: 2;"></div>
            <div class="position-relative py-2 py-md-3" style="z-index: 3;">
                <span class="badge bg-danger text-white px-3 py-2 rounded-pill text-uppercase mb-3 d-inline-block shadow-sm text-wrap" style="letter-spacing: 1px; max-width: 100%;">KONSULTASI GRATIS &amp; PENAWARAN HARGA</span>
                <h2 class="fs-2 text-white fw-bold mb-3 mx-auto" style="max-width: 680px; line-height: 1.35;">Siap Mewujudkan Proyek Bangunan &amp; Gudang Baja Anda?</h2>
                <p class="lead text-white-50 mb-4 mx-auto" style="max-width: 700px; font-size: 1.05rem; line-height: 1.6;">Dapatkan konsultasi gratis teknis rekayasa struktur dan estimasi penawaran harga terbaik dari tim engineer ahli PT Multi Power Abadi.</p>
                <div class="d-flex flex-wrap justify-content-center gap-3">
                    <a href="<?= e(route('public.quotation')) ?>" class="btn btn-accent btn-lg btn-ripple text-white fw-semibold px-4 shadow">
                        <i class="bi bi-file-earmark-spreadsheet-fill me-2"></i>Minta Penawaran Proyek
                    </a>
                    <a href="https://wa.me/62811272825" target="_blank" rel="noopener noreferrer" class="btn btn-outline-white btn-lg btn-ripple px-4 fw-semibold">
                        <i class="bi bi-whatsapp me-2"></i>Hubungi Tim Kami (WhatsApp)
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>
<?php
$content = ob_get_clean();
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="<?= e(csrf_token()) ?>">
    <link rel="shortcut icon" type="image/png" href="<?= e(asset('images/logo-mpa-favicon.png')) ?>">

    <title><?= e($pageTitle) ?></title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <!-- CSS/JS dari Vite build (setara @vite Laravel) -->
    <?php foreach ($vite['css'] as $cssFile): ?>
    <link rel="stylesheet" href="<?php echo e($cssFile); ?>">
    <?php endforeach; ?>

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
        .page-header-banner {
            background: linear-gradient(135deg, rgba(220, 38, 38, 0.25) 0%, rgba(15, 23, 42, 0.75) 100%), url('/images/page-header-bg.jpg') center/cover no-repeat !important;
        }
        .custom-navbar,
        .custom-navbar.shadow-lg,
        .custom-navbar.scrolled,
        #mainNavbar {
            background-color: #dc2626 !important;
            background: #dc2626 !important;
        }
    </style>

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
    <script>
        if (sessionStorage.getItem('mpa_site_opened')) {
            document.write('<style>#loading-screen { display: none !important; opacity: 0 !important; visibility: hidden !important; }</style>');
        }
    </script>
</head>
<body>

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

    <nav class="navbar navbar-expand-lg custom-navbar fixed-top border-0" id="mainNavbar" style="border: none !important; outline: none !important;">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center me-lg-4" href="<?= e(route('home')) ?>">
                <img src="<?= e(asset('images/logo-mpa-premium.png')) ?>" alt="Logo" class="logo-navbar-img">
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
                        <a class="nav-link <?= route_is('home') ? 'active' : '' ?>" href="<?= e(route('home')) ?>">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?= route_is('public.services.*') ? 'active' : '' ?>" href="<?= e(route('public.services.index')) ?>">Services</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?= route_is('public.projects.*') ? 'active' : '' ?>" href="<?= e(route('public.projects.index')) ?>">Projects</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?= route_is('public.contact') ? 'active' : '' ?>" href="<?= e(route('public.contact')) ?>">Contact</a>
                    </li>
                    <li class="nav-item ms-lg-3 mt-3 mt-lg-0 d-flex align-items-center gap-2">
                        <button type="button" class="theme-toggle-btn d-none d-lg-inline-flex" title="Ganti Mode Tampilan" aria-label="Toggle theme">
                            <i class="bi bi-moon-fill"></i>
                        </button>
                        <a href="<?= e(route('public.quotation')) ?>" class="btn btn-accent btn-ripple text-white px-4 py-2 shadow fw-semibold">
                            Request Quotation
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="page-transition-wrapper" style="padding-top: 0;">
        <?= $content ?>
    </div>

    <a href="https://wa.me/62811272825" target="_blank" rel="noopener noreferrer" class="floating-whatsapp" title="Hubungi Kami di WhatsApp">
        <i class="bi bi-whatsapp"></i>
    </a>

    <button id="back-to-top-btn" class="back-to-top" title="Kembali ke Atas">
        <i class="bi bi-arrow-up-short"></i>
    </button>

    <footer class="custom-footer mt-0" id="mainFooter">
        <div class="footer-bg-overlay"></div>
        <div class="footer-bg-img"></div>
        <div class="container footer-content position-relative">
            <div class="row g-4 g-lg-5 pt-5 pb-4">
                <div class="col-lg-4 col-md-6 footer-col reveal" style="transition-delay:0.1s;">
                    <div class="footer-col-inner">
                        <div class="footer-brand-mark mb-3">
                            <span class="footer-brand-icon"><i class="bi bi-building-fill-gear"></i></span>
                        </div>
                        <h5 class="footer-heading">PT. Multi Power Abadi</h5>
                        <p class="footer-desc">
                            Kontraktor Spesialis Engineering, Fabrikasi Workshop Mandiri, &amp; Steel Erection Berstandar Mutu SNI. Mitra Tepercaya Pembangunan Gudang, Pabrik, &amp; Bangunan Industri Masa Depan.
                        </p>
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
            <div class="footer-bottom-divider"></div>
            <div class="footer-bottom-bar">
                <div class="row align-items-center">
                    <div class="col-md-6 text-center text-md-start mb-2 mb-md-0">
                        <p class="footer-copyright mb-0">
                            &copy; <?= date('Y') ?> <strong>PT Multi Power Abadi</strong>. All rights reserved.
                        </p>
                    </div>
                    <div class="col-md-6 text-center text-md-end">
                        <nav class="footer-bottom-nav" aria-label="Footer bottom navigation">
                            <a href="<?= e(route('home')) ?>">Home</a>
                            <span class="footer-nav-sep">·</span>
                            <a href="<?= e(route('public.services.index')) ?>">Services</a>
                            <span class="footer-nav-sep">·</span>
                            <a href="<?= e(route('public.projects.index')) ?>">Projects</a>
                            <span class="footer-nav-sep">·</span>
                            <a href="<?= e(route('public.contact')) ?>">Contact</a>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </footer>

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

    <?php foreach ($vite['js'] as $jsFile): ?>
    <script src="<?php echo e($jsFile); ?>" defer></script>
    <?php endforeach; ?>

    <script>
        (function () {
            const navbar = document.getElementById('mainNavbar');
            if (!navbar) return;
            const onScroll = () => {
                navbar.classList.toggle('scrolled', window.scrollY > 60);
            };
            window.addEventListener('scroll', onScroll, { passive: true });
            onScroll();
        })();

        (function () {
            const revealEls = document.querySelectorAll('.reveal, .reveal-heading');
            if (!revealEls.length) return;
            const observer = new IntersectionObserver((entries) => {
                entries.forEach((entry) => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('revealed');
                        observer.unobserve(entry.target);
                    }
                });
            }, {
                threshold: 0.12,
                rootMargin: '0px 0px -50px 0px'
            });
            revealEls.forEach((el) => observer.observe(el));
        })();

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
                    hue: Math.random() < 0.6 ? 0 : 15
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

        function showToast(message, isSuccess = true) {
            const toastEl = document.getElementById('statusToast');
            const toastMessage = document.getElementById('toastMessage');
            toastMessage.textContent = message;
            toastEl.style.backgroundColor = isSuccess ? '#0F2D5C' : '#dc3545';
            const toast = new bootstrap.Toast(toastEl);
            toast.show();
        }

        <?php
        $flashSuccess = session_get('success');
        $flashError = session_get('error');
        if ($flashSuccess !== null) :
        ?>
        document.addEventListener('DOMContentLoaded', () => {
            showToast(<?php echo json_encode($flashSuccess, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP); ?>, true);
        });
        <?php endif; ?>
        <?php if ($flashError !== null) : ?>
        document.addEventListener('DOMContentLoaded', () => {
            showToast(<?php echo json_encode($flashError, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP); ?>, false);
        });
        <?php endif; ?>
    </script>

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
