<?php
require_once __DIR__ . '/../native/db.php';

echo "=== ALL TABLES IN SQLITE ===\n";
$tables = db_select("SELECT name FROM sqlite_master WHERE type='table'");
foreach ($tables as $t) {
    echo "- " . $t['name'] . "\n";
}

foreach ($tables as $t) {
    $tName = $t['name'];
    if (in_array($tName, ['company_settings', 'settings', 'home_settings', 'site_settings'])) {
        echo "\n=== SCHEMA OF {$tName} ===\n";
        $cols = db_select("PRAGMA table_info({$tName})");
        print_r($cols);
        echo "\n=== DATA IN {$tName} ===\n";
        $rows = db_select("SELECT * FROM {$tName}");
        print_r($rows);
    }
}
