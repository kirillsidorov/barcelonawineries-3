<?php include __DIR__ . '/header.php'; ?>

<div class="page-header">
    <div>
        <h1>Regions</h1>
        <div class="subtitle"><?= count($regions) ?> wine regions</div>
    </div>
    <a href="/admin/region-edit" class="btn btn-wine"><i class="bi bi-plus-lg"></i> Add Region</a>
</div>

<div class="admin-card" style="padding:0;overflow-x:auto;">
    <table class="admin-table">
        <thead>
            <tr>
                <th>Region</th>
                <th>Slug</th>
                <th>Description</th>
                <th>Wineries</th>
                <th>Order</th>
                <th style="text-align:right;">Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($regions as $r): ?>
            <tr>
                <td class="name-cell"><a href="/admin/region-edit?id=<?= $r['id'] ?>"><?= e($r['name']) ?></a></td>
                <td style="font-size:.82rem;color:var(--admin-muted);">/region/<?= e($r['slug']) ?></td>
                <td style="font-size:.85rem;max-width:300px;"><?= e(mb_strimwidth($r['description'], 0, 80, '…')) ?></td>
                <td><span class="badge-tag"><?= $r['winery_count'] ?? 0 ?></span></td>
                <td style="font-size:.85rem;"><?= $r['sort_order'] ?></td>
                <td style="text-align:right;">
                    <a href="/region/<?= e($r['slug']) ?>" target="_blank" class="btn btn-sm btn-outline-secondary" title="View"><i class="bi bi-eye"></i></a>
                    <a href="/admin/region-edit?id=<?= $r['id'] ?>" class="btn btn-sm btn-outline-primary">Edit</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?php include __DIR__ . '/footer.php'; ?>
