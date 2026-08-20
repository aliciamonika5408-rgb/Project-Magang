<?php
/**
 * resources/views/admin/clients/create.php
 * ─────────────────────────────────────────────────────────────────────────────
 * Form Tambah Partner / Klien Baru Admin PHP Native PT Multi Power Abadi.
 * Konversi dari create.blade.php — 100% PHP Native tanpa Laravel/Blade.
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
$old    = [
    'name'        => '',
    'website_url' => '',
];

// ── Proses Submit Form ────────────────────────────────────────────────────────
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $submittedToken = $_POST['_token'] ?? '';
    if (!auth_verify_csrf($submittedToken)) {
        $errors[] = 'Token keamanan tidak valid. Silakan coba lagi.';
    } else {
        $name       = trim($_POST['name'] ?? '');
        $websiteUrl = trim($_POST['website_url'] ?? '');

        $old['name']        = $name;
        $old['website_url'] = $websiteUrl;

        // Validasi input
        if (empty($name)) $errors[] = 'Nama Perusahaan / Partner wajib diisi.';

        // Handle Mandatory Logo Upload
        $logoPath = null;
        if (isset($_FILES['logo']) && $_FILES['logo']['error'] === UPLOAD_ERR_OK) {
            $tmpName      = $_FILES['logo']['tmp_name'];
            $originalName = $_FILES['logo']['name'];
            $ext          = strtolower(pathinfo($originalName, PATHINFO_EXTENSION));
            $allowedExts   = ['jpg', 'jpeg', 'png', 'webp', 'svg', 'gif'];

            if (!in_array($ext, $allowedExts, true)) {
                $errors[] = 'Format file logo harus berupa JPG, JPEG, PNG, WEBP, SVG, atau GIF.';
            } elseif ($_FILES['logo']['size'] > 5 * 1024 * 1024) {
                $errors[] = 'Ukuran file logo maksimal 5MB.';
            } else {
                $newFileName = 'client_' . time() . '_' . bin2hex(random_bytes(4)) . '.' . $ext;
                $destPublic  = $appRoot . '/public/storage/clients/' . $newFileName;
                $destStorage = $appRoot . '/storage/app/public/clients/' . $newFileName;

                @mkdir(dirname($destPublic), 0777, true);
                @mkdir(dirname($destStorage), 0777, true);

                if (move_uploaded_file($tmpName, $destPublic)) {
                    @copy($destPublic, $destStorage);
                    $logoPath = 'clients/' . $newFileName;
                } else {
                    $errors[] = 'Gagal mengunggah file logo perusahan.';
                }
            }
        } else {
            $errors[] = 'File logo perusahaan wajib diunggah.';
        }

        if (empty($errors) && $logoPath !== null) {
            try {
                $now = db_now();
                db_insert_row('clients', [
                    'name'        => $name,
                    'logo_path'   => $logoPath,
                    'website_url' => !empty($websiteUrl) ? $websiteUrl : null,
                    'created_at'  => $now,
                    'updated_at'  => $now,
                ]);

                $_SESSION['success'] = 'Partner "' . htmlspecialchars($name, ENT_QUOTES, 'UTF-8') . '" berhasil ditambahkan!';
                header('Location: ' . route('admin.clients.index'));
                exit;
            } catch (Throwable $e) {
                $errors[] = 'Terjadi kesalahan database: ' . $e->getMessage();
            }
        }
    }
}

$pageTitle       = 'Tambah Partner - Admin Dashboard';
$headerPageTitle = 'Tambah Partner Baru';
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

                <div class="mb-4">
                    <a href="<?= e(route('admin.clients.index')) ?>" class="btn btn-outline-secondary fw-semibold">
                        <i class="bi bi-arrow-left me-1"></i> Kembali ke Daftar Partner
                    </a>
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

                <div class="card border-0 shadow-sm rounded-3">
                    <div class="card-header bg-white py-3">
                        <h5 class="card-title text-navy mb-0 fw-bold"><i class="bi bi-plus-circle-fill me-2 text-warning"></i>Form Partner Baru</h5>
                    </div>
                    <div class="card-body p-4">
                        <form action="<?= e(route('admin.clients.create')) ?>" method="POST" enctype="multipart/form-data">
                            <input type="hidden" name="_token" value="<?= e($csrfToken) ?>">
                            <div class="row g-4">
                                <!-- Name -->
                                <div class="col-12">
                                    <label for="name" class="form-label fw-semibold text-navy">Nama Perusahaan / Partner *</label>
                                    <input type="text" name="name" id="name" class="form-control" placeholder="Contoh: PT Logistik Indonesia" required value="<?= e($old['name']) ?>">
                                </div>

                                <!-- Website URL -->
                                <div class="col-12">
                                    <label for="website_url" class="form-label fw-semibold text-navy">Alamat Website Perusahaan (Opsional)</label>
                                    <input type="url" name="website_url" id="website_url" class="form-control" placeholder="https://example.com" value="<?= e($old['website_url']) ?>">
                                </div>

                                <!-- Brand Logo Image -->
                                <div class="col-12">
                                    <label for="logo" class="form-label fw-semibold text-navy">File Logo Perusahaan *</label>
                                    <input type="file" name="logo" id="logo" class="form-control" accept="image/*" required>
                                    <span class="text-xs text-muted">Format: JPG, PNG, SVG, WEBP. Maksimal ukuran file: 5MB</span>
                                </div>

                                <!-- Buttons -->
                                <div class="col-12 mt-4 border-top pt-3 text-end">
                                    <a href="<?= e(route('admin.clients.index')) ?>" class="btn btn-outline-secondary me-2">Batal</a>
                                    <button type="submit" class="btn btn-navy text-white fw-bold px-4">Simpan Partner</button>
                                </div>
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
