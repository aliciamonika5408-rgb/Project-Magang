<?php
/**
 * native/db.php
 * ─────────────────────────────────────────────────────────────────────────────
 * Koneksi database PDO untuk PHP native PT Multi Power Abadi.
 *
 * Membaca konfigurasi dari file .env Laravel yang sudah ada sehingga
 * tidak perlu menyimpan kredensial di dua tempat.
 *
 * Mendukung:
 *   - SQLite  (DB_CONNECTION=sqlite) — aktif sekarang
 *   - MySQL   (DB_CONNECTION=mysql)  — ganti di .env jika sudah setup MySQL
 *
 * Cara pemakaian di file PHP native lain:
 *   require_once __DIR__ . '/../native/db.php';
 *   $rows = db_select('SELECT * FROM projects ORDER BY created_at DESC');
 *   $row  = db_find('SELECT * FROM projects WHERE id = ?', [$id]);
 *   $id   = db_insert('INSERT INTO contacts (name, email) VALUES (?, ?)', [$name, $email]);
 *
 * Jangan gunakan file ini di dalam folder Laravel (app/, routes/, dll).
 * Tidak menggunakan Eloquent. Tidak menggunakan DB Facade Laravel.
 * ─────────────────────────────────────────────────────────────────────────────
 */

declare(strict_types=1);

// ---------------------------------------------------------------------------
// 1.  Tentukan APP_ROOT sekali — titik pangkal untuk baca .env & path SQLite
// ---------------------------------------------------------------------------

if (!defined('NATIVE_APP_ROOT')) {
    define('NATIVE_APP_ROOT', dirname(__DIR__));
}

// ---------------------------------------------------------------------------
// 2.  Baca konfigurasi dari .env Laravel
// ---------------------------------------------------------------------------

/**
 * Ambil nilai dari .env Laravel.
 * Menggunakan static cache agar file hanya dibaca sekali per request.
 */
function native_env(string $key, ?string $default = null): ?string
{
    static $env = null;

    if ($env === null) {
        $env = [];
        $envFile = NATIVE_APP_ROOT . '/.env';

        if (!is_readable($envFile)) {
            return $default;
        }

        foreach (file($envFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES) as $line) {
            $line = trim($line);
            if ($line === '' || str_starts_with($line, '#') || !str_contains($line, '=')) {
                continue;
            }
            [$k, $v] = explode('=', $line, 2);
            // Hapus tanda kutip dan whitespace
            $env[trim($k)] = trim($v, " \t'\"");
        }
    }

    return $env[$key] ?? $default;
}

// ---------------------------------------------------------------------------
// 3.  Bangun DSN berdasarkan driver di .env
// ---------------------------------------------------------------------------

/**
 * Buat string DSN sesuai driver yang dikonfigurasi di .env.
 * Mengembalikan array [dsn, username, password].
 *
 * @return array{0: string, 1: string|null, 2: string|null}
 */
function native_build_dsn(): array
{
    $driver = native_env('DB_CONNECTION', 'sqlite');

    if ($driver === 'sqlite') {
        $dbPath = native_env('DB_DATABASE', 'database/database.sqlite');

        // Jika bukan path absolut Windows maupun Unix, buat relatif ke APP_ROOT
        $isAbsolute = str_starts_with($dbPath, '/')
            || (strlen($dbPath) >= 2 && ctype_alpha($dbPath[0]) && $dbPath[1] === ':');

        if (!$isAbsolute) {
            $dbPath = NATIVE_APP_ROOT . '/' . $dbPath;
        }

        return ['sqlite:' . $dbPath, null, null];
    }

    if ($driver === 'mysql') {
        $host     = native_env('DB_HOST', '127.0.0.1');
        $port     = native_env('DB_PORT', '3306');
        $dbname   = native_env('DB_DATABASE', '');
        $charset  = 'utf8mb4';
        $dsn      = "mysql:host={$host};port={$port};dbname={$dbname};charset={$charset}";
        $username = native_env('DB_USERNAME', 'root');
        $password = native_env('DB_PASSWORD', '');

        return [$dsn, $username, $password];
    }

    throw new RuntimeException("Driver database '{$driver}' tidak didukung. Gunakan 'sqlite' atau 'mysql'.");
}

// ---------------------------------------------------------------------------
// 4.  Koneksi PDO Singleton — dibuat satu kali per request
// ---------------------------------------------------------------------------

/**
 * Kembalikan instance PDO yang sudah terhubung ke database.
 * Singleton: koneksi dibuat satu kali dan di-cache untuk seluruh request.
 *
 * @throws RuntimeException jika koneksi gagal
 */
function db(): PDO
{
    static $pdo = null;

    if ($pdo instanceof PDO) {
        return $pdo;
    }

    [$dsn, $username, $password] = native_build_dsn();

    $options = [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES   => false,
    ];

    // Untuk MySQL: tambahkan opsi agar koneksi tetap hidup
    if (str_starts_with($dsn, 'mysql:')) {
        $options[PDO::ATTR_PERSISTENT] = false; // Jangan persistent di XAMPP shared env
        $options[PDO::MYSQL_ATTR_INIT_COMMAND] = "SET NAMES utf8mb4 COLLATE utf8mb4_unicode_ci";
    }

    $pdo = new PDO($dsn, $username, $password, $options);

    return $pdo;
}

// ---------------------------------------------------------------------------
// 5.  Helper Query — wrapper PDO dengan prepared statements
// ---------------------------------------------------------------------------

