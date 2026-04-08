<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | <?= SITE_NAME ?></title> <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background-color: #f4f7f6; height: 100vh; display: flex; align-items: center; }
        .login-card { border: none; border-radius: 15px; box-shadow: 0 10px 30px rgba(0,0,0,0.1); }
        .btn-wine { background-color: #722f37; color: white; border: none; }
        .btn-wine:hover { background-color: #5a252c; color: white; }
        .brand-logo { color: #722f37; font-weight: 800; font-size: 1.5rem; text-decoration: none; }
    </style>
</head>
<body>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-4">
            <div class="text-center mb-4">
                <a href="/" class="brand-logo"><?= SITE_NAME ?></a> <p class="text-muted">Content Management System</p>
            </div>
            
            <div class="card login-card p-4">
                <h4 class="text-center mb-4">Admin Access</h4>
                
                <?php if (isset($error)): ?>
                    <div class="alert alert-danger py-2 small"><?= $error ?></div>
                <?php endif; ?>

                <form action="/admin/login" method="POST">
                    <div class="mb-3">
                        <label class="form-label small fw-bold">Username</label>
                        <input type="text" name="user" class="form-control form-control-lg" placeholder="Enter username" required>
                    </div>
                    <div class="mb-4">
                        <label class="form-label small fw-bold">Password</label>
                        <input type="password" name="pass" class="form-control form-control-lg" placeholder="••••••••" required>
                    </div>
                    <button type="submit" class="btn btn-wine btn-lg w-100">Sign In</button>
                </form>
            </div>
            
            <div class="text-center mt-4">
                <a href="/" class="text-muted small text-decoration-none">← Back to website</a>
            </div>
        </div>
    </div>
</div>

</body>
</html>