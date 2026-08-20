<?php
require_once __DIR__ . '/../native/db.php';
$tables = db_select("SELECT name FROM sqlite_master WHERE type='table'");
foreach ($tables as $t) {
    echo $t['name'] . "\n";
}
