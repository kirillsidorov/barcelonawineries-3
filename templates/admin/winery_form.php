<?php include __DIR__ . '/header.php'; ?>

<div class="page-header">
    <div>
        <h1><?= $winery ? e($winery['name']) : 'Add New Winery' ?></h1>
        <div class="subtitle"><?= $winery ? '/winery/' . e($winery['slug']) : 'Create a new winery entry' ?></div>
    </div>
    <div class="d-flex gap-2">
        <?php if ($winery): ?>
        <a href="/winery/<?= e($winery['slug']) ?>" target="_blank" class="btn btn-outline-secondary"><i class="bi bi-eye"></i> View page</a>
        <?php endif; ?>
        <a href="/admin/wineries" class="btn btn-outline-secondary">← Back to list</a>
    </div>
</div>

<?php if (!empty($success)): ?>
<div class="admin-alert admin-alert-success"><i class="bi bi-check-circle"></i> Winery saved successfully.</div>
<?php endif; ?>

<form action="/admin/save" method="POST">
    <?php if ($winery): ?>
    <input type="hidden" name="id" value="<?= $winery['id'] ?>">
    <?php endif; ?>

    <div class="row g-3">
        <!-- Main column -->
        <div class="col-lg-8">

            <!-- Identity -->
            <div class="admin-card" style="margin-bottom:16px;">
                <div class="form-section-title">Identity</div>
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label fw-bold">Winery name *</label>
                        <input type="text" name="name" class="form-control" value="<?= e($winery['name'] ?? '') ?>" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-bold">Slug *</label>
                        <div class="input-group">
                            <span class="input-group-text">/winery/</span>
                            <input type="text" name="slug" class="form-control" value="<?= e($winery['slug'] ?? '') ?>" placeholder="auto-generated if empty">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-bold">Region *</label>
                        <select name="region_id" class="form-select" required>
                            <option value="">Select region…</option>
                            <?php foreach ($regions as $r): ?>
                            <option value="<?= $r['id'] ?>" <?= ($winery['region_id'] ?? '') == $r['id'] ? 'selected' : '' ?>><?= e($r['name']) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-bold">City</label>
                        <input type="text" name="city" class="form-control" value="<?= e($winery['city'] ?? '') ?>">
                    </div>
                </div>
            </div>

            <!-- Location -->
            <div class="admin-card" style="margin-bottom:16px;">
                <div class="form-section-title">Location & Transport</div>
                <div class="row g-3">
                    <div class="col-md-4">
                        <label class="form-label">Address</label>
                        <input type="text" name="address" class="form-control" value="<?= e($winery['address'] ?? '') ?>">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Postcode</label>
                        <input type="text" name="postcode" class="form-control" value="<?= e($winery['postcode'] ?? '') ?>">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Nearest station</label>
                        <input type="text" name="nearest_station" class="form-control" value="<?= e($winery['nearest_station'] ?? '') ?>">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Distance (km)</label>
                        <input type="number" name="distance_km" class="form-control" value="<?= e($winery['distance_km'] ?? '') ?>">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Drive time (min)</label>
                        <input type="number" name="drive_time_min" class="form-control" value="<?= e($winery['drive_time_min'] ?? '') ?>">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Latitude</label>
                        <input type="text" name="lat" class="form-control" value="<?= e($winery['lat'] ?? '') ?>">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Longitude</label>
                        <input type="text" name="lng" class="form-control" value="<?= e($winery['lng'] ?? '') ?>">
                    </div>
                    <div class="col-12">
                        <label class="form-label">Google Maps URL</label>
                        <input type="url" name="google_maps_url" class="form-control" value="<?= e($winery['google_maps_url'] ?? '') ?>">
                    </div>
                </div>
            </div>

            <!-- Content -->
            <div class="admin-card" style="margin-bottom:16px;">
                <div class="form-section-title">Content</div>
                <div class="row g-3">
                    <div class="col-12">
                        <label class="form-label fw-bold">Intro (card text, 300 chars max)</label>
                        <textarea name="intro" class="form-control" rows="3" maxlength="300"><?= e($winery['intro'] ?? '') ?></textarea>
                    </div>
                    <div class="col-12">
                        <label class="form-label">Body content (HTML)</label>
                        <textarea name="body_content" class="form-control font-monospace" rows="8" style="font-size:.85rem;"><?= e($winery['body_content'] ?? '') ?></textarea>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Benefit 1</label>
                        <input type="text" name="benefit_1" class="form-control" value="<?= e($winery['benefit_1'] ?? '') ?>">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Benefit 2</label>
                        <input type="text" name="benefit_2" class="form-control" value="<?= e($winery['benefit_2'] ?? '') ?>">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Benefit 3</label>
                        <input type="text" name="benefit_3" class="form-control" value="<?= e($winery['benefit_3'] ?? '') ?>">
                    </div>
                </div>
            </div>

            <!-- Visit details -->
            <div class="admin-card" style="margin-bottom:16px;">
                <div class="form-section-title">Visit Details</div>
                <div class="row g-3">
                    <div class="col-md-4">
                        <label class="form-label">Opening hours</label>
                        <input type="text" name="opening_hours" class="form-control" value="<?= e($winery['opening_hours'] ?? '') ?>">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Languages</label>
                        <input type="text" name="languages" class="form-control" value="<?= e($winery['languages'] ?? '') ?>" placeholder="EN / ES / CAT">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Price range</label>
                        <input type="text" name="price_range" class="form-control" value="<?= e($winery['price_range'] ?? '') ?>" placeholder="€15–25">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Rating (0–5)</label>
                        <input type="number" name="rating" class="form-control" step="0.1" min="0" max="5" value="<?= e($winery['rating'] ?? '') ?>">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Review count</label>
                        <input type="number" name="review_count" class="form-control" value="<?= e($winery['review_count'] ?? '') ?>">
                    </div>
                </div>
            </div>

            <!-- SEO -->
            <div class="admin-card" style="margin-bottom:16px;">
                <div class="form-section-title">SEO</div>
                <div class="row g-3">
                    <div class="col-12">
                        <label class="form-label">Meta title (max 70 chars)</label>
                        <input type="text" name="meta_title" class="form-control" maxlength="70" value="<?= e($winery['meta_title'] ?? '') ?>">
                    </div>
                    <div class="col-12">
                        <label class="form-label">Meta description (max 165 chars)</label>
                        <textarea name="meta_description" class="form-control" rows="2" maxlength="165"><?= e($winery['meta_description'] ?? '') ?></textarea>
                    </div>
                </div>
            </div>

            <!-- Links -->
            <div class="admin-card" style="margin-bottom:16px;">
                <div class="form-section-title">External Links & Affiliate</div>
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label">Website URL</label>
                        <input type="url" name="website_url" class="form-control" value="<?= e($winery['website_url'] ?? '') ?>">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Instagram URL</label>
                        <input type="url" name="instagram_url" class="form-control" value="<?= e($winery['instagram_url'] ?? '') ?>">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">GetYourGuide URL</label>
                        <input type="url" name="gyg_url" class="form-control" value="<?= e($winery['gyg_url'] ?? '') ?>">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Viator URL</label>
                        <input type="url" name="viator_url" class="form-control" value="<?= e($winery['viator_url'] ?? '') ?>">
                    </div>
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="col-lg-4">
            <!-- Publish -->
            <div class="admin-card" style="margin-bottom:16px;">
                <div class="form-section-title">Publish</div>
                <div class="form-check form-switch mb-2">
                    <input class="form-check-input" type="checkbox" name="is_published" id="is_published" <?= ($winery['is_published'] ?? 1) ? 'checked' : '' ?>>
                    <label class="form-check-label fw-bold" for="is_published">Published</label>
                </div>
                <div class="form-check form-switch mb-3">
                    <input class="form-check-input" type="checkbox" name="is_featured" id="is_featured" <?= ($winery['is_featured'] ?? 0) ? 'checked' : '' ?>>
                    <label class="form-check-label fw-bold" for="is_featured">Featured on homepage</label>
                </div>
                <button type="submit" class="btn btn-wine w-100"><i class="bi bi-check-lg"></i> Save winery</button>
                <?php if ($winery): ?>
                <div class="text-center mt-2" style="font-size:.78rem;color:var(--admin-muted);">
                    Last updated: <?= date('M j, Y H:i', strtotime($winery['updated_at'])) ?>
                </div>
                <?php endif; ?>
            </div>

            <!-- Features -->
            <div class="admin-card" style="margin-bottom:16px;">
                <div class="form-section-title">Features & Flags</div>
                <?php
                $flags = [
                    'no_car_needed'  => ['🚂', 'No car needed'],
                    'wine_tasting'   => ['🍷', 'Wine tasting'],
                    'cellar_tours'   => ['🏰', 'Cellar tours'],
                    'has_restaurant' => ['🍽️', 'Restaurant on site'],
                    'kids_welcome'   => ['👨‍👩‍👧', 'Family friendly'],
                    'organic'        => ['🌿', 'Organic / biodynamic'],
                    'accommodation'  => ['🛏️', 'Accommodation'],
                    'pet_friendly'   => ['🐕', 'Pet friendly'],
                    'wheelchair_accessible' => ['♿', 'Wheelchair accessible'],
                ];
                foreach ($flags as $field => [$icon, $label]):
                ?>
                <div class="form-check mb-2">
                    <input class="form-check-input" type="checkbox" name="<?= $field ?>" id="flag_<?= $field ?>" <?= ($winery[$field] ?? 0) ? 'checked' : '' ?>>
                    <label class="form-check-label" for="flag_<?= $field ?>"><?= $icon ?> <?= $label ?></label>
                </div>
                <?php endforeach; ?>
            </div>

            <!-- Danger zone -->
            <?php if ($winery): ?>
            <div class="admin-card" style="border-color:#f5c6cb;">
                <div class="form-section-title" style="color:#dc3545;">Danger zone</div>
                <form method="POST" action="/admin/delete" onsubmit="return confirm('Are you sure? This cannot be undone.')">
                    <input type="hidden" name="id" value="<?= $winery['id'] ?>">
                    <button type="submit" class="btn btn-outline-danger w-100"><i class="bi bi-trash"></i> Delete winery</button>
                </form>
            </div>
            <?php endif; ?>
        </div>
    </div>
</form>

<?php include __DIR__ . '/footer.php'; ?>
