<?php require_once COMPONENTS_PATH . '/header.php'; ?>

<div class="page">
  <div class="container">

    <!-- HERO -->
    <section style="margin-bottom:22px;">
      <div class="hero">
        <div class="hero-grid">
          <div class="hero-copy">
            <span class="eyebrow">Barcelona day trips · Cava · Scenic vineyards</span>
            <h1 style="margin-top:18px;font-size:clamp(3.6rem,7vw,6.6rem);max-width:10.6ch;">
              Find the right winery near Barcelona.
            </h1>
            <p style="max-width:60ch;margin:20px 0 24px;color:var(--muted);font-size:1.06rem;line-height:1.8;">
              From the Cava houses of Penedès to the steep terraces of Priorat — <?= count($wineries ?? []) ?>+ wineries across <?= count($regions ?? []) ?> Catalan wine regions, with routes by train, car, or guided tour.
            </p>
            <div class="hero-actions">
              <a class="btn" href="<?= SITE_URL ?>/region/penedes">Browse featured wineries</a>
              <a class="btn-secondary" href="#regions">Open wine regions</a>
            </div>
            <div class="hero-metrics">
              <div class="metric"><span>Closest escapes</span><strong>15–90 min from Barcelona</strong></div>
              <div class="metric"><span>No-car options</span><strong>Train-friendly wineries listed</strong></div>
              <div class="metric"><span>Content model</span><strong>Regions, wineries, category hubs</strong></div>
            </div>
          </div>
          <div class="hero-side">
            <article class="hero-panel primary">
              <span class="kicker" style="display:block;margin-bottom:10px;font-size:.76rem;letter-spacing:.1em;text-transform:uppercase;font-weight:800;opacity:.82;">Plan by travel style</span>
              <h2 style="font-size:2rem;margin-bottom:12px;">Not just by brand name.</h2>
              <p>Region pages for discovery. Category hubs for constraints. Winery pages for decisions.</p>
            </article>
            <article class="hero-panel">
              <span style="display:block;margin-bottom:10px;font-size:.76rem;letter-spacing:.1em;text-transform:uppercase;font-weight:800;color:var(--muted);">Quick routes</span>
              <div class="quick-grid">
                <a class="quick-link" href="<?= SITE_URL ?>/category/no-car-needed"><span>No car needed</span><span>→</span></a>
                <a class="quick-link" href="<?= SITE_URL ?>/region/penedes"><span>Best Cava tours</span><span>→</span></a>
                <a class="quick-link" href="<?= SITE_URL ?>/category/organic-wines"><span>Organic picks</span><span>→</span></a>
                <a class="quick-link" href="<?= SITE_URL ?>/category/with-accommodation"><span>Stay overnight</span><span>→</span></a>
              </div>
            </article>
          </div>
        </div>
      </div>
    </section>

    <!-- REGIONS -->
    <section class="section" id="regions">
      <div class="section-card">
        <div class="section-head">
          <div>
            <h2>Browse by region</h2>
            <p>Start here if you're still exploring. Each region has its own terroir, grape varieties, and visitor experience.</p>
          </div>
          <a class="text-link" href="#featured">Jump to featured wineries</a>
        </div>
        <div class="grid-3">
          <?php foreach (array_slice($regions ?? [], 0, 6) as $region): ?>
          <article class="card">
            <div class="art">
              <?php render_image(region_image_url($region['slug']), e($region['name']), '🍇', 560, 190); ?>
            </div>
            <div class="card-body">
              <div class="pills"><span class="pill">DO Region</span></div>
              <h3><?= e($region['name']) ?></h3>
              <p><?= e(mb_strimwidth($region['description'], 0, 120, '…')) ?></p>
              <a href="<?= url_region($region['slug']) ?>">Open region guide</a>
            </div>
          </article>
          <?php endforeach; ?>
        </div>
      </div>
    </section>

    <!-- CATEGORIES -->
    <section class="section" id="categories">
      <div class="section-card">
        <div class="section-head">
          <div>
            <h2>Category paths that work</h2>
            <p>These entry points match real traveller constraints: transport, trip style, wine type, and planning friction.</p>
          </div>
        </div>
        <div class="grid-4">
          <article class="card"><div class="card-body"><h3>No-car wineries</h3><p>Train-friendly, taxi-friendly, or tour-based winery visits from Barcelona.</p><a href="<?= SITE_URL ?>/category/no-car-needed">View category</a></div></article>
          <article class="card"><div class="card-body"><h3>Best Cava tours</h3><p>Sparkling wine, cellar tours, and easy day-trip planning in Penedès.</p><a href="<?= SITE_URL ?>/region/penedes">View Penedès</a></div></article>
          <article class="card"><div class="card-body"><h3>Family friendly</h3><p>Welcoming wineries with space for kids and relaxed visit formats.</p><a href="<?= SITE_URL ?>/category/family-friendly">View category</a></div></article>
          <article class="card"><div class="card-body"><h3>Organic picks</h3><p>Boutique, biodynamic, or quality-first wineries for the conscious traveller.</p><a href="<?= SITE_URL ?>/category/organic-wines">View category</a></div></article>
        </div>
      </div>
    </section>

    <!-- FEATURED WINERIES -->
    <?php if (!empty($featuredWineries)): ?>
    <section class="section" id="featured">
      <div class="section-card">
        <div class="section-head">
          <div>
            <h2>Featured wineries</h2>
            <p>Hand-picked estates that work well for first-time visitors, strong day-trip formats, or clear editorial angles.</p>
          </div>
          <a class="text-link" href="#compare">Compare first</a>
        </div>
        <div class="grid-3">
          <?php foreach ($featuredWineries as $card): $isFirst = false; ?>
            <?php include COMPONENTS_PATH . '/winery-card.php'; ?>
          <?php endforeach; ?>
        </div>
      </div>
    </section>
    <?php endif; ?>

    <!-- COMPARE TABLE -->
    <section class="section" id="compare">
      <div class="section-card">
        <div class="section-head">
          <div>
            <h2>Compare before clicking through</h2>
            <p>This table helps you self-segment into the right region, category, or winery page.</p>
          </div>
        </div>
        <div class="compare-wrap">
          <table>
            <thead>
              <tr>
                <th>Best for</th>
                <th>Start with</th>
                <th>Why it works</th>
                <th>Best next page</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td><strong>First-time day trip</strong></td>
                <td>Penedès</td>
                <td>Easy to understand, strong Cava relevance, many recognisable wineries.</td>
                <td><a class="text-link" href="<?= SITE_URL ?>/region/penedes">Penedès guide</a></td>
              </tr>
              <tr>
                <td><strong>No car needed</strong></td>
                <td>Alella or train-friendly Cava houses</td>
                <td>Lower friction, simpler logistics, stronger fit for short Barcelona itineraries.</td>
                <td><a class="text-link" href="<?= SITE_URL ?>/category/no-car-needed">No-car category</a></td>
              </tr>
              <tr>
                <td><strong>Premium scenic visit</strong></td>
                <td>Priorat</td>
                <td>Better for countryside atmosphere, dramatic terraces, and high-intent wine escapes.</td>
                <td><a class="text-link" href="<?= SITE_URL ?>/region/priorat">Priorat guide</a></td>
              </tr>
              <tr>
                <td><strong>Organic / boutique</strong></td>
                <td>Alella + selected Penedès estates</td>
                <td>Good for quality-driven travellers and editorial discovery pages.</td>
                <td><a class="text-link" href="<?= SITE_URL ?>/category/organic-wines">Organic picks</a></td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </section>

    <!-- PLANNING + EDITORIAL -->
    <section class="section" id="planning">
      <div class="section-card">
        <div class="split">
          <article class="note">
            <h3>How this guide works</h3>
            <p>The goal is not to dump information. The goal is to guide you into the right page type quickly.</p>
            <ul>
              <li>Start with <strong>region pages</strong> when you're still exploring.</li>
              <li>Use <strong>category pages</strong> for practical constraints like transport or trip style.</li>
              <li>Use <strong>winery pages</strong> for final selection and detailed planning.</li>
            </ul>
          </article>
          <aside class="aside-note">
            <h3>High-value shortcuts</h3>
            <p>The most useful entry points for planning a winery trip from Barcelona.</p>
            <div class="mini-list">
              <div class="mini-item">
                <div><strong>Best wineries near Barcelona</strong><span>Broad shortlist and comparison guide.</span></div>
                <a class="text-link" href="<?= SITE_URL ?>/region/penedes">Open</a>
              </div>
              <div class="mini-item">
                <div><strong>Wineries without a car</strong><span>Strong practical constraint page.</span></div>
                <a class="text-link" href="<?= SITE_URL ?>/category/no-car-needed">Open</a>
              </div>
              <div class="mini-item">
                <div><strong>Organic wineries near Barcelona</strong><span>Boutique and quality-first picks.</span></div>
                <a class="text-link" href="<?= SITE_URL ?>/category/organic-wines">Open</a>
              </div>
            </div>
          </aside>
        </div>
      </div>
    </section>

    <!-- FAQ -->
    <section class="section">
      <div class="section-card">
        <div class="section-head">
          <div>
            <h2>Popular planning questions</h2>
            <p>Common questions from travellers planning a winery trip near Barcelona.</p>
          </div>
        </div>
        <div class="faq">
          <article class="faq-item">
            <h3>What is the easiest wine region to visit from Barcelona?</h3>
            <p>Alella wins on short-distance convenience, while Penedès offers the broadest mix of Cava recognition, winery tours, and full-day options.</p>
          </article>
          <article class="faq-item">
            <h3>Can you visit a winery from Barcelona without a car?</h3>
            <p>Yes — several wineries in Penedès and Alella are reachable by train or organized tour. See our <a class="text-link" href="<?= SITE_URL ?>/category/no-car-needed">no-car category</a> for a curated list.</p>
          </article>
          <article class="faq-item">
            <h3>How far in advance should you book a winery visit?</h3>
            <p>Most wineries require advance booking, especially for cellar tours. Peak season (June–October) fills up fast — booking 1–2 weeks ahead is recommended.</p>
          </article>
        </div>
      </div>
    </section>

  </div>
</div>

<?php require_once COMPONENTS_PATH . '/footer.php'; ?>
