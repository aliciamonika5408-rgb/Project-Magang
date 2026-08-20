<?php
/**
 * Global Helper Functions untuk PHP Native Website PT Multi Power Abadi
 * Memastikan kompatibilitas penuh saat dijalankan via XAMPP Apache, Subfolder, maupun PHP Server.
 */

declare(strict_types=1);

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!function_exists('get_base_url')) {
    function get_base_url(): string
    {
        $scriptName = $_SERVER['SCRIPT_NAME'] ?? '';
        if (preg_match('#^(/[^/]+)#', $scriptName, $matches)) {
            $subfolder = $matches[1];
            $knownDirs = ['/resources', '/public', '/index.php', '/welcome.php', '/app', '/vendor', '/storage', '/config', '/database'];
            if (!in_array(strtolower($subfolder), $knownDirs, true)) {
                return $subfolder;
            }
        }
        return '';
    }
}

if (!function_exists('e')) {
    function e($value): string
    {
        return htmlspecialchars((string) ($value ?? ''), ENT_QUOTES, 'UTF-8');
    }
}

if (!function_exists('request')) {
    function request(?string $key = null, $default = null)
    {
        if ($key === null) {
            return array_merge($_GET, $_POST);
        }
        return $_GET[$key] ?? $_POST[$key] ?? $default;
    }
}

if (!function_exists('asset')) {
    function asset(string $path): string
    {
        $baseUrl = get_base_url();
        $cleanPath = ltrim($path, '/');
        
        if (str_starts_with($cleanPath, 'http://') || str_starts_with($cleanPath, 'https://')) {
            return $cleanPath;
        }

        if (str_starts_with($cleanPath, 'public/')) {
            $targetRel = $cleanPath;
        } else {
            $targetRel = 'public/' . $cleanPath;
        }

        return $baseUrl . '/' . ltrim($targetRel, '/');
    }
}

if (!function_exists('storage_asset')) {
    function storage_asset(string $path): string
    {
        $clean = ltrim($path, '/');
        if (str_starts_with($clean, 'storage/')) {
            return asset($clean);
        }
        return asset('storage/' . $clean);
    }
}

if (!function_exists('route')) {
    function route(string $name, $params = []): string
    {
        $baseUrl = get_base_url();
        $routes = [
            'home' => '/welcome.php',
            'public.services.index' => '/resources/views/public/services/index.php',
            'public.services.detail' => '/resources/views/public/services/detail.php',
            'public.projects.index' => '/resources/views/public/projects/index.php',
            'public.projects.detail' => '/resources/views/public/projects/detail.php',
            'public.contact' => '/resources/views/public/contact.php',
            'public.contact.submit' => '/resources/views/public/contact.php',
            'public.quotation' => '/resources/views/public/quotation.php',
            'public.quotation.submit' => '/resources/views/public/quotation.php',
            'public.clients' => '/resources/views/public/clients.php',
            'admin.home-editor' => '/resources/views/admin/home_editor.php',
            'admin.services.index' => '/resources/views/admin/services/index.php',
            'admin.services.create' => '/resources/views/admin/services/create.php',
            'admin.services.store' => '/resources/views/admin/services/create.php',
            'admin.services.edit' => '/resources/views/admin/services/edit.php',
            'admin.services.update' => '/resources/views/admin/services/edit.php',
            'admin.services.destroy' => '/resources/views/admin/services/index.php',
            'admin.other-services.index' => '/resources/views/admin/other_services/index.php',
            'admin.other-services.create' => '/resources/views/admin/other_services/create.php',
            'admin.other-services.store' => '/resources/views/admin/other_services/create.php',
            'admin.other-services.edit' => '/resources/views/admin/other_services/edit.php',
            'admin.other-services.update' => '/resources/views/admin/other_services/edit.php',
            'admin.other-services.destroy' => '/resources/views/admin/other_services/index.php',
            'admin.projects.index' => '/resources/views/admin/projects/index.php',
            'admin.projects.create' => '/resources/views/admin/projects/create.php',
            'admin.projects.store' => '/resources/views/admin/projects/create.php',
            'admin.projects.edit' => '/resources/views/admin/projects/edit.php',
            'admin.projects.update' => '/resources/views/admin/projects/edit.php',
            'admin.projects.destroy' => '/resources/views/admin/projects/index.php',
            'admin.clients.index' => '/resources/views/admin/clients/index.php',
            'admin.clients.create' => '/resources/views/admin/clients/create.php',
            'admin.clients.store' => '/resources/views/admin/clients/create.php',
            'admin.clients.edit' => '/resources/views/admin/clients/edit.php',
            'admin.clients.update' => '/resources/views/admin/clients/edit.php',
            'admin.clients.destroy' => '/resources/views/admin/clients/index.php',
            'admin.contacts.index' => '/resources/views/admin/contacts/index.php',
            'admin.contacts.show' => '/resources/views/admin/contacts/show.php',
            'admin.contacts.destroy' => '/resources/views/admin/contacts/index.php',
            'admin.quotations.index' => '/resources/views/admin/quotations/index.php',
            'admin.quotations.show' => '/resources/views/admin/quotations/show.php',
            'admin.quotations.update-status' => '/resources/views/admin/quotations/show.php',
            'admin.quotations.destroy' => '/resources/views/admin/quotations/index.php',
            'admin.settings.index' => '/resources/views/admin/settings/index.php',
            'admin.settings.update' => '/resources/views/admin/settings/index.php',
            'dashboard' => '/resources/views/admin/dashboard.php',
            'logout' => '/logout.php',
        ];

        $url = $baseUrl . ($routes[$name] ?? '/welcome.php');
        if (!empty($params)) {
            if (is_numeric($params) || is_string($params)) {
                $url .= '?id=' . urlencode((string) $params);
            } elseif (is_array($params)) {
                $url .= '?' . http_build_query($params);
            }
        }
        return $url;
    }
}

