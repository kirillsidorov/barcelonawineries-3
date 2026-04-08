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
            <span class="pill">Near Barcelona</span>
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
            <span style="display:block;margin-bottom:10px;font-size:.76rem;letter-spacing:.1em;text-transform:uppercase;font-weight:800;opacity:.82;">Why this category</span>
            <h2 style="font-size:1.85rem;margin-bottom:12px;">Built around real traveller constraints.</h2>
            <p><?= e($category['desc']) ?></p>
          </article>
          <article class="hero-panel">
            <span style="display:block;margin-bottom:10px;font-size:.76rem;letter-spacing:.1em;text-transform:uppercase;font-weight:800;color:var(--muted);">More categories</span>
            <div class="quick-grid">
              <a class="quick-link" href="<?= SITE_URL ?>/category/no-car-needed"><span>No car</span><span>→</span></a>
              <a class="quick-link" href="<?= SITE_URL ?>/category/organic-wines"><span>Organic</span><span>→</span></a>
              <a class="quick-link" href="<?= SITE_URL ?>/category/family-friendly"><span>Family</span><span>→</span></a>
              <a class="quick-link" href="<?= SITE_URL ?>/category/with-accommodation"><span>Stay over</span><span>→</span></a>
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

    <!-- CROSS-LINKS -->
    <section class="section">
      <div class="section-card">
        <div class="section-head"><div><h2>More experiences</h2></div></div>
        <div class="grid-4">
          <?php
          $all = ['no-car-needed'=>'🚂 No car needed','family-friendly'=>'👨‍👩‍👧 Family friendly','organic-wines'=>'🌿 Organic wines','restaurant-onsite'=>'🍽️ With restaurant','with-accommodation'=>'🛏️ Stay overnight','pet-friendly'=>'🐕 Pet friendly'];
          foreach ($all as $s => $l):
            if ($s === $slug) continue;
          ?>
          <article class="card">
            <div class="card-body">
              <h3 style="font-size:1.4rem;"><?= e($l) ?></h3>
              <a href="<?= url_category($s) ?>">View category</a>
            </div>
          </article>
          <?php endforeach; ?>
        </div>
      </div>
    </section>

  </div>
</div>

<?php require_once COMPONENTS_PATH . '/footer.php'; ?>
