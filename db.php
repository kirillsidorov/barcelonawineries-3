<?php
declare(strict_types=1);

require_once ROOT_PATH . '/config.php';
require_once ROOT_PATH . '/lib/Medoo.php'; // adjust if using Composer

use Medoo\Medoo;

/**
 * DB — Singleton wrapper around Medoo.
 *
 * Usage anywhere in the app:
 *   $db = DB::get();
 *   $winery = $db->get('wineries', '*', ['slug' => $slug]);
 */
final class DB
{
    private static ?Medoo $instance = null;

    public static function get(): Medoo
    {
        if (self::$instance === null) {
            try {
                self::$instance = new Medoo([
                    'type'     => 'mysql',
                    'host'     => DB_HOST,
                    'port'     => DB_PORT,
                    'database' => DB_NAME,
                    'username' => DB_USER,
                    'password' => DB_PASS,
                    'charset'  => DB_CHARSET,
                    'option'   => [
                        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                        PDO::ATTR_EMULATE_PREPARES   => false,
                        PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8mb4 COLLATE utf8mb4_unicode_ci",
                    ],
                    // Medoo logging — only in dev
                    'logging'  => DEBUG,
                ]);
            } catch (PDOException $e) {
                if (DEBUG) {
                    throw $e;
                }
                // In production: log quietly, show generic error
                error_log('DB connection failed: ' . $e->getMessage());
                http_response_code(503);
                die('Service temporarily unavailable.');
            }
        }

        return self::$instance;
    }

    // Prevent instantiation
    private function __construct() {}
    private function __clone() {}
}