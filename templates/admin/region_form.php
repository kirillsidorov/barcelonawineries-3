<?php include __DIR__ . '/header.php'; ?>

<div class="page-header">
    <div>
        <h1><?= $region ? e($region['name']) : 'Add Region' ?></h1>
        <div class="subtitle"><?= $region ? '/region/' . e($region['slug']) : 'Create a new wine region' ?></div>
    </div>
    <a href="/admin/regions" class="btn btn-outline-secondary">← Back to regions</a>
</div>

<?php if (!empty($success)): ?>
<div class="admin-alert admin-alert-success"><i class="bi bi-check-circle"></i> Region saved.</div>
<?php endif; ?>

<form action="/admin/region-save" method="POST">
    <?php if ($region): ?>
    <input type="hidden" name="id" value="<?= $region['id'] ?>">
    <?php endif; ?>

    <div class="row g-3">
        <div class="col-lg-8">
            <div class="admin-card">
                <div class="form-section-title">Region details</div>
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label fw-bold">Region name *</label>
                        <input type="text" name="name" class="form-control" value="<?= e($region['name'] ?? '') ?>" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-bold">Slug *</label>
                        <div class="input-group">
                            <span class="input-group-text">/region/</span>
                            <input type="text" name="slug" class="form-control" value="<?= e($region['slug'] ?? '') ?>">
                        </div>
                    </div>
                    <div class="col-12">
                        <label class="form-label fw-bold">Description</label>
                        <textarea name="description" class="form-control" rows="3"><?= e($region['description'] ?? '') ?></textarea>
                    </div>
                    <div class="col-12">
                        <label class="form-label">Meta description (max 165 chars)</label>
                        <textarea name="meta_description" class="form-control" rows="2" maxlength="165"><?= e($region['meta_description'] ?? '') ?></textarea>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Latitude</label>
                        <input type="text" name="lat" class="form-control" value="<?= e($region['lat'] ?? '') ?>">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Longitude</label>
                        <input type="text" name="lng" class="form-control" value="<?= e($region['lng'] ?? '') ?>">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Sort order</label>
                        <input type="number" name="sort_order" class="form-control" value="<?= e($region['sort_order'] ?? 0) ?>">
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="admin-card">
                <button type="submit" class="btn btn-wine w-100"><i class="bi bi-check-lg"></i> Save region</button>
                <?php if ($region): ?>
                <a href="/region/<?= e($region['slug']) ?>" target="_blank" class="btn btn-outline-secondary w-100 mt-2"><i class="bi bi-eye"></i> View page</a>
                <?php endif; ?>
            </div>
        </div>
    </div>
</form>

<?php include __DIR__ . '/footer.php'; ?>
