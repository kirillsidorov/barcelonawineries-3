<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= e($title ?? 'Admin') ?> — <?= e(SITE_NAME) ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link rel="icon" type="image/png" sizes="32x32" href="<?= ASSETS_URL ?>/img/favicon-32.png">
    <style>
        :root {
            --admin-wine: #8b2332;
            --admin-wine-dark: #6b1825;
            --admin-bg: #f5f3f0;
            --admin-surface: #ffffff;
            --admin-border: #e5e0d8;
            --admin-text: #1a1714;
            --admin-muted: #766d63;
        }
        body { background: var(--admin-bg); font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif; }

        /* Top nav */
        .admin-nav {
            background: var(--admin-text);
            padding: 0 1.5rem;
            display: flex;
            align-items: center;
            height: 56px;
            position: sticky;
            top: 0;
            z-index: 100;
        }
        .admin-nav .brand {
            color: #fff;
            font-weight: 700;
            font-size: 1rem;
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 8px;
            margin-right: 2rem;
        }
        .admin-nav .brand img { width: 28px; height: 28px; border-radius: 4px; }
        .admin-nav .nav-links {
            display: flex;
            gap: 2px;
            flex: 1;
        }
        .admin-nav .nav-links a {
            color: rgba(255,255,255,.65);
            text-decoration: none;
            padding: 8px 14px;
            border-radius: 6px;
            font-size: .88rem;
            font-weight: 600;
            transition: all .15s;
            display: flex;
            align-items: center;
            gap: 6px;
        }
        .admin-nav .nav-links a:hover { color: #fff; background: rgba(255,255,255,.08); }
        .admin-nav .nav-links a.active { color: #fff; background: var(--admin-wine); }
        .admin-nav .nav-right {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-left: auto;
        }
        .admin-nav .nav-right a {
            color: rgba(255,255,255,.6);
            text-decoration: none;
            font-size: .84rem;
            transition: color .15s;
        }
        .admin-nav .nav-right a:hover { color: #fff; }

        /* Content area */
        .admin-content {
            max-width: 1320px;
            margin: 0 auto;
            padding: 28px 24px 60px;
        }

        /* Page header */
        .page-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 24px;
        }
        .page-header h1 {
            font-size: 1.5rem;
            font-weight: 700;
            margin: 0;
            color: var(--admin-text);
        }
        .page-header .subtitle {
            font-size: .88rem;
            color: var(--admin-muted);
            margin-top: 2px;
        }

        /* Cards */
        .admin-card {
            background: var(--admin-surface);
            border: 1px solid var(--admin-border);
            border-radius: 10px;
            padding: 20px;
        }

        /* Stats */
        .stat-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
            gap: 12px;
            margin-bottom: 24px;
        }
        .stat-card {
            background: var(--admin-surface);
            border: 1px solid var(--admin-border);
            border-radius: 10px;
            padding: 18px;
        }
        .stat-card .stat-label {
            font-size: .72rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: .06em;
            color: var(--admin-muted);
            margin-bottom: 4px;
        }
        .stat-card .stat-value {
            font-size: 1.6rem;
            font-weight: 800;
            color: var(--admin-text);
        }

        /* Tables */
        .admin-table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
        }
        .admin-table th {
            background: #f8f6f3;
            border-bottom: 2px solid var(--admin-border);
            padding: 10px 14px;
            font-size: .72rem;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: .06em;
            color: var(--admin-muted);
            text-align: left;
            position: sticky;
            top: 56px;
            z-index: 10;
        }
        .admin-table td {
            padding: 12px 14px;
            border-bottom: 1px solid #f0ece6;
            font-size: .9rem;
            vertical-align: middle;
        }
        .admin-table tr:hover td { background: #faf8f5; }
        .admin-table .name-cell {
            font-weight: 700;
            color: var(--admin-text);
        }
        .admin-table .name-cell a {
            color: var(--admin-text);
            text-decoration: none;
        }
        .admin-table .name-cell a:hover { color: var(--admin-wine); }
        .admin-table .name-cell .slug {
            display: block;
            font-size: .78rem;
            color: var(--admin-muted);
            font-weight: 400;
        }

        /* Badges */
        .badge-status {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            padding: 3px 8px;
            border-radius: 4px;
            font-size: .75rem;
            font-weight: 700;
        }
        .badge-published { background: #e8f5e9; color: #2e7d32; }
        .badge-draft { background: #fff3e0; color: #e65100; }
        .badge-featured { background: #fce4ec; color: #ad1457; }
        .badge-tag {
            display: inline-flex;
            padding: 2px 6px;
            border-radius: 4px;
            font-size: .72rem;
            font-weight: 600;
            background: #f0ece6;
            color: var(--admin-muted);
        }

        /* Toggle buttons */
        .btn-toggle {
            background: none;
            border: 1px solid var(--admin-border);
            border-radius: 4px;
            padding: 3px 8px;
            font-size: .78rem;
            cursor: pointer;
            transition: all .15s;
        }
        .btn-toggle:hover { border-color: var(--admin-wine); color: var(--admin-wine); }

        /* Filters bar */
        .filters-bar {
            display: flex;
            gap: 10px;
            align-items: center;
            flex-wrap: wrap;
            margin-bottom: 16px;
        }
        .filters-bar .form-control,
        .filters-bar .form-select {
            max-width: 200px;
            font-size: .88rem;
            border-color: var(--admin-border);
        }

        /* Form sections */
        .form-section {
            margin-bottom: 28px;
        }
        .form-section-title {
            font-size: .78rem;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: .06em;
            color: var(--admin-muted);
            margin-bottom: 14px;
            padding-bottom: 8px;
            border-bottom: 1px solid var(--admin-border);
        }

        /* Buttons */
        .btn-wine {
            background: var(--admin-wine);
            color: #fff;
            border: none;
        }
        .btn-wine:hover {
            background: var(--admin-wine-dark);
            color: #fff;
        }

        /* Alert */
        .admin-alert {
            padding: 10px 16px;
            border-radius: 8px;
            font-size: .88rem;
            font-weight: 600;
            margin-bottom: 16px;
        }
        .admin-alert-success {
            background: #e8f5e9;
            color: #2e7d32;
            border: 1px solid #c8e6c9;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .admin-nav .nav-links { display: none; }
            .page-header { flex-direction: column; gap: 12px; align-items: flex-start; }
            .admin-content { padding: 16px; }
        }
    </style>
</head>
<body>

<?php
// Determine active nav item from current URI
$currentUri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$navItems = [
    '/admin'            => ['icon' => 'bi-grid-1x2', 'label' => 'Dashboard'],
    '/admin/wineries'   => ['icon' => 'bi-house-heart', 'label' => 'Wineries'],
    '/admin/regions'    => ['icon' => 'bi-map', 'label' => 'Regions'],
    '/admin/categories' => ['icon' => 'bi-tags', 'label' => 'Categories'],
];
?>

<nav class="admin-nav">
    <a class="brand" href="/admin">
        <img src="<?= ASSETS_URL ?>/img/brand-mark.png" alt="">
        <?= e(SITE_NAME) ?>
    </a>
    <div class="nav-links">
        <?php foreach ($navItems as $url => $item):
            $isActive = $currentUri === $url
                || ($url !== '/admin' && str_starts_with($currentUri, $url));
        ?>
        <a href="<?= $url ?>" class="<?= $isActive ? 'active' : '' ?>">
            <i class="bi <?= $item['icon'] ?>"></i> <?= $item['label'] ?>
        </a>
        <?php endforeach; ?>
    </div>
    <div class="nav-right">
        <a href="/" target="_blank"><i class="bi bi-box-arrow-up-right"></i> View site</a>
        <a href="/admin/logout"><i class="bi bi-box-arrow-right"></i> Logout</a>
    </div>
</nav>

<div class="admin-content">
