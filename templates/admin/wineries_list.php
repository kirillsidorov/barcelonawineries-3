<?php include __DIR__ . '/header.php'; ?>
<div class="container-fluid mt-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Wineries Catalog</h2>
        <a href="/admin/edit" class="btn btn-success">+ Add New Winery</a>
    </div>
    <table class="table table-hover align-middle border shadow-sm">
        <thead class="table-light">
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>City</th>
                <th>Status</th>
                <th>Featured</th>
                <th class="text-end">Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($wineries as $w): ?>
            <tr>
                <td><?= $w['id'] ?></td>
                <td><strong><?= $w['name'] ?></strong></td>
                <td><?= $w['city'] ?></td>
                <td><?= $w['is_published'] ? '✅' : '❌' ?></td>
                <td><?= $w['is_featured'] ? '⭐' : '' ?></td>
                <td class="text-end">
                    <a href="/admin/edit?id=<?= $w['id'] ?>" class="btn btn-sm btn-outline-primary">Edit</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>



<?php include __DIR__ . '/footer.php'; ?>