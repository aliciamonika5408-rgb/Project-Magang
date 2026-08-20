<?php
/**
 * native/test_db.php
 * ─────────────────────────────────────────────────────────────────────────────
 * Script tes koneksi database PHP native.
 * Jalankan via CLI:  php native/test_db.php
 * Atau via XAMPP:    http://localhost/construction-website/native/test_db.php
 *
 * HAPUS atau LINDUNGI file ini setelah pengujian selesai di production!
 * ─────────────────────────────────────────────────────────────────────────────
 */

declare(strict_types=1);

require_once __DIR__ . '/db.php';

// ─── Deteksi mode output (CLI vs browser) ────────────────────────────────────
$isCli = PHP_SAPI === 'cli';
$nl    = $isCli ? PHP_EOL : '<br>';
$bold  = fn(string $s) => $isCli ? "\033[1m{$s}\033[0m" : "<strong>{$s}</strong>";
$green = fn(string $s) => $isCli ? "\033[32m{$s}\033[0m" : "<span style='color:#16a34a'>{$s}</span>";
$red   = fn(string $s) => $isCli ? "\033[31m{$s}\033[0m" : "<span style='color:#dc2626'>{$s}</span>";
$gray  = fn(string $s) => $isCli ? "\033[90m{$s}\033[0m" : "<span style='color:#6b7280'>{$s}</span>";

if (!$isCli) {
    echo '<!DOCTYPE html><html lang="id"><head><meta charset="utf-8">';
    echo '<title>DB Test – PT Multi Power Abadi</title>';
    echo '<style>body{font-family:monospace;padding:2rem;background:#0f172a;color:#e2e8f0}';
    echo 'strong{color:#fbbf24}pre{background:#1e293b;padding:1rem;border-radius:.5rem;overflow-x:auto}</style>';
    echo '</head><body>';
}

echo $nl;
echo $bold('═══════════════════════════════════════════════════') . $nl;
echo $bold('  TES KONEKSI DATABASE – PHP Native PDO') . $nl;
echo $bold('  PT Multi Power Abadi Construction Website') . $nl;
echo $bold('═══════════════════════════════════════════════════') . $nl . $nl;

// ─── 1. Info Koneksi ─────────────────────────────────────────────────────────
echo $bold('1. Informasi Koneksi') . $nl;
echo $gray('   ─────────────────────────────────') . $nl;

$info = db_info();

if ($info['connected']) {
    echo $green('   ✔ Koneksi BERHASIL') . $nl;
    echo "   Driver   : " . strtoupper($info['driver']) . $nl;
    echo "   Database : " . $info['database'] . $nl;

    if ($info['driver'] === 'sqlite') {
        $dbPath = NATIVE_APP_ROOT . '/' . native_env('DB_DATABASE', 'database/database.sqlite');
        echo "   Path     : " . $gray($dbPath) . $nl;
        echo "   Ukuran   : " . number_format((int) @filesize($dbPath) / 1024, 1) . " KB" . $nl;
    } else {
        echo "   Host     : " . native_env('DB_HOST', '127.0.0.1') . ':' . native_env('DB_PORT', '3306') . $nl;
        echo "   User     : " . native_env('DB_USERNAME', 'root') . $nl;
    }
} else {
    echo $red('   ✘ Koneksi GAGAL') . $nl;
    echo $red('   Error: ' . $info['error']) . $nl;
    if (!$isCli) { echo '</body></html>'; }
    exit(1);
}

echo $nl;

// ─── 2. Daftar Tabel ─────────────────────────────────────────────────────────
echo $bold('2. Tabel dalam Database') . $nl;
echo $gray('   ─────────────────────────────────') . $nl;

$driver = native_env('DB_CONNECTION', 'sqlite');

if ($driver === 'sqlite') {
    $tables = db_select("SELECT name FROM sqlite_master WHERE type='table' AND name NOT LIKE 'sqlite_%' ORDER BY name");
    $tables = array_column($tables, 'name');
} else {
    $tables = db_select('SHOW TABLES');
    $tables = array_map('current', $tables);
}

