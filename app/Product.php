<?php

class Product {
    private $conn;
    
    public function __construct($conn) {
        $this->conn = $conn;
    }
    
    public function getAll() {
        $stmt = $this->conn->prepare("
            SELECT p.id, p.product_name, p.category_id, p.stock_quantity, p.min_stock_level, 
                   p.unit, p.price, p.description, c.name as category_name, c.color as category_color
            FROM products p 
            LEFT JOIN categories c ON p.category_id = c.id 
            ORDER BY c.name ASC, p.product_name ASC
        ");
        $stmt->execute();
        return $stmt->get_result();
    }
    
    public function getByCategory($categoryId) {
        $stmt = $this->conn->prepare("
            SELECT p.id, p.product_name, p.category_id, p.stock_quantity, p.min_stock_level, 
                   p.unit, p.price, p.description, c.name as category_name, c.color as category_color
            FROM products p 
            LEFT JOIN categories c ON p.category_id = c.id 
            WHERE p.category_id = ?
            ORDER BY p.product_name ASC
        ");
        $stmt->bind_param("i", $categoryId);
        $stmt->execute();
        return $stmt->get_result();
    }
    
    public function getById($id) {
        $stmt = $this->conn->prepare("
            SELECT p.id, p.product_name, p.category_id, p.stock_quantity, p.min_stock_level, 
                   p.unit, p.price, p.description, c.name as category_name, c.color as category_color
            FROM products p 
            LEFT JOIN categories c ON p.category_id = c.id 
            WHERE p.id = ?
        ");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }
    
    public function findById($id) {
        return $this->getById($id);
    }
    
    public function updateStock($id, $soldQuantity) {
        $stmt = $this->conn->prepare("
            UPDATE products
            SET stock_quantity = stock_quantity - ?
            WHERE id = ? AND stock_quantity >= ?
        ");
        $stmt->bind_param("iii", $soldQuantity, $id, $soldQuantity);
        $stmt->execute();
        return $stmt->affected_rows === 1;
    }
    
    public function updateProduct($id, $productName, $categoryId, $stockQuantity, $minStockLevel, $unit, $price, $description) {
        $stmt = $this->conn->prepare("
            UPDATE products 
            SET product_name = ?, category_id = ?, stock_quantity = ?, min_stock_level = ?, 
                unit = ?, price = ?, description = ?
            WHERE id = ?
        ");
        $stmt->bind_param("siiisdsi", $productName, $categoryId, $stockQuantity, $minStockLevel, $unit, $price, $description, $id);
        return $stmt->execute();
    }
    
    public function addProduct($productName, $categoryId, $initialStock, $minStockLevel = 10, $unit = 'adet', $price = 0.00, $description = '') {
        $stmt = $this->conn->prepare("
            INSERT INTO products (product_name, category_id, stock_quantity, min_stock_level, unit, price, description) 
            VALUES (?, ?, ?, ?, ?, ?, ?)
        ");
        $stmt->bind_param("siiisds", $productName, $categoryId, $initialStock, $minStockLevel, $unit, $price, $description);
        return $stmt->execute();
    }
    
    public function create($productName, $categoryId, $initialStock, $minStockLevel = 10, $unit = 'adet', $price = 0.00, $description = '') {
        $stmt = $this->conn->prepare("
            INSERT INTO products (product_name, category_id, stock_quantity, min_stock_level, unit, price, description) 
            VALUES (?, ?, ?, ?, ?, ?, ?)
        ");
        $stmt->bind_param("siiisds", $productName, $categoryId, $initialStock, $minStockLevel, $unit, $price, $description);
        $stmt->execute();
        return $stmt->insert_id;
    }
    
    public function deleteProduct($id) {
        $stmt = $this->conn->prepare("DELETE FROM products WHERE id = ?");
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }
    
    public function getLowStockProducts() {
        $stmt = $this->conn->prepare("
            SELECT p.id, p.product_name, p.category_id, p.stock_quantity, p.min_stock_level, 
                   p.unit, p.price, p.description, c.name as category_name, c.color as category_color
            FROM products p 
            LEFT JOIN categories c ON p.category_id = c.id 
            WHERE p.stock_quantity <= p.min_stock_level
            ORDER BY p.stock_quantity ASC
        ");
        $stmt->execute();
        return $stmt->get_result();
    }
    
    public function getTotalStockValue() {
        $stmt = $this->conn->prepare("
            SELECT SUM(stock_quantity * price) as total_value 
            FROM products
        ");
        $stmt->execute();
        $result = $stmt->get_result()->fetch_assoc();
        return $result['total_value'] ?? 0;
    }
    
    public function search($query) {
        $searchTerm = '%' . $query . '%';
        $stmt = $this->conn->prepare("
            SELECT p.id, p.product_name, p.category_id, p.stock_quantity, p.min_stock_level, 
                   p.unit, p.price, p.description, c.name as category_name, c.color as category_color
            FROM products p 
            LEFT JOIN categories c ON p.category_id = c.id 
            WHERE p.product_name LIKE ? OR p.description LIKE ? OR c.name LIKE ?
            ORDER BY 
                CASE 
                    WHEN p.product_name LIKE ? THEN 1
                    WHEN p.product_name LIKE ? THEN 2
                    ELSE 3
                END,
                p.product_name ASC
            LIMIT 10
        ");
        
        $exactMatch = $query . '%';
        $stmt->bind_param("sssss", $searchTerm, $searchTerm, $searchTerm, $exactMatch, $searchTerm);
        $stmt->execute();
        return $stmt->get_result();
    }
    
    public function getConnection() {
        return $this->conn;
    }
}
