<?php
// Use absolute paths
$basePath = dirname(dirname(__DIR__));
require_once $basePath . '/app/Database.php';
require_once $basePath . '/app/Notification.php';
require_once $basePath . '/app/middleware/Auth.php';

class NotificationController {
    private $notification;
    
    public function __construct() {
        // Sadece admin erişebilir
        Auth::requireAdmin();
        
        $this->notification = new Notification();
    }
    
    public function index() {
        $notifications = $this->notification->getAll();
        $unreadCount = $this->notification->getUnreadCount();
        
        include __DIR__ . '/../../resources/views/admin/notifications.php';
    }
    
    public function markAsRead() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = (int)($_POST['id'] ?? 0);
            
            if ($id > 0) {
                if ($this->notification->markAsRead($id)) {
                    echo json_encode(['success' => true]);
                } else {
                    echo json_encode(['success' => false, 'error' => 'Failed to mark as read']);
                }
            } else {
                echo json_encode(['success' => false, 'error' => 'Invalid ID']);
            }
        } else {
            http_response_code(405);
            echo json_encode(['success' => false, 'error' => 'Method not allowed']);
        }
    }
    
    public function markAllAsRead() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if ($this->notification->markAllAsRead()) {
                echo json_encode(['success' => true]);
            } else {
                echo json_encode(['success' => false, 'error' => 'Failed to mark all as read']);
            }
        } else {
            http_response_code(405);
            echo json_encode(['success' => false, 'error' => 'Method not allowed']);
        }
    }
    
    public function getUnreadCount() {
        $count = $this->notification->getUnreadCount();
        echo json_encode(['count' => $count]);
    }
    
    public function deleteNotification() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = (int)($_POST['id'] ?? 0);
            
            if ($id > 0) {
                if ($this->notification->deleteNotification($id)) {
                    echo json_encode(['success' => true]);
                } else {
                    echo json_encode(['success' => false, 'error' => 'Failed to delete notification']);
                }
            } else {
                echo json_encode(['success' => false, 'error' => 'Invalid ID']);
            }
        } else {
            http_response_code(405);
            echo json_encode(['success' => false, 'error' => 'Method not allowed']);
        }
    }
    
    public function deleteAllNotifications() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if ($this->notification->deleteAllNotifications()) {
                echo json_encode(['success' => true]);
            } else {
                echo json_encode(['success' => false, 'error' => 'Failed to delete all notifications']);
            }
        } else {
            http_response_code(405);
            echo json_encode(['success' => false, 'error' => 'Method not allowed']);
        }
    }
}
