<?php
/**
 * resources/views/admin/dashboard.php
 * ─────────────────────────────────────────────────────────────────────────────
 * Halaman Dashboard Admin PHP Native PT Multi Power Abadi.
 * Konversi dari dashboard.blade.php — 100% PHP Native tanpa Laravel/Blade.
 *
 * Proteksi: Memanggil auth_require() pada baris teratas. Jika belum login,
 * otomatis di-redirect ke halaman login admin.
 * ─────────────────────────────────────────────────────────────────────────────
 */

declare(strict_types=1);

$appRoot = dirname(__DIR__, 3);
require_once $appRoot . '/native/db.php';
require_once $appRoot . '/native/auth.php';
require_once __DIR__ . '/../native_helpers.php';

// ── Proteksi Halaman Admin ───────────────────────────────────────────────────
auth_require();

$currentUser = auth_user();
$userName    = $currentUser['name'] ?? 'Admin MPA';

// ── Ambil Data Ringkasan Dashboard dari Database ──────────────────────────────
$totalServices   = 0;
$totalProjects   = 0;
$unreadContacts  = 0;
$recentQuotations = [];
$recentContacts   = [];

try {
    $totalServices   = (int) (db_scalar('SELECT COUNT(*) FROM services') ?? 0);
    $totalProjects   = (int) (db_scalar('SELECT COUNT(*) FROM projects') ?? 0);
    $unreadContacts  = (int) (db_scalar('SELECT COUNT(*) FROM contacts WHERE is_read = 0') ?? 0);
    $recentQuotations = db_select('SELECT * FROM request_quotations ORDER BY created_at DESC LIMIT 5');
    $recentContacts   = db_select('SELECT * FROM contacts ORDER BY created_at DESC LIMIT 5');
} catch (Throwable $e) {
    // Graceful fallback jika terjadi query error
}

