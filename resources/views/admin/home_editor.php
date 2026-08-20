<?php
/**
 * resources/views/admin/home_editor.php
 * ─────────────────────────────────────────────────────────────────────────────
 * Editor Konten Halaman Utama (Home Editor) Admin PHP Native PT MPA.
 * Konversi dari home_editor.blade.php — 100% PHP Native tanpa Laravel/Blade.
 *
 * Proteksi: auth_require() pada baris teratas.
 * ─────────────────────────────────────────────────────────────────────────────
 */

declare(strict_types=1);

$appRoot = dirname(__DIR__, 3);
require_once $appRoot . '/native/db.php';
require_once $appRoot . '/native/auth.php';
require_once dirname(__DIR__) . '/native_helpers.php';

// ── Proteksi Halaman Admin ───────────────────────────────────────────────────
auth_require();

$currentUser = auth_user();
$userName    = $currentUser['name'] ?? 'Admin MPA';

$activeTab = strtolower(trim($_GET['tab'] ?? $_POST['_tab'] ?? 'services'));
$allowedTabs = ['services', 'other-services', 'projects', 'clients', 'stats', 'quotations'];
if (!in_array($activeTab, $allowedTabs, true)) {
    $activeTab = 'services';
}

// ── Handling POST Submissions ────────────────────────────────────────────────
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $submittedToken = $_POST['_token'] ?? '';
    if (!auth_verify_csrf($submittedToken)) {
        $_SESSION['error'] = 'Token keamanan tidak valid. Silakan coba lagi.';
    } else {
        $action = $_POST['_action'] ?? '';

        // 1. Action: Update Company Stats (Tab Stats)
        if ($action === 'update_stats') {
            $fields = [
                'years_experience'   => trim($_POST['years_experience'] ?? '15'),
                'projects_completed' => trim($_POST['projects_completed'] ?? '150'),
                'experts_count'      => trim($_POST['experts_count'] ?? '50'),
                'work_accidents'     => trim($_POST['work_accidents'] ?? '0'),
            ];

            try {
                $now = db_now();
                foreach ($fields as $key => $val) {
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
                $_SESSION['success'] = 'Statistik perusahaan berhasil diperbarui!';
            } catch (Throwable $e) {
                $_SESSION['error'] = 'Gagal memperbarui statistik: ' . $e->getMessage();
            }
            header('Location: ' . route('admin.home-editor', ['tab' => 'stats']));
            exit;
        }

        // 2. Action: Quick Status Update for Quotations (Tab Quotations)
        if ($action === 'update_quotation_status') {
            $qId = (int) ($_POST['quotation_id'] ?? 0);
            $newStatus = strtolower(trim($_POST['status'] ?? 'pending'));
            $allowedStatusList = ['pending', 'reviewed', 'approved', 'rejected'];

            if ($qId > 0 && in_array($newStatus, $allowedStatusList, true)) {
                try {
                    db_execute('UPDATE request_quotations SET status = ?, updated_at = ? WHERE id = ?', [$newStatus, db_now(), $qId]);
                    $_SESSION['success'] = 'Status quotation ID #' . $qId . ' berhasil diperbarui ke "' . strtoupper($newStatus) . '".';
                } catch (Throwable $e) {
                    $_SESSION['error'] = 'Gagal mengubah status quotation: ' . $e->getMessage();
                }
            } else {
                $_SESSION['error'] = 'Data status tidak valid.';
            }
            header('Location: ' . route('admin.home-editor', ['tab' => 'quotations']));
            exit;
        }
    }
}

// ── Fetch Data for All Tabs ──────────────────────────────────────────────────
$services      = [];
$otherServices = [];
$projects      = [];
$clients       = [];
$stats         = [];
$quotations    = [];

