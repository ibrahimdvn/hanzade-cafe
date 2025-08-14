<?php
// Zaman dilimini ayarla
date_default_timezone_set('Europe/Istanbul');

require_once __DIR__ . '/../app/controllers/ProductController.php';
require_once __DIR__ . '/../app/controllers/AuthController.php';
require_once __DIR__ . '/../app/controllers/NotificationController.php';
require_once __DIR__ . '/../app/middleware/Auth.php';

// Simple routing
$action = $_GET['action'] ?? 'index';
$id = $_GET['id'] ?? null;

// Authentication gerektirmeyen route'lar
$publicRoutes = ['login', 'register', 'logout', 'forgot-password', 'reset-password']; 

// Controller'ları oluştur
$authController = new AuthController();
$controller = null; // Varsayılan olarak null

if (!in_array($action, $publicRoutes)) {
    // Authentication kontrolü
    if (!Auth::check()) {
        header("Location: index.php?action=login");
        exit;
    }
    
    $controller = new ProductController();
}

try {
    switch ($action) {
        // Authentication routes
        case 'login':
            $authController->login();
            break;
        case 'register':
            $authController->register();
            break;
        case 'logout':
            $authController->logout();
            break;
        case 'forgot-password':
            $authController->forgotPassword();
            break;
        case 'reset-password':
            $token = $_GET['token'] ?? '';
            if (!$token) {
                http_response_code(400);
                die("Reset token is required.");
            }
            $authController->resetPassword($token);
            break;
            
        // Product routes (require authentication)
        case 'index':
            if ($controller) {
                $controller->index();
            } else {
                http_response_code(403);
                die("Access denied.");
            }
            break;
        case 'update':
            if (!$id) {
                http_response_code(400);
                die("Product ID is required.");
            }
            if ($controller) {
                $controller->update((int)$id);
            } else {
                http_response_code(403);
                die("Access denied.");
            }
            break;
        case 'edit':
            if (!$id) {
                http_response_code(400);
                die("Product ID is required.");
            }
            if ($controller) {
                $controller->edit((int)$id);
            } else {
                http_response_code(403);
                die("Access denied.");
            }
            break;
        case 'add':
            if ($controller) {
                $controller->add();
            } else {
                http_response_code(403);
                die("Access denied.");
            }
            break;
        case 'delete':
            if (!$id) {
                http_response_code(400);
                die("Product ID is required.");
            }
            if ($controller) {
                $controller->delete((int)$id);
            } else {
                http_response_code(403);
                die("Access denied.");
            }
            break;
        case 'category':
            if (!$id) {
                http_response_code(400);
                die("Category ID is required.");
            }
            if ($controller) {
                $controller->category((int)$id);
            } else {
                http_response_code(403);
                die("Access denied.");
            }
            break;
        case 'search':
            if ($controller) {
                $controller->search();
            } else {
                http_response_code(403);
                die("Access denied.");
            }
            break;
        case 'notifications':
            $notificationController = new NotificationController();
            $notificationController->index();
            break;
        case 'mark-as-read':
            $notificationController = new NotificationController();
            $notificationController->markAsRead();
            break;
        case 'mark-all-as-read':
            $notificationController = new NotificationController();
            $notificationController->markAllAsRead();
            break;
        case 'get-unread-count':
            $notificationController = new NotificationController();
            $notificationController->getUnreadCount();
            break;
        case 'delete-notification':
            $notificationController = new NotificationController();
            $notificationController->deleteNotification();
            break;
        case 'delete-all-notifications':
            $notificationController = new NotificationController();
            $notificationController->deleteAllNotifications();
            break;
        default:
            http_response_code(404);
            die("Page not found.");
    }
} catch (Exception $e) {
    http_response_code(500);
    die("An error occurred: " . $e->getMessage());
}
