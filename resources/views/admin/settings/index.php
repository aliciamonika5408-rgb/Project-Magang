<?php
/**
 * resources/views/admin/settings/index.php
 * ─────────────────────────────────────────────────────────────────────────────
 * Halaman Pengaturan Statistik Perusahaan Admin PHP Native PT MPA.
 * Konversi dari index.blade.php — 100% PHP Native tanpa Laravel/Blade.
 *
 * Proteksi: auth_require() pada baris teratas.
 * ─────────────────────────────────────────────────────────────────────────────
 */

declare(strict_types=1);

$appRoot = dirname(__DIR__, 4);
require_once $appRoot . '/native/db.php';
require_once $appRoot . '/native/auth.php';
require_once dirname(__DIR__, 2) . '/native_helpers.php';

// ── Proteksi Halaman Admin ───────────────────────────────────────────────────
auth_require();

$currentUser = auth_user();
$userName    = $currentUser['name'] ?? 'Admin MPA';

$errors = [];

// ── Proses POST Submit Pengaturan ───────────────────────────────────────────
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $submittedToken = $_POST['_token'] ?? '';
    if (!auth_verify_csrf($submittedToken)) {
        $errors[] = 'Token keamanan tidak valid. Silakan coba lagi.';
    } else {
        $yearsExperience  = trim($_POST['years_experience'] ?? '15');
        $projectsCompleted = trim($_POST['projects_completed'] ?? '150');
        $expertsCount     = trim($_POST['experts_count'] ?? '50');
        $workAccidents    = trim($_POST['work_accidents'] ?? '0');

        if (empty($yearsExperience))  $errors[] = 'Tahun Pengalaman wajib diisi.';
        if (empty($projectsCompleted)) $errors[] = 'Proyek Selesai wajib diisi.';
        if (empty($expertsCount))     $errors[] = 'Tenaga Ahli wajib diisi.';
        if ($workAccidents === '')    $errors[] = 'Kecelakaan Kerja wajib diisi.';

        if (empty($errors)) {
            try {
                $now = db_now();
                $dataToSave = [
                    'years_experience'   => $yearsExperience,
                    'projects_completed' => $projectsCompleted,
                    'experts_count'      => $expertsCount,
                    'work_accidents'     => $workAccidents,
                ];

                foreach ($dataToSave as $key => $val) {
                    $exists = db_scalar('SELECT COUNT(*) FROM company_settings WHERE key = ?', [$key]);
                    if ((int)$exists > 0) {
                        db_execute('UPDATE company_settings SET value = ?, updated_at = ? WHERE key = ?', [$val, $now, $key]);
                    } else {
                        db_insert_row('company_settings', [
                            'key'        => $key,
                            'value'      => $val,
                            'created_at' => $now,
                            'updated_at' => $now,
                        ]);
                    }
                }

                $_SESSION['success'] = 'Pengaturan statistik perusahaan berhasil diperbarui!';
                header('Location: ' . route('admin.settings.index'));
                exit;
            } catch (Throwable $e) {
                $errors[] = 'Gagal menyimpan pengaturan: ' . $e->getMessage();
            }
        }
    }
}

// ── Ambil Data company_settings dari Database ────────────────────────────────
$settings = [];
try {
    $settingsRaw = db_select('SELECT * FROM company_settings');
    foreach ($settingsRaw as $s) {
        $settings[$s['key']] = $s['value'];
    }
} catch (Throwable $e) {
    $_SESSION['error'] = 'Gagal mengambil data pengaturan: ' . $e->getMessage();
}

