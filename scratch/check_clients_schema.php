<?php
require_once __DIR__ . '/../native/db.php';

echo "=== CLIENTS TABLE SCHEMA ===\n";
$cols = db_select('PRAGMA table_info(clients)');
foreach ($cols as $c) {
    echo $c['cid'] . ' | ' . $c['name'] . ' | ' . $c['type'] . ' | notnull:' . $c['notnull'] . ' | dflt:' . $c['dflt_value'] . "\n";
}

echo "\n=== SAMPLE CLIENTS ===\n";
$rows = db_select('SELECT * FROM clients LIMIT 5');
print_r($rows);
