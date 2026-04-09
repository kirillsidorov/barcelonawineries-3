<!DOCTYPE html>
<html lang="<?= e(SITE_LANG) ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php render_seo_tags($seo ?? SEO_DEFAULTS); ?>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@500;600;700&family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <?php inline_critical_css(); ?>
    <link rel="stylesheet" href="<?= ASSETS_URL ?>/css/main.css" media="print" onload="this.media='all'">
    <noscript><link rel="stylesheet" href="<?= ASSETS_URL ?>/css/main.css"></noscript>
    <?php if (!empty($extraCss)): ?>
    <link rel="stylesheet" href="<?= ASSETS_URL ?>/css/<?= e($extraCss) ?>" media="print" onload="this.media='all'">
    <noscript><link rel="stylesheet" href="<?= ASSETS_URL ?>/css/<?= e($extraCss) ?>"></noscript>
    <?php endif; ?>
    <!-- Favicons -->
    <link rel="icon" type="image/png" sizes="32x32" href="<?= ASSETS_URL ?>/img/favicon-32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="<?= ASSETS_URL ?>/img/favicon-16.png">
    <link rel="apple-touch-icon" sizes="180x180" href="<?= ASSETS_URL ?>/img/apple-touch-icon.png">
    <link rel="icon" type="image/x-icon" href="<?= ASSETS_URL ?>/img/favicon.ico">
</head>
<body>
<a href="#main-content" class="skip-link">Skip to content</a>

<header class="site-header">
    <div class="container header-row">
        <a class="brand" href="<?= SITE_URL ?>/">
            <img class="brand-mark" src="<?= ASSETS_URL ?>/img/brand-mark.png" alt="<?= e(SITE_NAME) ?>" width="36" height="36">
            <span>
                <span class="brand-name"><?= e(SITE_NAME) ?></span>
                <span class="brand-sub">Catalan wine guide</span>
            </span>
        </a>
        <nav class="site-nav" aria-label="Primary navigation">
            <a href="<?= SITE_URL ?>/region/penedes">Penedès</a>
            <a href="<?= SITE_URL ?>/region/priorat">Priorat</a>
            <a href="<?= SITE_URL ?>/region/alella">Alella</a>
            <a href="<?= SITE_URL ?>/category/no-car-needed">No car</a>
        </nav>
        <div class="header-actions">
            <a class="btn-secondary" href="<?= SITE_URL ?>/category/no-car-needed">No car needed</a>
            <a class="btn" href="<?= SITE_URL ?>/region/penedes">Explore</a>
        </div>
    </div>
</header>

<main id="main-content">
