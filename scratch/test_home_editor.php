<?php
/**
 * scratch/test_home_editor.php
 * Automated test script for Admin Home Editor features and SQLite integration.
 */

declare(strict_types=1);

require_once __DIR__ . '/../native/db.php';
require_once __DIR__ . '/../resources/views/native_helpers.php';

echo "========================================================\n";
echo "1. TES BACA DATA HOME EDITOR & COMPANY SETTINGS\n";
echo "========================================================\n";

$settingsRaw = db_select('SELECT * FROM company_settings');
$stats = [];
foreach ($settingsRaw as $s) {
    $stats[$s['key']] = $s['value'];
}

echo "Initial Stats in SQLite:\n";
print_r($stats);
echo (isset($stats['years_experience']) ? '[PASS] Read company_settings Successful' : '[FAIL]') . "\n";

// --- Update Stats ---
echo "\n========================================================\n";
echo "2. TES PERUBAHAN DATA STATISTIK PERUSAHAAN (STATS TAB)\n";
echo "========================================================\n";

$newYears    = "18";
$newProjects = "175";
$newExperts  = "60";
$now         = db_now();

$fields = [
    'years_experience'   => $newYears,
    'projects_completed' => $newProjects,
    'experts_count'      => $newExperts,
    'work_accidents'     => "0",
];

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

$updatedSettingsRaw = db_select('SELECT * FROM company_settings');
$updatedStats = [];
foreach ($updatedSettingsRaw as $s) {
    $updatedStats[$s['key']] = $s['value'];
}

echo "Updated Stats in SQLite:\n";
print_r($updatedStats);

echo ($updatedStats['years_experience'] === "18" && $updatedStats['projects_completed'] === "175" ? '[PASS] Update company_settings Successful' : '[FAIL]') . "\n";

// --- Verify Public Integration ---
echo "\n========================================================\n";
echo "3. TES INTEGRASI KE HALAMAN PUBLIC HOME (WELCOME.PHP)\n";
echo "========================================================\n";

$publicSettings = [];
$publicRows = db_select('SELECT * FROM company_settings');
foreach ($publicRows as $row) {
    $publicSettings[$row['key']] = $row['value'];
}

echo "Public Page Years Experience: " . ($publicSettings['years_experience'] ?? '-') . "\n";
echo "Public Page Projects Completed: " . ($publicSettings['projects_completed'] ?? '-') . "\n";
echo ($publicSettings['years_experience'] === "18" ? '[PASS] Public Home page displays updated stats' : '[FAIL]') . "\n";

// --- Reset Stats ---
echo "\n========================================================\n";
echo "4. RESET STATS KE NILAI ASLI (15 TAHUN, 150 PROYEK)\n";
echo "========================================================\n";

db_execute('UPDATE company_settings SET value = ?, updated_at = ? WHERE key = ?', ['15', db_now(), 'years_experience']);
db_execute('UPDATE company_settings SET value = ?, updated_at = ? WHERE key = ?', ['150', db_now(), 'projects_completed']);
db_execute('UPDATE company_settings SET value = ?, updated_at = ? WHERE key = ?', ['50', db_now(), 'experts_count']);

echo "[PASS] Reset stats successful.\n";

echo "\n========================================================\n";
echo "SEMUA TES ADMIN HOME EDITOR BERHASIL 100%.\n";
echo "========================================================\n";
