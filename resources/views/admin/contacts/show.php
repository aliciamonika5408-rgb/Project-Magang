<?php
/**
 * resources/views/admin/contacts/show.php
 * ─────────────────────────────────────────────────────────────────────────────
 * Halaman Detail Baca Pesan Kontak Admin PHP Native PT Multi Power Abadi.
 * Konversi dari show.blade.php — 100% PHP Native tanpa Laravel/Blade.
 *
 * Proteksi: auth_require() pada baris teratas.
 * Otomatisasi: Mengubah is_read = 1 saat pesan dibuka oleh Admin.
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

$contactId = (int) ($_GET['id'] ?? $_POST['id'] ?? 0);
if ($contactId <= 0) {
    $_SESSION['error'] = 'ID pesan tidak valid.';
    header('Location: ' . route('admin.contacts.index'));
    exit;
}

// Ambil data pesan dari database
$contact = db_find('SELECT * FROM contacts WHERE id = ?', [$contactId]);
if (!$contact) {
    $_SESSION['error'] = 'Pesan tidak ditemukan.';
    header('Location: ' . route('admin.contacts.index'));
    exit;
}

// Otomatis tandai status is_read = 1 jika pesan belum dibaca
if ((int)($contact['is_read'] ?? 0) === 0) {
    try {
        db_execute('UPDATE contacts SET is_read = 1, updated_at = ? WHERE id = ?', [db_now(), $contactId]);
        $contact['is_read'] = 1;
    } catch (Throwable $e) {
        // Ignored
    }
}

$pageTitle       = 'Baca Pesan - Admin Dashboard';
$headerPageTitle = 'Pesan dari: ' . $contact['name'];
$csrfToken       = auth_csrf_token();

$createdAt = !empty($contact['created_at']) 
    ? date('d M Y - H:i:s', strtotime($contact['created_at'])) . ' WIB' 
    : '-';
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
                            <a class="nav-link active" href="<?= e(route('admin.contacts.index')) ?>">
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

                <div class="row justify-content-center">
                    <div class="col-lg-10">
                        <div class="card border-0 shadow-sm rounded-3 p-4 p-md-5 bg-white">
                            <div class="d-flex flex-wrap justify-content-between align-items-center mb-4 border-bottom pb-3">
                                <div>
                                    <h5 class="fw-bold text-navy mb-1"><i class="bi bi-envelope-paper-fill text-warning me-2"></i><?= e($contact['subject']) ?></h5>
                                    <span class="text-xs text-muted">Dikirim pada: <?= e($createdAt) ?></span>
                                </div>
                                <div class="mt-2 mt-sm-0">
                                    <form action="<?= e(route('admin.contacts.destroy')) ?>" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus pesan ini?');">
                                        <input type="hidden" name="_token" value="<?= e($csrfToken) ?>">
                                        <input type="hidden" name="_action" value="DELETE">
                                        <input type="hidden" name="id" value="<?= e((string) $contactId) ?>">
                                        <button type="submit" class="btn btn-outline-danger"><i class="bi bi-trash me-1"></i> Hapus Pesan</button>
                                    </form>
                                </div>
                            </div>

                            <div class="row g-4 mb-4">
                                <div class="col-md-4">
                                    <span class="text-muted text-xs d-block">NAMA PENGIRIM</span>
                                    <strong class="text-navy fs-6"><?= e($contact['name']) ?></strong>
                                </div>
                                <div class="col-md-4">
                                    <span class="text-muted text-xs d-block">ALAMAT EMAIL</span>
                                    <strong class="text-navy fs-6"><?= e($contact['email']) ?></strong>
                                </div>
                                <div class="col-md-4">
                                    <span class="text-muted text-xs d-block">NOMOR WHATSAPP</span>
                                    <strong class="text-navy fs-6"><?= e($contact['whatsapp'] ?? '-') ?></strong>
                                </div>
                            </div>

                            <span class="text-muted text-xs d-block mb-2">ISI PESAN</span>
                            <div class="bg-light p-4 rounded border text-muted leading-relaxed" style="min-height: 200px;">
                                <?= nl2br(e($contact['message'])) ?>
                            </div>

                            <div class="mt-4 border-top pt-3 text-end">
                                <a href="<?= e(route('admin.contacts.index')) ?>" class="btn btn-navy text-white fw-bold px-4">Kembali ke Inbox</a>
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
