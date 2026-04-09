<?php require_once COMPONENTS_PATH . '/header.php'; ?>

<div class="page">
  <div class="container">

    <ol class="breadcrumbs" aria-label="Breadcrumb">
      <?php foreach ($breadcrumbs as $i => $crumb): $isLast = $i === array_key_last($breadcrumbs); ?>
        <li><?php if (!$isLast): ?><a href="<?= e($crumb['url']) ?>"><?= e($crumb['name']) ?></a><?php else: ?><?= e($crumb['name']) ?><?php endif; ?></li>
      <?php endforeach; ?>
    </ol>

    <!-- HERO -->
    <div class="hero" style="margin-bottom:22px;">
      <div class="hero-grid">
        <div class="hero-copy">
          <span class="eyebrow">Wine Experiences · Catalunya</span>
          <h1 style="margin-top:18px;font-size:clamp(3rem,6vw,5.3rem);max-width:11ch;"><?= e($category['label']) ?></h1>
          <p style="margin:18px 0 22px;max-width:62ch;color:var(--muted);line-height:1.82;font-size:1.05rem;"><?= e($category['desc']) ?></p>
          <div class="hero-pills">
            <span class="pill"><?= count($wineries) ?> wineries</span>
            <span class="pill"><?= count(array_unique(array_column($wineries, 'region_name'))) ?> regions</span>
          </div>
          <div class="hero-actions">
            <a class="btn" href="#wineries">See wineries</a>
            <a class="btn-secondary" href="<?= SITE_URL ?>/">Back to home</a>
          </div>
          <div class="hero-stats">
            <div class="stat"><span>Wineries found</span><strong><?= count($wineries) ?></strong></div>
            <div class="stat"><span>Regions covered</span><strong><?= count(array_unique(array_column($wineries, 'region_name'))) ?></strong></div>
            <div class="stat"><span>Category</span><strong><?= e($category['label']) ?></strong></div>
          </div>
        </div>
        <div class="hero-side">
          <article class="hero-panel primary">
            <span style="display:block;margin-bottom:10px;font-size:.7rem;letter-spacing:.1em;text-transform:uppercase;font-weight:800;opacity:.7;">Why this category</span>
            <h2 style="font-size:1.4rem;margin-bottom:10px;">Built around real traveller constraints.</h2>
            <p><?= e($category['desc']) ?></p>
          </article>
          <article class="hero-panel">
            <span style="display:block;margin-bottom:10px;font-size:.7rem;letter-spacing:.1em;text-transform:uppercase;font-weight:800;color:var(--muted);">Quick links</span>
            <div class="quick-grid">
              <a class="quick-link" href="<?= SITE_URL ?>/category/no-car-needed"><span>No car</span><span>→</span></a>
              <a class="quick-link" href="<?= SITE_URL ?>/category/organic-wines"><span>Organic</span><span>→</span></a>
              <a class="quick-link" href="<?= SITE_URL ?>/category/family-friendly"><span>Family</span><span>→</span></a>
              <a class="quick-link" href="<?= SITE_URL ?>/category/restaurant-onsite"><span>Restaurant</span><span>→</span></a>
            </div>
          </article>
        </div>
      </div>
    </div>

    <!-- WINERY GRID -->
    <section class="section" id="wineries">
      <div class="section-card">
        <div class="section-head">
          <div>
            <h2><?= e($category['label']) ?></h2>
            <p><?= count($wineries) ?> winer<?= count($wineries) === 1 ? 'y' : 'ies' ?> in this category across Catalonia.</p>
          </div>
        </div>
        <?php if (!empty($wineries)): ?>
        <div class="grid-3">
          <?php foreach ($wineries as $card): $isFirst = false; ?>
            <?php include COMPONENTS_PATH . '/winery-card.php'; ?>
          <?php endforeach; ?>
        </div>
        <?php else: ?>
        <p style="color:var(--muted);padding:2rem 0;text-align:center;">We're still building this list — check back soon.</p>
        <?php endif; ?>
      </div>
    </section>

    <!-- BEST REGIONS FOR THIS CATEGORY (PDF brief: "Best regions for this category" block) -->
    <?php if (!empty($bestRegions)): ?>
    <section class="section">
      <div class="section-card">
        <div class="section-head"><div><h2>Best regions for <?= strtolower(e($category['label'])) ?></h2><p>These wine regions have the most options for this experience type.</p></div></div>
        <div class="grid-<?= count($bestRegions) <= 2 ? '2' : '3' ?>">
          <?php foreach ($bestRegions as $reg): ?>
          <article class="card">
            <div class="art">
              <?php render_image(region_image_url($reg['slug']), e($reg['name']), '🍇', 560, 190); ?>
            </div>
            <div class="card-body">
              <h3 style="font-size:1.35rem;"><?= e($reg['name']) ?></h3>
              <p><?= e(mb_strimwidth($reg['description'], 0, 120, '…')) ?></p>
              <a href="<?= url_region($reg['slug']) ?>">Explore <?= e($reg['name']) ?> →</a>
            </div>
          </article>
          <?php endforeach; ?>
        </div>
      </div>
    </section>
    <?php endif; ?>

    <!-- COMMERCIAL CTA (PDF brief: "Commercial CTA block") -->
    <section class="section">
      <div class="section-card" style="background:var(--wine);color:#fff;border-color:var(--wine-dark);">
        <div class="section-head"><div>
          <h2 style="color:#fff;">Book a wine tour from Barcelona</h2>
          <p style="color:rgba(255,255,255,.78);">Skip the planning — compare guided day trips with transport, tastings, and local lunch included.</p>
        </div></div>
        <div class="grid-2">
          <div class="fact" style="background:rgba(255,255,255,.08);border-color:rgba(255,255,255,.1);">
            <span style="color:rgba(255,255,255,.6);">Guided tours</span>
            <div style="color:#fff;">Full-day tours from Barcelona with hotel pickup and multiple winery visits.</div>
          </div>
          <div class="fact" style="background:rgba(255,255,255,.08);border-color:rgba(255,255,255,.1);">
            <span style="color:rgba(255,255,255,.6);">Self-guided visits</span>
            <div style="color:#fff;">Book individual tastings at wineries and plan your own route.</div>
          </div>
        </div>
      </div>
    </section>

    <!-- RELATED CATEGORIES (PDF brief: cross-links) -->
    <section class="section">
      <div class="section-card">
        <div class="section-head"><div><h2>More experiences</h2><p>Explore other ways to discover wineries near Barcelona.</p></div></div>
        <div class="grid-3">
          <?php if (!empty($relatedCategories)): ?>
            <?php foreach ($relatedCategories as $rel): ?>
            <article class="card">
              <div class="card-body">
                <h3 style="font-size:1.35rem;"><?= e($rel['label']) ?></h3>
                <p><?= e(mb_strimwidth($rel['desc'], 0, 100, '…')) ?></p>
                <a href="<?= url_category($rel['slug']) ?>">View category →</a>
              </div>
            </article>
            <?php endforeach; ?>
          <?php else: ?>
            <?php
            $all = ['no-car-needed'=>'🚂 No car needed','family-friendly'=>'👨‍👩‍👧 Family friendly','organic-wines'=>'🌿 Organic wines','restaurant-onsite'=>'🍽️ With restaurant','with-accommodation'=>'🛏️ Stay overnight','pet-friendly'=>'🐕 Pet friendly'];
            foreach ($all as $s => $l):
              if ($s === $slug) continue;
            ?>
            <article class="card">
              <div class="card-body">
                <h3 style="font-size:1.35rem;"><?= e($l) ?></h3>
                <a href="<?= url_category($s) ?>">View category →</a>
              </div>
            </article>
            <?php endforeach; ?>
          <?php endif; ?>
        </div>
      </div>
    </section>

  </div>
</div>

<?php require_once COMPONENTS_PATH . '/footer.php'; ?>
