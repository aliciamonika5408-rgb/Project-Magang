<?php
$db = new PDO('sqlite:database/database.sqlite');

echo "=== USERS TABLE SCHEMA ===\n";
$cols = $db->query('PRAGMA table_info(users)')->fetchAll(PDO::FETCH_ASSOC);
foreach ($cols as $c) {
    echo $c['cid'] . ' | ' . $c['name'] . ' | ' . $c['type']
       . ' | notnull:' . $c['notnull']
       . ' | dflt:' . $c['dflt_value'] . "\n";
}

echo "\n=== SAMPLE USERS ===\n";
$rows = $db->query('SELECT id, name, email, role, created_at FROM users LIMIT 5')->fetchAll(PDO::FETCH_ASSOC);
foreach ($rows as $r) { print_r($r); }
echo "Total rows: " . $db->query('SELECT COUNT(*) FROM users')->fetchColumn() . "\n";

echo "\n=== COLUMN 'password' sample (first row) ===\n";
$pw = $db->query('SELECT password FROM users LIMIT 1')->fetchColumn();
echo "Password hash: " . $pw . "\n";
echo "Hash algo: " . (str_starts_with($pw, '$2y$') ? 'bcrypt' : (str_starts_with($pw, '$argon') ? 'argon2' : 'unknown')) . "\n";
