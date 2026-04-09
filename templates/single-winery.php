<?php
$extraCss = 'single-winery.css';
require_once COMPONENTS_PATH . '/header.php';
?>
<?= schema_winery($winery, $breadcrumbs) ?>

<div class="page">
  <div class="container">

    <!-- BREADCRUMBS -->
    <ol class="breadcrumbs" aria-label="Breadcrumb">
      <?php foreach ($breadcrumbs as $i => $crumb): $isLast = $i === array_key_last($breadcrumbs); ?>
        <li><?php if (!$isLast): ?><a href="<?= e($crumb['url']) ?>"><?= e($crumb['name']) ?></a><?php else: ?><?= e($crumb['name']) ?><?php endif; ?></li>
      <?php endforeach; ?>
    </ol>

    <!-- HERO -->
    <div class="hero" style="margin-bottom:22px;">
      <div class="hero-grid">
        <div class="hero-copy">
          <span class="eyebrow"><a href="<?= url_region($winery['region_slug']) ?>" style="text-decoration:none;color:inherit;"><?= e($winery['region_name']) ?></a> · <?= !empty($winery['city']) ? e($winery['city']) : 'Catalunya' ?></span>
          <h1 style="margin-top:18px;font-size:clamp(3rem,6vw,5.2rem);max-width:10ch;"><?= e($winery['name']) ?></h1>
          <div class="hero-pills">
            <?php if (!empty($winery['distance_km'])): ?><span class="pill"><?= e($winery['distance_km']) ?> km from Barcelona</span><?php endif; ?>
            <?php if ($winery['organic']): ?><span class="pill">Organic</span><?php endif; ?>
            <?php if ($winery['no_car_needed']): ?><span class="pill">No car needed</span><?php endif; ?>
            <?php if ($winery['has_restaurant']): ?><span class="pill">Restaurant</span><?php endif; ?>
            <?php if ($winery['kids_welcome']): ?><span class="pill">Family friendly</span><?php endif; ?>
            <?php if ($winery['accommodation']): ?><span class="pill">Stay overnight</span><?php endif; ?>
          </div>
          <?php if (!empty($winery['intro'])): ?>
          <p class="lead" style="margin:0 0 22px;max-width:60ch;color:var(--muted);line-height:1.8;font-size:1.05rem;"><?= e($winery['intro']) ?></p>
          <?php endif; ?>
          <div class="hero-actions">
            <?php if (!empty($winery['gyg_url'])): ?>
            <a class="btn" href="<?= gyg_url($winery['gyg_url'], $winery['slug']) ?>" target="_blank" rel="noopener sponsored">See tour options</a>
            <?php endif; ?>
            <a class="btn-secondary" href="#quick-facts">Quick facts</a>
          </div>
          <div class="hero-stats">
            <div class="stat"><span>Best for</span><strong><?= !empty($winery['benefit_1']) ? e(mb_strimwidth($winery['benefit_1'], 0, 50, '…')) : 'Wine tasting & cellar tours' ?></strong></div>
            <div class="stat"><span>Distance</span><strong><?= !empty($winery['distance_km']) ? e($winery['distance_km']) . ' km from Barcelona' : 'Near Barcelona' ?></strong></div>
            <div class="stat"><span>Visit style</span><strong><?= $winery['wine_tasting'] ? 'Tasting' : '' ?><?= $winery['cellar_tours'] ? ' · Cellar tour' : '' ?><?= $winery['accommodation'] ? ' · Stay' : '' ?></strong></div>
          </div>
        </div>
        <div class="hero-side">
          <div class="hero-image">
            <?php render_image(
              winery_image_url($winery['slug']),
              e($winery['name']) . ' winery',
              '🍷', 560, 290, true
            ); ?>
          </div>
          <article class="hero-panel">
            <h2><?= !empty($winery['rating']) ? '★ ' . e($winery['rating']) . ' rating' : 'Why visit' ?></h2>
            <p><?= !empty($winery['meta_description']) ? e($winery['meta_description']) : (empty($winery['intro']) ? 'An exceptional winery experience near Barcelona.' : e(mb_strimwidth($winery['intro'], 0, 160, '…'))) ?></p>
          </article>
        </div>
      </div>
    </div>

    <!-- LAYOUT -->
    <div class="layout">
      <div class="stack">

        <!-- QUICK FACTS -->
        <section class="card-padded" id="quick-facts">
          <div class="section-head"><div><h2>Quick facts</h2><p>Practical info before you plan your visit.</p></div></div>
          <div class="grid-3">
            <div class="fact"><span>Region</span><strong><a href="<?= url_region($winery['region_slug']) ?>" style="color:var(--wine);text-decoration:none;"><?= e($winery['region_name']) ?></a></strong></div>
            <?php if (!empty($winery['city'])): ?><div class="fact"><span>Town</span><div><?= e($winery['city']) ?><?= !empty($winery['postcode']) ? ', ' . e($winery['postcode']) : '' ?></div></div><?php endif; ?>
            <?php if (!empty($winery['distance_km'])): ?><div class="fact"><span>Distance from Barcelona</span><div><?= e($winery['distance_km']) ?> km<?= !empty($winery['drive_time_min']) ? ' · ~' . e($winery['drive_time_min']) . ' min drive' : '' ?></div></div><?php endif; ?>
            <?php if (!empty($winery['nearest_station'])): ?><div class="fact"><span>Nearest train station</span><div><?= e($winery['nearest_station']) ?></div></div><?php endif; ?>
            <?php if (!empty($winery['languages'])): ?><div class="fact"><span>Languages</span><div><?= e($winery['languages']) ?></div></div><?php endif; ?>
            <?php if (!empty($winery['price_range'])): ?><div class="fact"><span>Price range</span><div><?= e($winery['price_range']) ?> / person</div></div><?php endif; ?>
            <?php if (!empty($winery['opening_hours'])): ?><div class="fact"><span>Opening hours</span><div><?= e($winery['opening_hours']) ?></div></div><?php endif; ?>
            <?php if (!empty($winery['address'])): ?><div class="fact"><span>Address</span><div><?= e($winery['address']) ?></div></div><?php endif; ?>
            <div class="fact"><span>Wheelchair</span><div><?= $winery['wheelchair_accessible'] ? '✓ Accessible' : 'Not confirmed' ?></div></div>
          </div>
        </section>

        <!-- WHY VISIT (benefits) -->
        <?php if (!empty($winery['benefit_1']) || !empty($winery['benefit_2']) || !empty($winery['benefit_3'])): ?>
        <section class="card-padded">
          <div class="section-head"><div><h2>Why visit <?= e($winery['name']) ?></h2><p>The editorial case for adding this winery to your trip.</p></div></div>
          <div class="bullet-list">
            <?php foreach (['benefit_1','benefit_2','benefit_3'] as $b): ?>
              <?php if (!empty($winery[$b])): ?><div class="bullet-item"><strong><?= e($winery[$b]) ?></strong></div><?php endif; ?>
            <?php endforeach; ?>
          </div>
        </section>
        <?php endif; ?>

        <!-- BODY CONTENT -->
        <?php if (!empty($winery['body_content'])): ?>
        <section class="card-padded">
          <div class="prose"><?= $winery['body_content'] ?></div>
        </section>
        <?php endif; ?>

        <!-- HOW TO GET THERE -->
        <section class="card-padded">
          <div class="section-head"><div><h2>How to get there</h2><p>Travel options from Barcelona.</p></div></div>
          <div class="grid-2">
            <div class="fact"><span>By car</span><div><?= !empty($winery['distance_km']) ? 'About ' . e($winery['distance_km']) . ' km' . (!empty($winery['drive_time_min']) ? ', ~' . e($winery['drive_time_min']) . ' min' : '') . ' from Barcelona centre.' : 'Best option for flexibility.' ?></div></div>
            <div class="fact"><span>Without a car</span><div><?= $winery['no_car_needed'] ? '✓ Train-accessible from Barcelona.' . (!empty($winery['nearest_station']) ? ' Nearest station: ' . e($winery['nearest_station']) : '') : 'Car or guided tour recommended for this winery.' ?></div></div>
            <?php if (!empty($winery['google_maps_url'])): ?>
            <div class="fact"><span>Directions</span><div><a href="<?= e($winery['google_maps_url']) ?>" target="_blank" rel="noopener noreferrer" style="color:var(--wine);font-weight:700;">Open in Google Maps →</a></div></div>
            <?php endif; ?>
            <?php if (!empty($winery['website_url'])): ?>
            <div class="fact"><span>Official website</span><div><a href="<?= e($winery['website_url']) ?>" target="_blank" rel="noopener noreferrer" style="color:var(--wine);font-weight:700;">Visit website ↗</a></div></div>
            <?php endif; ?>
          </div>
        </section>

        <!-- BEST FOR CATEGORIES (PDF brief: "Links to 2–3 relevant categories") -->
        <?php if (!empty($wineryCategories)): ?>
        <section class="card-padded">
          <div class="section-head"><div><h2>Best for</h2><p><?= e($winery['name']) ?> fits these travel styles.</p></div></div>
          <div class="grid-<?= min(count($wineryCategories), 3) ?>">
            <?php foreach ($wineryCategories as $cat): ?>
            <article class="card">
              <div class="card-body">
                <h3 style="font-size:1.2rem;"><?= e($cat['label']) ?></h3>
                <a href="<?= url_category($cat['slug']) ?>">Browse all →</a>
              </div>
            </article>
            <?php endforeach; ?>
          </div>
        </section>
        <?php endif; ?>

        <!-- FAQ -->
        <section class="card-padded">
          <div class="section-head"><div><h2>FAQ</h2><p>Common questions about visiting <?= e($winery['name']) ?>.</p></div></div>
          <div class="faq">
            <article class="faq-item">
              <h3>Is <?= e($winery['name']) ?> good to visit from Barcelona without a car?</h3>
              <p><?= $winery['no_car_needed'] ? 'Yes — ' . e($winery['name']) . ' is train-accessible from Barcelona.' . (!empty($winery['nearest_station']) ? ' The nearest station is ' . e($winery['nearest_station']) . '.' : '') : 'A car or guided tour is recommended for visiting ' . e($winery['name']) . '.' ?></p>
            </article>
            <article class="faq-item">
              <h3>Do you need to book in advance?</h3>
              <p>Most winery visits require advance booking, especially for cellar tours and tastings during peak season (June–October).</p>
            </article>
            <?php if ($winery['kids_welcome']): ?>
            <article class="faq-item">
              <h3>Is <?= e($winery['name']) ?> suitable for families with children?</h3>
              <p>Yes — <?= e($winery['name']) ?> welcomes families with children.</p>
            </article>
            <?php endif; ?>
          </div>
        </section>

        <!-- RELATED WINERIES (PDF brief: "Similar wineries block with 3–4 internal links") -->
        <?php if (!empty($related)): ?>
        <section class="card-padded" id="related">
          <div class="section-head"><div><h2>Similar wineries</h2><p>Other estates in <a class="text-link" href="<?= url_region($winery['region_slug']) ?>"><?= e($winery['region_name']) ?></a> worth comparing.</p></div></div>
          <div class="grid-<?= min(count($related), 3) ?>">
            <?php foreach ($related as $card): $isFirst = false; ?>
              <?php include COMPONENTS_PATH . '/winery-card.php'; ?>
            <?php endforeach; ?>
          </div>
        </section>
        <?php endif; ?>

        <!-- COMMERCIAL CTA (PDF brief: "Commercial next-step block") -->
        <section class="card-padded" style="background:var(--wine);color:#fff;border-color:var(--wine-dark);">
          <h2 style="color:#fff;font-size:1.6rem;margin-bottom:8px;">Ready to visit <?= e($winery['name']) ?>?</h2>
          <p style="color:rgba(255,255,255,.78);margin:0 0 16px;line-height:1.65;">Compare guided tours and direct booking options for <?= e($winery['name']) ?> and other wineries in <a href="<?= url_region($winery['region_slug']) ?>" style="color:#fff;text-decoration:underline;"><?= e($winery['region_name']) ?></a>.</p>
          <?php if (!empty($winery['gyg_url'])): ?>
          <a class="btn" href="<?= gyg_url($winery['gyg_url'], $winery['slug']) ?>" target="_blank" rel="noopener sponsored" style="background:#fff;color:var(--wine);box-shadow:none;">See available tours</a>
          <?php elseif (!empty($winery['website_url'])): ?>
          <a class="btn" href="<?= e($winery['website_url']) ?>" target="_blank" rel="noopener noreferrer" style="background:#fff;color:var(--wine);box-shadow:none;">Visit official website</a>
          <?php endif; ?>
        </section>

      </div>

      <!-- SIDEBAR -->
      <aside class="aside">
        <section class="aside-card">
          <h3>At a glance</h3>
          <div class="aside-list">
            <?php if (!empty($winery['city'])): ?>
            <div class="aside-row"><span>Town</span><strong><?= e($winery['city']) ?></strong></div>
            <?php endif; ?>
            <?php if (!empty($winery['distance_km'])): ?>
            <div class="aside-row"><span>Distance from Barcelona</span><strong><?= e($winery['distance_km']) ?> km</strong></div>
            <?php endif; ?>
            <div class="aside-row"><span>Experience</span><strong><?= $winery['wine_tasting'] ? 'Tasting' : '' ?><?= $winery['cellar_tours'] ? ', cellar tour' : '' ?><?= $winery['has_restaurant'] ? ', restaurant' : '' ?></strong></div>
            <div class="aside-row"><span>No car needed</span><strong><?= $winery['no_car_needed'] ? '✓ Yes' : '✗ Car recommended' ?></strong></div>
            <?php if (!empty($winery['price_range'])): ?>
            <div class="aside-row"><span>Price range</span><strong><?= e($winery['price_range']) ?></strong></div>
            <?php endif; ?>
          </div>
        </section>

        <!-- TOUR / BOOKING BOX -->
        <section class="aside-card tour-box" id="book">
          <h3>Book a tour</h3>
          <?php if (!empty($winery['rating'])): ?>
          <p style="margin-bottom:12px;">★ <?= e($winery['rating']) ?><?= !empty($winery['review_count']) ? ' · ' . number_format((int)$winery['review_count']) . ' reviews' : '' ?></p>
          <?php endif; ?>
          <p>Compare available tours and cellar experiences for <?= e($winery['name']) ?>.</p>
          <div class="tour-list">
            <?php if (!empty($winery['gyg_url'])): ?>
            <div class="tour-item">
              <strong>GetYourGuide tours</strong>
              <span>Cellar tours, tastings, and guided experiences.</span>
            </div>
            <?php endif; ?>
            <?php if (!empty($winery['viator_url'])): ?>
            <div class="tour-item">
              <strong>Viator experiences</strong>
              <span>Compare prices and availability via Viator.</span>
            </div>
            <?php endif; ?>
            <?php if (empty($winery['gyg_url']) && empty($winery['viator_url'])): ?>
            <div class="tour-item">
              <strong>Winery visits</strong>
              <span>Book directly with the winery or via a Barcelona day-trip operator.</span>
            </div>
            <?php endif; ?>
          </div>
          <?php if (!empty($winery['gyg_url'])): ?>
          <a class="btn" href="<?= gyg_url($winery['gyg_url'], $winery['slug']) ?>" target="_blank" rel="noopener sponsored">See available tours</a>
          <?php endif; ?>
          <?php if (!empty($winery['viator_url'])): ?>
          <a class="btn-secondary" href="<?= e($winery['viator_url']) ?>" target="_blank" rel="noopener sponsored">Compare on Viator</a>
          <?php endif; ?>
          <?php if (empty($winery['gyg_url']) && empty($winery['viator_url']) && !empty($winery['website_url'])): ?>
          <a class="btn" href="<?= e($winery['website_url']) ?>" target="_blank" rel="noopener noreferrer">Visit official website</a>
          <?php endif; ?>
        </section>

        <!-- CATEGORY LINKS IN SIDEBAR -->
        <?php if (!empty($wineryCategories)): ?>
        <section class="aside-card">
          <h3>Also in</h3>
          <div class="aside-list">
            <?php foreach ($wineryCategories as $cat): ?>
            <div class="aside-row"><span>Category</span><strong><a href="<?= url_category($cat['slug']) ?>" style="color:var(--wine);text-decoration:none;"><?= e($cat['label']) ?></a></strong></div>
            <?php endforeach; ?>
          </div>
        </section>
        <?php endif; ?>
      </aside>
    </div>

  </div>
</div>

<?php require_once COMPONENTS_PATH . '/footer.php'; ?>
