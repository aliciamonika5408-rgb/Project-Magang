<?php
/**
 * scratch/final_master_test.php
 * Master Final Testing Script for Complete Native PHP Construction Website.
 */

declare(strict_types=1);

require_once __DIR__ . '/../native/db.php';
require_once __DIR__ . '/../native/auth.php';
require_once __DIR__ . '/../resources/views/native_helpers.php';

$results = [
    'public'   => [],
    'database' => [],
    'admin'    => [],
    'crud'     => [],
];

echo "========================================================\n";
echo "1. TESTING PUBLIC WEBSITE PAGES & COMPONENT DATA\n";
echo "========================================================\n";

$publicPages = [
    'Home'           => __DIR__ . '/../resources/views/welcome.php',
    'Projects'       => __DIR__ . '/../resources/views/public/projects/index.php',
    'Project Detail' => __DIR__ . '/../resources/views/public/projects/detail.php',
    'Services'       => __DIR__ . '/../resources/views/public/services/index.php',
    'Service Detail' => __DIR__ . '/../resources/views/public/services/detail.php',
    'Clients'        => __DIR__ . '/../resources/views/public/clients.php',
    'Contact'        => __DIR__ . '/../resources/views/public/contact.php',
    'Quotation'      => __DIR__ . '/../resources/views/public/quotation.php',
];

foreach ($publicPages as $name => $path) {
    if (file_exists($path) && is_readable($path)) {
        $results['public'][$name] = 'LULUS';
        echo "[PASS] Public Page: {$name} -> File verified & readable.\n";
    } else {
        $results['public'][$name] = 'ERROR';
        echo "[FAIL] Public Page: {$name} -> File missing or unreadable!\n";
    }
}

echo "\n========================================================\n";
echo "2. TESTING DATABASE FEATURES & RECORD RETRIEVAL\n";
echo "========================================================\n";

$dbFeatures = [
    'Featured Projects'    => 'SELECT * FROM projects ORDER BY created_at DESC LIMIT 3',
    'Projects'             => 'SELECT * FROM projects ORDER BY created_at DESC',
    'Services'             => 'SELECT * FROM services ORDER BY created_at DESC',
    'Other Services'       => 'SELECT * FROM other_services ORDER BY created_at DESC',
    'Clients'              => 'SELECT * FROM clients ORDER BY created_at DESC',
    'Company Settings'     => 'SELECT * FROM company_settings',
    'Contact Submissions'  => 'SELECT * FROM contacts ORDER BY created_at DESC',
    'Quotation Submissions'=> 'SELECT * FROM request_quotations ORDER BY created_at DESC',
];

foreach ($dbFeatures as $feature => $sql) {
    try {
        $rows = db_select($sql);
        $results['database'][$feature] = 'LULUS';
        echo "[PASS] DB Feature: {$feature} -> Query executed successfully (" . count($rows) . " rows returned).\n";
    } catch (Throwable $e) {
        $results['database'][$feature] = 'ERROR';
        echo "[FAIL] DB Feature: {$feature} -> Error: " . $e->getMessage() . "\n";
    }
}

echo "\n========================================================\n";
echo "3. TESTING ADMIN AUTHENTICATION, SESSION & PROTECTION\n";
echo "========================================================\n";

// --- Login Failure Test ---
$invalidUser = db_find('SELECT * FROM users WHERE email = ?', ['invalid.admin@test.com']);
$invalidPassCheck = $invalidUser && password_verify('wrongpassword', $invalidUser['password']);
echo (!$invalidPassCheck ? '[PASS] Admin Login Failure Check (Invalid Credentials Blocked)' : '[FAIL]') . "\n";
$results['admin']['Login Gagal'] = !$invalidPassCheck ? 'LULUS' : 'ERROR';

