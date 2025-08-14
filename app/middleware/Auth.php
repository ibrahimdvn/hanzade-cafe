<?php
$basePath = dirname(dirname(__DIR__));
require_once $basePath . '/app/Database.php';
require_once $basePath . '/app/User.php';

class Auth {
    private static $user = null;
    
    public static function check() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        
        // Session kontrolü
        if (isset($_SESSION['user_id'])) {
            $db = Database::getInstance();
            $userModel = new User($db->getConnection());
            self::$user = $userModel->findById($_SESSION['user_id']);
            return self::$user !== null;
        }
        
        // Remember token kontrolü
        if (isset($_COOKIE['remember_token'])) {
            $db = Database::getInstance();
            $userModel = new User($db->getConnection());
            $user = $userModel->findByRememberToken($_COOKIE['remember_token']);
            
            if ($user) {
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['user_name'] = $user['name'];
                $_SESSION['user_email'] = $user['email'];
                $_SESSION['user_role'] = $user['role'];
                self::$user = $user;
                return true;
            }
        }
        
        return false;
    }
    
    public static function user() {
        if (self::$user === null) {
            self::check();
        }
        return self::$user;
    }
    
    public static function id() {
        return self::user()['id'] ?? null;
    }
    
    public static function name() {
        return self::user()['name'] ?? null;
    }
    
    public static function email() {
        return self::user()['email'] ?? null;
    }
    
    public static function role() {
        return self::user()['role'] ?? null;
    }
    
    public static function isAdmin() {
        return self::role() === 'admin';
    }
    
    public static function isManager() {
        return in_array(self::role(), ['admin', 'manager']);
    }
    
    public static function requireAuth() {
        if (!self::check()) {
            header("Location: index.php?action=login");
            exit;
        }
    }
    
    public static function requireAdmin() {
        self::requireAuth();
        if (!self::isAdmin()) {
            http_response_code(403);
            die("Bu sayfaya erişim yetkiniz yok.");
        }
    }
    
    public static function requireManager() {
        self::requireAuth();
        if (!self::isManager()) {
            http_response_code(403);
            die("Bu sayfaya erişim yetkiniz yok.");
        }
    }
}
