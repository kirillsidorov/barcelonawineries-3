<?php
declare(strict_types=1);

final class RegionController
{
    public static function show(string $slug): array
    {
        $db = DB::get();

        $region = $db->get('regions', '*', ['slug' => $slug]);

        if (!$region) {
            throw new NotFoundException("Region not found: {$slug}");
        }

        // All wineries in this region, ordered by rating
        $wineries = $db->select(
            'wineries',
            [
                'slug', 'name', 'city', 'image_hero', 'rating',
                'distance_km', 'no_car_needed', 'has_restaurant',
                'kids_welcome', 'wine_tasting', 'intro',
            ],
            [
                'region_id' => $region['id'],
                'ORDER'     => ['rating' => 'DESC'],
            ]
        );

        $breadcrumbs = [
            ['name' => 'Home',         'url' => SITE_URL . '/'],
            ['name' => 'Regions',      'url' => SITE_URL . '/region/'],
            ['name' => $region['name'],'url' => url_region($region['slug'])],
        ];

        $seo = build_seo([
            'title'       => "Wineries in {$region['name']} — Visit & Book Tours",
            'description' => $region['meta_description'] ?: $region['description'],
        ]);

        return [
            'seo'         => $seo,
            'region'      => $region,
            'wineries'    => $wineries,
            'breadcrumbs' => $breadcrumbs,
        ];
    }
}
