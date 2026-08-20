<?php
require_once __DIR__ . '/../native/db.php';

echo "=== DATABASE STATISTICAL COUNTS ===\n";
echo "Projects           : " . db_scalar('SELECT COUNT(*) FROM projects') . "\n";
echo "Services           : " . db_scalar('SELECT COUNT(*) FROM services') . "\n";
echo "Clients            : " . db_scalar('SELECT COUNT(*) FROM clients') . "\n";
echo "Contacts (Total)   : " . db_scalar('SELECT COUNT(*) FROM contacts') . "\n";
echo "Contacts (Unread)  : " . db_scalar('SELECT COUNT(*) FROM contacts WHERE is_read = 0') . "\n";
echo "Quotations (Total) : " . db_scalar('SELECT COUNT(*) FROM request_quotations') . "\n";
echo "Quotations (Pending): " . db_scalar("SELECT COUNT(*) FROM request_quotations WHERE status = 'pending'") . "\n";
