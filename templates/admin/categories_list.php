<?php include __DIR__ . '/header.php'; ?>

<div class="page-header">
    <div>
        <h1>Categories</h1>
        <div class="subtitle"><?= count($categories) ?> category hubs</div>
    </div>
    <a href="/admin/category-edit" class="btn btn-wine"><i class="bi bi-plus-lg"></i> Add Category</a>
</div>

<div class="admin-card" style="padding:0;overflow-x:auto;">
    <table class="admin-table">
        <thead>
            <tr>
                <th>Category</th>
                <th>Slug</th>
                <th>Filter column</th>
                <th>Description</th>
                <th>Order</th>
                <th style="text-align:right;">Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($categories as $c): ?>
            <tr>
                <td class="name-cell"><a href="/admin/category-edit?id=<?= $c['id'] ?>"><?= e($c['label']) ?></a></td>
                <td style="font-size:.82rem;color:var(--admin-muted);">/category/<?= e($c['slug']) ?></td>
                <td><span class="badge-tag"><?= e($c['filter_column'] ?? '—') ?></span></td>
                <td style="font-size:.85rem;max-width:300px;"><?= e(mb_strimwidth($c['description'], 0, 80, '…')) ?></td>
                <td style="font-size:.85rem;"><?= $c['sort_order'] ?></td>
                <td style="text-align:right;">
                    <a href="/category/<?= e($c['slug']) ?>" target="_blank" class="btn btn-sm btn-outline-secondary" title="View"><i class="bi bi-eye"></i></a>
                    <a href="/admin/category-edit?id=<?= $c['id'] ?>" class="btn btn-sm btn-outline-primary">Edit</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?php include __DIR__ . '/footer.php'; ?>
