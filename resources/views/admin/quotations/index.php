<?php
/**
 * resources/views/admin/quotations/index.php
 * ─────────────────────────────────────────────────────────────────────────────
 * Halaman Daftar Pengajuan Quotation (Penawaran Proyek) Admin PHP Native MPA.
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

// ── Proses POST Action: Delete Quotation ──────────────────────────────────────
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['_action'] ?? ($_POST['_method'] ?? '');
    if (strtoupper($action) === 'DELETE') {
        $submittedToken = $_POST['_token'] ?? '';
        if (!auth_verify_csrf($submittedToken)) {
            $_SESSION['error'] = 'Token keamanan tidak valid. Silakan coba lagi.';
        } else {
            $quotationId = (int) ($_POST['id'] ?? 0);
            if ($quotationId > 0) {
                try {
                    $quotation = db_find('SELECT * FROM request_quotations WHERE id = ?', [$quotationId]);
                    if ($quotation) {
                        db_execute('DELETE FROM request_quotations WHERE id = ?', [$quotationId]);
                        $_SESSION['success'] = 'Pengajuan quotation dari "' . htmlspecialchars($quotation['name'], ENT_QUOTES, 'UTF-8') . '" berhasil dihapus.';
                    } else {
                        $_SESSION['error'] = 'Pengajuan quotation tidak ditemukan.';
                    }
                } catch (Throwable $e) {
                    $_SESSION['error'] = 'Gagal menghapus quotation: ' . $e->getMessage();
                }
            }
        }
        header('Location: ' . route('admin.quotations.index'));
        exit;
    }
}

// ── Status Filter ─────────────────────────────────────────────────────────────
$statusFilter = strtolower(trim($_GET['status'] ?? 'all'));
$allowedStatuses = ['pending', 'reviewed', 'approved', 'rejected'];

$quotations = [];
try {
    if (in_array($statusFilter, $allowedStatuses, true)) {
        $quotations = db_select('SELECT * FROM request_quotations WHERE status = ? ORDER BY created_at DESC', [$statusFilter]);
    } else {
        $statusFilter = 'all';
        $quotations   = db_select('SELECT * FROM request_quotations ORDER BY created_at DESC');
    }
} catch (Throwable $e) {
    $_SESSION['error'] = 'Gagal mengambil data quotation: ' . $e->getMessage();
}

$pageTitle       = 'Kelola Quotation - Admin Dashboard';
$headerPageTitle = 'Pengajuan Penawaran Proyek (Quotation)';
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

                <!-- Filter Bar -->
                <div class="card border-0 shadow-sm rounded-3 mb-4">
                    <div class="card-body py-3 d-flex justify-content-between align-items-center">
                        <h5 class="card-title text-navy mb-0 fw-bold"><i class="bi bi-file-earmark-spreadsheet-fill text-warning me-2"></i>Filter Status</h5>
                        <div class="d-flex gap-2">
                            <a href="<?= e(route('admin.quotations.index', ['status' => 'all'])) ?>" class="btn btn-sm btn-outline-navy <?= $statusFilter === 'all' ? 'active' : '' ?>">Semua</a>
                            <a href="<?= e(route('admin.quotations.index', ['status' => 'pending'])) ?>" class="btn btn-sm btn-outline-warning <?= $statusFilter === 'pending' ? 'active' : '' ?>">Pending</a>
                            <a href="<?= e(route('admin.quotations.index', ['status' => 'reviewed'])) ?>" class="btn btn-sm btn-outline-info <?= $statusFilter === 'reviewed' ? 'active' : '' ?>">Reviewed</a>
                            <a href="<?= e(route('admin.quotations.index', ['status' => 'approved'])) ?>" class="btn btn-sm btn-outline-success <?= $statusFilter === 'approved' ? 'active' : '' ?>">Approved</a>
                            <a href="<?= e(route('admin.quotations.index', ['status' => 'rejected'])) ?>" class="btn btn-sm btn-outline-danger <?= $statusFilter === 'rejected' ? 'active' : '' ?>">Rejected</a>
                        </div>
                    </div>
                </div>

                <div class="card border-0 shadow-sm rounded-3">
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover table-striped align-middle mb-0">
                                <thead class="table-light text-navy fw-bold text-xs uppercase">
                                    <tr>
                                        <th class="ps-3">Pengirim</th>
                                        <th>WhatsApp / Email</th>
                                        <th>Jenis Proyek</th>
                                        <th>Lokasi & Luas</th>
                                        <th>Status</th>
                                        <th>Tanggal Pengajuan</th>
                                        <th class="text-end pe-3" style="width: 140px;">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (!empty($quotations)): ?>
                                        <?php foreach ($quotations as $quotation): ?>
                                            <?php
                                            $qId      = $quotation['id'];
                                            $qStatus  = strtolower((string)($quotation['status'] ?? 'pending'));
                                            $qCreated = !empty($quotation['created_at']) 
                                                ? date('d M Y, H:i', strtotime($quotation['created_at'])) . ' WIB' 
                                                : '-';
                                            ?>
                                            <tr>
                                                <td class="ps-3">
                                                    <strong class="text-navy d-block"><?= e($quotation['name']) ?></strong>
                                                    <span class="text-xs text-muted"><?= e($quotation['company_name'] ?? 'Personal') ?></span>
                                                </td>
                                                <td>
                                                    <div class="text-navy fw-semibold"><i class="bi bi-whatsapp text-success me-1"></i><?= e($quotation['whatsapp']) ?></div>
                                                    <span class="text-xs text-muted"><?= e($quotation['email']) ?></span>
                                                </td>
                                                <td><?= e($quotation['project_type']) ?></td>
                                                <td>
                                                    <div class="text-navy fw-semibold"><?= e($quotation['location']) ?></div>
                                                    <span class="text-xs text-muted"><?= e($quotation['building_area'] ?? '-') ?> m²</span>
                                                </td>
                                                <td>
                                                    <?php if ($qStatus === 'pending'): ?>
                                                        <span class="badge bg-warning text-dark text-xs uppercase px-2">Pending</span>
                                                    <?php elseif ($qStatus === 'reviewed'): ?>
                                                        <span class="badge bg-info text-dark text-xs uppercase px-2">Reviewed</span>
                                                    <?php elseif ($qStatus === 'approved'): ?>
                                                        <span class="badge bg-success text-white text-xs uppercase px-2">Approved</span>
                                                    <?php else: ?>
                                                        <span class="badge bg-danger text-white text-xs uppercase px-2">Rejected</span>
                                                    <?php endif; ?>
                                                </td>
                                                <td><?= e($qCreated) ?></td>
                                                <td class="text-end pe-3">
                                                    <div class="btn-group">
                                                        <a href="<?= e(route('admin.quotations.show', ['id' => $qId])) ?>" class="btn btn-outline-primary btn-sm me-1 rounded"><i class="bi bi-eye"></i> Detail</a>
                                                        <form action="<?= e(route('admin.quotations.destroy')) ?>" method="POST" class="d-inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data quotation ini?');">
                                                            <input type="hidden" name="_token" value="<?= e($csrfToken) ?>">
                                                            <input type="hidden" name="_action" value="DELETE">
                                                            <input type="hidden" name="id" value="<?= e((string) $qId) ?>">
                                                            <button type="submit" class="btn btn-outline-danger btn-sm rounded"><i class="bi bi-trash"></i></button>
                                                        </form>
                                                    </div>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <tr>
                                            <td colspan="7" class="text-center py-4 text-muted">Tidak ditemukan pengajuan quotation untuk filter ini.</td>
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
