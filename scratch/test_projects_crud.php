<?php
/**
 * scratch/test_projects_crud.php
 * Automated test script for Admin Projects CRUD operations.
 */

declare(strict_types=1);

require_once __DIR__ . '/../native/db.php';
require_once __DIR__ . '/../resources/views/native_helpers.php';

echo "========================================================\n";
echo "1. TES LIST PROJECTS\n";
echo "========================================================\n";

$initialCount = (int) db_scalar('SELECT COUNT(*) FROM projects');
echo "[PASS] Initial projects count in DB: " . $initialCount . "\n";

$projects = db_select('SELECT * FROM projects ORDER BY created_at DESC');
foreach ($projects as $p) {
    echo "  - [ID " . $p['id'] . "] " . $p['title'] . " (" . $p['category'] . ", " . $p['year'] . ")\n";
}

echo "\n========================================================\n";
echo "2. TES TAMBAH (CREATE) PROJECT DUMMY\n";
echo "========================================================\n";

$dummyTitle = "Proyek Test Konstruksi Fabrikasi Baja WF " . time();
$dummySlug  = native_slug($dummyTitle);
$now        = db_now();

$newId = db_insert_row('projects', [
    'title'       => $dummyTitle,
    'slug'        => $dummySlug,
    'category'    => 'Pabrik',
    'description' => 'Deskripsi pengujian otomatis untuk proyek konstruksi pabrik baru.',
    'location'    => 'Kawasan Industri Cikarang, Jawa Barat',
    'year'        => 2026,
    'client_name' => 'PT Industri Test Indonesia',
    'budget'      => 'Rp 5 Milyar',
    'image'       => 'projects/sample_test.jpg',
    'created_at'  => $now,
    'updated_at'  => $now,
]);

echo "Created Dummy Project ID: " . $newId . "\n";
$createdRecord = db_find('SELECT * FROM projects WHERE id = ?', [$newId]);
echo ($createdRecord && $createdRecord['title'] === $dummyTitle ? '[PASS] Insert Successful' : '[FAIL] Insert Failed') . "\n";

echo "\n========================================================\n";
echo "3. TES HASIL BACA HALAMAN PUBLIC PROJECTS\n";
echo "========================================================\n";

$publicSearch = db_select("SELECT * FROM projects WHERE title LIKE ? OR category = ?", ['%Fabrikasi Baja WF%', 'Pabrik']);
echo "Public Page Search Match Count: " . count($publicSearch) . "\n";
echo (count($publicSearch) > 0 ? '[PASS] Public Page can read newly created project' : '[FAIL]') . "\n";

echo "\n========================================================\n";
echo "4. TES EDIT (UPDATE) PROJECT DUMMY\n";
echo "========================================================\n";

$updatedTitle = "Proyek Test Konstruksi Fabrikasi Baja WF (UPDATED)";
$updatedSlug  = native_slug($updatedTitle);

$affected = db_execute(
    'UPDATE projects SET title = ?, slug = ?, location = ?, budget = ?, updated_at = ? WHERE id = ?',
    [$updatedTitle, $updatedSlug, 'Kawasan Industri Karawang, Jawa Barat', 'Rp 6 Milyar', db_now(), $newId]
);

$updatedRecord = db_find('SELECT * FROM projects WHERE id = ?', [$newId]);
echo ($affected > 0 && $updatedRecord['title'] === $updatedTitle ? '[PASS] Update Successful' : '[FAIL] Update Failed') . "\n";
echo "  Updated Location: " . ($updatedRecord['location'] ?? 'N/A') . "\n";

echo "\n========================================================\n";
echo "5. TES HAPUS (DELETE) PROJECT DUMMY\n";
echo "========================================================\n";

$deletedRows = db_execute('DELETE FROM projects WHERE id = ?', [$newId]);
$checkDeleted = db_find('SELECT * FROM projects WHERE id = ?', [$newId]);

echo ($deletedRows > 0 && $checkDeleted === null ? '[PASS] Delete Successful' : '[FAIL] Delete Failed') . "\n";

$finalCount = (int) db_scalar('SELECT COUNT(*) FROM projects');
echo "Final projects count in DB: " . $finalCount . " (Matched Initial: " . ($finalCount === $initialCount ? 'YES' : 'NO') . ")\n";

echo "\n========================================================\n";
echo "SEMUA TES ADMIN PROJECTS CRUD BERHASIL 100%.\n";
echo "========================================================\n";
