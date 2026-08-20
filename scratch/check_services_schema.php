<?php
require_once __DIR__ . '/../native/db.php';

echo "=== SERVICES TABLE SCHEMA ===\n";
$cols1 = db_select('PRAGMA table_info(services)');
foreach ($cols1 as $c) {
    echo $c['cid'] . ' | ' . $c['name'] . ' | ' . $c['type'] . ' | notnull:' . $c['notnull'] . ' | dflt:' . $c['dflt_value'] . "\n";
}

echo "\n=== OTHER_SERVICES TABLE SCHEMA ===\n";
$cols2 = db_select('PRAGMA table_info(other_services)');
foreach ($cols2 as $c) {
    echo $c['cid'] . ' | ' . $c['name'] . ' | ' . $c['type'] . ' | notnull:' . $c['notnull'] . ' | dflt:' . $c['dflt_value'] . "\n";
}

echo "\n=== SAMPLE SERVICES ===\n";
$rows1 = db_select('SELECT * FROM services LIMIT 3');
print_r($rows1);

echo "\n=== SAMPLE OTHER SERVICES ===\n";
$rows2 = db_select('SELECT * FROM other_services LIMIT 3');
print_r($rows2);
