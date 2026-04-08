<?php
declare(strict_types=1);

final class WineryController
{
    public static function show(string $slug): array
    {
        $db = DB::get();

        $winery = $db->get(
            'wineries',
            ['[>]regions' => ['region_id' => 'id']],
            [
                'wineries.id', 'wineries.slug', 'wineries.name',
                'wineries.city', 'wineries.postcode', 'wineries.address',
                'wineries.lat', 'wineries.lng',
                'wineries.distance_km', 'wineries.drive_time_min',
                'wineries.nearest_station',
                'wineries.intro', 'wineries.body_content', 'wineries.image_hero',
                'wineries.meta_title', 'wineries.meta_description',
                'wineries.no_car_needed', 'wineries.has_restaurant',
                'wineries.kids_welcome', 'wineries.wine_tasting',
                'wineries.opening_hours', 'wineries.languages',
                'wineries.price_range', 'wineries.cellar_tours',
                'wineries.accommodation', 'wineries.organic',
                'wineries.pet_friendly', 'wineries.wheelchair_accessible',
                'wineries.website_url', 'wineries.instagram_url',
                'wineries.google_maps_url', 'wineries.gyg_url', 'wineries.viator_url',
                'wineries.rating', 'wineries.review_count',
                'wineries.benefit_1', 'wineries.benefit_2', 'wineries.benefit_3',
                'regions.id(region_id)',
                'regions.name(region_name)',
                'regions.slug(region_slug)',
            ],
            ['wineries.slug' => $slug, 'wineries.is_published' => 1]
        );

        if (!$winery) {
            throw new NotFoundException("Winery not found: {$slug}");
        }

        $related = $db->select(
            'wineries',
            ['[>]regions' => ['region_id' => 'id']],
            [
                'wineries.slug', 'wineries.name', 'wineries.city',
                'wineries.rating', 'wineries.review_count',
                'wineries.no_car_needed', 'wineries.intro',
                'regions.name(region_name)', 'regions.slug(region_slug)',
            ],
            [
                'wineries.region_id' => $winery['region_id'],
                'wineries.slug[!]'   => $slug,
                'wineries.is_published' => 1,
                'ORDER' => ['wineries.rating' => 'DESC'],
                'LIMIT' => 3,
            ]
        );

        $breadcrumbs = [
            ['name' => 'Home',                  'url' => SITE_URL . '/'],
            ['name' => $winery['region_name'],  'url' => url_region($winery['region_slug'])],
            ['name' => $winery['name'],         'url' => url_winery($winery['slug'])],
        ];

        $seo = build_seo([
            'title'       => $winery['meta_title']       ?: $winery['name'] . ' — Winery near Barcelona',
            'description' => $winery['meta_description'] ?: $winery['intro'],
            'type'        => 'place',
        ]);

        return compact('seo', 'winery', 'related', 'breadcrumbs');
    }
}