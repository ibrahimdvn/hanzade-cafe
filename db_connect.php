<?php
// Database credentials
$servername = "localhost";
$username = "root";      // XAMPP default
$password = "";          // XAMPP default
$dbname = "hanzade_inventory";

// Enable mysqli exceptions for better error messages during development
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

try {
    $conn = new mysqli($servername, $username, $password, $dbname);
    $conn->set_charset("utf8mb4");
} catch (Exception $e) {
    http_response_code(500);
    die("Database connection failed: " . $e->getMessage());
}
?>
