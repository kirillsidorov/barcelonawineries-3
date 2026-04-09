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
     *   - regions: best regions for this category (PDF brief: "Best regions for this category" block)
     *   - related: related category slugs for cross-linking
     */
    private const CATEGORY_MAP = [
        'no-car-needed' => [
            'column'  => 'no_car_needed',
            'label'   => 'Wineries Reachable Without a Car',
            'desc'    => 'Discover Barcelona-area wineries you can visit by train, bus, or tour — no car required.',
            'regions' => ['alella', 'penedes'],
            'related' => ['family-friendly', 'organic-wines'],
        ],
        'family-friendly' => [
            'column'  => 'kids_welcome',
            'label'   => 'Family-Friendly Wineries near Barcelona',
            'desc'    => 'The best wineries near Barcelona that welcome children, with activities for the whole family.',
            'regions' => ['alella', 'penedes'],
            'related' => ['no-car-needed', 'restaurant-onsite'],
        ],
        'organic-wines' => [
            'column'  => 'organic',
            'label'   => 'Organic & Biodynamic Wineries',
            'desc'    => 'Explore certified organic and biodynamic wineries in Catalonia.',
            'regions' => ['penedes', 'alella', 'pla-de-bages'],
            'related' => ['no-car-needed', 'family-friendly'],
        ],
        'restaurant-onsite' => [
            'column'  => 'has_restaurant',
            'label'   => 'Wineries with Restaurants',
            'desc'    => 'Combine a winery visit with an exceptional meal — these estates have restaurants on site.',
            'regions' => ['penedes', 'priorat'],
            'related' => ['with-accommodation', 'organic-wines'],
        ],
        'with-accommodation' => [
            'column'  => 'accommodation',
            'label'   => 'Wineries with Accommodation',
            'desc'    => 'Stay overnight at a Catalan winery — from rustic farmhouses to boutique wine hotels.',
            'regions' => ['penedes', 'pla-de-bages', 'priorat'],
            'related' => ['restaurant-onsite', 'organic-wines'],
        ],
        'pet-friendly' => [
            'column'  => 'pet_friendly',
            'label'   => 'Pet-Friendly Wineries',
            'desc'    => 'Wine tasting with your dog — these Catalan wineries welcome four-legged visitors.',
            'regions' => ['penedes', 'alella'],
            'related' => ['family-friendly', 'no-car-needed'],
        ],
    ];

    public static function show(string $slug): array
    {
        if (!array_key_exists($slug, self::CATEGORY_MAP)) {
            throw new NotFoundException("Category not found: {$slug}");
        }

        $category = self::CATEGORY_MAP[$slug];
        $db       = DB::get();

        // Wineries in this category
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
                'wineries.review_count',
                'wineries.distance_km',
                'wineries.no_car_needed',
                'wineries.has_restaurant',
                'wineries.organic',
                'wineries.accommodation',
                'wineries.kids_welcome',
                'wineries.intro',
                'regions.name(region_name)',
                'regions.slug(region_slug)',
            ],
            [
                'wineries.' . $category['column'] => 1,
                'wineries.is_published' => 1,
                'ORDER' => ['wineries.rating' => 'DESC'],
            ]
        );

        // Best regions for this category
        $regionSlugs = $category['regions'] ?? [];
        $bestRegions = [];
        if (!empty($regionSlugs)) {
            $bestRegions = $db->select('regions', ['slug', 'name', 'description'], [
                'slug' => $regionSlugs,
                'ORDER' => ['sort_order' => 'ASC'],
            ]);
        }

        // Related categories for cross-linking
        $relatedSlugs = $category['related'] ?? [];
        $relatedCategories = [];
        foreach ($relatedSlugs as $relSlug) {
            if (isset(self::CATEGORY_MAP[$relSlug])) {
                $relatedCategories[] = [
                    'slug'  => $relSlug,
                    'label' => self::CATEGORY_MAP[$relSlug]['label'],
                    'desc'  => self::CATEGORY_MAP[$relSlug]['desc'],
                ];
            }
        }

        $breadcrumbs = [
            ['name' => 'Home',             'url' => SITE_URL . '/'],
            ['name' => $category['label'], 'url' => url_category($slug)],
        ];

        $seo = build_seo([
            'title'       => $category['label'],
            'description' => $category['desc'],
        ]);

        return [
            'seo'               => $seo,
            'category'          => $category,
            'slug'              => $slug,
            'wineries'          => $wineries,
            'bestRegions'       => $bestRegions,
            'relatedCategories' => $relatedCategories,
            'breadcrumbs'       => $breadcrumbs,
        ];
    }
}
