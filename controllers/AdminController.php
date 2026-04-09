<?php
declare(strict_types=1);

class AdminController
{
    // ── Auth ──────────────────────────────────────────────────
    private static function auth(): void
    {
        if (!isset($_SESSION['admin_logged_in'])) {
            header('Location: /admin/login');
            exit;
        }
    }

    // ── Dashboard ─────────────────────────────────────────────
    public static function index(): void
    {
        self::auth();
        $db = DB::get();

        $stats = [
            'wineries'   => $db->count('wineries'),
            'published'  => $db->count('wineries', ['is_published' => 1]),
            'featured'   => $db->count('wineries', ['is_featured' => 1]),
            'regions'    => $db->count('regions'),
            'categories' => $db->count('categories'),
        ];

        $recent = $db->select(
            'wineries',
            ['[>]regions' => ['region_id' => 'id']],
            ['wineries.id', 'wineries.name', 'wineries.slug', 'wineries.is_published',
             'wineries.updated_at', 'regions.name(region_name)'],
            ['ORDER' => ['wineries.updated_at' => 'DESC'], 'LIMIT' => 8]
        );

        render('admin/dashboard', [
            'title'  => 'Dashboard',
            'stats'  => $stats,
            'recent' => $recent,
        ]);
    }

    // ── Wineries List ─────────────────────────────────────────
    public static function wineries(): void
    {
        self::auth();
        $db = DB::get();

        $search = trim($_GET['q'] ?? '');
        $regionFilter = $_GET['region'] ?? '';
        $statusFilter = $_GET['status'] ?? '';

        $where = [];
        if ($search !== '') {
            $where['OR'] = [
                'wineries.name[~]' => $search,
                'wineries.city[~]' => $search,
                'wineries.slug[~]' => $search,
            ];
        }
        if ($regionFilter !== '') {
            $where['wineries.region_id'] = (int)$regionFilter;
        }
        if ($statusFilter === 'published') {
            $where['wineries.is_published'] = 1;
        } elseif ($statusFilter === 'draft') {
            $where['wineries.is_published'] = 0;
        }
        $where['ORDER'] = ['wineries.name' => 'ASC'];

        $wineries = $db->select(
            'wineries',
            ['[>]regions' => ['region_id' => 'id']],
            [
                'wineries.id', 'wineries.name', 'wineries.slug', 'wineries.city',
                'wineries.distance_km', 'wineries.is_published', 'wineries.is_featured',
                'wineries.no_car_needed', 'wineries.organic', 'wineries.has_restaurant',
                'wineries.rating', 'wineries.updated_at',
                'regions.name(region_name)',
            ],
            $where
        );

        $regions = $db->select('regions', ['id', 'name'], ['ORDER' => ['sort_order' => 'ASC']]);

        render('admin/wineries_list', [
            'title'        => 'Wineries',
            'wineries'     => $wineries,
            'regions'      => $regions,
            'search'       => $search,
            'regionFilter' => $regionFilter,
            'statusFilter' => $statusFilter,
        ]);
    }

    // ── Winery Edit Form ──────────────────────────────────────
    public static function edit(?string $id = null): void
    {
        self::auth();
        $db = DB::get();
        $winery = $id ? $db->get('wineries', '*', ['id' => (int)$id]) : null;
        $regions = $db->select('regions', ['id', 'name', 'slug'], ['ORDER' => ['sort_order' => 'ASC']]);

        render('admin/winery_form', [
            'title'   => $winery ? 'Edit: ' . $winery['name'] : 'Add New Winery',
            'winery'  => $winery,
            'regions' => $regions,
            'success' => $_GET['saved'] ?? null,
        ]);
    }

    // ── Winery Save ───────────────────────────────────────────
    public static function save(): void
    {
        self::auth();
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: /admin/wineries');
            exit;
        }

        $db = DB::get();
        $id = !empty($_POST['id']) ? (int)$_POST['id'] : null;

