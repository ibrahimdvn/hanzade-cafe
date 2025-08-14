<?php

class User {
    private $conn;
    
    public function __construct($conn) {
        $this->conn = $conn;
    }
    
    public function findByEmail($email) {
        $stmt = $this->conn->prepare("SELECT * FROM users WHERE email = ? AND is_active = 1");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }
    
    public function findById($id) {
        $stmt = $this->conn->prepare("SELECT * FROM users WHERE id = ? AND is_active = 1");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }
    
    public function create($name, $email, $password, $role = 'staff') {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $this->conn->prepare("
            INSERT INTO users (name, email, password, role) 
            VALUES (?, ?, ?, ?)
        ");
        $stmt->bind_param("ssss", $name, $email, $hashedPassword, $role);
        return $stmt->execute();
    }
    
    public function updateRememberToken($id, $token) {
        $stmt = $this->conn->prepare("UPDATE users SET remember_token = ? WHERE id = ?");
        $stmt->bind_param("si", $token, $id);
        return $stmt->execute();
    }
    
    public function findByRememberToken($token) {
        $stmt = $this->conn->prepare("SELECT * FROM users WHERE remember_token = ? AND is_active = 1");
        $stmt->bind_param("s", $token);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }
    
    public function updatePassword($id, $password) {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $this->conn->prepare("UPDATE users SET password = ? WHERE id = ?");
        $stmt->bind_param("si", $hashedPassword, $id);
        return $stmt->execute();
    }
    
    public function createPasswordResetToken($email, $token) {
        $stmt = $this->conn->prepare("
            INSERT INTO password_reset_tokens (email, token) 
            VALUES (?, ?) 
            ON DUPLICATE KEY UPDATE token = ?, created_at = CURRENT_TIMESTAMP
        ");
        $stmt->bind_param("sss", $email, $token, $token);
        return $stmt->execute();
    }
    
    public function findPasswordResetToken($token) {
        $stmt = $this->conn->prepare("
            SELECT * FROM password_reset_tokens 
            WHERE token = ? AND created_at > DATE_SUB(NOW(), INTERVAL 1 HOUR)
        ");
        $stmt->bind_param("s", $token);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }
    
    public function deletePasswordResetToken($email) {
        $stmt = $this->conn->prepare("DELETE FROM password_reset_tokens WHERE email = ?");
        $stmt->bind_param("s", $email);
        return $stmt->execute();
    }
    
    public function verifyPassword($password, $hashedPassword) {
        return password_verify($password, $hashedPassword);
    }
}
