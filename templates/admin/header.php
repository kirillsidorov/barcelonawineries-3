<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'Admin' ?> | <?= SITE_NAME ?></title> <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    
    <style>
        :root { --admin-sidebar-width: 240px; }
        body { background-color: #f8f9fa; }
        .navbar-brand { font-weight: 700; color: #722f37 !important; } /* Цвет вина */
        .nav-link.active { font-weight: 600; color: #722f37 !important; }
    </style>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark shadow-sm mb-4">
    <div class="container-fluid">
        <a class="navbar-brand px-3" href="/admin">
            <i class="bi bi-patch-check-fill"></i> <?= SITE_NAME ?> Admin </a>
        
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#adminNavbar">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="adminNavbar">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link" href="/admin"><i class="bi bi-speedometer2"></i> Dashboard</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/admin/wineries"><i class="bi bi-houses"></i> Wineries</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link disabled" href="#"><i class="bi bi-map"></i> Regions</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link disabled" href="#"><i class="bi bi-tags"></i> Categories</a>
                </li>
            </ul>
            
            <div class="d-flex align-items-center px-3">
                <span class="text-light me-3 small">Logged as Admin</span>
                <a href="/admin/logout" class="btn btn-outline-danger btn-sm">
                    <i class="bi bi-box-arrow-right"></i> Logout
                </a>
            </div>
        </div>
    </div>
</nav>