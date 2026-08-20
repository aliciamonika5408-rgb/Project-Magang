<?php
/**
 * native/auth.php
 * ─────────────────────────────────────────────────────────────────────────────
 * Helper autentikasi PHP native untuk PT Multi Power Abadi.
 *
 * Menyediakan fungsi-fungsi:
 *   - auth_start_session()   : Mulai session dengan konfigurasi aman
 *   - auth_login()           : Verifikasi email+password dan simpan session
 *   - auth_check()           : Cek apakah user sudah login
 *   - auth_user()            : Ambil data user dari session
 *   - auth_require()         : Proteksi halaman admin (redirect jika belum login)
 *   - auth_logout()          : Hapus session dan redirect ke login
 *   - auth_redirect_if_logged_in() : Redirect ke dashboard jika sudah login
 *
 * Cara pemakaian di file PHP native admin:
 *   require_once __DIR__ . '/../../../../native/auth.php';
 *   auth_require(); // Taruh di baris paling atas halaman admin
 *
 * ─────────────────────────────────────────────────────────────────────────────
 */

declare(strict_types=1);

if (!defined('NATIVE_APP_ROOT')) {
    define('NATIVE_APP_ROOT', dirname(__DIR__));
}

// Pastikan db.php sudah dimuat
if (!function_exists('db')) {
    require_once __DIR__ . '/db.php';
}

// ─────────────────────────────────────────────────────────────────────────────
// Konstanta konfigurasi session
// ─────────────────────────────────────────────────────────────────────────────

define('AUTH_SESSION_KEY',    'admin_auth');        // Key utama session login
define('AUTH_TOKEN_KEY',      '_csrf_token');       // Key CSRF token
define('AUTH_REGENERATE_KEY', '_session_created');  // Untuk regenerasi periodik
define('ADMIN_SESSION_LIFETIME', 7200);             // 2 jam dalam detik

// ─────────────────────────────────────────────────────────────────────────────
// 1. Mulai Session Aman
// ─────────────────────────────────────────────────────────────────────────────

/**
 * Mulai session PHP dengan konfigurasi keamanan yang tepat.
 * Aman dipanggil berkali-kali — hanya berjalan sekali.
 */
function auth_start_session(): void
{
    if (session_status() !== PHP_SESSION_NONE) {
        return; // Sudah berjalan
    }

    // Konfigurasi cookie session yang aman (hanya jika header belum terkirim)
    if (!headers_sent()) {
        session_set_cookie_params([
            'lifetime' => ADMIN_SESSION_LIFETIME,
            'path'     => '/',
            'domain'   => '',
            'secure'   => isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off',
            'httponly' => true,   // Tidak bisa diakses JavaScript
            'samesite' => 'Lax',  // Proteksi CSRF dasar
        ]);
        session_start();
    } else if (session_status() === PHP_SESSION_NONE) {
        @session_start();
    }

    // Regenerasi session ID secara periodik (setiap 30 menit) untuk keamanan
    if (session_status() === PHP_SESSION_ACTIVE) {
        if (!isset($_SESSION[AUTH_REGENERATE_KEY])) {
            $_SESSION[AUTH_REGENERATE_KEY] = time();
        } elseif (time() - $_SESSION[AUTH_REGENERATE_KEY] > 1800) {
            if (!headers_sent()) {
                session_regenerate_id(true);
            }
            $_SESSION[AUTH_REGENERATE_KEY] = time();
        }
    }
}

// ─────────────────────────────────────────────────────────────────────────────
// 2. Login
// ─────────────────────────────────────────────────────────────────────────────

/**
 * Verifikasi kredensial user dan buat session login.
 *
 * @param  string $email      Email yang disubmit
 * @param  string $password   Password plaintext yang disubmit
 * @return array{success: bool, message: string, user?: array}
 */
function auth_login(string $email, string $password): array
{
    auth_start_session();

    $email = trim(strtolower($email));

    if (empty($email) || empty($password)) {
        return ['success' => false, 'message' => 'Email dan kata sandi wajib diisi.'];
    }

    // Cari user berdasarkan email (case-insensitive via LOWER)
    $user = db_find(
        'SELECT id, name, email, password FROM users WHERE LOWER(email) = ? LIMIT 1',
        [$email]
    );

    if ($user === null) {
        // Delay kecil untuk mencegah timing attack / user enumeration
        usleep(200000); // 0.2 detik
        return ['success' => false, 'message' => 'Email atau kata sandi salah.'];
    }

    // Verifikasi password dengan password_verify() — aman untuk bcrypt & argon2
    if (!password_verify($password, $user['password'])) {
        usleep(200000);
        return ['success' => false, 'message' => 'Email atau kata sandi salah.'];
    }

    // Login berhasil — regenerasi session ID untuk keamanan
    if (!headers_sent() && session_status() === PHP_SESSION_ACTIVE) {
        session_regenerate_id(true);
    }
    $_SESSION[AUTH_REGENERATE_KEY] = time();

    // Simpan data user ke session (JANGAN simpan password)
    $_SESSION[AUTH_SESSION_KEY] = [
        'id'         => (int) $user['id'],
        'name'       => $user['name'],
        'email'      => $user['email'],
        'logged_in'  => true,
        'login_at'   => time(),
    ];

    return [
        'success' => true,
        'message' => 'Login berhasil.',
        'user'    => [
            'id'    => (int) $user['id'],
            'name'  => $user['name'],
            'email' => $user['email'],
        ],
    ];
}

// ─────────────────────────────────────────────────────────────────────────────
// 3. Cek Status Login
// ─────────────────────────────────────────────────────────────────────────────

