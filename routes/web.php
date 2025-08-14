<?php

require_once __DIR__ . '/../app/Database.php';
require_once __DIR__ . '/../app/Product.php';

use App\Product;

// Simple router
$requestUri = $_SERVER['REQUEST_URI'];
$path = parse_url($requestUri, PHP_URL_PATH);
$path = trim($path, '/');

// Remove project folder from path if exists
$path = str_replace('hanzade-stock/', '', $path);

switch ($path) {
    case '':
    case 'index.php':
        require __DIR__ . '/../resources/views/index.php';
        break;
        
    case 'update':
        require __DIR__ . '/../resources/views/update.php';
        break;
        
    case 'add':
        require __DIR__ . '/../resources/views/add.php';
        break;
        
    default:
        http_response_code(404);
        echo "404 - Sayfa bulunamadı";
        break;
}
