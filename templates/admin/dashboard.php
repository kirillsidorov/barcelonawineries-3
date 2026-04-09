<?php include __DIR__ . '/header.php'; ?>

<div class="page-header">
    <div>
        <h1>Dashboard</h1>
        <div class="subtitle">Overview of your winery directory</div>
    </div>
    <a href="/admin/edit" class="btn btn-wine"><i class="bi bi-plus-lg"></i> Add Winery</a>
</div>

<!-- Stats -->
<div class="stat-grid">
    <div class="stat-card">
        <div class="stat-label">Total wineries</div>
        <div class="stat-value"><?= $stats['wineries'] ?? 0 ?></div>
    </div>
    <div class="stat-card">
        <div class="stat-label">Published</div>
        <div class="stat-value"><?= $stats['published'] ?? 0 ?></div>
    </div>
    <div class="stat-card">
        <div class="stat-label">Featured</div>
        <div class="stat-value"><?= $stats['featured'] ?? 0 ?></div>
    </div>
    <div class="stat-card">
        <div class="stat-label">Regions</div>
        <div class="stat-value"><?= $stats['regions'] ?? 0 ?></div>
    </div>
    <div class="stat-card">
        <div class="stat-label">Categories</div>
        <div class="stat-value"><?= $stats['categories'] ?? 0 ?></div>
    </div>
</div>

<div class="row g-3">
    <!-- Recent wineries -->
    <div class="col-lg-8">
        <div class="admin-card">
            <h5 style="font-weight:700;margin-bottom:16px;">Recently updated</h5>
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>Winery</th>
                        <th>Region</th>
                        <th>Status</th>
                        <th>Updated</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($recent ?? [] as $w): ?>
                    <tr>
                        <td class="name-cell">
                            <a href="/admin/edit?id=<?= $w['id'] ?>"><?= e($w['name']) ?></a>
                            <span class="slug">/winery/<?= e($w['slug']) ?></span>
                        </td>
                        <td><?= e($w['region_name'] ?? '—') ?></td>
                        <td>
                            <?php if ($w['is_published']): ?>
                                <span class="badge-status badge-published">Published</span>
                            <?php else: ?>
                                <span class="badge-status badge-draft">Draft</span>
                            <?php endif; ?>
                        </td>
                        <td style="font-size:.82rem;color:var(--admin-muted);"><?= date('M j', strtotime($w['updated_at'])) ?></td>
                        <td><a href="/admin/edit?id=<?= $w['id'] ?>" class="btn btn-sm btn-outline-secondary">Edit</a></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Quick actions -->
    <div class="col-lg-4">
        <div class="admin-card" style="margin-bottom:12px;">
            <h5 style="font-weight:700;margin-bottom:14px;">Quick actions</h5>
            <div class="d-grid gap-2">
                <a href="/admin/edit" class="btn btn-wine"><i class="bi bi-plus-lg"></i> Add winery</a>
                <a href="/admin/wineries" class="btn btn-outline-secondary"><i class="bi bi-list-ul"></i> All wineries</a>
                <a href="/admin/regions" class="btn btn-outline-secondary"><i class="bi bi-map"></i> Manage regions</a>
                <a href="/admin/categories" class="btn btn-outline-secondary"><i class="bi bi-tags"></i> Manage categories</a>
            </div>
        </div>
        <div class="admin-card">
            <h5 style="font-weight:700;margin-bottom:14px;">Links</h5>
            <div class="d-grid gap-2">
                <a href="/" target="_blank" class="btn btn-outline-secondary"><i class="bi bi-box-arrow-up-right"></i> View live site</a>
                <a href="/sitemap.xml" target="_blank" class="btn btn-outline-secondary"><i class="bi bi-filetype-xml"></i> Sitemap</a>
            </div>
        </div>
    </div>
</div>

<?php include __DIR__ . '/footer.php'; ?>
