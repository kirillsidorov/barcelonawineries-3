<?php
declare(strict_types=1);

final class HomeController
{
    public static function index(): array
    {
        $db = DB::get();

        $featuredWineries = $db->select(
            'wineries',
            [
                '[>]regions' => ['region_id' => 'id'],
            ],
            [
                'wineries.slug',
                'wineries.name',
                'wineries.city',
                'wineries.image_hero',
                'wineries.rating',
                'wineries.review_count',
                'wineries.distance_km',
                'wineries.no_car_needed',
                'wineries.organic',
                'wineries.has_restaurant',
                'wineries.accommodation',
                'wineries.kids_welcome',
                'wineries.intro',
                'regions.name(region_name)',
                'regions.slug(region_slug)',
            ],
            [
                'wineries.is_featured'  => 1,
                'wineries.is_published' => 1,
                'ORDER' => ['wineries.rating' => 'DESC'],
                'LIMIT' => 6,
            ]
        );

        $regions = $db->select('regions', '*', ['ORDER' => ['sort_order' => 'ASC']]);

        // Total published winery count for hero
        $wineryCount = $db->count('wineries', ['is_published' => 1]);

        // All categories for the category section
        $categories = $db->select('categories', ['slug', 'label', 'description'], [
            'ORDER' => ['sort_order' => 'ASC'],
        ]);

        $seo = build_seo([]);

        return [
            'seo'              => $seo,
            'featuredWineries' => $featuredWineries,
            'regions'          => $regions,
            'wineryCount'      => $wineryCount,
            'categories'       => $categories,
        ];
    }
}