if (!function_exists('route_is')) {
    function route_is(string $pattern): bool
    {
        $requestUri = $_SERVER['REQUEST_URI'] ?? '/';
        $path = parse_url($requestUri, PHP_URL_PATH) ?? '/';
        
        if ($pattern === 'home') {
            return str_ends_with($path, '/welcome.php') || str_ends_with($path, '/index.php') || $path === '/';
        }
        
        $key = str_replace(['public.', 'admin.', '.*', '.index'], '', $pattern);
        return str_contains($path, $key);
    }
}

if (!function_exists('csrf_token')) {
    function csrf_token(): string
    {
        if (empty($_SESSION['_token'])) {
            $_SESSION['_token'] = bin2hex(random_bytes(32));
        }
        return $_SESSION['_token'];
    }
}

if (!function_exists('env_value')) {
    function env_value(string $key, ?string $default = null): ?string
    {
        static $env = null;
        if ($env === null) {
            $env = [];
            $appRoot = dirname(__DIR__);
            $envFile = $appRoot . '/.env';
            if (is_readable($envFile)) {
                foreach (file($envFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES) as $line) {
                    $line = trim($line);
                    if ($line === '' || str_starts_with($line, '#') || !str_contains($line, '=')) {
                        continue;
                    }
                    list($k, $v) = explode('=', $line, 2);
                    $env[trim($k)] = trim($v, " \t" . "'" . '"');
                }
            }
        }
        return $env[$key] ?? $default;
    }
}

if (!function_exists('get_pdo')) {
    function get_pdo(): ?PDO
    {
        static $pdo = null;
        if ($pdo instanceof PDO) {
            return $pdo;
        }
        try {
            $driver = env_value('DB_CONNECTION', 'sqlite');
            if ($driver === 'sqlite') {
                $appRoot = dirname(__DIR__);
                $database = env_value('DB_DATABASE', 'database/database.sqlite');
                $isWindowsDrive = (strlen($database) >= 2 && ctype_alpha($database[0]) && $database[1] === ':');
                if (!str_starts_with($database, '/') && !$isWindowsDrive) {
                    $database = $appRoot . '/' . $database;
                }
                if (!is_readable($database)) {
                    return null;
                }
                $pdo = new PDO('sqlite:' . $database);
            } else {
                $host = env_value('DB_HOST', '127.0.0.1');
                $port = env_value('DB_PORT', '3306');
                $database = env_value('DB_DATABASE', '');
                $username = env_value('DB_USERNAME', 'root');
                $password = env_value('DB_PASSWORD', '');
                $dsn = "mysql:host={$host};port={$port};dbname={$database};charset=utf8mb4";
                $pdo = new PDO($dsn, $username, $password);
            }
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
        } catch (Throwable $e) {
            return null;
        }
        return $pdo;
    }
}

if (!function_exists('native_slug')) {
    function native_slug(string $text): string
    {
        $text = preg_replace('~[^\pL\d]+~u', '-', $text);
        $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);
        $text = preg_replace('~[^-\w]+~', '', $text);
        $text = trim($text, '-');
        $text = preg_replace('~-+~', '-', $text);
        $text = strtolower($text);
        return empty($text) ? 'n-a' : $text;
    }
}

if (!function_exists('vite_assets')) {
    function vite_assets(): array
    {
        $appRoot = dirname(__DIR__, 2);
        $manifestPath = $appRoot . '/public/build/manifest.json';
        $css = [];
        $js = [];

        if (is_readable($manifestPath)) {
            $manifest = json_decode((string) file_get_contents($manifestPath), true);
            if (is_array($manifest)) {
                if (!empty($manifest['resources/css/app.css']['file'])) {
                    $css[] = asset('build/' . ltrim($manifest['resources/css/app.css']['file'], '/'));
                }
                if (!empty($manifest['resources/js/app.js']['file'])) {
                    $js[] = asset('build/' . ltrim($manifest['resources/js/app.js']['file'], '/'));
                }
            }
        }

        if ($css === []) {
            $css[] = 'https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css';
        }

        if ($js === []) {
            $js[] = 'https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js';
        }

        return ['css' => $css, 'js' => $js];
    }
}