        $data = [
            'name'                 => trim($_POST['name'] ?? ''),
            'slug'                 => trim($_POST['slug'] ?? ''),
            'region_id'            => (int)($_POST['region_id'] ?? 0),
            'city'                 => trim($_POST['city'] ?? ''),
            'postcode'             => trim($_POST['postcode'] ?? ''),
            'address'              => trim($_POST['address'] ?? ''),
            'lat'                  => $_POST['lat'] !== '' ? (float)$_POST['lat'] : null,
            'lng'                  => $_POST['lng'] !== '' ? (float)$_POST['lng'] : null,
            'distance_km'          => $_POST['distance_km'] !== '' ? (int)$_POST['distance_km'] : null,
            'drive_time_min'       => $_POST['drive_time_min'] !== '' ? (int)$_POST['drive_time_min'] : null,
            'nearest_station'      => trim($_POST['nearest_station'] ?? ''),
            'intro'                => trim($_POST['intro'] ?? ''),
            'body_content'         => $_POST['body_content'] ?? '',
            'meta_title'           => trim($_POST['meta_title'] ?? ''),
            'meta_description'     => trim($_POST['meta_description'] ?? ''),
            'no_car_needed'        => isset($_POST['no_car_needed']) ? 1 : 0,
            'has_restaurant'       => isset($_POST['has_restaurant']) ? 1 : 0,
            'kids_welcome'         => isset($_POST['kids_welcome']) ? 1 : 0,
            'wine_tasting'         => isset($_POST['wine_tasting']) ? 1 : 0,
            'cellar_tours'         => isset($_POST['cellar_tours']) ? 1 : 0,
            'accommodation'        => isset($_POST['accommodation']) ? 1 : 0,
            'organic'              => isset($_POST['organic']) ? 1 : 0,
            'pet_friendly'         => isset($_POST['pet_friendly']) ? 1 : 0,
            'wheelchair_accessible'=> isset($_POST['wheelchair_accessible']) ? 1 : 0,
            'opening_hours'        => trim($_POST['opening_hours'] ?? ''),
            'languages'            => trim($_POST['languages'] ?? ''),
            'price_range'          => trim($_POST['price_range'] ?? ''),
            'website_url'          => trim($_POST['website_url'] ?? ''),
            'instagram_url'        => trim($_POST['instagram_url'] ?? ''),
            'google_maps_url'      => trim($_POST['google_maps_url'] ?? ''),
            'gyg_url'              => trim($_POST['gyg_url'] ?? ''),
            'viator_url'           => trim($_POST['viator_url'] ?? ''),
            'rating'               => $_POST['rating'] !== '' ? (float)$_POST['rating'] : null,
            'review_count'         => $_POST['review_count'] !== '' ? (int)$_POST['review_count'] : 0,
            'is_published'         => isset($_POST['is_published']) ? 1 : 0,
            'is_featured'          => isset($_POST['is_featured']) ? 1 : 0,
            'benefit_1'            => trim($_POST['benefit_1'] ?? ''),
            'benefit_2'            => trim($_POST['benefit_2'] ?? ''),
            'benefit_3'            => trim($_POST['benefit_3'] ?? ''),
        ];

        // Auto-generate slug if empty
        if (empty($data['slug']) && !empty($data['name'])) {
            $data['slug'] = slugify($data['name']);
        }

        if ($id) {
            $db->update('wineries', $data, ['id' => $id]);
        } else {
            $db->insert('wineries', $data);
            $id = (int)$db->id();
        }

