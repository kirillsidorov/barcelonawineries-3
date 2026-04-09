<?php require_once COMPONENTS_PATH . '/header.php'; ?>
<?= schema_region($region, $breadcrumbs) ?>

<div class="page">
  <div class="container">

    <!-- BREADCRUMBS -->
    <ol class="breadcrumbs" aria-label="Breadcrumb">
      <?php foreach ($breadcrumbs as $i => $crumb):
        $isLast = $i === array_key_last($breadcrumbs); ?>
        <li><?php if (!$isLast): ?><a href="<?= e($crumb['url']) ?>"><?= e($crumb['name']) ?></a><?php else: ?><?= e($crumb['name']) ?><?php endif; ?></li>
      <?php endforeach; ?>
    </ol>

    <!-- HERO -->
    <div class="hero" style="margin-bottom:22px;">
      <div class="hero-grid">
        <div class="hero-copy">
          <span class="eyebrow">DO Wine Region · Catalunya</span>
          <h1 style="margin-top:18px;font-size:clamp(3rem,6vw,5.2rem);max-width:10ch;"><?= e($region['name']) ?></h1>
          <?php if (!empty($region['description'])): ?>
          <p style="margin:18px 0 22px;max-width:62ch;color:var(--muted);line-height:1.82;font-size:1.05rem;"><?= e($region['description']) ?></p>
          <?php endif; ?>
          <div class="hero-pills">
            <?php if (!empty($wineries)): ?><span class="pill"><?= count($wineries) ?> wineries listed</span><?php endif; ?>
            <span class="pill">Catalonia, Spain</span>
          </div>
          <div class="hero-actions">
            <a class="btn" href="#wineries">See wineries</a>
            <a class="btn-secondary" href="#faq">Planning FAQ</a>
          </div>
          <div class="hero-stats">
            <div class="stat"><span>Region</span><strong><?= e($region['name']) ?> DO</strong></div>
            <div class="stat"><span>Wineries listed</span><strong><?= count($wineries) ?></strong></div>
            <div class="stat"><span>No-car options</span><strong><?= count(array_filter($wineries, fn($w) => $w['no_car_needed'])) ?> available</strong></div>
          </div>
        </div>
        <div class="hero-side">
          <div class="hero-image">
            <?php render_image(region_image_url($region['slug']), e($region['name']) . ' wine region', '🍇', 560, 290, true); ?>
          </div>
          <article class="hero-panel">
            <h2>At a glance</h2>
            <p><?= e(mb_strimwidth($region['meta_description'] ?? $region['description'], 0, 160, '…')) ?></p>
          </article>
        </div>
      </div>
    </div>

    <!-- MAIN LAYOUT -->
    <div class="layout">
      <div class="stack">

        <!-- QUICK FACTS -->
        <section class="card-padded">
          <div class="section-head"><div><h2>Quick facts</h2></div></div>
          <div class="grid-3">
            <div class="fact"><span>Region</span><strong><?= e($region['name']) ?> DO</strong></div>
            <div class="fact"><span>Wineries listed</span><div><?= count($wineries) ?> estates</div></div>
            <div class="fact"><span>No-car options</span><div><?= count(array_filter($wineries, fn($w) => $w['no_car_needed'])) ?> train-accessible</div></div>
            <div class="fact"><span>Organic producers</span><div><?= count(array_filter($wineries, fn($w) => $w['organic'] ?? 0)) ?> listed</div></div>
            <div class="fact"><span>Family friendly</span><div><?= count(array_filter($wineries, fn($w) => $w['kids_welcome'] ?? 0)) ?> options</div></div>
            <div class="fact"><span>With restaurant</span><div><?= count(array_filter($wineries, fn($w) => $w['has_restaurant'] ?? 0)) ?> estates</div></div>
          </div>
        </section>

        <!-- WINERIES GRID -->
        <section class="card-padded" id="wineries">
          <div class="section-head">
            <div>
              <h2>Wineries in <?= e($region['name']) ?></h2>
              <p>A mix of recognisable names, boutique producers, and clear "best for" angles.</p>
            </div>
            <a class="text-link" href="<?= SITE_URL ?>/category/no-car-needed">Filter: no car →</a>
          </div>

          <!-- Filter bar -->
          <div class="filter-bar" role="group" aria-label="Filter">
            <span class="filter-bar__label">Show:</span>
            <button class="filter-btn is-active" data-filter="all">All</button>
            <button class="filter-btn" data-filter="no_car">🚂 No car</button>
            <button class="filter-btn" data-filter="restaurant">🍽️ Restaurant</button>
            <button class="filter-btn" data-filter="organic">🌿 Organic</button>
            <button class="filter-btn" data-filter="kids">👨‍👩‍👧 Family</button>
          </div>

          <?php if (!empty($wineries)): ?>
          <div class="grid-3" id="winery-grid">
            <?php foreach ($wineries as $card): $isFirst = false; ?>
            <div class="grid-item"
                 data-no_car="<?= (int)$card['no_car_needed'] ?>"
                 data-restaurant="<?= (int)($card['has_restaurant'] ?? 0) ?>"
                 data-organic="<?= (int)($card['organic'] ?? 0) ?>"
                 data-kids="<?= (int)($card['kids_welcome'] ?? 0) ?>">
              <?php include COMPONENTS_PATH . '/winery-card.php'; ?>
            </div>
            <?php endforeach; ?>
          </div>
          <?php else: ?>
          <p style="color:var(--muted);padding:2rem 0;">No wineries listed yet. Check back soon.</p>
          <?php endif; ?>
        </section>

        <!-- HOW TO PLAN -->
        <section class="card-padded">
          <div class="section-head"><div><h2>How to plan a <?= e($region['name']) ?> day trip</h2></div></div>
          <div class="grid-2">
            <div class="fact"><span>Best for self-drive</span><div>Users who want flexibility and two or more winery stops.</div></div>
            <div class="fact"><span>Best for guided tours</span><div>Visitors who want transport, lower friction, and clearer day structure.</div></div>
            <div class="fact"><span>Typical route</span><div>Start with a known winery, then compare with a boutique stop.</div></div>
            <div class="fact"><span>Best pairing</span><div>Wine tasting + local lunch + countryside scenery.</div></div>
          </div>
        </section>

        <!-- RELATED CATEGORIES (PDF brief: "Related category links") -->
        <?php if (!empty($categories)): ?>
        <section class="card-padded">
          <div class="section-head"><div><h2>Browse <?= e($region['name']) ?> by experience</h2><p>Find wineries in this region that match your travel style.</p></div></div>
          <div class="grid-3">
            <?php foreach ($categories as $cat): ?>
            <article class="card">
              <div class="card-body">
                <h3 style="font-size:1.35rem;"><?= e($cat['label']) ?></h3>
                <a href="<?= url_category($cat['slug']) ?>">View category →</a>
              </div>
            </article>
            <?php endforeach; ?>
          </div>
        </section>
        <?php endif; ?>

        <!-- COMPARE REGIONS (PDF brief: "Compare-region block") -->
        <?php if (!empty($relatedRegions)): ?>
        <section class="card-padded">
          <div class="section-head"><div><h2>Compare with other regions</h2><p>Exploring options? See how <?= e($region['name']) ?> compares to neighbouring wine regions.</p></div></div>
          <div class="grid-2">
            <?php foreach ($relatedRegions as $rel): ?>
            <article class="card">
              <div class="card-body">
                <h3 style="font-size:1.35rem;"><?= e($rel['name']) ?></h3>
                <p><?= e(mb_strimwidth($rel['description'], 0, 120, '…')) ?></p>
                <a href="<?= url_region($rel['slug']) ?>">Explore <?= e($rel['name']) ?> →</a>
              </div>
            </article>
            <?php endforeach; ?>
          </div>
        </section>
        <?php endif; ?>

        <!-- COMMERCIAL CTA (PDF brief: "Commercial next-step block") -->
        <section class="card-padded" style="background:var(--wine);color:#fff;border-color:var(--wine-dark);">
          <div class="section-head"><div>
            <h2 style="color:#fff;">Book a <?= e($region['name']) ?> wine tour</h2>
            <p style="color:rgba(255,255,255,.78);">Skip the planning — join a guided day trip from Barcelona with transport, tastings, and local lunch included.</p>
          </div></div>
          <div class="grid-2">
            <div class="fact" style="background:rgba(255,255,255,.08);border-color:rgba(255,255,255,.1);">
              <span style="color:rgba(255,255,255,.6);">Guided day trips</span>
              <div style="color:#fff;">Full-day tours from Barcelona with hotel pickup, winery visits, and tastings.</div>
            </div>
            <div class="fact" style="background:rgba(255,255,255,.08);border-color:rgba(255,255,255,.1);">
              <span style="color:rgba(255,255,255,.6);">Self-guided options</span>
              <div style="color:#fff;">Book individual tastings and plan your own route through <?= e($region['name']) ?>.</div>
            </div>
          </div>
        </section>

        <!-- FAQ -->
        <section class="card-padded" id="faq">
          <div class="section-head"><div><h2>Questions about <?= e($region['name']) ?></h2></div></div>
          <div class="faq">
            <article class="faq-item">
              <h3>Is <?= e($region['name']) ?> a good region for first-time visitors?</h3>
              <p>It depends on your travel style — see the "At a glance" sidebar for the best audience fit for this region.</p>
            </article>
            <article class="faq-item">
              <h3>Can you visit <?= e($region['name']) ?> without a car?</h3>
              <p>Some wineries are easier than others. Check our <a class="text-link" href="<?= SITE_URL ?>/category/no-car-needed">no-car category</a> for the best train-accessible options.</p>
            </article>
          </div>
        </section>

      </div>

      <!-- SIDEBAR -->
      <aside class="aside">
        <section class="aside-card">
          <h3>At a glance</h3>
          <p><?= e(mb_strimwidth($region['description'], 0, 140, '…')) ?></p>
          <div class="aside-list">
            <div class="aside-row"><span>Region</span><strong><?= e($region['name']) ?></strong></div>
            <div class="aside-row"><span>Wineries listed</span><strong><?= count($wineries) ?></strong></div>
            <div class="aside-row"><span>Train-accessible</span><strong><?= count(array_filter($wineries, fn($w) => $w['no_car_needed'])) ?> options</strong></div>
          </div>
        </section>
        <section class="aside-card primary">
          <h3>Best next clicks</h3>
          <div class="aside-list">
            <?php if (!empty($categories)): ?>
              <?php foreach ($categories as $cat): ?>
              <div class="aside-row"><span>Category</span><strong><a href="<?= url_category($cat['slug']) ?>" style="color:#fff;"><?= e($cat['label']) ?></a></strong></div>
              <?php endforeach; ?>
            <?php else: ?>
              <div class="aside-row"><span>Category</span><strong><a href="<?= SITE_URL ?>/category/no-car-needed" style="color:#fff;">No-car wineries</a></strong></div>
              <div class="aside-row"><span>Category</span><strong><a href="<?= SITE_URL ?>/category/organic-wines" style="color:#fff;">Organic picks</a></strong></div>
            <?php endif; ?>
          </div>
        </section>
      </aside>
    </div>

  </div>
</div>

<?php require_once COMPONENTS_PATH . '/footer.php'; ?>
