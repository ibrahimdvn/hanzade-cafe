<?php

class Category {
    private $conn;
    
    public function __construct($conn) {
        $this->conn = $conn;
    }
    
    public function getAll() {
        $stmt = $this->conn->prepare("SELECT id, name, description, color FROM categories ORDER BY name ASC");
        $stmt->execute();
        return $stmt->get_result();
    }
    
    public function getById($id) {
        $stmt = $this->conn->prepare("SELECT id, name, description, color FROM categories WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }
    
    public function create($name, $description = '', $color = '#667eea') {
        $stmt = $this->conn->prepare("INSERT INTO categories (name, description, color) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $name, $description, $color);
        $stmt->execute();
        return $stmt->insert_id;
    }
    
    public function update($id, $name, $description = '', $color = '#667eea') {
        $stmt = $this->conn->prepare("UPDATE categories SET name = ?, description = ?, color = ? WHERE id = ?");
        $stmt->bind_param("sssi", $name, $description, $color, $id);
        return $stmt->execute();
    }
    
    public function delete($id) {
        $stmt = $this->conn->prepare("DELETE FROM categories WHERE id = ?");
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }
    
    public function getProductCount($categoryId) {
        $stmt = $this->conn->prepare("SELECT COUNT(*) as count FROM products WHERE category_id = ?");
        $stmt->bind_param("i", $categoryId);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_assoc();
        return $result['count'];
    }
}
