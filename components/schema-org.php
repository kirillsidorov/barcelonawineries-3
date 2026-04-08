<?php
/**
 * Component: schema-org.php
 *
 * A dispatcher that outputs the correct JSON-LD block depending on page type.
 * Include this in any template that doesn't call schema_winery() or schema_region() directly.
 *
 * Usage in a template:
 *   $schemaType = 'winery'; // or 'region', 'category', 'home'
 *   include COMPONENTS_PATH . '/schema-org.php';
 *
 * For winery and region pages the dedicated functions in functions.php are
 * preferred (they are called inline in the templates for clarity). This
 * component is useful for future page types added without modifying templates.
 *
 * Variables expected depending on $schemaType:
 *   winery   → $winery (array), $breadcrumbs (array)
 *   region   → $region (array), $breadcrumbs (array)
 *   category → $category (array), $slug (string), $wineries (array), $breadcrumbs (array)
 */

switch ($schemaType ?? 'none') {

    case 'winery':
        if (!empty($winery) && !empty($breadcrumbs)) {
            echo schema_winery($winery, $breadcrumbs);
        }
        break;

    case 'region':
        if (!empty($region) && !empty($breadcrumbs)) {
            echo schema_region($region, $breadcrumbs);
        }
        break;

    case 'category':
        // Category schema is inline in category.php — nothing to do here.
        break;

    case 'none':
    default:
        // No schema output for unknown types.
        break;
}
