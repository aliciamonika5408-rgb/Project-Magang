<?php
/**
 * scratch/change_admin_password.php
 * Script untuk memperbarui password akun admin di database SQLite menjadi 'adminmpa123'.
 */

declare(strict_types=1);

require_once __DIR__ . '/../native/db.php';

echo "========================================================\n";
echo "1. CEK USER ADMIN SAAT INI DI DATABASE\n";
echo "========================================================\n";

$users = db_select('SELECT id, name, email, password FROM users');
print_r($users);

if (empty($users)) {
    echo "[FAIL] User admin tidak ditemukan di database!\n";
    exit(1);
}

$newPasswordPlain = 'adminmpa123';
$newPasswordHash  = password_hash($newPasswordPlain, PASSWORD_BCRYPT);
$now = db_now();

echo "\n========================================================\n";
echo "2. MEMPERBARUI PASSWORD ADMIN MENJADI '{$newPasswordPlain}'\n";
echo "========================================================\n";

$updatedCount = db_execute(
    'UPDATE users SET password = ?, updated_at = ? WHERE email = ?',
    [$newPasswordHash, $now, 'admin@multipowerabadi.co.id']
);

if ($updatedCount === 0) {
    // Jika email spesifik tidak cocok, update user pertama
    $firstUserId = $users[0]['id'];
    $updatedCount = db_execute(
        'UPDATE users SET password = ?, updated_at = ? WHERE id = ?',
        [$newPasswordHash, $now, $firstUserId]
    );
}

echo "Jumlah baris diupdate: {$updatedCount}\n";

echo "\n========================================================\n";
echo "3. VERIFIKASI HASIL UPDATE PASSWORD\n";
echo "========================================================\n";

$updatedUser = db_find('SELECT id, name, email, password FROM users LIMIT 1');
print_r($updatedUser);

$verifyCheck = password_verify($newPasswordPlain, $updatedUser['password']);

if ($verifyCheck) {
    echo "\n[PASS] Password admin BERHASIL diubah menjadi '{$newPasswordPlain}'!\n";
    echo "[PASS] password_verify('{$newPasswordPlain}', hash) = VALID.\n";
} else {
    echo "\n[FAIL] Verifikasi password gagal!\n";
}
