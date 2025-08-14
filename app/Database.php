<?php

class Database {
    private static $instance = null;
    private $conn;
    
    private function __construct() {
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "hanzade_inventory";
        
        mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
        
        try {
            $this->conn = new mysqli($servername, $username, $password, $dbname);
            $this->conn->set_charset("utf8mb4");
        } catch (Exception $e) {
            http_response_code(500);
            die("Database connection failed: " . $e->getMessage());
        }
    }
    
    public static function getInstance() {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }
    
    public function getConnection() {
        return $this->conn;
    }
    
    public function __destruct() {
        if ($this->conn) {
            $this->conn->close();
        }
    }
}