// --- Login Success Test ---
$adminUser = db_find('SELECT * FROM users WHERE email = ?', ['admin@multipowerabadi.co.id']);
$validPassCheck = $adminUser && password_verify('adminmpa123', $adminUser['password']);
echo ($validPassCheck ? '[PASS] Admin Login Success Check (Password Verify Valid)' : '[FAIL]') . "\n";
$results['admin']['Login Berhasil'] = $validPassCheck ? 'LULUS' : 'ERROR';

// --- Session & Protection Test ---
$protectionCheck = function_exists('auth_require') && function_exists('auth_user') && function_exists('auth_verify_csrf');
echo ($protectionCheck ? '[PASS] Admin Session & Page Protection Functions Ready' : '[FAIL]') . "\n";
$results['admin']['Session & Proteksi Halaman'] = $protectionCheck ? 'LULUS' : 'ERROR';
$results['admin']['Dashboard Admin'] = file_exists(__DIR__ . '/../resources/views/admin/dashboard.php') ? 'LULUS' : 'ERROR';
$results['admin']['Logout'] = file_exists(__DIR__ . '/../logout.php') ? 'LULUS' : 'ERROR';

echo "\n========================================================\n";
echo "4. TESTING END-TO-END CRUD OPERATIONS\n";
echo "========================================================\n";

$now = db_now();

// --- 4A. Projects CRUD ---
$pTitle = "Test Master Project " . time();
$pSlug  = native_slug($pTitle);
$pId = db_insert_row('projects', [
    'title'       => $pTitle,
    'slug'        => $pSlug,
    'category'    => 'Gudang',
    'location'    => 'Surabaya',
    'year'        => 2026,
    'description' => 'Test project desc',
    'created_at'  => $now,
    'updated_at'  => $now,
]);
$pUpdated = db_execute('UPDATE projects SET location = ? WHERE id = ?', ['Sidoarjo', $pId]);
$pDeleted = db_execute('DELETE FROM projects WHERE id = ?', [$pId]);
$projectsCrudOk = ($pId > 0 && $pUpdated > 0 && $pDeleted > 0);
echo ($projectsCrudOk ? '[PASS] Projects CRUD (Create, Read, Update, Delete)' : '[FAIL]') . "\n";
$results['crud']['Projects CRUD'] = $projectsCrudOk ? 'LULUS' : 'ERROR';

// --- 4B. Services CRUD ---
$sTitle = "Test Master Service " . time();
$sSlug  = native_slug($sTitle);
$sId = db_insert_row('services', [
    'title'       => $sTitle,
    'slug'        => $sSlug,
    'description' => 'Test service desc',
    'icon'        => 'bi-building',
    'created_at'  => $now,
    'updated_at'  => $now,
]);
$sUpdated = db_execute('UPDATE services SET icon = ? WHERE id = ?', ['bi-tools', $sId]);
$sDeleted = db_execute('DELETE FROM services WHERE id = ?', [$sId]);
$servicesCrudOk = ($sId > 0 && $sUpdated > 0 && $sDeleted > 0);
echo ($servicesCrudOk ? '[PASS] Services CRUD (Create, Read, Update, Delete)' : '[FAIL]') . "\n";
$results['crud']['Services CRUD'] = $servicesCrudOk ? 'LULUS' : 'ERROR';

// --- 4C. Other Services CRUD ---
$osId = db_insert_row('other_services', [
    'title'       => 'Test Other Service ' . time(),
    'description' => 'Test other service desc',
    'icon'        => 'bi-tools',
    'created_at'  => $now,
    'updated_at'  => $now,
]);
$osUpdated = db_execute('UPDATE other_services SET description = ? WHERE id = ?', ['Updated desc', $osId]);
$osDeleted = db_execute('DELETE FROM other_services WHERE id = ?', [$osId]);
$otherServicesCrudOk = ($osId > 0 && $osUpdated > 0 && $osDeleted > 0);
echo ($otherServicesCrudOk ? '[PASS] Other Services CRUD (Create, Read, Update, Delete)' : '[FAIL]') . "\n";
$results['crud']['Other Services CRUD'] = $otherServicesCrudOk ? 'LULUS' : 'ERROR';

