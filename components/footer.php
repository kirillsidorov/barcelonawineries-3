</main>

<footer class="site-footer" role="contentinfo">
    <div class="container">
        <div class="footer-inner">
            <div>
                <div class="footer-brand"><?= e(SITE_NAME) ?></div>
                <p style="font-size:.9rem;color:var(--muted);max-width:280px;line-height:1.7;margin-top:.4rem;">
                    Your independent guide to wine tourism near Barcelona. Editorial picks, no pay-to-rank.
                </p>
            </div>
            <div class="footer-cols">
                <div class="footer-col">
                    <h4>Regions</h4>
                    <ul>
                        <li><a href="<?= SITE_URL ?>/region/penedes">Penedès</a></li>
                        <li><a href="<?= SITE_URL ?>/region/priorat">Priorat</a></li>
                        <li><a href="<?= SITE_URL ?>/region/alella">Alella</a></li>
                        <li><a href="<?= SITE_URL ?>/region/emporda">Empordà</a></li>
                        <li><a href="<?= SITE_URL ?>/region/montsant">Montsant</a></li>
                    </ul>
                </div>
                <div class="footer-col">
                    <h4>Experiences</h4>
                    <ul>
                        <li><a href="<?= SITE_URL ?>/category/no-car-needed">No car needed</a></li>
                        <li><a href="<?= SITE_URL ?>/category/family-friendly">Family friendly</a></li>
                        <li><a href="<?= SITE_URL ?>/category/organic-wines">Organic wines</a></li>
                        <li><a href="<?= SITE_URL ?>/category/restaurant-onsite">With restaurant</a></li>
                        <li><a href="<?= SITE_URL ?>/category/with-accommodation">Stay overnight</a></li>
                    </ul>
                </div>
                <div class="footer-col">
                    <h4>About</h4>
                    <ul>
                        <li><a href="#">About</a></li>
                        <li><a href="#">Editorial policy</a></li>
                        <li><a href="#">Contact</a></li>
                        <li><a href="#">Privacy</a></li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="footer-bottom">
            <p>© <?= date('Y') ?> <?= e(SITE_NAME) ?> · All rights reserved</p>
            <p>This site contains affiliate links to GetYourGuide and Viator. We may earn a commission at no cost to you.</p>
        </div>
    </div>
</footer>

<script src="<?= ASSETS_URL ?>/js/main.js" defer></script>
</body>
</html>
