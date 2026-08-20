<?php
require_once __DIR__ . '/../native/db.php';

echo "=== PROJECTS TABLE SCHEMA ===\n";
$cols = db_select('PRAGMA table_info(projects)');
foreach ($cols as $c) {
    echo $c['cid'] . ' | ' . $c['name'] . ' | ' . $c['type'] . ' | notnull:' . $c['notnull'] . ' | dflt:' . $c['dflt_value'] . "\n";
}

echo "\n=== SAMPLE PROJECTS DATA ===\n";
$rows = db_select('SELECT * FROM projects LIMIT 3');
foreach ($rows as $r) {
    print_r($r);
}
