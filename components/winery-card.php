<?php
/**
 * Winery Card — matches test_region_page.html / test_category_hub.html design
 * Expects: $card array, optional $isFirst bool
 */
$isFirst = $isFirst ?? false;
?>
<article class="winery-card" itemscope itemtype="https://schema.org/LocalBusiness">
    <a href="<?= url_winery($card['slug']) ?>" class="winery-art" tabindex="-1" aria-hidden="true">
        <?php render_image(
            winery_image_url($card['slug']),
            e($card['name']) . ' winery',
            '🍷', 560, 420
        ); ?>
    </a>
    <div class="winery-body">
        <div class="chip-row">
            <?php if (!empty($card['region_name'])): ?>
                <span class="chip"><a href="<?= url_region($card['region_slug'] ?? '') ?>" style="text-decoration:none;color:inherit;"><?= e($card['region_name']) ?></a></span>
            <?php endif; ?>
            <?php if ($card['no_car_needed'] ?? false): ?><span class="chip">No car</span><?php endif; ?>
            <?php if ($card['organic'] ?? false): ?><span class="chip">Organic</span><?php endif; ?>
            <?php if ($card['has_restaurant'] ?? false): ?><span class="chip">Restaurant</span><?php endif; ?>
            <?php if ($card['accommodation'] ?? false): ?><span class="chip">Stay</span><?php endif; ?>
        </div>
        <h3 itemprop="name"><?= e($card['name']) ?></h3>
        <?php if (!empty($card['intro'])): ?>
        <p itemprop="description"><?= e(mb_strimwidth($card['intro'], 0, 115, '…')) ?></p>
        <?php else: ?>
        <p><?= !empty($card['city']) ? e($card['city']) : e($card['region_name'] ?? '') ?> winery<?= !empty($card['distance_km']) ? ' · ' . e($card['distance_km']) . ' km from Barcelona' : '' ?></p>
        <?php endif; ?>
        <div class="winery-meta-row">
            <?php if (!empty($card['distance_km'])): ?>
            <span class="winery-distance">~<?= e($card['distance_km']) ?> km</span>
            <?php endif; ?>
            <?php if (!empty($card['rating'])): ?>
            <span class="winery-rating">
                <span class="stars">★</span>
                <span class="rating-val"><?= e($card['rating']) ?></span>
                <?php if (!empty($card['review_count'])): ?><span style="color:var(--muted);font-size:.78rem;">· <?= number_format((int)$card['review_count']) ?></span><?php endif; ?>
            </span>
            <?php endif; ?>
        </div>
        <a class="link" href="<?= url_winery($card['slug']) ?>" style="margin-top:14px;">Open winery page</a>
    </div>
</article>
