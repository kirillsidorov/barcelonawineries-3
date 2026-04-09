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

$segment0 = $parts[0] ?? '';
$segment1 = $parts[1] ?? '';

try {
    match (true) {

        // HOME
        $uri === '/' => (function () {
            require_once CONTROLLERS_PATH . '/HomeController.php';
            $data = HomeController::index();
            render('home', $data);
        })(),

        // WINERY
        $segment0 === 'winery' && !empty($segment1) => (function () use ($segment1) {
            require_once CONTROLLERS_PATH . '/WineryController.php';
            $data = WineryController::show($segment1);
            render('single-winery', $data);
        })(),

        // REGION
        $segment0 === 'region' && !empty($segment1) => (function () use ($segment1) {
            require_once CONTROLLERS_PATH . '/RegionController.php';
            $data = RegionController::show($segment1);
            render('region', $data);
        })(),

        // CATEGORY
        $segment0 === 'category' && !empty($segment1) => (function () use ($segment1) {
            require_once CONTROLLERS_PATH . '/CategoryController.php';
            $data = CategoryController::show($segment1);
            render('category', $data);
        })(),

        // ─── ADMIN PANEL ──────────────────────────────────────────
        str_starts_with($uri, '/admin') => (function () use ($uri) {
            require_once CONTROLLERS_PATH . '/AdminController.php';

            match ($uri) {
                // Core
                '/admin'              => AdminController::index(),
                '/admin/login'        => AdminController::login(),
                '/admin/logout'       => AdminController::logout(),

                // Wineries CRUD
                '/admin/wineries'     => AdminController::wineries(),
                '/admin/edit'         => AdminController::edit($_GET['id'] ?? null),
                '/admin/save'         => AdminController::save(),
                '/admin/delete'       => AdminController::delete(),
                '/admin/toggle'       => AdminController::toggle(),

                // Regions CRUD
                '/admin/regions'      => AdminController::regions(),
                '/admin/region-edit'  => AdminController::regionEdit($_GET['id'] ?? null),
                '/admin/region-save'  => AdminController::regionSave(),

                // Categories CRUD
                '/admin/categories'   => AdminController::categories(),
                '/admin/category-edit'=> AdminController::categoryEdit($_GET['id'] ?? null),
                '/admin/category-save'=> AdminController::categorySave(),

                default               => http_response_code(404),
            };
        })(),

        // SITEMAP
        $uri === '/sitemap.xml' => (function () {
            require_once CONTROLLERS_PATH . '/SitemapController.php';
            SitemapController::index();
        })(),

        // 404
        default => (function () {
            http_response_code(404);
            $data = [
                'seo' => [
                    'title'       => '404 — Page Not Found | ' . SITE_NAME,
                    'description' => 'Sorry, this page does not exist.',
                    'canonical'   => '',
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
function render(string $template, array $data = []): void
{
    extract($data, EXTR_SKIP);
    $templateFile = TEMPLATES_PATH . '/' . $template . '.php';

    if (!file_exists($templateFile)) {
        throw new RuntimeException("Template not found: {$template}");
    }

    require $templateFile;
}
