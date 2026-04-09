<?php
declare(strict_types=1);

final class RegionController
{
    /**
     * Maps region slugs to related regions for cross-linking.
     * PDF brief: "Compare-region block" on each region page.
     */
    private const RELATED_REGIONS = [
        'penedes'      => ['alella', 'pla-de-bages'],
        'alella'       => ['penedes', 'pla-de-bages'],
        'priorat'      => ['montsant', 'penedes'],
        'pla-de-bages' => ['penedes', 'priorat'],
        'emporda'      => ['penedes', 'priorat'],
        'montsant'     => ['priorat', 'penedes'],
        'conca-de-barbera' => ['penedes', 'priorat'],
        'costers-del-segre'=> ['conca-de-barbera', 'priorat'],
        'terra-alta'   => ['priorat', 'montsant'],
        'tarragona'    => ['penedes', 'priorat'],
        'catalunya-do' => ['penedes', 'alella'],
    ];

    /**
     * Maps region slugs to relevant category slugs.
     * PDF brief: "Related category links" on each region page.
     */
    private const REGION_CATEGORIES = [
        'penedes'      => ['no-car-needed', 'organic-wines', 'family-friendly'],
        'alella'       => ['no-car-needed', 'organic-wines', 'family-friendly'],
        'priorat'      => ['organic-wines', 'restaurant-onsite'],
        'pla-de-bages' => ['organic-wines', 'with-accommodation'],
        'emporda'      => ['restaurant-onsite', 'with-accommodation'],
        'montsant'     => ['organic-wines', 'restaurant-onsite'],
    ];

    public static function show(string $slug): array
    {
        $db = DB::get();

        $region = $db->get('regions', '*', ['slug' => $slug]);

        if (!$region) {
            throw new NotFoundException("Region not found: {$slug}");
        }

        // All wineries in this region
        $wineries = $db->select(
            'wineries',
            [
                'slug', 'name', 'city', 'image_hero', 'rating', 'review_count',
                'distance_km', 'no_car_needed', 'has_restaurant',
                'kids_welcome', 'wine_tasting', 'intro', 'organic',
                'accommodation', 'is_published',
            ],
            [
                'region_id'    => $region['id'],
                'is_published' => 1,
                'ORDER'        => ['rating' => 'DESC'],
            ]
        );

        // Related regions for "Compare regions" block
        $relatedSlugs = self::RELATED_REGIONS[$slug] ?? [];
        $relatedRegions = [];
        if (!empty($relatedSlugs)) {
            $relatedRegions = $db->select('regions', ['slug', 'name', 'description'], [
                'slug' => $relatedSlugs,
                'ORDER' => ['sort_order' => 'ASC'],
            ]);
        }

        // Related categories for cross-linking
        $categorySlugs = self::REGION_CATEGORIES[$slug] ?? ['no-car-needed', 'organic-wines'];
        // We pass the slugs to the template; labels are resolved there or via a shared map
        $categories = $db->select('categories', ['slug', 'label'], [
            'slug' => $categorySlugs,
            'ORDER' => ['sort_order' => 'ASC'],
        ]);

        $breadcrumbs = [
            ['name' => 'Home',          'url' => SITE_URL . '/'],
            ['name' => $region['name'], 'url' => url_region($region['slug'])],
        ];

        $seo = build_seo([
            'title'       => "Wineries in {$region['name']} — Visit & Book Tours",
            'description' => $region['meta_description'] ?: $region['description'],
        ]);

        return [
            'seo'            => $seo,
            'region'         => $region,
            'wineries'       => $wineries,
            'relatedRegions' => $relatedRegions,
            'categories'     => $categories,
            'breadcrumbs'    => $breadcrumbs,
        ];
    }
}
