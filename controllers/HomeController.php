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
                'wineries.distance_km',
                'wineries.no_car_needed',
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

        $seo = build_seo([]); // uses site defaults

        return [
            'seo'              => $seo,
            'featuredWineries' => $featuredWineries,
            'regions'          => $regions,
        ];
    }
}
