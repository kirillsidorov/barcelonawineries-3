<?php
declare(strict_types=1);

class SitemapController {
    public static function index(): void {
        $db = DB::get(); // Используем твой Singleton
        
        $wineries   = $db->select('wineries', ['slug'], ['is_published' => 1]); //
        $regions    = $db->select('regions', ['slug']); //
        $categories = $db->select('categories', ['slug']); //

        header("Content-Type: application/xml; charset=utf-8");
        echo '<?xml version="1.0" encoding="UTF-8"?>';
        echo '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';

        // Главная
        self::addUrl('');

        // Винодельни
        foreach ($wineries as $w) self::addUrl('/winery/' . $w['slug']);
        
        // Регионы
        foreach ($regions as $r) self::addUrl('/region/' . $r['slug']);

        echo '</urlset>';
    }

    private static function addUrl(string $path): void {
        echo '<url><loc>' . SITE_URL . $path . '</loc><changefreq>weekly</changefreq></url>'; //
    }
}