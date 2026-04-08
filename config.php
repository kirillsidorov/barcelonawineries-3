<?php
declare(strict_types=1);

// 1. ЗАГРУЗЧИК .env (добавь этот блок)
if (file_exists(__DIR__ . '/.env')) {
    $lines = file(__DIR__ . '/.env', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($lines as $line) {
        if (strpos(trim($line), '#') === 0) continue; // Пропускаем комментарии
        if (strpos($line, '=') !== false) {
            list($name, $value) = explode('=', $line, 2);
            putenv(trim($name) . "=" . trim($value));
        }
    }
}

// ─── Environment ─────────────────────────────────────────────────────────────
define('ENV', getenv('APP_ENV') ?: 'development'); // 'development' | 'production'
define('DEBUG', ENV === 'development');

if (DEBUG) {
    error_reporting(E_ALL);
    ini_set('display_errors', '1');
} else {
    error_reporting(0);
    ini_set('display_errors', '0');
}

// ─── Site Identity ────────────────────────────────────────────────────────────
define('SITE_NAME',    'Barcelona Wineries');
define('SITE_URL',     'https://barcelonawineries.com');
define('SITE_LANG',    'en');
define('SITE_LOCALE',  'en_GB');

// ─── Database ─────────────────────────────────────────────────────────────────
// Store real credentials in a .env file or server environment variables.
// Never hardcode passwords in version-controlled files.

define('DB_HOST',    getenv('DB_HOST')     ?: 'local');
define('DB_PORT',    (int)(getenv('DB_PORT') ?: 3306));
define('DB_NAME',    getenv('DB_NAME')     ?: 'barcelonawineries');
define('DB_USER',    getenv('DB_USER')     ?: 'root');
define('DB_PASS',    getenv('DB_PASS')     ?: '');
define('DB_CHARSET', 'utf8mb4');

// ─── SEO Defaults ─────────────────────────────────────────────────────────────
define('SEO_DEFAULTS', [
    'title'       => "Barcelona Wineries — Discover Catalonia's Best Wine Regions",
    'description' => "Explore wineries near Barcelona. Visit Penedès, Priorat & more — by car, train, or tour. Book experiences with GetYourGuide.",
    'image'       => SITE_URL . '/assets/img/og-default.webp',
    'type'        => 'website',
]);

// ─── Affiliate Partners ───────────────────────────────────────────────────────
define('GYG_PARTNER_ID',    getenv('GYG_PARTNER_ID')    ?: '');
define('VIATOR_PARTNER_ID', getenv('VIATOR_PARTNER_ID') ?: '');

// ─── Cache ────────────────────────────────────────────────────────────────────
define('CACHE_TTL', 3600); // seconds — used for output buffering cache layer

// ─── Paths ────────────────────────────────────────────────────────────────────
define('ROOT_PATH',        __DIR__);
define('TEMPLATES_PATH',   ROOT_PATH . '/templates');
define('COMPONENTS_PATH',  ROOT_PATH . '/components');
define('CONTROLLERS_PATH', ROOT_PATH . '/controllers');
define('ASSETS_URL',       SITE_URL  . '/assets');
