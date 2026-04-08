<?php
declare(strict_types=1);

require_once __DIR__ . '/config.php';
require_once __DIR__ . '/db.php';
require_once __DIR__ . '/functions.php';

session_start();

// ─── Parse the request URI ────────────────────────────────────────────────────
$uri    = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$uri    = rtrim($uri, '/') ?: '/';
$parts  = explode('/', ltrim($uri, '/'));

// ─── Route Definitions ────────────────────────────────────────────────────────
// Pattern: [segment_0, segment_1] → controller + method
// e.g. /winery/can-rafols-dels-caus → ['winery', <slug>]

$segment0 = $parts[0] ?? '';
$segment1 = $parts[1] ?? '';

try {
    match (true) {

        // HOME  →  /
        $uri === '/' => (function () {
            require_once CONTROLLERS_PATH . '/HomeController.php';
            $data = HomeController::index();
            render('home', $data);
        })(),
        
        // ТЕСТОВЫЙ ДИЗАЙН  →  /test
        $uri === '/test' => (function () {
            // Просто отдаем наш новый файл без подключения стандартных хедеров
            require_once ROOT_PATH . '/templates/test_design.php';
        })(),

        // WINERY  →  /winery/[slug]
        $segment0 === 'winery' && !empty($segment1) => (function () use ($segment1) {
            require_once CONTROLLERS_PATH . '/WineryController.php';
            $data = WineryController::show($segment1);
            render('single-winery', $data);
        })(),

        // REGION  →  /region/[slug]
        $segment0 === 'region' && !empty($segment1) => (function () use ($segment1) {
            require_once CONTROLLERS_PATH . '/RegionController.php';
            $data = RegionController::show($segment1);
            render('region', $data);
        })(),

        // CATEGORY / SEMANTIC HUB  →  /category/[slug]
        // e.g. /category/no-car-needed, /category/family-friendly
        $segment0 === 'category' && !empty($segment1) => (function () use ($segment1) {
            require_once CONTROLLERS_PATH . '/CategoryController.php';
            $data = CategoryController::show($segment1);
            render('category', $data);
        })(),


        // ADMIN PANEL
        str_starts_with($uri, '/admin') => (function () use ($uri) {
            require_once CONTROLLERS_PATH . '/AdminController.php';
            
            match ($uri) {
                '/admin'          => AdminController::index(),
                '/admin/login'    => AdminController::login(),
                '/admin/wineries' => AdminController::wineries(),
                '/admin/edit'     => AdminController::edit($_GET['id'] ?? null),
                '/admin/save'     => AdminController::save(),
                '/admin/logout'   => AdminController::logout(),
                default           => http_response_code(404),
            };
        })(),
        // SITEMAP  →  /sitemap.xml
        $uri === '/sitemap.xml' => (function () {
            require_once CONTROLLERS_PATH . '/SitemapController.php';
            SitemapController::index();
        })(),

        // Fallback → 404
        default => (function () {
            http_response_code(404);
            $data = [
                'seo' => [
                    'title'       => '404 — Page Not Found | ' . SITE_NAME,
                    'description' => 'Sorry, this page does not exist.', // Добавили ключ
                    'canonical'   => ''                                   // Добавили ключ
                ]
            ];
            render('404', $data);
        })(),

    };
} catch (NotFoundException $e) {
    http_response_code(404);
    $data = ['seo' => ['title' => '404 — Page Not Found | ' . SITE_NAME]];
    render('404', $data);
} catch (Throwable $e) {
    error_log($e->getMessage());
    http_response_code(500);
    if (DEBUG) throw $e;
    echo 'Something went wrong.';
}

// ─── Render Helper ────────────────────────────────────────────────────────────
/**
 * Extracts $data keys as variables, then includes the template.
 * Templates receive clean named variables — no $data['x'] noise.
 */
function render(string $template, array $data = []): void
{
    extract($data, EXTR_SKIP); // EXTR_SKIP: never overwrite existing vars
    $templateFile = TEMPLATES_PATH . '/' . $template . '.php';

    if (!file_exists($templateFile)) {
        throw new RuntimeException("Template not found: {$template}");
    }

    require $templateFile;
}
