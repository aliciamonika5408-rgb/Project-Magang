<?php
require_once __DIR__ . '/../native/db.php';

echo "=== BEFORE DELETION ===\n";
echo "CONTACTS:\n";
$contacts = db_select('SELECT id, name, email, subject FROM contacts');
print_r($contacts);

echo "\nREQUEST_QUOTATIONS:\n";
$quotations = db_select('SELECT id, name, company_name, email FROM request_quotations');
print_r($quotations);

// --- Delete specific dummy data ---
$deletedContacts = db_execute("DELETE FROM contacts WHERE name LIKE '%Dummy Test User%' OR subject LIKE '%Tes Submit Form Contact%'");
echo "\nDeleted Contacts Count: {$deletedContacts}\n";

$deletedQuotations = db_execute("DELETE FROM request_quotations WHERE name LIKE '%PT. Dummy Konstruksi%' OR company_name LIKE '%PT. Dummy%'");
echo "Deleted Quotations Count: {$deletedQuotations}\n";

echo "\n=== AFTER DELETION ===\n";
echo "REMAINING CONTACTS:\n";
$remContacts = db_select('SELECT id, name, email, subject FROM contacts');
print_r($remContacts);

echo "\nREMAINING REQUEST_QUOTATIONS:\n";
$remQuotations = db_select('SELECT id, name, company_name, email FROM request_quotations');
print_r($remQuotations);

echo "\n=== REMAINING PROJECTS COUNT ===\n";
$projectsCount = db_scalar('SELECT COUNT(*) FROM projects');
echo "Projects count: {$projectsCount}\n";
