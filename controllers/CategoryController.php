<?php
declare(strict_types=1);

/**
 * CategoryController
 *
 * Handles semantic hub pages like:
 *   /category/no-car-needed
 *   /category/family-friendly
 *   /category/organic-wines
 *
 * Each category slug maps to a feature flag column in the wineries table.
 */
final class CategoryController
{
    /**
     * Maps URL slugs to:
     *   - column:  the wineries table column to filter on
     *   - label:   human-readable name
     *   - desc:    SEO description for the hub page
     */
    private const CATEGORY_MAP = [
        'no-car-needed'    => [
            'column' => 'no_car_needed',
            'label'  => 'Wineries Reachable Without a Car',
            'desc'   => 'Discover Barcelona-area wineries you can visit by train, bus, or tour — no car required.',
        ],
        'family-friendly'  => [
            'column' => 'kids_welcome',
            'label'  => 'Family-Friendly Wineries near Barcelona',
            'desc'   => 'The best wineries near Barcelona that welcome children, with activities for the whole family.',
        ],
        'organic-wines'    => [
            'column' => 'organic',
            'label'  => 'Organic & Biodynamic Wineries',
            'desc'   => 'Explore certified organic and biodynamic wineries in Catalonia.',
        ],
        'restaurant-onsite'=> [
            'column' => 'has_restaurant',
            'label'  => 'Wineries with Restaurants',
            'desc'   => 'Combine a winery visit with an exceptional meal — these estates have restaurants on site.',
        ],
        'with-accommodation'=> [
            'column' => 'accommodation',
            'label'  => 'Wineries with Accommodation',
            'desc'   => 'Stay overnight at a Catalan winery — from rustic farmhouses to boutique wine hotels.',
        ],
        'pet-friendly'     => [
            'column' => 'pet_friendly',
            'label'  => 'Pet-Friendly Wineries',
            'desc'   => 'Wine tasting with your dog — these Catalan wineries welcome four-legged visitors.',
        ],
    ];

    public static function show(string $slug): array
    {
        if (!array_key_exists($slug, self::CATEGORY_MAP)) {
            throw new NotFoundException("Category not found: {$slug}");
        }

        $category = self::CATEGORY_MAP[$slug];
        $db       = DB::get();

        $wineries = $db->select(
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
                'wineries.' . $category['column'] => 1,
                'ORDER' => ['wineries.rating' => 'DESC'],
            ]
        );

        $breadcrumbs = [
            ['name' => 'Home',               'url' => SITE_URL . '/'],
            ['name' => 'Wine Experiences',   'url' => SITE_URL . '/category/'],
            ['name' => $category['label'],   'url' => url_category($slug)],
        ];

        $seo = build_seo([
            'title'       => $category['label'],
            'description' => $category['desc'],
        ]);

        return [
            'seo'         => $seo,
            'category'    => $category,
            'slug'        => $slug,
            'wineries'    => $wineries,
            'breadcrumbs' => $breadcrumbs,
        ];
    }
}
