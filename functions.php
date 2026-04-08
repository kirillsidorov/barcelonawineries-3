<?php
declare(strict_types=1);

// ─── Exceptions ───────────────────────────────────────────────────────────────
class NotFoundException extends RuntimeException {}

// ─── Output Helpers ───────────────────────────────────────────────────────────

/** Safe HTML output — always escape user/DB content */
function e(mixed $value): string
{
    return htmlspecialchars((string)$value, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}

/** Generate a URL-safe slug from a string */
function slugify(string $text): string
{
    $text = strtolower(trim($text));
    $text = iconv('UTF-8', 'ASCII//TRANSLIT', $text);
    $text = preg_replace('/[^a-z0-9]+/', '-', $text);
    return trim($text, '-');
}

// ─── URL Builders ─────────────────────────────────────────────────────────────

function url_winery(string $slug): string
{
    return SITE_URL . '/winery/' . e($slug);
}

function url_region(string $slug): string
{
    return SITE_URL . '/region/' . e($slug);
}

function url_category(string $slug): string
{
    return SITE_URL . '/category/' . e($slug);
}

// ─── SEO Meta Tag Generator ───────────────────────────────────────────────────

/**
 * Merges page-specific SEO data with site defaults.
 * Call once per controller, pass result to template as $seo.
 *
 * @param array $overrides ['title', 'description', 'image', 'type', 'canonical']
 */
function build_seo(array $overrides = []): array
{
    $defaults = SEO_DEFAULTS;

    $seo = array_merge($defaults, $overrides);

    // Title: append site name unless already present
    if (!str_contains($seo['title'], SITE_NAME)) {
        $seo['title'] = $seo['title'] . ' | ' . SITE_NAME;
    }

    // Canonical defaults to current page URL
    if (empty($seo['canonical'])) {
        $seo['canonical'] = SITE_URL . parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
    }

    return $seo;
}

/**
 * Renders <title>, meta description, OG tags, and canonical link.
 * Called inside <head> in header.php.
 */
function render_seo_tags(array $seo): void
{
    $title       = e($seo['title']);
    $description = $seo['description'] ?? SEO_DEFAULTS['description'];
    $image       = e($seo['image'] ?? SEO_DEFAULTS['image']);
    $canonical = $seo['canonical'] ?? SITE_URL . $_SERVER['REQUEST_URI'];
    $type        = e($seo['type'] ?? 'website');
    $siteName    = e(SITE_NAME);

    echo <<<HTML
    <title>{$title}</title>
    <meta name="description" content="{$description}">
    <link rel="canonical" href="{$canonical}">

    <!-- Open Graph -->
    <meta property="og:type"        content="{$type}">
    <meta property="og:title"       content="{$title}">
    <meta property="og:description" content="{$description}">
    <meta property="og:image"       content="{$image}">
    <meta property="og:url"         content="{$canonical}">
    <meta property="og:site_name"   content="{$siteName}">

    <!-- Twitter Card -->
    <meta name="twitter:card"        content="summary_large_image">
    <meta name="twitter:title"       content="{$title}">
    <meta name="twitter:description" content="{$description}">
    <meta name="twitter:image"       content="{$image}">
    HTML;

    // Noindex pages (e.g. search results, filtered pages without unique content)
    if (!empty($seo['noindex'])) {
        echo "\n    <meta name=\"robots\" content=\"noindex, follow\">";
    }
}

// ─── Schema.org / JSON-LD ─────────────────────────────────────────────────────

/**
 * Generates Schema.org JSON-LD for a Winery (LocalBusiness + TouristAttraction).
 * Called in components/schema-org.php or directly in single-winery.php.
 *
 * @param array $winery   Full winery row + joined region data
 * @param array $breadcrumbs  [['name'=>'Home','url'=>'/'], ['name'=>'Region',...], ...]
 */
function schema_winery(array $winery, array $breadcrumbs = []): string
{
    $schema = [
        '@context' => 'https://schema.org',
        '@graph'   => [
            [
                '@type'       => ['LocalBusiness', 'Winery', 'TouristAttraction'],
                '@id'         => url_winery($winery['slug']) . '#winery',
                'name'        => $winery['name'],
                'description' => $winery['meta_description'] ?? $winery['intro'],
                'url'         => url_winery($winery['slug']),
                'image'       => SITE_URL . '/assets/img/wineries/' . e($winery['slug']) . '.webp',
                'address'     => [
                    '@type'           => 'PostalAddress',
                    'addressLocality' => $winery['city']    ?? '',
                    'addressRegion'   => $winery['region_name'] ?? '',
                    'addressCountry'  => 'ES',
                ],
                'geo' => !empty($winery['lat']) ? [
                    '@type'     => 'GeoCoordinates',
                    'latitude'  => $winery['lat'],
                    'longitude' => $winery['lng'],
                ] : null,
                'aggregateRating' => !empty($winery['rating']) ? [
                    '@type'       => 'AggregateRating',
                    'ratingValue' => $winery['rating'],
                    'reviewCount' => $winery['review_count'] ?? 0,
                ] : null,
                'amenityFeature' => build_amenity_features($winery),
                'hasMap'  => !empty($winery['google_maps_url']) ? $winery['google_maps_url'] : null,
                'sameAs'  => array_filter([
                    $winery['website_url'] ?? null,
                    $winery['instagram_url'] ?? null,
                ]),
            ],
            build_breadcrumb_schema($breadcrumbs),
        ],
    ];

    // Remove null values recursively
    $schema = array_map_recursive(fn($v) => $v, $schema);

    return '<script type="application/ld+json">' . "\n"
        . json_encode($schema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT)
        . "\n</script>";
}

/** Generates Schema.org JSON-LD for a Region hub page */
function schema_region(array $region, array $breadcrumbs = []): string
{
    $schema = [
        '@context' => 'https://schema.org',
        '@graph'   => [
            [
                '@type'       => 'CollectionPage',
                '@id'         => url_region($region['slug']) . '#region',
                'name'        => $region['name'],
                'description' => $region['description'],
                'url'         => url_region($region['slug']),
                'about'       => [
                    '@type' => 'Place',
                    'name'  => $region['name'],
                    'geo'   => [
                        '@type'     => 'GeoCoordinates',
                        'latitude'  => $region['lat']  ?? '',
                        'longitude' => $region['lng']  ?? '',
                    ],
                ],
            ],
            build_breadcrumb_schema($breadcrumbs),
        ],
    ];

    return '<script type="application/ld+json">' . "\n"
        . json_encode($schema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT)
        . "\n</script>";
}

// ─── Breadcrumbs ──────────────────────────────────────────────────────────────

/**
 * Renders HTML breadcrumbs + returns structured data array for schema_*() functions.
 *
 * @param array $crumbs [['name' => 'Home', 'url' => '/'], ['name' => 'Penedès', 'url' => '/region/penedes'], ...]
 */
function render_breadcrumbs(array $crumbs): void
{
    echo '<nav aria-label="Breadcrumb" class="breadcrumbs"><ol itemscope itemtype="https://schema.org/BreadcrumbList">';
    foreach ($crumbs as $i => $crumb) {
        $isLast  = $i === array_key_last($crumbs);
        $pos     = $i + 1;
        $name    = e($crumb['name']);
        $url     = e($crumb['url']);
        $current = $isLast ? ' aria-current="page"' : '';

        echo "<li itemprop=\"itemListElement\" itemscope itemtype=\"https://schema.org/ListItem\">";
        if (!$isLast) {
            echo "<a itemprop=\"item\" href=\"{$url}\"><span itemprop=\"name\">{$name}</span></a>";
        } else {
            echo "<span itemprop=\"name\"{$current}>{$name}</span>";
        }
        echo "<meta itemprop=\"position\" content=\"{$pos}\"></li>";
    }
    echo '</ol></nav>';
}

function build_breadcrumb_schema(array $crumbs): array
{
    $items = [];
    foreach ($crumbs as $i => $crumb) {
        $items[] = [
            '@type'    => 'ListItem',
            'position' => $i + 1,
            'name'     => $crumb['name'],
            'item'     => $crumb['url'],
        ];
    }

    return [
        '@type'           => 'BreadcrumbList',
        'itemListElement' => $items,
    ];
}

// ─── Affiliate URL Builders ───────────────────────────────────────────────────

function gyg_url(string $productUrl, string $campaignLabel = 'winery'): string
{
    if (empty(GYG_PARTNER_ID) || empty($productUrl)) return '#';
    return $productUrl . '?partner_id=' . urlencode(GYG_PARTNER_ID) . '&utm_campaign=' . urlencode($campaignLabel);
}

// ─── Internal Helpers ─────────────────────────────────────────────────────────

/**
 * Converts winery feature flags to Schema.org LocationFeatureSpecification array.
 */
function build_amenity_features(array $winery): array
{
    $features = [
        'no_car_needed' => 'Accessible Without a Car',
        'has_restaurant'=> 'Restaurant on Site',
        'kids_welcome'  => 'Family Friendly',
        'wine_tasting'  => 'Wine Tasting Available',
        'cellar_tours'  => 'Cellar Tours',
        'accommodation' => 'Accommodation',
        'organic'       => 'Organic / Biodynamic Wines',
        'pet_friendly'  => 'Pet Friendly',
    ];

    $result = [];
    foreach ($features as $column => $label) {
        if (!empty($winery[$column])) {
            $result[] = [
                '@type' => 'LocationFeatureSpecification',
                'name'  => $label,
                'value' => true,
            ];
        }
    }
    return $result;
}

/**
 * Recursively remove null values from an array (for clean JSON-LD output).
 */
function array_map_recursive(callable $fn, array $arr): array
{
    $result = [];
    foreach ($arr as $k => $v) {
        if ($v === null) continue;
        $result[$k] = is_array($v) ? array_map_recursive($fn, $v) : $fn($v);
    }
    return $result;
}

/**
 * Inline the critical CSS file directly into <head>.
 * Called once in header.php.
 */
function inline_critical_css(): void
{
    $file = ROOT_PATH . '/assets/css/critical.css';
    if (file_exists($file)) {
        echo '<style>' . file_get_contents($file) . '</style>';
    }
}

// ─── Image Helpers ────────────────────────────────────────────────────────────

/**
 * Returns the URL to a winery image if the file exists on disk,
 * otherwise returns null so the template renders a CSS placeholder.
 */
function winery_image_url(string $slug): ?string
{
    $file = ROOT_PATH . '/assets/img/wineries/' . $slug . '.webp';
    return file_exists($file) ? ASSETS_URL . '/img/wineries/' . $slug . '.webp' : null;
}

/**
 * Returns the URL to a region image if the file exists on disk,
 * otherwise returns null.
 */
function region_image_url(string $slug): ?string
{
    $file = ROOT_PATH . '/assets/img/regions/' . $slug . '.webp';
    return file_exists($file) ? ASSETS_URL . '/img/regions/' . $slug . '.webp' : null;
}

/**
 * Renders an <img> tag or a styled CSS placeholder when no image exists.
 *
 * Usage:
 *   render_image(winery_image_url($card['slug']), $card['name'] . ' winery');
 *   render_image(winery_image_url($card['slug']), $card['name'], priority: true); // LCP image
 *
 * @param string|null $url       Image URL — null triggers the placeholder
 * @param string      $alt       Alt text for the <img>
 * @param string      $icon      Emoji displayed in the placeholder
 * @param int         $w         width attribute on <img>
 * @param int         $h         height attribute on <img>
 * @param bool        $priority  true = fetchpriority="high" + no lazy (use for LCP)
 */
function render_image(
    ?string $url,
    string  $alt,
    string  $icon     = '🍷',
    int     $w        = 800,
    int     $h        = 500,
    bool    $priority = false
): void {
    if ($url) {
        $loading = $priority ? '' : 'loading="lazy" decoding="async"';
        $fetch   = $priority ? 'fetchpriority="high"' : '';
        $altSafe = e($alt);
        echo "<img src=\"{$url}\" alt=\"{$altSafe}\" width=\"{$w}\" height=\"{$h}\" {$loading} {$fetch}>";
    } else {
        echo "<div class=\"img-placeholder\" aria-hidden=\"true\">"
           . "<span class=\"img-placeholder__icon\">{$icon}</span>"
           . "</div>";
    }
}