<?php
require_once 'Database.php';

class Notification {
    private $conn;

    public function __construct() {
        $this->conn = Database::getInstance()->getConnection();
    }

    // Bildirim oluşturma
    public function create($userId, $actionType, $tableName, $recordId, $description) {
        $stmt = $this->conn->prepare("
            INSERT INTO notifications (user_id, action_type, table_name, record_id, description) 
            VALUES (?, ?, ?, ?, ?)
        ");
        $stmt->bind_param("issis", $userId, $actionType, $tableName, $recordId, $description);
        return $stmt->execute();
    }

    // Tüm bildirimleri getirme (admin için)
    public function getAll($limit = 50) {
        $stmt = $this->conn->prepare("
            SELECT n.*, u.name as user_name, u.email as user_email 
            FROM notifications n 
            JOIN users u ON n.user_id = u.id 
            ORDER BY n.created_at DESC 
            LIMIT ?
        ");
        $stmt->bind_param("i", $limit);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    // Okunmamış bildirimleri getirme
    public function getUnread($limit = 20) {
        $stmt = $this->conn->prepare("
            SELECT n.*, u.name as user_name, u.email as user_email 
            FROM notifications n 
            JOIN users u ON n.user_id = u.id 
            WHERE n.is_read = FALSE 
            ORDER BY n.created_at DESC 
            LIMIT ?
        ");
        $stmt->bind_param("i", $limit);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    // Okunmamış bildirim sayısını getirme
    public function getUnreadCount() {
        $stmt = $this->conn->prepare("SELECT COUNT(*) as count FROM notifications WHERE is_read = FALSE");
        $stmt->execute();
        $result = $stmt->get_result()->fetch_assoc();
        return $result['count'];
    }

    // Bildirimi okundu olarak işaretleme
    public function markAsRead($id) {
        $stmt = $this->conn->prepare("UPDATE notifications SET is_read = TRUE WHERE id = ?");
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }

    // Tüm bildirimleri okundu olarak işaretleme
    public function markAllAsRead() {
        $stmt = $this->conn->prepare("UPDATE notifications SET is_read = TRUE");
        return $stmt->execute();
    }

    // Eski bildirimleri temizleme (30 günden eski)
    public function cleanOldNotifications() {
        $stmt = $this->conn->prepare("
            DELETE FROM notifications 
            WHERE created_at < DATE_SUB(NOW(), INTERVAL 30 DAY)
        ");
        return $stmt->execute();
    }
    
    // Tek bildirimi silme
    public function deleteNotification($id) {
        $stmt = $this->conn->prepare("DELETE FROM notifications WHERE id = ?");
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }
    
    // Tüm bildirimleri silme
    public function deleteAllNotifications() {
        $stmt = $this->conn->prepare("DELETE FROM notifications");
        return $stmt->execute();
    }
}