/**
 * Kembalikan true jika user sudah login (session valid).
 */
function auth_check(): bool
{
    auth_start_session();

    if (empty($_SESSION[AUTH_SESSION_KEY])) {
        return false;
    }

    $auth = $_SESSION[AUTH_SESSION_KEY];

    // Validasi struktur session
    if (
        empty($auth['logged_in']) ||
        empty($auth['id']) ||
        empty($auth['login_at'])
    ) {
        return false;
    }

    // Cek apakah session sudah expired
    if (time() - $auth['login_at'] > ADMIN_SESSION_LIFETIME) {
        auth_logout_silent();
        return false;
    }

    return (bool) $auth['logged_in'];
}

/**
 * Kembalikan data user yang sedang login, atau null jika belum login.
 *
 * @return array{id: int, name: string, email: string, logged_in: bool, login_at: int}|null
 */
function auth_user(): ?array
{
    if (!auth_check()) {
        return null;
    }
    return $_SESSION[AUTH_SESSION_KEY] ?? null;
}

// ─────────────────────────────────────────────────────────────────────────────
// 4. Proteksi Halaman Admin
// ─────────────────────────────────────────────────────────────────────────────

/**
 * Proteksi halaman admin.
 * Panggil di baris paling atas setiap halaman admin.
 * Jika belum login, redirect ke halaman login.
 */
function auth_require(): void
{
    if (!auth_check()) {
        $loginUrl = _auth_login_url();

        // Simpan URL yang ingin dituju agar bisa redirect setelah login
        auth_start_session();
        $_SESSION['_intended_url'] = $_SERVER['REQUEST_URI'] ?? '';

        header('Location: ' . $loginUrl);
        exit;
    }
}

/**
 * Redirect ke dashboard jika user sudah login.
 * Dipakai di halaman login agar tidak bisa diakses saat sudah login.
 */
function auth_redirect_if_logged_in(): void
{
    if (auth_check()) {
        $dashboardUrl = _auth_dashboard_url();
        header('Location: ' . $dashboardUrl);
        exit;
    }
}

// ─────────────────────────────────────────────────────────────────────────────
// 5. Logout
// ─────────────────────────────────────────────────────────────────────────────

/**
 * Logout user: hapus data session, hancurkan session, redirect ke login.
 */
function auth_logout(): void
{
    auth_start_session();
    auth_logout_silent();

    // Mulai session baru bersih untuk pesan flash logout
    auth_start_session();
    $_SESSION['_flash_status'] = 'Anda telah berhasil keluar (logout).';

    $loginUrl = _auth_login_url();
    header('Location: ' . $loginUrl);
    exit;
}

/**
 * Hapus data session tanpa redirect (digunakan internal).
 */
function auth_logout_silent(): void
{
    auth_start_session();

    // Hapus data auth dari session
    unset($_SESSION[AUTH_SESSION_KEY]);
    unset($_SESSION['_intended_url']);

    // Hapus semua data session dan hancurkan
    $_SESSION = [];

    // Hapus cookie session dari browser jika header belum terkirim
    if (ini_get('session.use_cookies') && !headers_sent()) {
        $params = session_get_cookie_params();
        setcookie(
            session_name(),
            '',
            time() - 42000,
            $params['path'],
            $params['domain'],
            $params['secure'],
            $params['httponly']
        );
    }

    if (session_status() === PHP_SESSION_ACTIVE) {
        session_destroy();
    }
}

// ─────────────────────────────────────────────────────────────────────────────
// 6. CSRF Token
// ─────────────────────────────────────────────────────────────────────────────

/**
 * Generate atau ambil CSRF token untuk form.
 */
function auth_csrf_token(): string
{
    auth_start_session();
    if (empty($_SESSION[AUTH_TOKEN_KEY])) {
        $_SESSION[AUTH_TOKEN_KEY] = bin2hex(random_bytes(32));
    }
    return $_SESSION[AUTH_TOKEN_KEY];
}

/**
 * Verifikasi CSRF token dari POST request.
 * Kembalikan true jika valid.
 */
function auth_verify_csrf(?string $token): bool
{
    auth_start_session();
    $stored = $_SESSION[AUTH_TOKEN_KEY] ?? '';
    if (empty($stored) || empty($token)) {
        return false;
    }
    return hash_equals($stored, $token);
}

// ─────────────────────────────────────────────────────────────────────────────
// 7. URL Helper Internal
// ─────────────────────────────────────────────────────────────────────────────

/**
 * Bangun URL login berdasarkan struktur direktori file yang memanggil.
 * Deteksi otomatis base URL dari REQUEST_URI.
 */
function _auth_login_url(): string
{
    return _auth_base_url() . '/resources/views/auth/login.php';
}

/**
 * Bangun URL dashboard admin.
 */
function _auth_dashboard_url(): string
{
    return _auth_base_url() . '/resources/views/admin/dashboard.php';
}

/**
 * Deteksi base URL dari server (subfolder XAMPP aware).
 */
function _auth_base_url(): string
{
    // Cek apakah ada subfolder (misal /construction-website)
    $scriptName = $_SERVER['SCRIPT_NAME'] ?? '';
    if (preg_match('#^(/[^/]+)#', $scriptName, $m)) {
        $known = ['/resources', '/public', '/native', '/index.php', '/welcome.php',
                  '/app', '/vendor', '/storage', '/config', '/database', '/logout.php'];
        $sub = $m[1];
        if (!in_array(strtolower($sub), $known, true)) {
            return $sub; // subfolder seperti /construction-website
        }
    }
    return '';
}