$appTables = ['clients', 'company_settings', 'contacts', 'other_services', 'project_images', 'projects', 'request_quotations', 'services', 'users'];

foreach ($tables as $table) {
    $count  = (int) db_scalar("SELECT COUNT(*) FROM `{$table}`");
    $isApp  = in_array($table, $appTables, true) ? '  ← app' : '';
    $marker = $count > 0 ? $green('●') : $gray('○');
    echo "   {$marker} {$table} {$gray('('.$count.' rows)')}{$isApp}" . $nl;
}

echo $nl;

// ─── 3. Sample Data dari Tabel Utama ─────────────────────────────────────────
echo $bold('3. Sample Data Tabel Utama') . $nl;
echo $gray('   ─────────────────────────────────') . $nl;

// 3a. projects
$projects = db_select('SELECT id, title, category, location, year FROM projects ORDER BY created_at DESC LIMIT 3');
echo $nl;
echo "   " . $bold('[projects]') . " — " . count($projects) . " baris ditemukan" . $nl;
foreach ($projects as $p) {
    echo $gray("   ├─ ") . "[{$p['id']}] {$p['title']} | {$p['category']} | {$p['location']} | {$p['year']}" . $nl;
}
if (empty($projects)) {
    echo $gray("   └─ (kosong)") . $nl;
}

// 3b. company_settings
$settings = db_select('SELECT key, value FROM company_settings ORDER BY key');
echo $nl;
echo "   " . $bold('[company_settings]') . " — " . count($settings) . " baris ditemukan" . $nl;
foreach ($settings as $s) {
    echo $gray("   ├─ ") . "{$s['key']} = {$s['value']}" . $nl;
}
if (empty($settings)) {
    echo $gray("   └─ (kosong)") . $nl;
}

// 3c. services
$services = db_select('SELECT id, title, slug FROM services LIMIT 3');
echo $nl;
echo "   " . $bold('[services]') . " — " . count($services) . " baris ditemukan" . $nl;
foreach ($services as $s) {
    echo $gray("   ├─ ") . "[{$s['id']}] {$s['title']} ({$s['slug']})" . $nl;
}
if (empty($services)) {
    echo $gray("   └─ (kosong — isi data dulu melalui Laravel admin)") . $nl;
}

echo $nl;

// ─── 4. Tes Prepared Statement ───────────────────────────────────────────────
echo $bold('4. Tes Prepared Statement (db_find)') . $nl;
echo $gray('   ─────────────────────────────────') . $nl;

$firstProject = db_find('SELECT * FROM projects LIMIT 1');
if ($firstProject !== null) {
    echo $green('   ✔ db_find() berhasil') . $nl;
    echo "   Kolom tersedia: " . implode(', ', array_keys($firstProject)) . $nl;
} else {
    echo $gray('   ⚠ Tabel projects kosong — tidak ada data untuk di-fetch') . $nl;
}

echo $nl;

// ─── 5. Tes db_scalar ────────────────────────────────────────────────────────
echo $bold('5. Tes db_scalar (COUNT)') . $nl;
echo $gray('   ─────────────────────────────────') . $nl;

$totalProjects = (int) db_scalar('SELECT COUNT(*) FROM projects');
echo $green('   ✔ db_scalar() berhasil') . $nl;
echo "   Total projects: {$totalProjects}" . $nl;

echo $nl;

// ─── Ringkasan ───────────────────────────────────────────────────────────────
echo $bold('═══════════════════════════════════════════════════') . $nl;
echo $green('  ✔ SEMUA TES LULUS — Koneksi PDO siap digunakan') . $nl;
echo $bold('═══════════════════════════════════════════════════') . $nl . $nl;

echo $gray("  PHP     : " . PHP_VERSION) . $nl;
echo $gray("  Driver  : " . strtoupper($info['driver'])) . $nl;
echo $gray("  Waktu   : " . date('Y-m-d H:i:s')) . $nl . $nl;

if (!$isCli) {
    echo '</body></html>';
}
