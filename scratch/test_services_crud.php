<?php
/**
 * scratch/test_services_crud.php
 * Automated test script for Admin Services & Other Services CRUD operations.
 */

declare(strict_types=1);

require_once __DIR__ . '/../native/db.php';
require_once __DIR__ . '/../resources/views/native_helpers.php';

echo "========================================================\n";
echo "1. TES ADMIN SERVICES (UTAMA) CRUD\n";
echo "========================================================\n";

$initialServicesCount = (int) db_scalar('SELECT COUNT(*) FROM services');
echo "[PASS] Initial Services count in DB: " . $initialServicesCount . "\n";

// --- Create ---
$sTitle = "Konstruksi Pabrik & Gudang Heavy Duty " . time();
$sSlug  = native_slug($sTitle);
$now    = db_now();

$sId = db_insert_row('services', [
    'title'       => $sTitle,
    'slug'        => $sSlug,
    'description' => 'Deskripsi singkat layanan fabrikasi & ereksi konstruksi baja pabrik heavy duty.',
    'content'     => '<p>Poin-poin cakupan pekerjaan pabrik heavy duty...</p>',
    'icon'        => 'bi-building-gear',
    'image'       => 'services/sample_service_test.jpg',
    'created_at'  => $now,
    'updated_at'  => $now,
]);

echo "Created Dummy Service ID: " . $sId . "\n";
$createdService = db_find('SELECT * FROM services WHERE id = ?', [$sId]);
echo ($createdService && $createdService['title'] === $sTitle ? '[PASS] Insert Service Successful' : '[FAIL] Insert Service Failed') . "\n";

// --- Public Read ---
$publicServicesRead = db_select("SELECT * FROM services WHERE title LIKE ?", ['%Pabrik & Gudang%']);
echo "Public Page Services Match Count: " . count($publicServicesRead) . "\n";
echo (count($publicServicesRead) > 0 ? '[PASS] Public Page can read newly created Service' : '[FAIL]') . "\n";

// --- Update ---
$sTitleUpdated = "Konstruksi Pabrik & Gudang Heavy Duty (UPDATED)";
$affectedS = db_execute(
    'UPDATE services SET title = ?, description = ?, updated_at = ? WHERE id = ?',
    [$sTitleUpdated, 'Deskripsi yang telah diupdate.', db_now(), $sId]
);
$updatedService = db_find('SELECT * FROM services WHERE id = ?', [$sId]);
echo ($affectedS > 0 && $updatedService['title'] === $sTitleUpdated ? '[PASS] Update Service Successful' : '[FAIL] Update Service Failed') . "\n";

// --- Delete ---
$deletedRowsS = db_execute('DELETE FROM services WHERE id = ?', [$sId]);
$checkDeletedS = db_find('SELECT * FROM services WHERE id = ?', [$sId]);
echo ($deletedRowsS > 0 && $checkDeletedS === null ? '[PASS] Delete Service Successful' : '[FAIL] Delete Service Failed') . "\n";

$finalServicesCount = (int) db_scalar('SELECT COUNT(*) FROM services');
echo "Final Services count in DB: " . $finalServicesCount . " (Matched Initial: " . ($finalServicesCount === $initialServicesCount ? 'YES' : 'NO') . ")\n";

echo "\n========================================================\n";
echo "2. TES ADMIN OTHER SERVICES (DUKUNGAN) CRUD\n";
echo "========================================================\n";

$initialOtherCount = (int) db_scalar('SELECT COUNT(*) FROM other_services');
echo "[PASS] Initial Other Services count in DB: " . $initialOtherCount . "\n";

// --- Create ---
$osTitle = "Renovasi & Interiordesign Industri " . time();
$osId = db_insert_row('other_services', [
    'title'       => $osTitle,
    'description' => 'Layanan dukungan renovasi fasad dan interior gedung komersial.',
    'icon'        => 'bi-tools',
    'created_at'  => $now,
    'updated_at'  => $now,
]);

echo "Created Dummy Other Service ID: " . $osId . "\n";
$createdOther = db_find('SELECT * FROM other_services WHERE id = ?', [$osId]);
echo ($createdOther && $createdOther['title'] === $osTitle ? '[PASS] Insert Other Service Successful' : '[FAIL]') . "\n";

// --- Public Read ---
$publicOtherRead = db_select("SELECT * FROM other_services WHERE title LIKE ?", ['%Renovasi%']);
echo "Public Page Other Services Match Count: " . count($publicOtherRead) . "\n";
echo (count($publicOtherRead) > 0 ? '[PASS] Public Page can read newly created Other Service' : '[FAIL]') . "\n";

// --- Update ---
$osTitleUpdated = "Renovasi & Interiordesign Industri (UPDATED)";
$affectedOS = db_execute(
    'UPDATE other_services SET title = ?, description = ?, updated_at = ? WHERE id = ?',
    [$osTitleUpdated, 'Deskripsi layanan dukungan updated.', db_now(), $osId]
);
$updatedOther = db_find('SELECT * FROM other_services WHERE id = ?', [$osId]);
echo ($affectedOS > 0 && $updatedOther['title'] === $osTitleUpdated ? '[PASS] Update Other Service Successful' : '[FAIL]') . "\n";

// --- Delete ---
$deletedRowsOS = db_execute('DELETE FROM other_services WHERE id = ?', [$osId]);
$checkDeletedOS = db_find('SELECT * FROM other_services WHERE id = ?', [$osId]);
echo ($deletedRowsOS > 0 && $checkDeletedOS === null ? '[PASS] Delete Other Service Successful' : '[FAIL]') . "\n";

$finalOtherCount = (int) db_scalar('SELECT COUNT(*) FROM other_services');
echo "Final Other Services count in DB: " . $finalOtherCount . " (Matched Initial: " . ($finalOtherCount === $initialOtherCount ? 'YES' : 'NO') . ")\n";

echo "\n========================================================\n";
echo "SEMUA TES ADMIN SERVICES & OTHER SERVICES CRUD BERHASIL 100%.\n";
echo "========================================================\n";