try {
    $services      = db_select('SELECT * FROM services ORDER BY created_at DESC');
    $otherServices = db_select('SELECT * FROM other_services ORDER BY created_at DESC');
    $projects      = db_select('SELECT * FROM projects ORDER BY created_at DESC LIMIT 6');
    $clients       = db_select('SELECT * FROM clients ORDER BY created_at DESC');
    $quotations    = db_select('SELECT * FROM request_quotations ORDER BY created_at DESC');

    $settingsRaw = db_select('SELECT * FROM company_settings');
    foreach ($settingsRaw as $s) {
        $stats[$s['key']] = $s['value'];
    }
} catch (Throwable $e) {
    $_SESSION['error'] = 'Gagal memuat data Home Editor: ' . $e->getMessage();
}

$pageTitle       = 'Editor Halaman Home - Admin PT Multi Power Abadi';
$headerPageTitle = 'Editor Konten Halaman Utama (Home)';
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

        .custom-admin-tabs .nav-link {
            color: #1e293b;
            background: transparent;
            transition: all 0.3s ease;
        }
        .custom-admin-tabs .nav-link.active {
            background-color: #0f172a !important;
            color: #ffffff !important;
            box-shadow: 0 4px 12px rgba(15, 23, 42, 0.25);
        }
        .custom-admin-tabs .nav-link.active i {
            color: #ef4444 !important;
        }
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
                            <a class="nav-link active" href="<?= e(route('admin.home-editor')) ?>">
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
                    <p class="text-muted mb-0">Kelola seluruh section yang tampil pada halaman **Home** website dalam satu panel editor terpadu.</p>
                </div>

                <!-- Home Sections Navigation Tabs -->
                <ul class="nav nav-pills custom-admin-tabs mb-4 bg-white p-2 rounded-4 shadow-sm border" id="homeSectionsTab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link text-navy fw-semibold px-3 py-2.5 rounded-3 <?= $activeTab === 'services' ? 'active' : '' ?>" id="services-tab" data-bs-toggle="tab" data-bs-target="#tab-services" type="button" role="tab">
                            <i class="bi bi-building me-1 text-danger"></i> Solusi Konstruksi Baja
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link text-navy fw-semibold px-3 py-2.5 rounded-3 <?= $activeTab === 'other-services' ? 'active' : '' ?>" id="other-services-tab" data-bs-toggle="tab" data-bs-target="#tab-other-services" type="button" role="tab">
                            <i class="bi bi-tools me-1 text-danger"></i> Layanan Lainnya
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link text-navy fw-semibold px-3 py-2.5 rounded-3 <?= $activeTab === 'projects' ? 'active' : '' ?>" id="projects-tab" data-bs-toggle="tab" data-bs-target="#tab-projects" type="button" role="tab">
                            <i class="bi bi-images me-1 text-danger"></i> Portfolio Proyek
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link text-navy fw-semibold px-3 py-2.5 rounded-3 <?= $activeTab === 'clients' ? 'active' : '' ?>" id="clients-tab" data-bs-toggle="tab" data-bs-target="#tab-clients" type="button" role="tab">
                            <i class="bi bi-people me-1 text-danger"></i> Klien Kami
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link text-navy fw-semibold px-3 py-2.5 rounded-3 <?= $activeTab === 'stats' ? 'active' : '' ?>" id="stats-tab" data-bs-toggle="tab" data-bs-target="#tab-stats" type="button" role="tab">
                            <i class="bi bi-sliders me-1 text-danger"></i> Statistik Perusahaan
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link text-navy fw-semibold px-3 py-2.5 rounded-3 <?= $activeTab === 'quotations' ? 'active' : '' ?>" id="quotations-tab" data-bs-toggle="tab" data-bs-target="#tab-quotations" type="button" role="tab">
                            <i class="bi bi-file-earmark-spreadsheet me-1 text-danger"></i> Request Quotation
                        </button>
                    </li>
                </ul>

                <!-- Tab Contents -->
                <div class="tab-content" id="homeSectionsTabContent">

                    <!-- ================= TAB 1: SOLUSI KONSTRUKSI BAJA ================= -->
                    <div class="tab-pane fade <?= $activeTab === 'services' ? 'show active' : '' ?>" id="tab-services" role="tabpanel">
                        <div class="card border-0 shadow-sm rounded-4">
                            <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                                <h5 class="card-title text-navy mb-0 fw-bold"><i class="bi bi-building me-2 text-danger"></i>Solusi Konstruksi Baja (Layanan Utama)</h5>
                                <a href="<?= e(route('admin.services.create')) ?>" class="btn btn-danger btn-sm text-white fw-semibold">
                                    <i class="bi bi-plus-lg me-1"></i> Tambah Layanan Utama
                                </a>
                            </div>
                            <div class="card-body p-0">
                                <div class="table-responsive">
                                    <table class="table table-hover table-striped align-middle mb-0">
                                        <thead class="table-light text-navy fw-bold text-xs uppercase">
                                            <tr>
                                                <th class="ps-4" style="width: 80px;">Gambar</th>
                                                <th>Layanan</th>
                                                <th>Deskripsi Singkat</th>
                                                <th>Icon</th>
                                                <th class="text-end pe-4" style="width: 150px;">Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php if (!empty($services)): ?>
                                                <?php foreach ($services as $service): ?>
                                                    <?php
                                                    $sId = $service['id'];
                                                    $sTitle = $service['title'];
                                                    $sSlug = $service['slug'];
                                                    $sDesc = mb_strimwidth((string)($service['description'] ?? ''), 0, 90, '...');
                                                    $sIcon = !empty($service['icon']) ? $service['icon'] : 'bi-building';
                                                    $sRawImg = $service['image'] ?? '';
                                                    $sImg = !empty($sRawImg) 
                                                        ? (str_starts_with($sRawImg, 'http') ? $sRawImg : asset('storage/' . $sRawImg))
                                                        : 'https://images.unsplash.com/photo-1581094288338-2314dddb7ecc?q=80&w=100&auto=format&fit=crop';
                                                    ?>
                                                    <tr>
                                                        <td class="ps-4">
                                                            <img src="<?= e($sImg) ?>" class="rounded object-fit-cover" style="width: 60px; height: 50px;" alt="<?= e($sTitle) ?>">
                                                        </td>
                                                        <td>
                                                            <strong class="text-navy d-block"><?= e($sTitle) ?></strong>
                                                            <span class="text-xs text-muted"><?= e($sSlug) ?></span>
                                                        </td>
                                                        <td><?= e($sDesc) ?></td>
                                                        <td>
                                                            <span class="badge bg-navy text-white py-2"><i class="bi <?= e($sIcon) ?> me-1"></i> <?= e($sIcon) ?></span>
                                                        </td>
                                                        <td class="text-end pe-4">
                                                            <div class="btn-group">
                                                                <a href="<?= e(route('admin.services.edit', ['id' => $sId])) ?>" class="btn btn-outline-warning btn-sm me-1 rounded"><i class="bi bi-pencil-square"></i> Edit</a>
                                                                <form action="<?= e(route('admin.services.destroy')) ?>" method="POST" class="d-inline" onsubmit="return confirm('Yakin hapus?');">
                                                                    <input type="hidden" name="_token" value="<?= e($csrfToken) ?>">
                                                                    <input type="hidden" name="_action" value="DELETE">
                                                                    <input type="hidden" name="id" value="<?= e((string) $sId) ?>">
                                                                    <button type="submit" class="btn btn-outline-danger btn-sm rounded"><i class="bi bi-trash"></i> Hapus</button>
                                                                </form>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                <?php endforeach; ?>
                                            <?php else: ?>
                                                <tr>
                                                    <td colspan="5" class="text-center py-4 text-muted">Belum ada layanan utama. Silakan tambahkan baru.</td>
                                                </tr>
                                            <?php endif; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- ================= TAB 2: LAYANAN LAINNYA ================= -->
                    <div class="tab-pane fade <?= $activeTab === 'other-services' ? 'show active' : '' ?>" id="tab-other-services" role="tabpanel">
                        <div class="card border-0 shadow-sm rounded-4">
                            <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                                <h5 class="card-title text-navy mb-0 fw-bold"><i class="bi bi-tools me-2 text-danger"></i>Layanan Lainnya (Dukungan & Interior)</h5>
                                <a href="<?= e(route('admin.other-services.create')) ?>" class="btn btn-danger btn-sm text-white fw-semibold">
                                    <i class="bi bi-plus-lg me-1"></i> Tambah Layanan Lainnya
                                </a>
                            </div>
                            <div class="card-body p-0">
                                <div class="table-responsive">
                                    <table class="table table-hover table-striped align-middle mb-0">
                                        <thead class="table-light text-navy fw-bold text-xs uppercase">
                                            <tr>
                                                <th class="ps-4">Judul Layanan</th>
                                                <th>Deskripsi</th>
                                                <th class="text-end pe-4" style="width: 150px;">Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php if (!empty($otherServices)): ?>
                                                <?php foreach ($otherServices as $item): ?>
                                                    <?php
                                                    $osId = $item['id'];
                                                    $osTitle = $item['title'];
                                                    $osDesc = mb_strimwidth((string)($item['description'] ?? ''), 0, 100, '...');
                                                    ?>
                                                    <tr>
                                                        <td class="ps-4"><strong class="text-navy"><?= e($osTitle) ?></strong></td>
                                                        <td><p class="text-muted text-sm mb-0"><?= e($osDesc) ?></p></td>
                                                        <td class="text-end pe-4">
                                                            <div class="btn-group">
                                                                <a href="<?= e(route('admin.other-services.edit', ['id' => $osId])) ?>" class="btn btn-outline-warning btn-sm me-1 rounded"><i class="bi bi-pencil-square"></i> Edit</a>
                                                                <form action="<?= e(route('admin.other-services.destroy')) ?>" method="POST" class="d-inline" onsubmit="return confirm('Yakin hapus?');">
                                                                    <input type="hidden" name="_token" value="<?= e($csrfToken) ?>">
                                                                    <input type="hidden" name="_action" value="DELETE">
                                                                    <input type="hidden" name="id" value="<?= e((string) $osId) ?>">
                                                                    <button type="submit" class="btn btn-outline-danger btn-sm rounded"><i class="bi bi-trash"></i> Hapus</button>
                                                                </form>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                <?php endforeach; ?>
                                            <?php else: ?>
                                                <tr>
                                                    <td colspan="3" class="text-center py-4 text-muted">Belum ada layanan lainnya. Silakan tambahkan baru.</td>
                                                </tr>
                                            <?php endif; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- ================= TAB 3: PORTFOLIO PROYEK ================= -->
                    <div class="tab-pane fade <?= $activeTab === 'projects' ? 'show active' : '' ?>" id="tab-projects" role="tabpanel">
                        <div class="card border-0 shadow-sm rounded-4">
                            <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                                <h5 class="card-title text-navy mb-0 fw-bold"><i class="bi bi-images me-2 text-danger"></i>Portfolio Proyek (Dokumentasi Home)</h5>
                                <a href="<?= e(route('admin.projects.create')) ?>" class="btn btn-danger btn-sm text-white fw-semibold">
                                    <i class="bi bi-plus-lg me-1"></i> Tambah Proyek Baru
                                </a>
                            </div>
                            <div class="card-body p-0">
                                <div class="table-responsive">
                                    <table class="table table-hover table-striped align-middle mb-0">
                                        <thead class="table-light text-navy fw-bold text-xs uppercase">
                                            <tr>
                                                <th class="ps-4" style="width: 80px;">Gambar</th>
                                                <th>Proyek</th>
                                                <th>Kategori</th>
                                                <th>Lokasi & Tahun</th>
                                                <th class="text-end pe-4" style="width: 150px;">Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php if (!empty($projects)): ?>
                                                <?php foreach ($projects as $project): ?>
                                                    <?php
                                                    $pId = $project['id'];
                                                    $pTitle = $project['title'];
                                                    $pSlug = $project['slug'];
                                                    $pCategory = $project['category'] ?? 'Konstruksi';
                                                    $pLocation = $project['location'] ?? '-';
                                                    $pYear = $project['year'] ?? '-';
                                                    $pRawImg = $project['image'] ?? '';
                                                    $pImg = !empty($pRawImg)
                                                        ? (str_starts_with($pRawImg, 'http') ? $pRawImg : asset('storage/' . $pRawImg))
                                                        : 'https://images.unsplash.com/photo-1486406146926-c627a92ad1ab?q=80&w=100&auto=format&fit=crop';
                                                    ?>
                                                    <tr>
                                                        <td class="ps-4">
                                                            <img src="<?= e($pImg) ?>" class="rounded object-fit-cover" style="width: 60px; height: 50px;" alt="<?= e($pTitle) ?>">
                                                        </td>
                                                        <td>
                                                            <strong class="text-navy d-block"><?= e($pTitle) ?></strong>
                                                            <span class="text-xs text-muted"><?= e($pSlug) ?></span>
                                                        </td>
                                                        <td><span class="badge bg-light text-navy border py-2 px-3 fw-semibold"><?= e($pCategory) ?></span></td>
                                                        <td><?= e($pLocation) ?> (<?= e((string)$pYear) ?>)</td>
                                                        <td class="text-end pe-4">
                                                            <div class="btn-group">
                                                                <a href="<?= e(route('admin.projects.edit', ['id' => $pId])) ?>" class="btn btn-outline-warning btn-sm me-1 rounded"><i class="bi bi-pencil-square"></i> Edit</a>
                                                                <form action="<?= e(route('admin.projects.destroy')) ?>" method="POST" class="d-inline" onsubmit="return confirm('Yakin hapus?');">
                                                                    <input type="hidden" name="_token" value="<?= e($csrfToken) ?>">
                                                                    <input type="hidden" name="_action" value="DELETE">
                                                                    <input type="hidden" name="id" value="<?= e((string) $pId) ?>">
                                                                    <button type="submit" class="btn btn-outline-danger btn-sm rounded"><i class="bi bi-trash"></i> Hapus</button>
                                                                </form>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                <?php endforeach; ?>
                                            <?php else: ?>
                                                <tr>
                                                    <td colspan="5" class="text-center py-4 text-muted">Belum ada proyek terdaftar. Silakan tambahkan proyek baru.</td>
                                                </tr>
                                            <?php endif; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- ================= TAB 4: KLIEN KAMI ================= -->
                    <div class="tab-pane fade <?= $activeTab === 'clients' ? 'show active' : '' ?>" id="tab-clients" role="tabpanel">
                        <div class="card border-0 shadow-sm rounded-4">
                            <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                                <h5 class="card-title text-navy mb-0 fw-bold"><i class="bi bi-people me-2 text-danger"></i>Klien Kami (Logo Mitra)</h5>
                                <a href="<?= e(route('admin.clients.create')) ?>" class="btn btn-danger btn-sm text-white fw-semibold">
                                    <i class="bi bi-plus-lg me-1"></i> Tambah Klien Baru
                                </a>
                            </div>
                            <div class="card-body p-0">
                                <div class="table-responsive">
                                    <table class="table table-hover table-striped align-middle mb-0">
                                        <thead class="table-light text-navy fw-bold text-xs uppercase">
                                            <tr>
                                                <th class="ps-4" style="width: 120px;">Logo</th>
                                                <th>Perusahaan / Mitra</th>
                                                <th class="text-end pe-4" style="width: 150px;">Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php if (!empty($clients)): ?>
                                                <?php foreach ($clients as $client): ?>
                                                    <?php
                                                    $cId = $client['id'];
                                                    $cName = $client['name'];
                                                    $cRawLogo = $client['logo_path'] ?? '';
                                                    $cLogo = !empty($cRawLogo)
                                                        ? (str_starts_with($cRawLogo, 'http') ? $cRawLogo : asset('storage/' . $cRawLogo))
                                                        : asset('images/logo-mpa-favicon.png');
                                                    ?>
                                                    <tr>
                                                        <td class="ps-4">
                                                            <div class="bg-light p-2 rounded text-center border" style="width: 80px; height: 50px; display: flex; align-items: center; justify-content: center;">
                                                                <img src="<?= e($cLogo) ?>" class="img-fluid object-fit-contain" style="max-height: 40px;" alt="<?= e($cName) ?>">
                                                            </div>
                                                        </td>
                                                        <td><strong class="text-navy"><?= e($cName) ?></strong></td>
                                                        <td class="text-end pe-4">
                                                            <div class="btn-group">
                                                                <a href="<?= e(route('admin.clients.edit', ['id' => $cId])) ?>" class="btn btn-outline-warning btn-sm me-1 rounded"><i class="bi bi-pencil-square"></i> Edit</a>
                                                                <form action="<?= e(route('admin.clients.destroy')) ?>" method="POST" class="d-inline" onsubmit="return confirm('Yakin hapus?');">
                                                                    <input type="hidden" name="_token" value="<?= e($csrfToken) ?>">
                                                                    <input type="hidden" name="_action" value="DELETE">
                                                                    <input type="hidden" name="id" value="<?= e((string) $cId) ?>">
                                                                    <button type="submit" class="btn btn-outline-danger btn-sm rounded"><i class="bi bi-trash"></i> Hapus</button>
                                                                </form>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                <?php endforeach; ?>
                                            <?php else: ?>
                                                <tr>
                                                    <td colspan="3" class="text-center py-4 text-muted">Belum ada klien terdaftar. Silakan tambahkan klien baru.</td>
                                                </tr>
                                            <?php endif; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- ================= TAB 5: STATISTIK PERUSAHAAN ================= -->
                    <div class="tab-pane fade <?= $activeTab === 'stats' ? 'show active' : '' ?>" id="tab-stats" role="tabpanel">
                        <div class="card border-0 shadow-sm rounded-4">
                            <div class="card-header bg-white py-3">
                                <h5 class="card-title text-navy mb-0 fw-bold"><i class="bi bi-sliders me-2 text-danger"></i>Statistik & Angka Perusahaan</h5>
                            </div>
                            <div class="card-body p-4 p-md-5">
                                <form action="<?= e(route('admin.home-editor')) ?>" method="POST">
                                    <input type="hidden" name="_token" value="<?= e($csrfToken) ?>">
                                    <input type="hidden" name="_action" value="update_stats">
                                    <input type="hidden" name="_tab" value="stats">

                                    <div class="row g-4">
                                        <div class="col-md-6">
                                            <div class="card border bg-light p-3">
                                                <label for="years_experience" class="form-label fw-bold text-navy">Tahun Pengalaman</label>
                                                <div class="input-group">
                                                    <input type="text" class="form-control form-control-lg fw-bold text-navy" id="years_experience" name="years_experience" value="<?= e($stats['years_experience'] ?? '15') ?>" required>
                                                    <span class="input-group-text bg-white fw-bold">Tahun</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="card border bg-light p-3">
                                                <label for="projects_completed" class="form-label fw-bold text-navy">Proyek Selesai</label>
                                                <div class="input-group">
                                                    <input type="text" class="form-control form-control-lg fw-bold text-navy" id="projects_completed" name="projects_completed" value="<?= e($stats['projects_completed'] ?? '150') ?>" required>
                                                    <span class="input-group-text bg-white fw-bold">Proyek</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="card border bg-light p-3">
                                                <label for="experts_count" class="form-label fw-bold text-navy">Tenaga Ahli</label>
                                                <div class="input-group">
                                                    <input type="text" class="form-control form-control-lg fw-bold text-navy" id="experts_count" name="experts_count" value="<?= e($stats['experts_count'] ?? '50') ?>" required>
                                                    <span class="input-group-text bg-white fw-bold">Orang</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="card border bg-light p-3">
                                                <label for="work_accidents" class="form-label fw-bold text-navy">Kecelakaan Kerja (K3 / Zero Accident)</label>
                                                <div class="input-group">
                                                    <input type="text" class="form-control form-control-lg fw-bold text-navy" id="work_accidents" name="work_accidents" value="<?= e($stats['work_accidents'] ?? '0') ?>" required>
                                                    <span class="input-group-text bg-white fw-bold">Kasus</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="d-flex justify-content-end mt-4">
                                        <button type="submit" class="btn btn-danger px-5 py-2.5 fw-bold text-white shadow-sm">
                                            <i class="bi bi-check-circle-fill me-2"></i> Simpan Statistik
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <!-- ================= TAB 6: REQUEST QUOTATION ================= -->
                    <div class="tab-pane fade <?= $activeTab === 'quotations' ? 'show active' : '' ?>" id="tab-quotations" role="tabpanel">
                        <div class="card border-0 shadow-sm rounded-4">
                            <div class="card-header bg-white py-3">
                                <h5 class="card-title text-navy mb-0 fw-bold"><i class="bi bi-file-earmark-spreadsheet me-2 text-danger"></i>Daftar Pengajuan Request Quotation (Penawaran)</h5>
                            </div>
                            <div class="card-body p-0">
                                <div class="table-responsive">
                                    <table class="table table-hover table-striped align-middle mb-0 text-sm">
                                        <thead class="table-light text-navy fw-bold text-xs uppercase">
                                            <tr>
                                                <th class="ps-4">Nama / Perusahaan</th>
                                                <th>Kontak Info</th>
                                                <th>Jenis Proyek</th>
                                                <th>Status</th>
                                                <th class="text-end pe-4">Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php if (!empty($quotations)): ?>
                                                <?php foreach ($quotations as $quotation): ?>
                                                    <?php
                                                    $qId     = $quotation['id'];
                                                    $qStatus = strtolower((string)($quotation['status'] ?? 'pending'));
                                                    ?>
                                                    <tr>
                                                        <td class="ps-4">
                                                            <strong class="text-navy d-block"><?= e($quotation['name']) ?></strong>
                                                            <span class="text-xs text-muted"><?= e($quotation['company_name'] ?? 'Personal') ?></span>
                                                        </td>
                                                        <td>
                                                            <div><i class="bi bi-envelope me-1 text-muted"></i><?= e($quotation['email']) ?></div>
                                                            <small class="text-muted"><i class="bi bi-whatsapp me-1 text-success"></i><?= e($quotation['whatsapp']) ?></small>
                                                        </td>
                                                        <td><?= e($quotation['project_type']) ?></td>
                                                        <td>
                                                            <form action="<?= e(route('admin.home-editor')) ?>" method="POST" class="d-inline">
                                                                <input type="hidden" name="_token" value="<?= e($csrfToken) ?>">
                                                                <input type="hidden" name="_action" value="update_quotation_status">
                                                                <input type="hidden" name="_tab" value="quotations">
                                                                <input type="hidden" name="quotation_id" value="<?= e((string)$qId) ?>">
                                                                <select name="status" class="form-select form-select-sm border-0 bg-light fw-bold text-xs" onchange="this.form.submit()">
                                                                    <option value="pending" <?= $qStatus === 'pending' ? 'selected' : '' ?>>Pending</option>
                                                                    <option value="reviewed" <?= $qStatus === 'reviewed' ? 'selected' : '' ?>>Reviewed</option>
                                                                    <option value="approved" <?= $qStatus === 'approved' ? 'selected' : '' ?>>Approved</option>
                                                                    <option value="rejected" <?= $qStatus === 'rejected' ? 'selected' : '' ?>>Rejected</option>
                                                                </select>
                                                            </form>
                                                        </td>
                                                        <td class="text-end pe-4">
                                                            <div class="btn-group">
                                                                <a href="<?= e(route('admin.quotations.show', ['id' => $qId])) ?>" class="btn btn-outline-primary btn-sm rounded-circle me-1" title="Detail"><i class="bi bi-eye"></i></a>
                                                                <form action="<?= e(route('admin.quotations.destroy')) ?>" method="POST" class="d-inline" onsubmit="return confirm('Yakin hapus quotation ini?');">
                                                                    <input type="hidden" name="_token" value="<?= e($csrfToken) ?>">
                                                                    <input type="hidden" name="_action" value="DELETE">
                                                                    <input type="hidden" name="id" value="<?= e((string) $qId) ?>">
                                                                    <button type="submit" class="btn btn-outline-danger btn-sm rounded-circle" title="Hapus"><i class="bi bi-trash"></i></button>
                                                                </form>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                <?php endforeach; ?>
                                            <?php else: ?>
                                                <tr>
                                                    <td colspan="5" class="text-center py-4 text-muted">Belum ada pengajuan quotation.</td>
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
