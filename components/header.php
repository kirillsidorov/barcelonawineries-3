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
    <link rel="icon" type="image/svg+xml" href="<?= ASSETS_URL ?>/img/favicon.svg">
</head>
<body>
<a href="#main-content" class="skip-link">Skip to content</a>

<header class="site-header">
    <div class="container header-row">
        <a class="brand" href="<?= SITE_URL ?>/">
            <span class="brand-mark">🍷</span>
            <span>
                <span class="brand-name"><?= e(SITE_NAME) ?></span>
                <span class="brand-sub">Editorial wine guide near Barcelona</span>
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
            <a class="btn" href="<?= SITE_URL ?>/region/penedes">Explore now</a>
        </div>
    </div>
</header>

<main id="main-content">
