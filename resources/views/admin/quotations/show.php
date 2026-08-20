<?php
/**
 * resources/views/admin/quotations/show.php
 * ─────────────────────────────────────────────────────────────────────────────
 * Halaman Detail & Pembaruan Status Quotation Admin PHP Native PT MPA.
 * Konversi dari show.blade.php — 100% PHP Native tanpa Laravel/Blade.
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

$quotationId = (int) ($_GET['id'] ?? $_POST['id'] ?? 0);
if ($quotationId <= 0) {
    $_SESSION['error'] = 'ID quotation tidak valid.';
    header('Location: ' . route('admin.quotations.index'));
    exit;
}

// Ambil data quotation dari database
$quotation = db_find('SELECT * FROM request_quotations WHERE id = ?', [$quotationId]);
if (!$quotation) {
    $_SESSION['error'] = 'Data quotation tidak ditemukan.';
    header('Location: ' . route('admin.quotations.index'));
    exit;
}

// ── Proses POST Action: Update Status ─────────────────────────────────────────
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $submittedToken = $_POST['_token'] ?? '';
    if (!auth_verify_csrf($submittedToken)) {
        $_SESSION['error'] = 'Token keamanan tidak valid. Silakan coba lagi.';
    } else {
        $newStatus = strtolower(trim($_POST['status'] ?? 'pending'));
        $allowedStatuses = ['pending', 'reviewed', 'approved', 'rejected'];

        if (in_array($newStatus, $allowedStatuses, true)) {
            try {
                $now = db_now();
                db_execute('UPDATE request_quotations SET status = ?, updated_at = ? WHERE id = ?', [$newStatus, $now, $quotationId]);
                $_SESSION['success'] = 'Status quotation berhasil diperbarui menjadi "' . strtoupper($newStatus) . '".';
                $quotation['status'] = $newStatus;
            } catch (Throwable $e) {
                $_SESSION['error'] = 'Gagal memperbarui status: ' . $e->getMessage();
            }
        } else {
            $_SESSION['error'] = 'Pilihan status tidak valid.';
        }
    }
    header('Location: ' . route('admin.quotations.show', ['id' => $quotationId]));
    exit;
}

$pageTitle       = 'Detail Quotation - Admin Dashboard';
$headerPageTitle = 'Detail Pengajuan Quotation';
$csrfToken       = auth_csrf_token();
$qStatus         = strtolower((string)($quotation['status'] ?? 'pending'));
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
        .leading-relaxed { line-height: 1.625; }
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
                    <a href="<?= e(route('admin.quotations.index')) ?>" class="btn btn-outline-secondary fw-semibold">
                        <i class="bi bi-arrow-left me-1"></i> Kembali ke Daftar Quotation
                    </a>
                </div>

                <div class="row g-4">
                    <!-- Left Column: Details -->
                    <div class="col-lg-8">
                        <div class="card border-0 shadow-sm rounded-3 p-4 mb-4 bg-white">
                            <h5 class="fw-bold text-navy border-bottom pb-2 mb-3">Informasi Utama Pengaju</h5>
                            
                            <div class="row g-3">
                                <div class="col-sm-6">
                                    <span class="text-muted text-xs d-block">NAMA PENGIRIM</span>
                                    <strong class="text-navy fs-6"><?= e($quotation['name']) ?></strong>
                                </div>
                                <div class="col-sm-6">
                                    <span class="text-muted text-xs d-block">NAMA PERUSAHAAN</span>
                                    <strong class="text-navy fs-6"><?= e($quotation['company_name'] ?? '-') ?></strong>
                                </div>
                                <div class="col-sm-6">
                                    <span class="text-muted text-xs d-block">EMAIL</span>
                                    <strong class="text-navy fs-6"><i class="bi bi-envelope me-1"></i><?= e($quotation['email']) ?></strong>
                                </div>
                                <div class="col-sm-6">
                                    <span class="text-muted text-xs d-block">NOMOR WHATSAPP</span>
                                    <strong class="text-navy fs-6"><i class="bi bi-whatsapp me-1 text-success"></i><?= e($quotation['whatsapp']) ?></strong>
                                </div>
                            </div>

                            <h5 class="fw-bold text-navy border-bottom pb-2 mb-3 mt-5">Informasi Rencana Proyek</h5>
                            
                            <div class="row g-3">
                                <div class="col-sm-6">
                                    <span class="text-muted text-xs d-block">JENIS PROYEK</span>
                                    <strong class="text-navy fs-6"><?= e($quotation['project_type']) ?></strong>
                                </div>
                                <div class="col-sm-6">
                                    <span class="text-muted text-xs d-block">LOKASI RENCANA</span>
                                    <strong class="text-navy fs-6"><i class="bi bi-geo-alt me-1"></i><?= e($quotation['location']) ?></strong>
                                </div>
                                <div class="col-sm-6">
                                    <span class="text-muted text-xs d-block">PERKIRAAN LUAS BANGUNAN</span>
                                    <strong class="text-navy fs-6"><?= e($quotation['building_area'] ?? '-') ?> m²</strong>
                                </div>
                                <div class="col-sm-6">
                                    <span class="text-muted text-xs d-block">ESTIMASI RENCANA ANGGARAN</span>
                                    <strong class="text-navy fs-6"><?= e($quotation['budget'] ?? '-') ?></strong>
                                </div>
                            </div>

                            <?php if (!empty($quotation['description'])): ?>
                                <h5 class="fw-bold text-navy border-bottom pb-2 mb-3 mt-5">Catatan Tambahan & Spesifikasi</h5>
                                <div class="bg-light p-3 rounded border text-muted leading-relaxed">
                                    <?= nl2br(e($quotation['description'])) ?>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>

                    <!-- Right Column: Document & Status -->
                    <div class="col-lg-4">
                        <!-- Document Download -->
                        <div class="card border-0 shadow-sm rounded-3 p-4 mb-4 bg-white">
                            <h5 class="fw-bold text-navy mb-3"><i class="bi bi-paperclip text-warning me-1"></i>Dokumen Terlampir</h5>
                            <?php if (!empty($quotation['file_path'])): ?>
                                <?php
                                $fPath = $quotation['file_path'];
                                $fUrl  = str_starts_with($fPath, 'http') ? $fPath : asset('storage/' . $fPath);
                                ?>
                                <div class="bg-light p-3 rounded text-center border mb-3">
                                    <i class="bi bi-file-earmark-pdf-fill text-danger fs-1"></i>
                                    <span class="d-block text-xs text-muted text-truncate mt-2" style="max-width: 100%;"><?= e(basename($fPath)) ?></span>
                                </div>
                                <a href="<?= e($fUrl) ?>" target="_blank" class="btn btn-navy text-white w-100 fw-semibold"><i class="bi bi-download me-1"></i> Download Dokumen</a>
                            <?php else: ?>
                                <div class="text-center py-3 text-muted text-sm border rounded">
                                    Tidak melampirkan berkas gambar/DED.
                                </div>
                            <?php endif; ?>
                        </div>

                        <!-- Update Status -->
                        <div class="card border-0 shadow-sm rounded-3 p-4 bg-white">
                            <h5 class="fw-bold text-navy mb-3">Pembaruan Status</h5>
                            
                            <div class="mb-3">
                                <span class="text-muted text-xs d-block mb-1">STATUS SAAT INI</span>
                                <?php if ($qStatus === 'pending'): ?>
                                    <span class="badge bg-warning text-dark text-xs uppercase py-2 px-3 fw-bold">Pending</span>
                                <?php elseif ($qStatus === 'reviewed'): ?>
                                    <span class="badge bg-info text-dark text-xs uppercase py-2 px-3 fw-bold">Reviewed</span>
                                <?php elseif ($qStatus === 'approved'): ?>
                                    <span class="badge bg-success text-white text-xs uppercase py-2 px-3 fw-bold">Approved</span>
                                <?php else: ?>
                                    <span class="badge bg-danger text-white text-xs uppercase py-2 px-3 fw-bold">Rejected</span>
                                <?php endif; ?>
                            </div>

                            <form action="<?= e(route('admin.quotations.update-status', ['id' => $quotationId])) ?>" method="POST">
                                <input type="hidden" name="_token" value="<?= e($csrfToken) ?>">
                                <input type="hidden" name="id" value="<?= e((string) $quotationId) ?>">
                                <div class="mb-3">
                                    <label for="status" class="form-label text-xs fw-semibold text-muted">UBAH STATUS MENJADI</label>
                                    <select name="status" id="status" class="form-select">
                                        <option value="pending" <?= $qStatus === 'pending' ? 'selected' : '' ?>>Pending</option>
                                        <option value="reviewed" <?= $qStatus === 'reviewed' ? 'selected' : '' ?>>Reviewed</option>
                                        <option value="approved" <?= $qStatus === 'approved' ? 'selected' : '' ?>>Approved</option>
                                        <option value="rejected" <?= $qStatus === 'rejected' ? 'selected' : '' ?>>Rejected</option>
                                    </select>
                                </div>
                                <button type="submit" class="btn btn-warning text-dark w-100 fw-bold">Simpan Status</button>
                            </form>
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
