<?php include __DIR__ . '/header.php'; ?>

<div class="container mt-4">
    <div class="row mb-4">
        <div class="col-12">
            <h2 class="display-6">Welcome, Admin!</h2>
            <p class="text-muted">Manage your Barcelona Wineries catalog and content from here.</p>
        </div>
    </div>

    <div class="row g-4">
        <div class="col-md-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body text-center">
                    <div class="display-4 text-primary mb-2">
                        <i class="bi bi-houses-fill"></i>
                    </div>
                    <h5 class="card-title">Wineries</h5>
                    <p class="card-text text-muted">Manage your master catalog of vineyards.</p>
                    <a href="/admin/wineries" class="btn btn-primary w-100">Manage Wineries</a>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body text-center">
                    <div class="display-4 text-success mb-2">
                        <i class="bi bi-geo-alt-fill"></i>
                    </div>
                    <h5 class="card-title">Regions</h5>
                    <p class="card-text text-muted">Edit DO descriptions and SEO for wine regions.</p>
                    <a href="#" class="btn btn-outline-success w-100 disabled">Manage Regions</a>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body text-center">
                    <div class="display-4 text-warning mb-2">
                        <i class="bi bi-google"></i>
                    </div>
                    <h5 class="card-title">Sitemap & Robots</h5>
                    <p class="card-text text-muted">Check your SEO files and global settings.</p>
                    <a href="/sitemap.xml" target="_blank" class="btn btn-outline-warning w-100">View Sitemap</a>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-5">
        <div class="col-md-8">
            <div class="card border-0 shadow-sm p-4">
                <h5><i class="bi bi-lightning-charge"></i> Quick Actions</h5>
                <hr>
                <div class="d-grid gap-2 d-md-block">
                    <a href="/admin/edit" class="btn btn-success me-2">
                        <i class="bi bi-plus-circle"></i> Add New Winery
                    </a>
                    <a href="/" target="_blank" class="btn btn-outline-secondary">
                        <i class="bi bi-eye"></i> View Live Site
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include __DIR__ . '/footer.php'; ?>