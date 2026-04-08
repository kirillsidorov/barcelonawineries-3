<?php
declare(strict_types=1);

class AdminController {
    // Проверка авторизации
    private static function auth(): void {
        if (!isset($_SESSION['admin_logged_in'])) {
            header('Location: /admin/login');
            exit;
        }
    }

    public static function index(): void {
        self::auth();
        render('admin/dashboard', ['title' => 'Dashboard']);
    }

    public static function wineries(): void {
        self::auth();
        $db = DB::get(); //
        $wineries = $db->select('wineries', '*', ['ORDER' => ['id' => 'DESC']]); //
        render('admin/wineries_list', ['wineries' => $wineries]);
    }

    public static function edit(?string $id = null): void {
        self::auth();
        $db = DB::get();
        $winery = $id ? $db->get('wineries', '*', ['id' => $id]) : null; //
        $regions = $db->select('regions', ['id', 'name']); //
        
        render('admin/winery_form', [
            'winery' => $winery,
            'regions' => $regions
        ]);
    }

    public static function login(): void {
        // Если уже залогинен — отправляем в админку
        if (isset($_SESSION['admin_logged_in'])) {
            header('Location: /admin');
            exit;
        }

        $error = null;

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $user = $_POST['user'] ?? '';
            $pass = $_POST['pass'] ?? '';

            // Сверяем с данными из .env
            if ($user === getenv('ADMIN_USER') && $pass === getenv('ADMIN_PASS')) {
                $_SESSION['admin_logged_in'] = true;
                header('Location: /admin');
                exit;
            } else {
                $error = "Invalid username or password.";
            }
        }

        // Рендерим наш новый шаблон логина
        render('admin/login', ['error' => $error]);
    }

    public static function logout(): void {
        session_destroy();
        header('Location: /admin/login');
    }
}