<?php
/**
 * resources/views/auth/login.php
 * ─────────────────────────────────────────────────────────────────────────────
 * Halaman login admin — PHP native konversi dari login.blade.php
 * Desain identik dengan versi Blade (Bootstrap 5 + Bootstrap Icons).
 *
 * Alur:
 *   GET  → tampilkan form login
 *   POST → proses login, redirect ke dashboard jika berhasil
 *
 * TIDAK mengubah: login.blade.php asli.
 * ─────────────────────────────────────────────────────────────────────────────
 */

declare(strict_types=1);

// ── Bootstrap ─────────────────────────────────────────────────────────────────
$appRoot = dirname(__DIR__, 3); // construction-website/
require_once $appRoot . '/native/db.php';
require_once $appRoot . '/native/auth.php';
require_once __DIR__ . '/../native_helpers.php';

// Jika sudah login, redirect ke dashboard
auth_redirect_if_logged_in();

// ── Proses POST Login ─────────────────────────────────────────────────────────
$errors  = [];
$oldEmail = '';
$statusMsg = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Verifikasi CSRF
    $submittedToken = $_POST['_token'] ?? '';
    if (!auth_verify_csrf($submittedToken)) {
        $errors[] = 'Token keamanan tidak valid. Silakan muat ulang halaman.';
    } else {
        $email    = trim($_POST['email'] ?? '');
        $password = $_POST['password'] ?? '';
        $oldEmail = htmlspecialchars($email, ENT_QUOTES, 'UTF-8');

        $result = auth_login($email, $password);

        if ($result['success']) {
            // Login berhasil — redirect ke intended URL atau dashboard
            auth_start_session();
            $intended = $_SESSION['_intended_url'] ?? '';
            unset($_SESSION['_intended_url']);

            $dashboardUrl = _auth_dashboard_url();
            $redirectTo = !empty($intended) ? $intended : $dashboardUrl;

            header('Location: ' . $redirectTo);
            exit;
        } else {
            $errors[] = $result['message'];
        }
    }
}

// ── Baca pesan status dari session (misal: setelah logout) ────────────────────
auth_start_session();
if (!empty($_SESSION['_flash_status'])) {
    $statusMsg = $_SESSION['_flash_status'];
    unset($_SESSION['_flash_status']);
}

// ── Generate CSRF token baru jika belum ada ───────────────────────────────────
$csrfToken = auth_csrf_token();

