<?php include __DIR__ . '/header.php'; ?>

<div class="page-header">
    <div>
        <h1>Wineries</h1>
        <div class="subtitle"><?= count($wineries) ?> wineries in catalog</div>
    </div>
    <a href="/admin/edit" class="btn btn-wine"><i class="bi bi-plus-lg"></i> Add Winery</a>
</div>

<?php if (isset($_GET['deleted'])): ?>
<div class="admin-alert admin-alert-success"><i class="bi bi-check-circle"></i> Winery deleted.</div>
<?php endif; ?>

<!-- Filters -->
<div class="filters-bar">
    <form method="GET" action="/admin/wineries" class="d-flex gap-2 flex-wrap align-items-center" style="width:100%;">
        <input type="text" name="q" class="form-control" placeholder="Search name, city, slug…" value="<?= e($search ?? '') ?>">
        <select name="region" class="form-select">
            <option value="">All regions</option>
            <?php foreach ($regions ?? [] as $r): ?>
            <option value="<?= $r['id'] ?>" <?= ($regionFilter ?? '') == $r['id'] ? 'selected' : '' ?>><?= e($r['name']) ?></option>
            <?php endforeach; ?>
        </select>
        <select name="status" class="form-select" style="max-width:140px;">
            <option value="">All status</option>
            <option value="published" <?= ($statusFilter ?? '') === 'published' ? 'selected' : '' ?>>Published</option>
            <option value="draft" <?= ($statusFilter ?? '') === 'draft' ? 'selected' : '' ?>>Draft</option>
        </select>
        <button type="submit" class="btn btn-outline-secondary"><i class="bi bi-search"></i> Filter</button>
        <?php if (!empty($search) || !empty($regionFilter) || !empty($statusFilter)): ?>
        <a href="/admin/wineries" class="btn btn-outline-secondary"><i class="bi bi-x-lg"></i> Clear</a>
        <?php endif; ?>
    </form>
</div>

<!-- Table -->
<div class="admin-card" style="padding:0;overflow-x:auto;">
    <table class="admin-table">
        <thead>
            <tr>
                <th>Winery</th>
                <th>Region</th>
                <th>City</th>
                <th>Dist.</th>
                <th>Flags</th>
                <th>Rating</th>
                <th>Status</th>
                <th style="text-align:right;">Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php if (empty($wineries)): ?>
            <tr><td colspan="8" style="text-align:center;padding:2rem;color:var(--admin-muted);">No wineries found.</td></tr>
            <?php endif; ?>
            <?php foreach ($wineries as $w): ?>
            <tr>
                <td class="name-cell">
                    <a href="/admin/edit?id=<?= $w['id'] ?>"><?= e($w['name']) ?></a>
                    <span class="slug">/winery/<?= e($w['slug']) ?></span>
                </td>
                <td><?= e($w['region_name'] ?? '—') ?></td>
                <td style="font-size:.85rem;"><?= e($w['city'] ?? '—') ?></td>
                <td style="font-size:.85rem;"><?= $w['distance_km'] ? e($w['distance_km']) . ' km' : '—' ?></td>
                <td>
                    <?php if ($w['no_car_needed']): ?><span class="badge-tag">🚂</span><?php endif; ?>
                    <?php if ($w['organic']): ?><span class="badge-tag">🌿</span><?php endif; ?>
                    <?php if ($w['has_restaurant']): ?><span class="badge-tag">🍽️</span><?php endif; ?>
                </td>
                <td style="font-size:.85rem;"><?= $w['rating'] ? '★ ' . e($w['rating']) : '—' ?></td>
                <td>
                    <form method="POST" action="/admin/toggle" style="display:inline;">
                        <input type="hidden" name="id" value="<?= $w['id'] ?>">
                        <input type="hidden" name="field" value="is_published">
                        <button type="submit" class="btn-toggle" title="Toggle publish">
                            <?= $w['is_published'] ? '✅' : '❌' ?>
                        </button>
                    </form>
                    <form method="POST" action="/admin/toggle" style="display:inline;margin-left:4px;">
                        <input type="hidden" name="id" value="<?= $w['id'] ?>">
                        <input type="hidden" name="field" value="is_featured">
                        <button type="submit" class="btn-toggle" title="Toggle featured">
                            <?= $w['is_featured'] ? '⭐' : '☆' ?>
                        </button>
                    </form>
                </td>
                <td style="text-align:right;">
                    <a href="/winery/<?= e($w['slug']) ?>" target="_blank" class="btn btn-sm btn-outline-secondary" title="View"><i class="bi bi-eye"></i></a>
                    <a href="/admin/edit?id=<?= $w['id'] ?>" class="btn btn-sm btn-outline-primary">Edit</a>
                    <form method="POST" action="/admin/delete" style="display:inline;" onsubmit="return confirm('Delete this winery?')">
                        <input type="hidden" name="id" value="<?= $w['id'] ?>">
                        <button type="submit" class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                    </form>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?php include __DIR__ . '/footer.php'; ?>
