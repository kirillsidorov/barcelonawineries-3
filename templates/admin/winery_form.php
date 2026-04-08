<?php include __DIR__ . '/header.php'; ?>
<div class="container mt-4 mb-5">
    <form action="/admin/save" method="POST" class="card shadow-sm p-4">
        <h3><?= $winery ? 'Edit Winery' : 'Add New Winery' ?></h3>
        <div class="row g-3 mt-2">
            <div class="col-md-6">
                <label class="form-label">Winery Name</label>
                <input type="text" name="name" class="form-control" value="<?= $winery['name'] ?? '' ?>" required>
            </div>
            <div class="col-md-6">
                <label class="form-label">Slug (URL path)</label>
                <input type="text" name="slug" class="form-control" value="<?= $winery['slug'] ?? '' ?>" required>
            </div>
            <div class="col-md-3">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="no_car_needed" <?= ($winery['no_car_needed'] ?? 0) ? 'checked' : '' ?>>
                    <label class="form-check-label">No car needed</label>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="organic" <?= ($winery['organic'] ?? 0) ? 'checked' : '' ?>>
                    <label class="form-check-label">Organic</label>
                </div>
            </div>
            <div class="col-12 mt-4">
                <button type="submit" class="btn btn-primary btn-lg">Save Changes</button>
                <a href="/admin/wineries" class="btn btn-link">Cancel</a>
            </div>
        </div>
    </form>
</div>
<?php include __DIR__ . '/footer.php'; ?>