/**
 * Eksekusi query SELECT dan kembalikan semua baris sebagai array.
 *
 * @param  string  $sql    Query SQL dengan placeholder '?' untuk parameternya
 * @param  array   $params Parameter untuk prepared statement
 * @return array           Array of associative arrays (FETCH_ASSOC)
 *
 * @example
 *   $projects = db_select('SELECT * FROM projects WHERE category = ? ORDER BY year DESC', ['Mezzanine']);
 */
function db_select(string $sql, array $params = []): array
{
    $stmt = db()->prepare($sql);
    $stmt->execute($params);
    return $stmt->fetchAll();
}

/**
 * Eksekusi query SELECT dan kembalikan satu baris pertama, atau null jika tidak ada.
 *
 * @param  string     $sql
 * @param  array      $params
 * @return array|null Associative array satu baris, atau null
 *
 * @example
 *   $project = db_find('SELECT * FROM projects WHERE slug = ? LIMIT 1', [$slug]);
 */
function db_find(string $sql, array $params = []): ?array
{
    $stmt = db()->prepare($sql);
    $stmt->execute($params);
    $row = $stmt->fetch();
    return $row !== false ? $row : null;
}

/**
 * Eksekusi query SELECT dan kembalikan nilai satu kolom (skalar).
 *
 * @param  string $sql
 * @param  array  $params
 * @return mixed  Nilai kolom pertama baris pertama, atau null
 *
 * @example
 *   $total = db_scalar('SELECT COUNT(*) FROM projects WHERE category = ?', ['Gudang']);
 */
function db_scalar(string $sql, array $params = []): mixed
{
    $stmt = db()->prepare($sql);
    $stmt->execute($params);
    $val = $stmt->fetchColumn();
    return $val !== false ? $val : null;
}

/**
 * Eksekusi INSERT dan kembalikan ID baris yang baru dibuat.
 *
 * @param  string $sql
 * @param  array  $params
 * @return int|string Last insert ID
 *
 * @example
 *   $id = db_insert(
 *       'INSERT INTO contacts (name, email, subject, message, created_at, updated_at) VALUES (?, ?, ?, ?, ?, ?)',
 *       [$name, $email, $subject, $message, $now, $now]
 *   );
 */
function db_insert(string $sql, array $params = []): int|string
{
    $stmt = db()->prepare($sql);
    $stmt->execute($params);
    return db()->lastInsertId();
}

/**
 * Helper INSERT yang lebih nyaman: menerima nama tabel dan array asosiatif kolom => nilai.
 * Membangun query INSERT secara otomatis menggunakan prepared statements.
 *
 * @param  string         $table  Nama tabel
 * @param  array          $data   Array asosiatif ['kolom' => 'nilai', ...]
 * @return int|string             Last insert ID
 *
 * @example
 *   $id = db_insert_row('contacts', [
 *       'name'       => 'Budi',
 *       'email'      => 'budi@example.com',
 *       'subject'    => 'Harga WF',
 *       'message'    => 'Saya ingin tanya harga.',
 *       'is_read'    => 0,
 *       'created_at' => date('Y-m-d H:i:s'),
 *       'updated_at' => date('Y-m-d H:i:s'),
 *   ]);
 */
function db_insert_row(string $table, array $data): int|string
{
    $columns     = implode(', ', array_keys($data));
    $placeholders = implode(', ', array_fill(0, count($data), '?'));
    $sql         = "INSERT INTO {$table} ({$columns}) VALUES ({$placeholders})";
    return db_insert($sql, array_values($data));
}

/**
 * Eksekusi UPDATE atau DELETE dan kembalikan jumlah baris yang terpengaruh.
 *
 * @param  string $sql
 * @param  array  $params
 * @return int    Jumlah baris yang diupdate/didelete
 *
 * @example
 *   $affected = db_execute('UPDATE request_quotations SET status = ? WHERE id = ?', ['reviewed', $id]);
 */
function db_execute(string $sql, array $params = []): int
{
    $stmt = db()->prepare($sql);
    $stmt->execute($params);
    return $stmt->rowCount();
}

/**
 * Helper: Buat timestamp "sekarang" dalam format yang sesuai untuk database.
 * Untuk SQLite maupun MySQL: format DATETIME standar SQL.
 */
function db_now(): string
{
    return date('Y-m-d H:i:s');
}

/**
 * Helper: Tes koneksi database dan kembalikan info ringkas.
 * Digunakan hanya untuk diagnostik/debug — jangan panggil di production.
 *
 * @return array{driver: string, database: string, connected: bool, error: string|null}
 */
function db_info(): array
{
    try {
        $pdo    = db();
        $driver = native_env('DB_CONNECTION', 'sqlite');

        if ($driver === 'sqlite') {
            $dbName = basename((string) native_env('DB_DATABASE', 'database.sqlite'));
        } else {
            $dbName = (string) native_env('DB_DATABASE', '');
        }

        // Ping query kecil untuk verifikasi koneksi aktif
        $pdo->query('SELECT 1');

        return [
            'driver'    => $driver,
            'database'  => $dbName,
            'connected' => true,
            'error'     => null,
        ];
    } catch (Throwable $e) {
        return [
            'driver'    => native_env('DB_CONNECTION', 'sqlite') ?? 'unknown',
            'database'  => '',
            'connected' => false,
            'error'     => $e->getMessage(),
        ];
    }
}
