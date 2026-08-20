<?php
/**
 * resources/views/admin/other_services/index.php
 * ─────────────────────────────────────────────────────────────────────────────
 * Halaman Daftar Layanan Lainnya (Dukungan) Admin PHP Native PT Multi Power Abadi.
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

// ── Proses POST Action: Delete Other Service ─────────────────────────────────
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['_action'] ?? ($_POST['_method'] ?? '');
    if (strtoupper($action) === 'DELETE') {
        $submittedToken = $_POST['_token'] ?? '';
        if (!auth_verify_csrf($submittedToken)) {
            $_SESSION['error'] = 'Token keamanan tidak valid. Silakan coba lagi.';
        } else {
            $otherServiceId = (int) ($_POST['id'] ?? 0);
            if ($otherServiceId > 0) {
                try {
                    $service = db_find('SELECT * FROM other_services WHERE id = ?', [$otherServiceId]);
                    if ($service) {
                        db_execute('DELETE FROM other_services WHERE id = ?', [$otherServiceId]);
                        $_SESSION['success'] = 'Layanan lainnya "' . htmlspecialchars($service['title'], ENT_QUOTES, 'UTF-8') . '" berhasil dihapus.';
                    } else {
                        $_SESSION['error'] = 'Layanan tidak ditemukan.';
                    }
                } catch (Throwable $e) {
                    $_SESSION['error'] = 'Gagal menghapus layanan: ' . $e->getMessage();
                }
            }
        }
        header('Location: ' . route('admin.other-services.index'));
        exit;
    }
}

// ── Ambil Data Layanan Lainnya dari Database ──────────────────────────────────
$otherServices = [];
try {
    $otherServices = db_select('SELECT * FROM other_services ORDER BY created_at DESC');
} catch (Throwable $e) {
    $_SESSION['error'] = 'Gagal mengambil data layanan lainnya: ' . $e->getMessage();
}

$pageTitle       = 'Kelola Layanan Lainnya - Admin PT Multi Power Abadi';
$headerPageTitle = 'Kelola Layanan Lainnya (Dukungan)';
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
        .uppercase { text-transform: uppercase; }
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

                <div class="d-flex justify-content-between align-items-center mb-4">
                    <p class="text-muted mb-0">Daftar layanan konstruksi dukungan & interior yang ditampilkan pada bagian 'Layanan Lainnya'.</p>
                    <a href="<?= e(route('admin.other-services.create')) ?>" class="btn btn-warning fw-semibold shadow-sm text-navy">
                        <i class="bi bi-plus-lg me-1"></i> Tambah Layanan Lainnya
                    </a>
                </div>

                <div class="card border-0 shadow-sm rounded-3">
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover table-striped align-middle mb-0">
                                <thead class="table-light text-navy fw-bold text-xs uppercase">
                                    <tr>
                                        <th class="ps-4">Judul Layanan</th>
                                        <th>Deskripsi</th>
                                        <th class="text-end pe-4" style="width: 170px;">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (!empty($otherServices)): ?>
                                        <?php foreach ($otherServices as $service): ?>
                                            <?php
                                            $osId = $service['id'];
                                            $osTitle = $service['title'];
                                            $osDesc = mb_strimwidth((string)($service['description'] ?? ''), 0, 100, '...');
                                            ?>
                                            <tr>
                                                <td class="ps-4">
                                                    <div class="fw-bold text-navy fs-6"><?= e($osTitle) ?></div>
                                                </td>
                                                <td style="max-width: 400px;">
                                                    <p class="text-muted text-sm mb-0"><?= e($osDesc) ?></p>
                                                </td>
                                                <td class="text-end pe-4">
                                                    <div class="btn-group">
                                                        <a href="<?= e(route('admin.other-services.edit', ['id' => $osId])) ?>" class="btn btn-sm btn-outline-primary" title="Edit">
                                                            <i class="bi bi-pencil-square"></i> Edit
                                                        </a>
                                                        <form action="<?= e(route('admin.other-services.destroy')) ?>" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus layanan ini?');">
                                                            <input type="hidden" name="_token" value="<?= e($csrfToken) ?>">
                                                            <input type="hidden" name="_action" value="DELETE">
                                                            <input type="hidden" name="id" value="<?= e((string) $osId) ?>">
                                                            <button type="submit" class="btn btn-sm btn-outline-danger" title="Hapus">
                                                                <i class="bi bi-trash"></i> Hapus
                                                            </button>
                                                        </form>
                                                    </div>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <tr>
                                            <td colspan="3" class="text-center py-5 text-muted">
                                                <i class="bi bi-inbox fs-1 d-block mb-2 text-secondary"></i>
                                                Belum ada data Layanan Lainnya. Klik tombol di atas untuk menambah data baru.
                                            </td>
                                        </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>

    <!-- Bootstrap 5 JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
