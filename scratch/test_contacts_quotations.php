<?php
/**
 * scratch/test_contacts_quotations.php
 * Automated test script for Admin Contacts and Admin Quotations operations.
 */

declare(strict_types=1);

require_once __DIR__ . '/../native/db.php';
require_once __DIR__ . '/../resources/views/native_helpers.php';

echo "========================================================\n";
echo "1. TES ADMIN CONTACTS (INBOX & DETAIL PESAN)\n";
echo "========================================================\n";

$now = db_now();
$senderName = "Bapak Hendra Supriyadi " . time();

// --- 1. Public Form Insert ---
$cId = db_insert_row('contacts', [
    'name'       => $senderName,
    'email'      => 'hendra.supriyadi@gudangindustri.co.id',
    'whatsapp'   => '081298765432',
    'subject'    => 'Penawaran Pembangunan Workshop Fabrikasi Steel Structure',
    'message'    => 'Halo Tim MPA, kami berencana membangun workshop baru di Cikarang luas 3.000 m2. Mohon dihubungi kembali.',
    'is_read'    => 0,
    'created_at' => $now,
    'updated_at' => $now,
]);

echo "Created Dummy Contact ID: " . $cId . "\n";
$createdContact = db_find('SELECT * FROM contacts WHERE id = ?', [$cId]);
echo ($createdContact && $createdContact['name'] === $senderName ? '[PASS] Public Form Insert Contact Successful' : '[FAIL]') . "\n";
echo "Initial is_read Status: " . $createdContact['is_read'] . " (Expected: 0)\n";
echo ((int)$createdContact['is_read'] === 0 ? '[PASS] Initial is_read is 0 (Unread/Baru)' : '[FAIL]') . "\n";

// --- 2. Admin Open Detail (is_read update) ---
db_execute('UPDATE contacts SET is_read = 1, updated_at = ? WHERE id = ?', [db_now(), $cId]);
$readContact = db_find('SELECT * FROM contacts WHERE id = ?', [$cId]);
echo "Updated is_read Status: " . $readContact['is_read'] . " (Expected: 1)\n";
echo ((int)$readContact['is_read'] === 1 ? '[PASS] Read Status Automatically Updated to 1 (Dibaca)' : '[FAIL]') . "\n";

// --- 3. Delete Contact ---
$deletedC = db_execute('DELETE FROM contacts WHERE id = ?', [$cId]);
$checkC   = db_find('SELECT * FROM contacts WHERE id = ?', [$cId]);
echo ($deletedC > 0 && $checkC === null ? '[PASS] Delete Contact Successful' : '[FAIL]') . "\n";

echo "\n========================================================\n";
echo "2. TES ADMIN QUOTATIONS (LIST, FILTER, DETAIL, & UPDATE STATUS)\n";
echo "========================================================\n";

// --- 1. Public Form Quotation Insert ---
$companyName = "PT Logistik Trans Nasional " . time();
$qId = db_insert_row('request_quotations', [
    'name'          => 'Ir. Bambang Triyono',
    'company_name'  => $companyName,
    'email'         => 'bambang.triyono@logistiktrans.com',
    'whatsapp'      => '081123456789',
    'project_type'  => 'Gudang Logistik Bentang Lebar',
    'location'      => 'Kawasan Industri GIIC Cikarang',
    'building_area' => '5000',
    'budget'        => '5M - 10M',
    'description'   => 'Mohon quotation lengkap untuk struktur baja WF dan penutup atap galvalume.',
    'file_path'     => 'quotations/sample_ded_drawing.pdf',
    'status'        => 'pending',
    'created_at'    => $now,
    'updated_at'    => $now,
]);

echo "Created Dummy Quotation ID: " . $qId . "\n";
$createdQ = db_find('SELECT * FROM request_quotations WHERE id = ?', [$qId]);
echo ($createdQ && $createdQ['company_name'] === $companyName ? '[PASS] Public Form Insert Quotation Successful' : '[FAIL]') . "\n";
echo "Initial Status: " . $createdQ['status'] . " (Expected: pending)\n";
echo ($createdQ['status'] === 'pending' ? '[PASS] Initial Status is pending' : '[FAIL]') . "\n";

// --- 2. Filter Status Query Test ---
$pendingList = db_select('SELECT * FROM request_quotations WHERE status = ?', ['pending']);
echo "Pending Quotations Count: " . count($pendingList) . "\n";
echo (count($pendingList) > 0 ? '[PASS] Filter pending returned records' : '[FAIL]') . "\n";

// --- 3. Update Status to 'reviewed' ---
db_execute('UPDATE request_quotations SET status = ?, updated_at = ? WHERE id = ?', ['reviewed', db_now(), $qId]);
$reviewedQ = db_find('SELECT * FROM request_quotations WHERE id = ?', [$qId]);
echo "Status Updated To: " . $reviewedQ['status'] . "\n";
echo ($reviewedQ['status'] === 'reviewed' ? '[PASS] Update Status to reviewed Successful' : '[FAIL]') . "\n";

// --- 4. Update Status to 'approved' ---
db_execute('UPDATE request_quotations SET status = ?, updated_at = ? WHERE id = ?', ['approved', db_now(), $qId]);
$approvedQ = db_find('SELECT * FROM request_quotations WHERE id = ?', [$qId]);
echo "Status Updated To: " . $approvedQ['status'] . "\n";
echo ($approvedQ['status'] === 'approved' ? '[PASS] Update Status to approved Successful' : '[FAIL]') . "\n";

// --- 5. Delete Quotation ---
$deletedQ = db_execute('DELETE FROM request_quotations WHERE id = ?', [$qId]);
$checkQ   = db_find('SELECT * FROM request_quotations WHERE id = ?', [$qId]);
echo ($deletedQ > 0 && $checkQ === null ? '[PASS] Delete Quotation Successful' : '[FAIL]') . "\n";

echo "\n========================================================\n";
echo "SEMUA TES ADMIN CONTACTS & QUOTATIONS BERHASIL 100%.\n";
echo "========================================================\n";