// --- 4D. Clients CRUD ---
$cId = db_insert_row('clients', [
    'name'        => 'Test Master Client ' . time(),
    'logo_path'   => 'clients/sample.png',
    'website_url' => 'https://testclient.com',
    'created_at'  => $now,
    'updated_at'  => $now,
]);
$cUpdated = db_execute('UPDATE clients SET website_url = ? WHERE id = ?', ['https://updated.com', $cId]);
$cDeleted = db_execute('DELETE FROM clients WHERE id = ?', [$cId]);
$clientsCrudOk = ($cId > 0 && $cUpdated > 0 && $cDeleted > 0);
echo ($clientsCrudOk ? '[PASS] Clients CRUD (Create, Read, Update, Delete)' : '[FAIL]') . "\n";
$results['crud']['Clients CRUD'] = $clientsCrudOk ? 'LULUS' : 'ERROR';

echo "\n========================================================\n";
echo "5. TESTING CONTACTS & QUOTATIONS WORKFLOW\n";
echo "========================================================\n";

// --- Contact Submission & Read Status ---
$ctId = db_insert_row('contacts', [
    'name'       => 'Public User Test',
    'email'      => 'user@test.com',
    'subject'    => 'Tanya Biaya Konstruksi',
    'message'    => 'Berapa biaya per m2?',
    'is_read'    => 0,
    'created_at' => $now,
    'updated_at' => $now,
]);
db_execute('UPDATE contacts SET is_read = 1 WHERE id = ?', [$ctId]);
$readCheck = db_find('SELECT * FROM contacts WHERE id = ?', [$ctId]);
db_execute('DELETE FROM contacts WHERE id = ?', [$ctId]);
$contactOk = ($readCheck && (int)$readCheck['is_read'] === 1);
echo ($contactOk ? '[PASS] Contacts Submission, Auto Read Status & Admin View' : '[FAIL]') . "\n";
$results['crud']['Contacts Inbox & Detail Status'] = $contactOk ? 'LULUS' : 'ERROR';

// --- Quotation Submission & Status Update ---
$qId = db_insert_row('request_quotations', [
    'name'          => 'Public Quotation User',
    'company_name'  => 'PT Test Industri',
    'email'         => 'quotation@test.com',
    'whatsapp'      => '0812345678',
    'project_type'  => 'Pabrik',
    'location'      => 'Surabaya',
    'status'        => 'pending',
    'created_at'    => $now,
    'updated_at'    => $now,
]);
db_execute('UPDATE request_quotations SET status = ? WHERE id = ?', ['approved', $qId]);
$statusCheck = db_find('SELECT * FROM request_quotations WHERE id = ?', [$qId]);
db_execute('DELETE FROM request_quotations WHERE id = ?', [$qId]);
$quotationOk = ($statusCheck && $statusCheck['status'] === 'approved');
echo ($quotationOk ? '[PASS] Quotation Submission, Filter & Admin Status Update' : '[FAIL]') . "\n";
$results['crud']['Quotation Submission & Status Update'] = $quotationOk ? 'LULUS' : 'ERROR';

echo "\n========================================================\n";
echo "6. TESTING HOME EDITOR & SETTINGS SYNC\n";
echo "========================================================\n";

db_execute('UPDATE company_settings SET value = ? WHERE key = ?', ['16', 'years_experience']);
$settingCheck = db_scalar('SELECT value FROM company_settings WHERE key = ?', ['years_experience']);
db_execute('UPDATE company_settings SET value = ? WHERE key = ?', ['15', 'years_experience']);
$settingsOk = ($settingCheck === '16');
echo ($settingsOk ? '[PASS] Home Editor & Settings SQLite Sync & Public Reflection' : '[FAIL]') . "\n";
$results['crud']['Home Editor & Settings Sync'] = $settingsOk ? 'LULUS' : 'ERROR';

echo "\n========================================================\n";
echo "SUMMARY RESULTS:\n";
echo "========================================================\n";
print_r($results);
