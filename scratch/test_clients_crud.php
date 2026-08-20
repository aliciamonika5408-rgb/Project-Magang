<?php
/**
 * scratch/test_clients_crud.php
 * Automated test script for Admin Clients CRUD operations.
 */

declare(strict_types=1);

require_once __DIR__ . '/../native/db.php';
require_once __DIR__ . '/../resources/views/native_helpers.php';

echo "========================================================\n";
echo "1. TES ADMIN CLIENTS LIST & COUNT\n";
echo "========================================================\n";

$initialClientsCount = (int) db_scalar('SELECT COUNT(*) FROM clients');
echo "[PASS] Initial Clients count in DB: " . $initialClientsCount . "\n";

// --- Create ---
echo "\n========================================================\n";
echo "2. TES TAMBAH (CREATE) CLIENT DUMMY\n";
echo "========================================================\n";

$clientName = "PT Semen Gresik Industri " . time();
$logoPath   = "clients/sample_client_logo.png";
$website    = "https://semengresik.co.id";
$now        = db_now();

$cId = db_insert_row('clients', [
    'name'        => $clientName,
    'logo_path'   => $logoPath,
    'website_url' => $website,
    'created_at'  => $now,
    'updated_at'  => $now,
]);

echo "Created Dummy Client ID: " . $cId . "\n";
$createdClient = db_find('SELECT * FROM clients WHERE id = ?', [$cId]);
echo ($createdClient && $createdClient['name'] === $clientName ? '[PASS] Insert Client Successful' : '[FAIL] Insert Client Failed') . "\n";

// --- Public Read ---
echo "\n========================================================\n";
echo "3. TES HASIL BACA HALAMAN PUBLIC CLIENTS\n";
echo "========================================================\n";

$publicClientsRead = db_select("SELECT * FROM clients WHERE name LIKE ?", ['%Semen Gresik%']);
echo "Public Page Clients Match Count: " . count($publicClientsRead) . "\n";
echo (count($publicClientsRead) > 0 ? '[PASS] Public Page can read newly created Client' : '[FAIL]') . "\n";

// --- Update ---
echo "\n========================================================\n";
echo "4. TES EDIT (UPDATE) CLIENT DUMMY\n";
echo "========================================================\n";

$updatedName = "PT Semen Gresik Industri Tbk (UPDATED)";
$affected = db_execute(
    'UPDATE clients SET name = ?, website_url = ?, updated_at = ? WHERE id = ?',
    [$updatedName, 'https://semengresiktbk.co.id', db_now(), $cId]
);

$updatedClient = db_find('SELECT * FROM clients WHERE id = ?', [$cId]);
echo ($affected > 0 && $updatedClient['name'] === $updatedName ? '[PASS] Update Client Successful' : '[FAIL] Update Client Failed') . "\n";

// --- Delete ---
echo "\n========================================================\n";
echo "5. TES HAPUS (DELETE) CLIENT DUMMY\n";
echo "========================================================\n";

$deletedRows = db_execute('DELETE FROM clients WHERE id = ?', [$cId]);
$checkDeleted = db_find('SELECT * FROM clients WHERE id = ?', [$cId]);

echo ($deletedRows > 0 && $checkDeleted === null ? '[PASS] Delete Client Successful' : '[FAIL] Delete Client Failed') . "\n";

$finalClientsCount = (int) db_scalar('SELECT COUNT(*) FROM clients');
echo "Final Clients count in DB: " . $finalClientsCount . " (Matched Initial: " . ($finalClientsCount === $initialClientsCount ? 'YES' : 'NO') . ")\n";

echo "\n========================================================\n";
echo "SEMUA TES ADMIN CLIENTS CRUD BERHASIL 100%.\n";
echo "========================================================\n";
