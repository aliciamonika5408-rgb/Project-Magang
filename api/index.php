<?php
/**
 * api/index.php
 * Vercel Serverless Function Entry Point untuk Website PT Multi Power Abadi.
 */

declare(strict_types=1);

// Change working directory to project root for seamless file includes
chdir(dirname(__DIR__));

$requestUri = $_SERVER['REQUEST_URI'] ?? '/';
$path = parse_url($requestUri, PHP_URL_PATH) ?? '/';

// Cleaning path
if ($path === '' || $path === '/') {
    require __DIR__ . '/../index.php';
    exit;
}

// Direct routing shortcuts
$routes = [
    '/login'     => __DIR__ . '/../login.php',
    '/admin'     => __DIR__ . '/../admin.php',
    '/logout'    => __DIR__ . '/../logout.php',
    '/welcome'   => __DIR__ . '/../welcome.php',
    '/projects'  => __DIR__ . '/../resources/views/public/projects/index.php',
    '/services'  => __DIR__ . '/../resources/views/public/services/index.php',
    '/clients'   => __DIR__ . '/../resources/views/public/clients.php',
    '/contact'   => __DIR__ . '/../resources/views/public/contact.php',
    '/quotation' => __DIR__ . '/../resources/views/public/quotation.php',
];

if (isset($routes[$path])) {
    require $routes[$path];
    exit;
}

// Direct file check
$targetFile = __DIR__ . '/..' . $path;
if (file_exists($targetFile) && is_file($targetFile) && str_ends_with($targetFile, '.php')) {
    require $targetFile;
    exit;
}

// Default fallback to index.php
require __DIR__ . '/../index.php';