$pageTitle       = 'Admin Dashboard - PT Multi Power Abadi';
$headerPageTitle = 'Dashboard Ringkasan Administrator';
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
        .admin-stat-card { transition: transform 0.2s, box-shadow 0.2s; }
        .admin-stat-card:hover { transform: translateY(-3px); box-shadow: 0 10px 20px rgba(0,0,0,0.1) !important; }
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
                            <a class="nav-link active" href="<?= e(route('dashboard')) ?>">
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

                <!-- Quick Actions Banner -->
                <div class="card border-0 shadow-sm rounded-4 mb-4 bg-danger text-white overflow-hidden position-relative">
                    <div class="card-body p-4 p-md-5 position-relative" style="z-index: 2;">
                        <div class="row align-items-center">
                            <div class="col-lg-7">
                                <span class="badge bg-warning text-dark text-xs uppercase px-3 py-2 rounded-pill mb-2 fw-bold">Navigasi Terintegrasi</span>
                                <h2 class="fw-bold text-white mb-2">Selamat Datang di Panel Admin PT. Multi Power Abadi</h2>
                                <p class="text-white-50 mb-4 mb-lg-0" style="max-width: 600px;">
                                    Kelola seluruh halaman website (Home, Services, Projects, dan Contact) dari satu dashboard terpadu yang sederhana dan mudah digunakan.
                                </p>
                            </div>
                            <div class="col-lg-5 text-lg-end">
                                <div class="d-flex flex-wrap gap-2 justify-content-lg-end">
                                    <a href="<?= e(route('admin.home-editor')) ?>" class="btn btn-warning btn-md fw-bold text-navy shadow-sm">
                                        <i class="bi bi-house-door-fill me-1"></i> Edit Halaman Home
                                    </a>
                                    <a href="<?= e(route('admin.services.index')) ?>" class="btn btn-outline-light btn-md fw-semibold shadow-sm">
                                        <i class="bi bi-building me-1"></i> Services
                                    </a>
                                    <a href="<?= e(route('admin.projects.index')) ?>" class="btn btn-outline-light btn-md fw-semibold shadow-sm">
                                        <i class="bi bi-images me-1"></i> Projects
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Main 4 Navigation Modules Cards Grid -->
                <div class="row g-4 mb-4">
                    <!-- Home Editor Module -->
                    <div class="col-md-6 col-lg-3">
                        <div class="card admin-stat-card border-0 bg-white shadow-sm h-100 rounded-4">
                            <div class="card-body p-4 text-center">
                                <div class="bg-danger bg-opacity-10 text-danger rounded-circle mx-auto mb-3 d-flex align-items-center justify-content-center" style="width: 60px; height: 60px;">
                                    <i class="bi bi-house-door-fill fs-3"></i>
                                </div>
                                <h5 class="fw-bold text-navy mb-1">Halaman Home</h5>
                                <p class="text-muted text-xs mb-3">Solusi Baja, Layanan Lainnya, Portfolio, Klien, & Statistik</p>
                            </div>
                            <div class="card-footer bg-light border-0 py-3 text-center rounded-bottom-4">
                                <a href="<?= e(route('admin.home-editor')) ?>" class="btn btn-sm btn-danger w-100 fw-semibold text-white">Edit Konten Home <i class="bi bi-arrow-right ms-1"></i></a>
                            </div>
                        </div>
                    </div>

                    <!-- Services Module -->
                    <div class="col-md-6 col-lg-3">
                        <div class="card admin-stat-card border-0 bg-white shadow-sm h-100 rounded-4">
                            <div class="card-body p-4 text-center">
                                <div class="bg-navy bg-opacity-10 text-navy rounded-circle mx-auto mb-3 d-flex align-items-center justify-content-center" style="width: 60px; height: 60px;">
                                    <i class="bi bi-building fs-3"></i>
                                </div>
                                <h5 class="fw-bold text-navy mb-1">Halaman Services</h5>
                                <span class="fs-4 fw-bold text-navy d-block mb-1"><?= $totalServices ?> Layanan</span>
                                <p class="text-muted text-xs mb-3">Kelola rincian & detail halaman Services</p>
                            </div>
                            <div class="card-footer bg-light border-0 py-3 text-center rounded-bottom-4">
                                <a href="<?= e(route('admin.services.index')) ?>" class="btn btn-sm btn-navy w-100 fw-semibold text-white">Kelola Services <i class="bi bi-arrow-right ms-1"></i></a>
                            </div>
                        </div>
                    </div>

                    <!-- Projects Module -->
                    <div class="col-md-6 col-lg-3">
                        <div class="card admin-stat-card border-0 bg-white shadow-sm h-100 rounded-4">
                            <div class="card-body p-4 text-center">
                                <div class="bg-warning bg-opacity-10 text-warning rounded-circle mx-auto mb-3 d-flex align-items-center justify-content-center" style="width: 60px; height: 60px;">
                                    <i class="bi bi-images fs-3"></i>
                                </div>
                                <h5 class="fw-bold text-navy mb-1">Halaman Projects</h5>
                                <span class="fs-4 fw-bold text-navy d-block mb-1"><?= $totalProjects ?> Proyek</span>
                                <p class="text-muted text-xs mb-3">Kelola dokumentasi proyek & foto galeri</p>
                            </div>
                            <div class="card-footer bg-light border-0 py-3 text-center rounded-bottom-4">
                                <a href="<?= e(route('admin.projects.index')) ?>" class="btn btn-sm btn-warning w-100 fw-bold text-navy">Kelola Projects <i class="bi bi-arrow-right ms-1"></i></a>
                            </div>
                        </div>
                    </div>

                    <!-- Contact Module -->
                    <div class="col-md-6 col-lg-3">
                        <div class="card admin-stat-card border-0 bg-white shadow-sm h-100 rounded-4">
                            <div class="card-body p-4 text-center">
                                <div class="bg-info bg-opacity-10 text-info rounded-circle mx-auto mb-3 d-flex align-items-center justify-content-center" style="width: 60px; height: 60px;">
                                    <i class="bi bi-envelope-paper-fill fs-3"></i>
                                </div>
                                <h5 class="fw-bold text-navy mb-1">Halaman Contact</h5>
                                <span class="fs-4 fw-bold text-navy d-block mb-1"><?= $unreadContacts ?> Pesan Baru</span>
                                <p class="text-muted text-xs mb-3">Kotak masuk pertanyaan & pesan kontak</p>
                            </div>
                            <div class="card-footer bg-light border-0 py-3 text-center rounded-bottom-4">
                                <a href="<?= e(route('admin.contacts.index')) ?>" class="btn btn-sm btn-info w-100 fw-semibold text-white">Buka Contact Inbox <i class="bi bi-arrow-right ms-1"></i></a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row g-4">
                    <!-- Recent Quotations -->
                    <div class="col-lg-6">
                        <div class="card border-0 shadow-sm rounded-4">
                            <div class="card-header bg-danger py-3 d-flex justify-content-between align-items-center rounded-top-4">
                                <h5 class="card-title text-white mb-0 fw-semibold fs-6"><i class="bi bi-file-earmark-spreadsheet-fill me-2 text-warning"></i>Request Quotation Terbaru</h5>
                                <a href="<?= e(route('admin.home-editor', ['tab' => 'quotations'])) ?>" class="btn btn-xs btn-outline-light">Kelola di Home Editor</a>
                            </div>
                            <div class="card-body p-0">
                                <div class="table-responsive">
                                    <table class="table table-hover table-striped align-middle mb-0 text-sm">
                                        <thead class="table-light text-navy fw-bold text-xs uppercase">
                                            <tr>
                                                <th class="ps-3">Nama</th>
                                                <th>Proyek</th>
                                                <th>Status</th>
                                                <th class="text-end pe-3">Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php if (!empty($recentQuotations)): ?>
                                                <?php foreach ($recentQuotations as $quotation): ?>
                                                    <?php
                                                    $qName = $quotation['name'] ?? '';
                                                    $qCompany = $quotation['company_name'] ?? 'Personal';
                                                    $qProjectType = $quotation['project_type'] ?? '-';
                                                    $qStatus = $quotation['status'] ?? 'pending';
                                                    $qId = $quotation['id'] ?? 1;
                                                    ?>
                                                    <tr>
                                                        <td class="ps-3">
                                                            <div class="fw-semibold text-navy"><?= e($qName) ?></div>
                                                            <span class="text-xs text-muted"><?= e($qCompany) ?></span>
                                                        </td>
                                                        <td><?= e($qProjectType) ?></td>
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
                                                        <td class="text-end pe-3">
                                                            <a href="<?= e(route('admin.quotations.show', ['id' => $qId])) ?>" class="btn btn-outline-primary btn-sm rounded-circle"><i class="bi bi-eye"></i></a>
                                                        </td>
                                                    </tr>
                                                <?php endforeach; ?>
                                            <?php else: ?>
                                                <tr>
                                                    <td colspan="4" class="text-center py-4 text-muted">Belum ada pengajuan quotation masuk.</td>
                                                </tr>
                                            <?php endif; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Recent Messages -->
                    <div class="col-lg-6">
                        <div class="card border-0 shadow-sm rounded-4">
                            <div class="card-header bg-danger py-3 d-flex justify-content-between align-items-center rounded-top-4">
                                <h5 class="card-title text-white mb-0 fw-semibold fs-6"><i class="bi bi-chat-left-text-fill me-2 text-warning"></i>Pesan Masuk Contact</h5>
                                <a href="<?= e(route('admin.contacts.index')) ?>" class="btn btn-xs btn-outline-light">Lihat Semua</a>
                            </div>
                            <div class="card-body p-0">
                                <div class="table-responsive">
                                    <table class="table table-hover table-striped align-middle mb-0 text-sm">
                                        <thead class="table-light text-navy fw-bold text-xs uppercase">
                                            <tr>
                                                <th class="ps-3">Pengirim</th>
                                                <th>Subjek</th>
                                                <th>Status</th>
                                                <th class="text-end pe-3">Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php if (!empty($recentContacts)): ?>
                                                <?php foreach ($recentContacts as $contact): ?>
                                                    <?php
                                                    $cName = $contact['name'] ?? '';
                                                    $cEmail = $contact['email'] ?? '';
                                                    $cSubject = mb_strimwidth((string)($contact['subject'] ?? ''), 0, 30, '...');
                                                    $cIsRead = !empty($contact['is_read']);
                                                    $cId = $contact['id'] ?? 1;
                                                    ?>
                                                    <tr>
                                                        <td class="ps-3">
                                                            <div class="fw-semibold text-navy"><?= e($cName) ?></div>
                                                            <span class="text-xs text-muted"><?= e($cEmail) ?></span>
                                                        </td>
                                                        <td><?= e($cSubject) ?></td>
                                                        <td>
                                                            <?php if (!$cIsRead): ?>
                                                                <span class="badge bg-danger text-white text-xs uppercase px-2">Baru</span>
                                                            <?php else: ?>
                                                                <span class="badge bg-secondary text-white text-xs uppercase px-2">Dibaca</span>
                                                            <?php endif; ?>
                                                        </td>
                                                        <td class="text-end pe-3">
                                                            <a href="<?= e(route('admin.contacts.index', ['id' => $cId])) ?>" class="btn btn-outline-primary btn-sm rounded-circle"><i class="bi bi-eye"></i></a>
                                                        </td>
                                                    </tr>
                                                <?php endforeach; ?>
                                            <?php else: ?>
                                                <tr>
                                                    <td colspan="4" class="text-center py-4 text-muted">Belum ada pesan kontak masuk.</td>
                                                </tr>
                                            <?php endif; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
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
