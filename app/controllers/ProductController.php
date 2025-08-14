<?php
// Use absolute paths
$basePath = dirname(dirname(__DIR__));
require_once $basePath . '/app/Database.php';
require_once $basePath . '/app/Product.php';
require_once $basePath . '/app/Category.php';
require_once $basePath . '/app/middleware/Auth.php';

class ProductController {
    private $product;
    private $category;
    
    public function __construct() {
        // Authentication kontrolü
        Auth::requireAuth();
        
        $db = Database::getInstance();
        $this->product = new Product($db->getConnection());
        $this->category = new Category($db->getConnection());
    }
    
    public function index() {
        $products = $this->product->getAll();
        $categories = $this->category->getAll();
        $lowStockProducts = $this->product->getLowStockProducts();
        $totalStockValue = $this->product->getTotalStockValue();
        
        include __DIR__ . '/../../resources/views/index.php';
    }
    
    public function update($id) {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $sold_quantity = isset($_POST['sold_quantity']) ? (int)$_POST['sold_quantity'] : 0;
            
            if ($sold_quantity <= 0) {
                $error = "Sold quantity must be a positive number.";
            } else {
                if ($this->product->updateStock($id, $sold_quantity)) {
                    $success = "Stok başarıyla güncellendi!";
                } else {
                    $error = "Not enough stock (or invalid product).";
                }
            }
        }
        
        $product = $this->product->getById($id);
        if (!$product) {
            http_response_code(404);
            die("Product not found.");
        }
        
        $categories = $this->category->getAll();
        include __DIR__ . '/../../resources/views/update.php';
    }
    
    public function edit($id) {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $product_name = trim($_POST['product_name'] ?? '');
            $category_id = (int)($_POST['category_id'] ?? 0);
            $stock_quantity = (int)($_POST['stock_quantity'] ?? 0);
            $min_stock_level = (int)($_POST['min_stock_level'] ?? 10);
            $unit = trim($_POST['unit'] ?? 'adet');
            $price = (float)($_POST['price'] ?? 0.00);
            $description = trim($_POST['description'] ?? '');
            
            if (empty($product_name)) {
                $error = "Product name is required.";
            } elseif ($category_id <= 0) {
                $error = "Please select a category.";
            } elseif ($stock_quantity < 0) {
                $error = "Stock quantity must be non-negative.";
            } else {
                if ($this->product->updateProduct($id, $product_name, $category_id, $stock_quantity, $min_stock_level, $unit, $price, $description)) {
                    $success = "Ürün bilgileri başarıyla güncellendi!";
                } else {
                    $error = "Failed to update product.";
                }
            }
        }
        
        $product = $this->product->getById($id);
        if (!$product) {
            http_response_code(404);
            die("Product not found.");
        }
        
        $categories = $this->category->getAll();
        include __DIR__ . '/../../resources/views/update.php';
    }
    
    public function add() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $product_name = trim($_POST['product_name'] ?? '');
            $category_id = (int)($_POST['category_id'] ?? 0);
            $initial_stock = (int)($_POST['initial_stock'] ?? 0);
            $min_stock_level = (int)($_POST['min_stock_level'] ?? 10);
            $unit = trim($_POST['unit'] ?? 'adet');
            $price = (float)($_POST['price'] ?? 0.00);
            $description = trim($_POST['description'] ?? '');
            
            if (empty($product_name)) {
                $error = "Product name is required.";
            } elseif ($category_id <= 0) {
                $error = "Please select a category.";
            } elseif ($initial_stock < 0) {
                $error = "Initial stock must be non-negative.";
            } else {
                if ($this->product->addProduct($product_name, $category_id, $initial_stock, $min_stock_level, $unit, $price, $description)) {
                    header("Location: index.php");
                    exit;
                } else {
                    $error = "Failed to add product.";
                }
            }
        }
        
        $categories = $this->category->getAll();
        include __DIR__ . '/../../resources/views/add.php';
    }
    
    public function delete($id) {
        if ($this->product->deleteProduct($id)) {
            header("Location: index.php");
            exit;
        } else {
            http_response_code(400);
            die("Failed to delete product.");
        }
    }
    
    public function category($categoryId) {
        $products = $this->product->getByCategory($categoryId);
        $category = $this->category->getById($categoryId);
        $categories = $this->category->getAll();
        
        if (!$category) {
            http_response_code(404);
            die("Category not found.");
        }
        
        include __DIR__ . '/../../resources/views/category.php';
    }
    
    public function search() {
        $query = $_GET['q'] ?? '';
        
        if (empty($query)) {
            echo json_encode([]);
            return;
        }
        
        $products = $this->product->search($query);
        $results = [];
        
        while ($product = $products->fetch_assoc()) {
            $results[] = [
                'id' => $product['id'],
                'product_name' => $product['product_name'],
                'category_name' => $product['category_name'],
                'price' => $product['price'],
                'stock_quantity' => $product['stock_quantity'],
                'unit' => $product['unit']
            ];
        }
        
        header('Content-Type: application/json');
        echo json_encode($results);
    }
}
