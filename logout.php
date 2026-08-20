<?php
/**
 * logout.php
 * ─────────────────────────────────────────────────────────────────────────────
 * Handler Logout Admin PHP Native PT Multi Power Abadi.
 *
 * Menghapus data session, menghancurkan cookie session, dan mengarahkan
 * user kembali ke halaman login admin.
 * ─────────────────────────────────────────────────────────────────────────────
 */

declare(strict_types=1);

require_once __DIR__ . '/native/db.php';
require_once __DIR__ . '/native/auth.php';

// Jalankan proses logout dan redirect
auth_logout();
