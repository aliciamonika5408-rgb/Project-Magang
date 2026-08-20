<?php
/**
 * resources/views/admin/services/create.php
 * ─────────────────────────────────────────────────────────────────────────────
 * Form Tambah Layanan Baru Admin PHP Native PT Multi Power Abadi.
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
    'title'       => '',
    'icon'        => 'bi-building',
    'description' => '',
    'content'     => '',
];

// ── Proses Submit Form ────────────────────────────────────────────────────────
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $submittedToken = $_POST['_token'] ?? '';
    if (!auth_verify_csrf($submittedToken)) {
        $errors[] = 'Token keamanan tidak valid. Silakan coba lagi.';
    } else {
        $title       = trim($_POST['title'] ?? '');
        $icon        = trim($_POST['icon'] ?? 'bi-building');
        $description = trim($_POST['description'] ?? '');
        $content     = trim($_POST['content'] ?? '');

        $old['title']       = $title;
        $old['icon']        = $icon;
        $old['description'] = $description;
        $old['content']     = $content;

        // Validasi input
        if (empty($title))       $errors[] = 'Nama Layanan wajib diisi.';
        if (empty($description)) $errors[] = 'Deskripsi Singkat wajib diisi.';
        if (empty($icon))        $icon = 'bi-building';

        // Handle Image Upload
        $imagePath = null;
        if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
            $tmpName      = $_FILES['image']['tmp_name'];
            $originalName = $_FILES['image']['name'];
            $ext          = strtolower(pathinfo($originalName, PATHINFO_EXTENSION));
            $allowedExts   = ['jpg', 'jpeg', 'png', 'webp', 'gif'];

            if (!in_array($ext, $allowedExts, true)) {
                $errors[] = 'Format gambar harus berupa JPG, JPEG, PNG, WEBP, atau GIF.';
            } elseif ($_FILES['image']['size'] > 5 * 1024 * 1024) {
                $errors[] = 'Ukuran gambar maksimal 5MB.';
            } else {
                $newFileName = 'service_' . time() . '_' . bin2hex(random_bytes(4)) . '.' . $ext;
                $destPublic  = $appRoot . '/public/storage/services/' . $newFileName;
                $destStorage = $appRoot . '/storage/app/public/services/' . $newFileName;

                @mkdir(dirname($destPublic), 0777, true);
                @mkdir(dirname($destStorage), 0777, true);

                if (move_uploaded_file($tmpName, $destPublic)) {
                    @copy($destPublic, $destStorage);
                    $imagePath = 'services/' . $newFileName;
                } else {
                    $errors[] = 'Gagal mengunggah gambar layanan.';
                }
            }
        } elseif (isset($_FILES['image']) && $_FILES['image']['error'] !== UPLOAD_ERR_NO_FILE) {
            $errors[] = 'Terjadi kesalahan saat mengunggah gambar.';
        }

        if (empty($errors)) {
            try {
                // Generate slug
                $slug = native_slug($title);
                $existingSlug = db_scalar('SELECT COUNT(*) FROM services WHERE slug = ?', [$slug]);
                if ((int)$existingSlug > 0) {
                    $slug .= '-' . time();
                }

                $now = db_now();
                db_insert_row('services', [
                    'title'       => $title,
                    'slug'        => $slug,
                    'description' => $description,
                    'content'     => !empty($content) ? $content : null,
                    'icon'        => $icon,
                    'image'       => $imagePath,
                    'created_at'  => $now,
                    'updated_at'  => $now,
                ]);

                $_SESSION['success'] = 'Layanan "' . htmlspecialchars($title, ENT_QUOTES, 'UTF-8') . '" berhasil ditambahkan!';
                header('Location: ' . route('admin.services.index'));
                exit;
            } catch (Throwable $e) {
                $errors[] = 'Terjadi kesalahan database: ' . $e->getMessage();
            }
        }
    }
}

$pageTitle       = 'Tambah Layanan - Admin Dashboard';
$headerPageTitle = 'Tambah Layanan Konstruksi Baru';
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
                            <a class="nav-link active" href="<?= e(route('admin.services.index')) ?>">
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
                    <a href="<?= e(route('admin.services.index')) ?>" class="btn btn-outline-secondary fw-semibold">
                        <i class="bi bi-arrow-left me-1"></i> Kembali ke Daftar Layanan
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
                        <h5 class="card-title text-navy mb-0 fw-bold"><i class="bi bi-plus-circle-fill me-2 text-warning"></i>Form Layanan Baru</h5>
                    </div>
                    <div class="card-body p-4">
                        <form action="<?= e(route('admin.services.create')) ?>" method="POST" enctype="multipart/form-data">
                            <input type="hidden" name="_token" value="<?= e($csrfToken) ?>">
                            <div class="row g-4">
                                <!-- Title -->
                                <div class="col-md-8">
                                    <label for="title" class="form-label fw-semibold text-navy">Nama Layanan *</label>
                                    <input type="text" name="title" id="title" class="form-control" placeholder="Contoh: Konstruksi Gudang Bentang Lebar" required value="<?= e($old['title']) ?>">
                                </div>

                                <!-- Icon -->
                                <div class="col-md-4">
                                    <label for="icon" class="form-label fw-semibold text-navy">Icon Class Bootstrap Icons *</label>
                                    <input type="text" name="icon" id="icon" class="form-control" placeholder="Contoh: bi-building" required value="<?= e($old['icon']) ?>">
                                    <span class="text-xs text-muted">Lihat kelas di <a href="https://icons.getbootstrap.com/" target="_blank">Bootstrap Icons</a></span>
                                </div>

                                <!-- Short Description -->
                                <div class="col-12">
                                    <label for="description" class="form-label fw-semibold text-navy">Deskripsi Singkat *</label>
                                    <textarea name="description" id="description" class="form-control" rows="3" placeholder="Tulis deskripsi singkat untuk kartu beranda..." required><?= e($old['description']) ?></textarea>
                                </div>

                                <!-- Content -->
                                <div class="col-12">
                                    <label for="content" class="form-label fw-semibold text-navy">Detail Isi Layanan / Cakupan Pekerjaan</label>
                                    <textarea name="content" id="content" class="form-control" rows="6" placeholder="Masukkan poin cakupan pekerjaan atau penjelasan mendalam tentang pengerjaan... HTML diperbolehkan."><?= e($old['content']) ?></textarea>
                                </div>

                                <!-- Featured Image -->
                                <div class="col-12">
                                    <label for="image" class="form-label fw-semibold text-navy">Gambar Utama / Foto Banner</label>
                                    <input type="file" name="image" id="image" class="form-control" accept="image/*">
                                    <span class="text-xs text-muted">Format: JPG, PNG, WEBP. Ukuran file maksimal: 5MB</span>
                                </div>

                                <!-- Buttons -->
                                <div class="col-12 mt-4 border-top pt-3 text-end">
                                    <a href="<?= e(route('admin.services.index')) ?>" class="btn btn-outline-secondary me-2">Batal</a>
                                    <button type="submit" class="btn btn-navy text-white fw-bold px-4">Simpan Layanan</button>
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
