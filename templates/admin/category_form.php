<?php include __DIR__ . '/header.php'; ?>

<div class="page-header">
    <div>
        <h1><?= $category ? e($category['label']) : 'Add Category' ?></h1>
        <div class="subtitle"><?= $category ? '/category/' . e($category['slug']) : 'Create a new category hub' ?></div>
    </div>
    <a href="/admin/categories" class="btn btn-outline-secondary">← Back to categories</a>
</div>

<?php if (!empty($success)): ?>
<div class="admin-alert admin-alert-success"><i class="bi bi-check-circle"></i> Category saved.</div>
<?php endif; ?>

<form action="/admin/category-save" method="POST">
    <?php if ($category): ?>
    <input type="hidden" name="id" value="<?= $category['id'] ?>">
    <?php endif; ?>

    <div class="row g-3">
        <div class="col-lg-8">
            <div class="admin-card">
                <div class="form-section-title">Category details</div>
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label fw-bold">Category label *</label>
                        <input type="text" name="label" class="form-control" value="<?= e($category['label'] ?? '') ?>" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-bold">Slug *</label>
                        <div class="input-group">
                            <span class="input-group-text">/category/</span>
                            <input type="text" name="slug" class="form-control" value="<?= e($category['slug'] ?? '') ?>">
                        </div>
                    </div>
                    <div class="col-12">
                        <label class="form-label fw-bold">Description</label>
                        <textarea name="description" class="form-control" rows="3"><?= e($category['description'] ?? '') ?></textarea>
                    </div>
                    <div class="col-12">
                        <label class="form-label">Meta description (max 165 chars)</label>
                        <textarea name="meta_description" class="form-control" rows="2" maxlength="165"><?= e($category['meta_description'] ?? '') ?></textarea>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Filter column</label>
                        <select name="filter_column" class="form-select">
                            <option value="">None (manual linking)</option>
                            <?php
                            $cols = [
                                'no_car_needed' => 'no_car_needed',
                                'kids_welcome'  => 'kids_welcome',
                                'organic'       => 'organic',
                                'has_restaurant'=> 'has_restaurant',
                                'accommodation' => 'accommodation',
                                'pet_friendly'  => 'pet_friendly',
                            ];
                            foreach ($cols as $val => $label):
                            ?>
                            <option value="<?= $val ?>" <?= ($category['filter_column'] ?? '') === $val ? 'selected' : '' ?>><?= $label ?></option>
                            <?php endforeach; ?>
                        </select>
                        <div class="form-text">Maps to wineries table column for automatic filtering.</div>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Sort order</label>
                        <input type="number" name="sort_order" class="form-control" value="<?= e($category['sort_order'] ?? 0) ?>">
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="admin-card">
                <button type="submit" class="btn btn-wine w-100"><i class="bi bi-check-lg"></i> Save category</button>
                <?php if ($category): ?>
                <a href="/category/<?= e($category['slug']) ?>" target="_blank" class="btn btn-outline-secondary w-100 mt-2"><i class="bi bi-eye"></i> View page</a>
                <?php endif; ?>
            </div>
        </div>
    </div>
</form>

<?php include __DIR__ . '/footer.php'; ?>
