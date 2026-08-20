<?php
require_once __DIR__ . '/../native/db.php';

echo "=== CONTACTS TABLE SCHEMA ===\n";
$cols = db_select('PRAGMA table_info(contacts)');
foreach ($cols as $c) {
    echo $c['cid'] . ' | ' . $c['name'] . ' | ' . $c['type'] . ' | notnull:' . $c['notnull'] . ' | dflt:' . $c['dflt_value'] . "\n";
}

echo "\n=== SAMPLE CONTACTS ===\n";
$contacts = db_select('SELECT * FROM contacts LIMIT 5');
print_r($contacts);

echo "\n=== REQUEST_QUOTATIONS TABLE SCHEMA ===\n";
$colsQ = db_select('PRAGMA table_info(request_quotations)');
foreach ($colsQ as $c) {
    echo $c['cid'] . ' | ' . $c['name'] . ' | ' . $c['type'] . ' | notnull:' . $c['notnull'] . ' | dflt:' . $c['dflt_value'] . "\n";
}

echo "\n=== SAMPLE REQUEST_QUOTATIONS ===\n";
$quotations = db_select('SELECT * FROM request_quotations LIMIT 5');
print_r($quotations);