        header("Location: /admin/edit?id={$id}&saved=1");
        exit;
    }

    // ── Winery Delete ─────────────────────────────────────────
    public static function delete(): void
    {
        self::auth();
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: /admin/wineries');
            exit;
        }

        $id = (int)($_POST['id'] ?? 0);
        if ($id > 0) {
            $db = DB::get();
            $db->delete('wineries', ['id' => $id]);
        }

        header('Location: /admin/wineries?deleted=1');
        exit;
    }

    // ── Toggle Publish/Featured ───────────────────────────────
    public static function toggle(): void
    {
        self::auth();
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: /admin/wineries');
            exit;
        }

        $id    = (int)($_POST['id'] ?? 0);
        $field = $_POST['field'] ?? '';
        $db    = DB::get();

        if ($id > 0 && in_array($field, ['is_published', 'is_featured'], true)) {
            $current = $db->get('wineries', $field, ['id' => $id]);
            $db->update('wineries', [$field => $current ? 0 : 1], ['id' => $id]);
        }

        // Return to referrer
        $ref = $_SERVER['HTTP_REFERER'] ?? '/admin/wineries';
        header("Location: {$ref}");
        exit;
    }

    // ── Regions List ──────────────────────────────────────────
    public static function regions(): void
    {
        self::auth();
        $db = DB::get();

        $regions = $db->select('regions', '*', ['ORDER' => ['sort_order' => 'ASC']]);

        // Count wineries per region
        foreach ($regions as &$r) {
            $r['winery_count'] = $db->count('wineries', [
                'region_id' => $r['id'],
                'is_published' => 1,
            ]);
        }
        unset($r);

        render('admin/regions_list', [
            'title'   => 'Regions',
            'regions' => $regions,
        ]);
    }

    // ── Region Edit ───────────────────────────────────────────
    public static function regionEdit(?string $id = null): void
    {
        self::auth();
        $db = DB::get();
        $region = $id ? $db->get('regions', '*', ['id' => (int)$id]) : null;

        render('admin/region_form', [
            'title'   => $region ? 'Edit: ' . $region['name'] : 'Add Region',
            'region'  => $region,
            'success' => $_GET['saved'] ?? null,
        ]);
    }

    // ── Region Save ───────────────────────────────────────────
    public static function regionSave(): void
    {
        self::auth();
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: /admin/regions');
            exit;
        }

        $db = DB::get();
        $id = !empty($_POST['id']) ? (int)$_POST['id'] : null;

        $data = [
            'name'             => trim($_POST['name'] ?? ''),
            'slug'             => trim($_POST['slug'] ?? ''),
            'description'      => trim($_POST['description'] ?? ''),
            'meta_description' => trim($_POST['meta_description'] ?? ''),
            'lat'              => $_POST['lat'] !== '' ? (float)$_POST['lat'] : null,
            'lng'              => $_POST['lng'] !== '' ? (float)$_POST['lng'] : null,
            'sort_order'       => (int)($_POST['sort_order'] ?? 0),
        ];

        if (empty($data['slug']) && !empty($data['name'])) {
            $data['slug'] = slugify($data['name']);
        }

        if ($id) {
            $db->update('regions', $data, ['id' => $id]);
        } else {
            $db->insert('regions', $data);
            $id = (int)$db->id();
        }

        header("Location: /admin/region-edit?id={$id}&saved=1");
        exit;
    }

    // ── Categories List ───────────────────────────────────────
    public static function categories(): void
    {
        self::auth();
        $db = DB::get();
        $categories = $db->select('categories', '*', ['ORDER' => ['sort_order' => 'ASC']]);

        render('admin/categories_list', [
            'title'      => 'Categories',
            'categories' => $categories,
        ]);
    }

    // ── Category Edit ─────────────────────────────────────────
    public static function categoryEdit(?string $id = null): void
    {
        self::auth();
        $db = DB::get();
        $category = $id ? $db->get('categories', '*', ['id' => (int)$id]) : null;

        render('admin/category_form', [
            'title'    => $category ? 'Edit: ' . $category['label'] : 'Add Category',
            'category' => $category,
            'success'  => $_GET['saved'] ?? null,
        ]);
    }

    // ── Category Save ─────────────────────────────────────────
    public static function categorySave(): void
    {
        self::auth();
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: /admin/categories');
            exit;
        }

        $db = DB::get();
        $id = !empty($_POST['id']) ? (int)$_POST['id'] : null;

        $data = [
            'label'            => trim($_POST['label'] ?? ''),
            'slug'             => trim($_POST['slug'] ?? ''),
            'description'      => trim($_POST['description'] ?? ''),
            'meta_description' => trim($_POST['meta_description'] ?? ''),
            'filter_column'    => trim($_POST['filter_column'] ?? ''),
            'sort_order'       => (int)($_POST['sort_order'] ?? 0),
        ];

        if (empty($data['slug']) && !empty($data['label'])) {
            $data['slug'] = slugify($data['label']);
        }

        if ($id) {
            $db->update('categories', $data, ['id' => $id]);
        } else {
            $db->insert('categories', $data);
            $id = (int)$db->id();
        }

        header("Location: /admin/category-edit?id={$id}&saved=1");
        exit;
    }

    // ── Login ─────────────────────────────────────────────────
    public static function login(): void
    {
        if (isset($_SESSION['admin_logged_in'])) {
            header('Location: /admin');
            exit;
        }

        $error = null;

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $user = $_POST['user'] ?? '';
            $pass = $_POST['pass'] ?? '';

            if ($user === getenv('ADMIN_USER') && $pass === getenv('ADMIN_PASS')) {
                $_SESSION['admin_logged_in'] = true;
                header('Location: /admin');
                exit;
            } else {
                $error = "Invalid username or password.";
            }
        }

        render('admin/login', ['error' => $error, 'title' => 'Login']);
    }

    // ── Logout ────────────────────────────────────────────────
    public static function logout(): void
    {
        session_destroy();
        header('Location: /admin/login');
    }
}
