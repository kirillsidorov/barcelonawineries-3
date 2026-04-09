<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login — <?= e(SITE_NAME) ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background: #f5f3f0; height: 100vh; display: flex; align-items: center; }
        .login-card { border: 1px solid #e5e0d8; border-radius: 12px; background: #fff; }
        .btn-wine { background: #8b2332; color: #fff; border: none; }
        .btn-wine:hover { background: #6b1825; color: #fff; }
    </style>
</head>
<body>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-4">
            <div class="text-center mb-4">
                <div style="font-weight:800;font-size:1.3rem;color:#1a1714;"><?= e(SITE_NAME) ?></div>
                <div style="font-size:.84rem;color:#766d63;">Content Management</div>
            </div>
            <div class="card login-card p-4">
                <h4 class="text-center mb-4" style="font-weight:700;">Sign in</h4>
                <?php if (!empty($error)): ?>
                <div class="alert alert-danger py-2 small"><?= e($error) ?></div>
                <?php endif; ?>
                <form action="/admin/login" method="POST">
                    <div class="mb-3">
                        <label class="form-label small fw-bold">Username</label>
                        <input type="text" name="user" class="form-control" required autofocus>
                    </div>
                    <div class="mb-4">
                        <label class="form-label small fw-bold">Password</label>
                        <input type="password" name="pass" class="form-control" required>
                    </div>
                    <button type="submit" class="btn btn-wine btn-lg w-100">Sign in</button>
                </form>
            </div>
            <div class="text-center mt-3">
                <a href="/" style="font-size:.84rem;color:#766d63;text-decoration:none;">← Back to site</a>
            </div>
        </div>
    </div>
</div>
</body>
</html>
