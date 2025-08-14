<?php
require_once __DIR__ . '/../app/controllers/ProductController.php';
require_once __DIR__ . '/../app/controllers/AuthController.php';
require_once __DIR__ . '/../app/middleware/Auth.php';

// Simple routing
$action = $_GET['action'] ?? 'index';
$id = $_GET['id'] ?? null;

// Authentication gerektirmeyen route'lar
$publicRoutes = ['login', 'register', 'forgot-password', 'reset-password']; 

if (!in_array($action, $publicRoutes)) {
    // Authentication kontrolü
    if (!Auth::check()) {
        header("Location: index.php?action=login");
        exit;
    }
    
    $controller = new ProductController();
} else {
    $authController = new AuthController();
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
            $controller->index();
            break;
        case 'update':
            if (!$id) {
                http_response_code(400);
                die("Product ID is required.");
            }
            $controller->update((int)$id);
            break;
        case 'edit':
            if (!$id) {
                http_response_code(400);
                die("Product ID is required.");
            }
            $controller->edit((int)$id);
            break;
        case 'add':
            $controller->add();
            break;
        case 'delete':
            if (!$id) {
                http_response_code(400);
                die("Product ID is required.");
            }
            $controller->delete((int)$id);
            break;
        case 'category':
            if (!$id) {
                http_response_code(400);
                die("Category ID is required.");
            }
            $controller->category((int)$id);
            break;
        case 'search':
            $controller->search();
            break;
        default:
            http_response_code(404);
            die("Page not found.");
    }
} catch (Exception $e) {
    http_response_code(500);
    die("An error occurred: " . $e->getMessage());
}