$pageTitle       = 'Kelola Statistik Perusahaan - Admin PT Multi Power Abadi';
$headerPageTitle = 'Kelola Statistik & Angka Perusahaan';
$csrfToken       = auth_csrf_token();
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="<?= e($csrfToken) ?>">
    <link rel="shortcut icon" type="image/png" href="<?= e(asset('images/logo-mpa-favicon.png')) ?>">

    <title><?= e($pageTitle) ?></title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <!-- Bootstrap 5 CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">

    <!-- Custom Admin Styles -->
    <style>
        body { font-family: 'Poppins', sans-serif; }
        .text-navy { color: #0f2d5c !important; }
        .btn-navy { background-color: #0f2d5c; color: #ffffff; }
        .btn-navy:hover { background-color: #0b2247; color: #ffffff; }
        .admin-sidebar { background-color: #0f172a; min-height: 100vh; }
        .admin-sidebar .nav-link {
            color: rgba(255, 255, 255, 0.75);
            padding: 0.75rem 1.25rem;
            font-weight: 500;
            transition: all 0.2s ease;
        }
        .admin-sidebar .nav-link:hover,
        .admin-sidebar .nav-link.active {
            color: #ffffff;
            background-color: rgba(255, 255, 255, 0.1);
        }
        .text-xs { font-size: 0.75rem; }
    </style>
</head>
<body class="bg-light">

    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar Panel -->
            <nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block admin-sidebar collapse position-fixed top-0 start-0 h-100 p-0 shadow-lg" style="z-index: 1000; overflow-y: auto;">
                <div class="sidebar-heading text-center py-4 bg-danger">
                    <span class="fs-5 fw-bold text-white"><i class="bi bi-house-door-fill text-warning me-2"></i><span style="color: #ffffff">Multi</span> <span class="text-warning">Power</span> Admin</span>
                </div>
                <div class="position-sticky pt-3">
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link" href="<?= e(route('dashboard')) ?>">
                                <i class="bi bi-speedometer2 me-2 text-warning"></i> Dashboard
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?= e(route('admin.home-editor')) ?>">
                                <i class="bi bi-house-door me-2"></i> Home
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?= e(route('admin.services.index')) ?>">
                                <i class="bi bi-building me-2"></i> Services
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?= e(route('admin.projects.index')) ?>">
                                <i class="bi bi-images me-2"></i> Projects
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?= e(route('admin.contacts.index')) ?>">
                                <i class="bi bi-envelope me-2"></i> Contact
                            </a>
                        </li>
                        <li class="nav-item mt-4 border-top pt-3 border-secondary">
                            <a class="nav-link text-white-50" href="<?= e(route('home')) ?>" target="_blank">
                                <i class="bi bi-box-arrow-up-right me-2"></i> Lihat Website
                            </a>
                        </li>
                        <li class="nav-item mt-2">
                            <form method="POST" action="<?= e(route('logout')) ?>">
                                <input type="hidden" name="_token" value="<?= e($csrfToken) ?>">
                                <button type="submit" class="nav-link border-0 bg-transparent w-100 text-start" style="color: #ff9999 !important;">
                                    <i class="bi bi-power me-2"></i> Keluar (Logout)
                                </button>
                            </form>
                        </li>
                    </ul>
                </div>
            </nav>

            <!-- Main Panel Content -->
            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 py-4" style="margin-left: auto;">
                <!-- Header bar -->
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                    <h1 class="h2 text-navy fw-bold"><?= e($headerPageTitle) ?></h1>
                    <div class="btn-toolbar mb-2 mb-md-0 d-flex align-items-center gap-2">
                        <div class="btn-group">
                            <span class="btn btn-sm btn-outline-secondary border-0 text-navy fw-semibold">
                                <i class="bi bi-person-fill text-warning me-2"></i><?= e($userName) ?>
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Toast Notifications / Session Flash -->
                <?php if (isset($_SESSION['success'])): ?>
                    <div class="alert alert-success alert-dismissible fade show rounded-3 shadow-sm border-0 mb-4" role="alert">
                        <i class="bi bi-check-circle-fill me-2"></i><?= e($_SESSION['success']) ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                    <?php unset($_SESSION['success']); ?>
                <?php endif; ?>
                <?php if (isset($_SESSION['error'])): ?>
                    <div class="alert alert-danger alert-dismissible fade show rounded-3 shadow-sm border-0 mb-4" role="alert">
                        <i class="bi bi-exclamation-triangle-fill me-2"></i><?= e($_SESSION['error']) ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                    <?php unset($_SESSION['error']); ?>
                <?php endif; ?>

                <div class="mb-4">
                    <a href="<?= e(route('admin.home-editor')) ?>" class="btn btn-outline-secondary fw-semibold">
                        <i class="bi bi-arrow-left me-1"></i> Kembali ke Home Editor
                    </a>
                </div>

                <div class="mb-4">
                    <p class="text-muted">Ubah nilai angka statistik perusahaan yang tampil pada halaman depan website (Tahun Pengalaman, Proyek Selesai, Tenaga Ahli, dan Kecelakaan Kerja).</p>
                </div>

                <!-- Error Alert -->
                <?php if (!empty($errors)): ?>
                    <div class="alert alert-danger alert-dismissible fade show rounded-3 shadow-sm border-0 mb-4" role="alert">
                        <div class="fw-bold mb-1"><i class="bi bi-exclamation-triangle-fill me-2"></i>Mohon perbaiki kesalahan berikut:</div>
                        <ul class="mb-0 ps-3">
                            <?php foreach ($errors as $err): ?>
                                <li><?= e($err) ?></li>
                            <?php endforeach; ?>
                        </ul>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php endif; ?>

                <div class="card border-0 shadow-sm rounded-4">
                    <div class="card-body p-4 p-md-5">
                        <form action="<?= e(route('admin.settings.update')) ?>" method="POST">
                            <input type="hidden" name="_token" value="<?= e($csrfToken) ?>">

                            <div class="row g-4">
                                <!-- Tahun Pengalaman -->
                                <div class="col-md-6">
                                    <div class="card border bg-light h-100 p-3">
                                        <div class="d-flex align-items-center gap-3 mb-3">
                                            <div class="bg-warning bg-opacity-20 text-warning p-3 rounded-3 fs-3">
                                                <i class="bi bi-calendar-check-fill"></i>
                                            </div>
                                            <div>
                                                <label for="years_experience" class="form-label fw-bold text-navy mb-0">Tahun Pengalaman</label>
                                                <small class="text-muted d-block">Lama perusahaan beroperasi di bidang konstruksi</small>
                                            </div>
                                        </div>
                                        <div class="input-group">
                                            <input type="text" class="form-control form-control-lg fw-bold text-navy" id="years_experience" name="years_experience" value="<?= e($settings['years_experience'] ?? '15') ?>" required placeholder="Contoh: 15">
                                            <span class="input-group-text bg-white fw-bold">Tahun</span>
                                        </div>
                                    </div>
                                </div>

                                <!-- Proyek Selesai -->
                                <div class="col-md-6">
                                    <div class="card border bg-light h-100 p-3">
                                        <div class="d-flex align-items-center gap-3 mb-3">
                                            <div class="bg-navy bg-opacity-10 text-navy p-3 rounded-3 fs-3">
                                                <i class="bi bi-building-check"></i>
                                            </div>
                                            <div>
                                                <label for="projects_completed" class="form-label fw-bold text-navy mb-0">Proyek Selesai</label>
                                                <small class="text-muted d-block">Jumlah proyek konstruksi baja & gedung yang telah dirampungkan</small>
                                            </div>
                                        </div>
                                        <div class="input-group">
                                            <input type="text" class="form-control form-control-lg fw-bold text-navy" id="projects_completed" name="projects_completed" value="<?= e($settings['projects_completed'] ?? '150') ?>" required placeholder="Contoh: 150">
                                            <span class="input-group-text bg-white fw-bold">Proyek</span>
                                        </div>
                                    </div>
                                </div>

                                <!-- Tenaga Ahli -->
                                <div class="col-md-6">
                                    <div class="card border bg-light h-100 p-3">
                                        <div class="d-flex align-items-center gap-3 mb-3">
                                            <div class="bg-primary bg-opacity-10 text-primary p-3 rounded-3 fs-3">
                                                <i class="bi bi-people-fill"></i>
                                            </div>
                                            <div>
                                                <label for="experts_count" class="form-label fw-bold text-navy mb-0">Tenaga Ahli</label>
                                                <small class="text-muted d-block">Jumlah engineer, arsitek & pengawas profesional</small>
                                            </div>
                                        </div>
                                        <div class="input-group">
                                            <input type="text" class="form-control form-control-lg fw-bold text-navy" id="experts_count" name="experts_count" value="<?= e($settings['experts_count'] ?? '50') ?>" required placeholder="Contoh: 50">
                                            <span class="input-group-text bg-white fw-bold">Orang</span>
                                        </div>
                                    </div>
                                </div>

                                <!-- Kecelakaan Kerja -->
                                <div class="col-md-6">
                                    <div class="card border bg-light h-100 p-3">
                                        <div class="d-flex align-items-center gap-3 mb-3">
                                            <div class="bg-success bg-opacity-10 text-success p-3 rounded-3 fs-3">
                                                <i class="bi bi-shield-fill-check"></i>
                                            </div>
                                            <div>
                                                <label for="work_accidents" class="form-label fw-bold text-navy mb-0">Kecelakaan Kerja (K3)</label>
                                                <small class="text-muted d-block">Metrik keselamatan kerja K3 (Zero Accident)</small>
                                            </div>
                                        </div>
                                        <div class="input-group">
                                            <input type="text" class="form-control form-control-lg fw-bold text-navy" id="work_accidents" name="work_accidents" value="<?= e($settings['work_accidents'] ?? '0') ?>" required placeholder="Contoh: 0">
                                            <span class="input-group-text bg-white fw-bold">Kasus</span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <hr class="my-4">

                            <div class="d-flex justify-content-end gap-2">
                                <button type="submit" class="btn btn-warning px-5 py-2.5 fw-bold text-navy shadow-sm">
                                    <i class="bi bi-check-circle-fill me-2"></i> Simpan Perubahan Statistik
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </main>
        </div>
    </div>

    <!-- Bootstrap 5 JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