// ── Tentukan base URL ─────────────────────────────────────────────────────────
$baseUrl = _auth_base_url();
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Masuk Admin — PT Multi Power Abadi</title>
    <meta name="description" content="Halaman login panel admin PT Multi Power Abadi. Masukkan kredensial Anda untuk mengelola website.">
    <meta name="robots" content="noindex, nofollow">

    <!-- Bootstrap 5 CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        :root {
            --navy:         #0A1628;
            --navy-light:   #162040;
            --accent-red:   #C0392B;
            --accent-orange:#E05C1A;
            --accent-gold:  #D4A017;
            --text-muted:   #6c757d;
        }

        * { box-sizing: border-box; }

        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, var(--navy) 0%, var(--navy-light) 50%, #1a2a4a 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 1rem;
            position: relative;
            overflow: hidden;
        }

        /* Background decorative circles */
        body::before, body::after {
            content: '';
            position: fixed;
            border-radius: 50%;
            pointer-events: none;
        }
        body::before {
            width: 500px; height: 500px;
            background: radial-gradient(circle, rgba(192,57,43,0.12) 0%, transparent 70%);
            top: -100px; right: -100px;
        }
        body::after {
            width: 400px; height: 400px;
            background: radial-gradient(circle, rgba(212,160,23,0.08) 0%, transparent 70%);
            bottom: -80px; left: -80px;
        }

        /* Card */
        .login-card {
            background: rgba(255,255,255,0.97);
            border-radius: 20px;
            box-shadow: 0 25px 60px rgba(0,0,0,0.4), 0 0 0 1px rgba(255,255,255,0.1);
            padding: 2.5rem;
            width: 100%;
            max-width: 440px;
            position: relative;
            z-index: 1;
            animation: slideUp 0.5s ease-out;
        }

        @keyframes slideUp {
            from { opacity: 0; transform: translateY(30px); }
            to   { opacity: 1; transform: translateY(0); }
        }

        /* Logo area */
        .login-logo {
            width: 64px; height: 64px;
            background: linear-gradient(135deg, var(--accent-red), var(--accent-orange));
            border-radius: 16px;
            display: flex; align-items: center; justify-content: center;
            margin: 0 auto 1rem;
            box-shadow: 0 8px 20px rgba(192,57,43,0.35);
        }
        .login-logo i { font-size: 1.8rem; color: #fff; }

        /* Typography */
        .text-navy    { color: var(--navy) !important; }
        .text-sm      { font-size: 0.875rem; }
        .text-xs      { font-size: 0.75rem; }

        /* Form controls */
        .form-label.fw-bold { color: var(--navy); font-size: 0.875rem; }

        .input-group-text {
            background: #f8f9fa;
            color: var(--text-muted);
            border-right: none;
        }
        .form-control {
            border-left: none;
            padding: 0.6rem 0.75rem;
            transition: border-color 0.2s, box-shadow 0.2s;
        }
        .form-control:focus {
            border-color: var(--accent-orange);
            box-shadow: 0 0 0 0.2rem rgba(224,92,26,0.18);
        }
        .input-group:focus-within .input-group-text {
            border-color: var(--accent-orange);
        }

        /* Submit button */
        .btn-login {
            background: linear-gradient(135deg, var(--accent-red), var(--accent-orange));
            border: none;
            color: #fff;
            font-weight: 600;
            padding: 0.75rem;
            border-radius: 10px;
            transition: transform 0.2s, box-shadow 0.2s, opacity 0.2s;
            box-shadow: 0 4px 15px rgba(192,57,43,0.35);
        }
        .btn-login:hover {
            transform: translateY(-1px);
            box-shadow: 0 6px 20px rgba(192,57,43,0.45);
            opacity: 0.95;
        }
        .btn-login:active { transform: translateY(0); }

        /* Divider */
        .login-divider {
            border-top: 1px solid #e9ecef;
            margin: 1.5rem 0;
        }

        /* Footer back link */
        .back-link {
            color: var(--text-muted);
            text-decoration: none;
            font-size: 0.8rem;
            transition: color 0.2s;
        }
        .back-link:hover { color: var(--accent-orange); }

        /* Error & success alerts */
        .alert { font-size: 0.875rem; border-radius: 10px; }

        /* Password toggle button */
        .btn-toggle-pw {
            background: #f8f9fa;
            border-left: none;
            border-color: #ced4da;
            color: var(--text-muted);
            transition: color 0.2s;
        }
        .btn-toggle-pw:hover { color: var(--navy); background: #f8f9fa; }
        .form-control:focus ~ .btn-toggle-pw,
        .input-group:focus-within .btn-toggle-pw {
            border-color: var(--accent-orange);
        }
    </style>
</head>
<body>
    <div class="login-card">

        <!-- Logo & Header -->
        <div class="text-center mb-4">
            <div class="login-logo">
                <i class="bi bi-shield-lock-fill"></i>
            </div>
            <h4 class="fw-bold text-navy mb-1">Masuk Admin</h4>
            <p class="text-muted text-sm mb-0">Masukkan email dan kata sandi akun admin Anda.</p>
        </div>

        <!-- Status message (misal: berhasil logout) -->
        <?php if ($statusMsg): ?>
            <div class="alert alert-success alert-dismissible fade show text-sm mb-4" role="alert">
                <?= htmlspecialchars($statusMsg, ENT_QUOTES, 'UTF-8') ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Tutup"></button>
            </div>
        <?php endif; ?>

        <!-- Error messages -->
        <?php if (!empty($errors)): ?>
            <div class="alert alert-danger alert-dismissible fade show text-sm mb-4" role="alert">
                <i class="bi bi-exclamation-triangle-fill me-2"></i>
                <?php foreach ($errors as $err): ?>
                    <?= htmlspecialchars($err, ENT_QUOTES, 'UTF-8') ?>
                <?php endforeach; ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Tutup"></button>
            </div>
        <?php endif; ?>

        <!-- Login Form -->
        <form method="POST" action="" novalidate>
            <input type="hidden" name="_token" value="<?= htmlspecialchars($csrfToken, ENT_QUOTES, 'UTF-8') ?>">

            <!-- Email -->
            <div class="mb-3">
                <label for="email" class="form-label fw-bold text-navy text-sm">Alamat Email</label>
                <div class="input-group">
                    <span class="input-group-text border-end-0">
                        <i class="bi bi-envelope"></i>
                    </span>
                    <input
                        id="email"
                        type="email"
                        class="form-control border-start-0 py-2<?= !empty($errors) && !$statusMsg ? ' is-invalid' : '' ?>"
                        name="email"
                        value="<?= htmlspecialchars($oldEmail, ENT_QUOTES, 'UTF-8') ?>"
                        required
                        autofocus
                        autocomplete="username"
                        placeholder="Masukkan email admin"
                    >
                </div>
            </div>

            <!-- Password -->
            <div class="mb-3">
                <div class="d-flex justify-content-between align-items-center mb-1">
                    <label for="password" class="form-label fw-bold text-navy text-sm mb-0">Kata Sandi</label>
                </div>
                <div class="input-group">
                    <span class="input-group-text border-end-0">
                        <i class="bi bi-lock"></i>
                    </span>
                    <input
                        id="password"
                        type="password"
                        class="form-control border-start-0 border-end-0 py-2<?= !empty($errors) ? ' is-invalid' : '' ?>"
                        name="password"
                        required
                        autocomplete="current-password"
                        placeholder="Masukkan kata sandi"
                    >
                    <button type="button" class="btn btn-toggle-pw border" id="togglePassword" aria-label="Tampilkan/sembunyikan kata sandi">
                        <i class="bi bi-eye" id="togglePwIcon"></i>
                    </button>
                </div>
            </div>

            <!-- Remember Me -->
            <div class="mb-4 form-check">
                <input type="checkbox" class="form-check-input" id="remember_me" name="remember">
                <label class="form-check-label text-sm text-muted" for="remember_me">Ingat Saya</label>
            </div>

            <!-- Submit -->
            <div class="d-grid mb-3">
                <button type="submit" id="loginBtn" class="btn btn-login btn-lg fw-semibold">
                    <i class="bi bi-box-arrow-in-right me-2"></i> Masuk ke Admin Panel
                </button>
            </div>
        </form>

        <hr class="login-divider">

        <!-- Back to website -->
        <div class="text-center">
            <a href="<?= $baseUrl . '/welcome.php' ?>" class="back-link">
                <i class="bi bi-arrow-left me-1"></i> Kembali ke Website
            </a>
        </div>

    </div>

    <!-- Bootstrap 5 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Toggle show/hide password
        const toggleBtn  = document.getElementById('togglePassword');
        const pwInput    = document.getElementById('password');
        const toggleIcon = document.getElementById('togglePwIcon');

        if (toggleBtn && pwInput) {
            toggleBtn.addEventListener('click', function () {
                const isPassword = pwInput.type === 'password';
                pwInput.type = isPassword ? 'text' : 'password';
                toggleIcon.className = isPassword ? 'bi bi-eye-slash' : 'bi bi-eye';
            });
        }

        // Loading state saat submit
        const loginForm = document.querySelector('form');
        const loginBtn  = document.getElementById('loginBtn');
        if (loginForm && loginBtn) {
            loginForm.addEventListener('submit', function () {
                loginBtn.disabled = true;
                loginBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-2" role="status"></span> Memproses...';
            });
        }
    </script>
</body>
</html>
