<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <title>Bildirimler - Hanzade Cafe</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/png" href="favicon-32x32.png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        .notification-item {
            transition: all 0.3s ease;
        }
        .notification-item:hover {
            background-color: #f8f9fa;
        }
        .notification-item.unread {
            background-color: #e3f2fd;
            border-left: 4px solid #2196f3;
        }
        .notification-time {
            font-size: 0.875rem;
            color: #6c757d;
        }
                 .action-badge {
             font-size: 0.75rem;
         }
         
                   /* Okundu badge'i için özel stil */
          .read-badge {
              display: inline-flex;
              align-items: center;
              justify-content: center;
              padding: 0.375rem 0.75rem;
              font-size: 0.75rem;
              font-weight: 500;
              line-height: 1;
              border-radius: 0.375rem;
              background-color: #198754;
              color: white;
              border: none;
              min-width: 70px;
              height: 32px;
          }
          
          .read-badge i {
              margin-right: 0.25rem;
              font-size: 0.7rem;
          }
          
          /* Silme butonu için özel stil - Okundu badge'i ile eşit boyut */
          .delete-btn {
              display: inline-flex;
              align-items: center;
              justify-content: center;
              padding: 0.375rem 0.75rem;
              font-size: 0.75rem;
              font-weight: 500;
              line-height: 1;
              border-radius: 0.375rem;
              border: 1px solid #dc3545;
              background-color: transparent;
              color: #dc3545;
              min-width: 32px;
              height: 32px;
              transition: all 0.2s ease;
          }
          
          .delete-btn:hover {
              background-color: #dc3545;
              color: white;
              border-color: #dc3545;
          }
          
          .delete-btn i {
              font-size: 0.7rem;
          }
        
        /* Sidebar Styles */
        .sidebar {
            min-height: 100vh;
            box-shadow: 2px 0 10px rgba(0,0,0,0.1);
        }
        
        .sidebar .nav-link {
            transition: all 0.3s ease;
            border-radius: 8px;
            margin: 0 8px;
        }
        
        .sidebar .nav-link:hover {
            background-color: rgba(255,255,255,0.1);
            transform: translateX(5px);
        }
        
        .sidebar .nav-link.active {
            background-color: rgba(255,255,255,0.15);
            box-shadow: 0 2px 8px rgba(0,0,0,0.2);
        }
        
        .sidebar .nav-link.active:hover {
            background-color: rgba(255,255,255,0.2);
        }
        
        .sidebar hr {
            border-color: rgba(255,255,255,0.2);
        }
        
        /* Logo hover effect */
        .sidebar a:hover {
            text-decoration: none;
        }
        
        .sidebar .fa-coffee {
            transition: all 0.3s ease;
        }
        
        .sidebar a:hover .fa-coffee {
            transform: scale(1.1);
            color: #ffc107 !important;
        }
    </style>
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <nav class="col-md-3 col-lg-2 d-md-block bg-dark sidebar collapse">
                <div class="position-sticky pt-3">
                    <!-- Logo/Brand -->
                    <div class="text-center mb-4">
                        <a href="index.php" class="text-decoration-none">
                            <img src="favicon-32x32.png" alt="Hanzade Cafe" style="width: 32px; height: 32px;" class="mb-2">
                            <h5 class="text-white mb-0">Hanzade Cafe</h5>
                            <small class="text-muted">Admin Panel</small>
                        </a>
                    </div>
                    
                    <!-- Navigation Menu -->
                    <ul class="nav flex-column">
                        <li class="nav-item mb-2">
                            <a class="nav-link text-white-50 d-flex align-items-center py-2 px-3 rounded" href="index.php">
                                <i class="fas fa-home me-3"></i>
                                <span>Ana Sayfa</span>
                            </a>
                        </li>
                        <li class="nav-item mb-2">
                            <a class="nav-link text-white d-flex align-items-center py-2 px-3 rounded active" 
                               style="background-color: rgba(255,255,255,0.1);" 
                               href="index.php?action=notifications">
                                <i class="fas fa-bell me-3"></i>
                                <span>Bildirimler</span>
                                <?php if ($unreadCount > 0): ?>
                                <span class="badge bg-danger ms-auto"><?php echo $unreadCount; ?></span>
                                <?php endif; ?>
                            </a>
                        </li>
                        <li class="nav-item mb-2">
                            <a class="nav-link text-white-50 d-flex align-items-center py-2 px-3 rounded" href="index.php?action=logout">
                                <i class="fas fa-sign-out-alt me-3"></i>
                                <span>Çıkış Yap</span>
                            </a>
                        </li>
                    </ul>
                    
                    <!-- Divider -->
                    <hr class="text-white-50 my-4">
                    
                    <!-- Quick Stats -->
                    <div class="px-3">
                        <h6 class="text-white-50 text-uppercase small mb-3">Hızlı İstatistikler</h6>
                        <div class="d-flex justify-content-between text-white-50 mb-2">
                            <small>Toplam Bildirim:</small>
                            <small><?php echo count($notifications); ?></small>
                        </div>
                        <div class="d-flex justify-content-between text-white-50 mb-2">
                            <small>Okunmamış:</small>
                            <small class="text-warning"><?php echo $unreadCount; ?></small>
                        </div>
                        <div class="d-flex justify-content-between text-white-50">
                            <small>Okunmuş:</small>
                            <small class="text-success"><?php echo count($notifications) - $unreadCount; ?></small>
                        </div>
                    </div>
                </div>
            </nav>

            <!-- Main content -->
            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                    <div>
                        <h1 class="h2 mb-1">
                            <i class="fas fa-bell me-2 text-primary"></i>
                            Bildirimler
                        </h1>
                        <p class="text-muted mb-0">Staff kullanıcılarının aktivitelerini takip edin</p>
                    </div>
                                         <div class="btn-toolbar mb-2 mb-md-0">
                         <div class="btn-group me-2">
                             <button type="button" class="btn btn-primary" onclick="markAllAsRead()">
                                 <i class="fas fa-check-double me-1"></i>
                                 Tümünü Okundu İşaretle
                             </button>
                             <button type="button" class="btn btn-danger" onclick="deleteAllNotifications()">
                                 <i class="fas fa-trash me-1"></i>
                                 Tümünü Sil
                             </button>
                         </div>
                     </div>
                </div>

                <?php if (empty($notifications)): ?>
                <div class="text-center py-5">
                    <div class="mb-4">
                        <i class="fas fa-bell-slash fa-4x text-muted"></i>
                    </div>
                    <h4 class="text-muted mb-2">Henüz bildirim bulunmuyor</h4>
                    <p class="text-muted">Staff kullanıcıları işlem yaptığında burada görünecek</p>
                </div>
                <?php else: ?>
                <div class="row">
                    <div class="col-12">
                        <div class="card shadow-sm">
                            <div class="card-header bg-white">
                                <div class="d-flex justify-content-between align-items-center">
                                    <h6 class="mb-0">
                                        <i class="fas fa-list me-2"></i>
                                        Bildirim Listesi
                                    </h6>
                                    <span class="badge bg-primary"><?php echo count($notifications); ?> bildirim</span>
                                </div>
                            </div>
                            <div class="card-body p-0">
                                <div class="list-group list-group-flush">
                                    <?php foreach ($notifications as $notification): ?>
                                    <div class="list-group-item notification-item <?php echo $notification['is_read'] ? '' : 'unread'; ?>" 
                                         data-id="<?php echo $notification['id']; ?>">
                                        <div class="d-flex justify-content-between align-items-start">
                                            <div class="flex-grow-1">
                                                <div class="d-flex align-items-center mb-2">
                                                    <span class="badge bg-<?php echo getActionColor($notification['action_type']); ?> action-badge me-2">
                                                        <i class="fas fa-<?php echo getActionIcon($notification['action_type']); ?> me-1"></i>
                                                        <?php echo getActionText($notification['action_type']); ?>
                                                    </span>
                                                    <strong class="text-primary"><?php echo htmlspecialchars($notification['user_name']); ?></strong>
                                                    <?php if (!$notification['is_read']): ?>
                                                    <span class="badge bg-warning ms-2">Yeni</span>
                                                    <?php endif; ?>
                                                </div>
                                                <p class="mb-2 text-dark"><?php echo htmlspecialchars($notification['description']); ?></p>
                                                                                                 <small class="notification-time" data-timestamp="<?php echo strtotime($notification['created_at']); ?>">
                                                     <i class="fas fa-clock me-1"></i>
                                                     <span class="time-text"><?php echo formatDate($notification['created_at']); ?></span>
                                                 </small>
                                            </div>
                                                                                         <div class="d-flex gap-1">
                                                 <?php if (!$notification['is_read']): ?>
                                                 <button class="btn btn-sm btn-success" onclick="markAsRead(<?php echo $notification['id']; ?>)">
                                                     <i class="fas fa-check me-1"></i>
                                                     Okundu
                                                 </button>
                                                 <?php else: ?>
                                                 <span class="read-badge">
                                                     <i class="fas fa-check"></i>
                                                     Okundu
                                                 </span>
                                                 <?php endif; ?>
                                                                                                   <button class="delete-btn" onclick="deleteNotification(<?php echo $notification['id']; ?>)">
                                                      <i class="fas fa-trash"></i>
                                                  </button>
                                             </div>
                                        </div>
                                    </div>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <?php endif; ?>
            </main>
        </div>
    </div>

         <!-- Mark All As Read Confirmation Modal -->
     <div class="modal fade" id="markAllAsReadModal" tabindex="-1" aria-labelledby="markAllAsReadModalLabel" aria-hidden="true">
         <div class="modal-dialog modal-dialog-centered">
             <div class="modal-content">
                 <div class="modal-header bg-primary text-white">
                     <h5 class="modal-title" id="markAllAsReadModalLabel">
                         <i class="fas fa-check-double me-2"></i>Tümünü Okundu İşaretle
                     </h5>
                     <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                 </div>
                 <div class="modal-body">
                     <div class="text-center mb-3">
                         <i class="fas fa-bell fa-3x text-primary mb-3"></i>
                         <h5>Tüm bildirimleri okundu olarak işaretlemek istediğinizden emin misiniz?</h5>
                         <p class="text-muted">Bu işlem tüm okunmamış bildirimleri okundu olarak işaretleyecektir.</p>
                     </div>
                     <div class="alert alert-info">
                         <i class="fas fa-info-circle me-2"></i>
                         <strong><?php echo $unreadCount; ?> okunmamış bildirim</strong> okundu olarak işaretlenecektir.
                     </div>
                 </div>
                 <div class="modal-footer">
                     <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                         <i class="fas fa-times me-1"></i>İptal
                     </button>
                     <button type="button" class="btn btn-primary" onclick="confirmMarkAllAsRead()">
                         <i class="fas fa-check-double me-1"></i>Evet, Tümünü İşaretle
                     </button>
                 </div>
             </div>
         </div>
     </div>

     <!-- Delete Single Notification Modal -->
     <div class="modal fade" id="deleteNotificationModal" tabindex="-1" aria-labelledby="deleteNotificationModalLabel" aria-hidden="true">
         <div class="modal-dialog modal-dialog-centered">
             <div class="modal-content">
                 <div class="modal-header bg-danger text-white">
                     <h5 class="modal-title" id="deleteNotificationModalLabel">
                         <i class="fas fa-trash me-2"></i>Bildirimi Sil
                     </h5>
                     <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                 </div>
                 <div class="modal-body">
                     <div class="text-center mb-3">
                         <i class="fas fa-exclamation-triangle fa-3x text-danger mb-3"></i>
                         <h5>Bu bildirimi silmek istediğinizden emin misiniz?</h5>
                         <p class="text-muted">Bu işlem geri alınamaz.</p>
                     </div>
                     <div class="alert alert-warning">
                         <i class="fas fa-info-circle me-2"></i>
                         <strong>Seçilen bildirim</strong> kalıcı olarak silinecektir.
                     </div>
                 </div>
                 <div class="modal-footer">
                     <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                         <i class="fas fa-times me-1"></i>İptal
                     </button>
                     <button type="button" class="btn btn-danger" onclick="confirmDeleteNotification()">
                         <i class="fas fa-trash me-1"></i>Evet, Sil
                     </button>
                 </div>
             </div>
         </div>
     </div>

     <!-- Delete All Notifications Modal -->
     <div class="modal fade" id="deleteAllNotificationsModal" tabindex="-1" aria-labelledby="deleteAllNotificationsModalLabel" aria-hidden="true">
         <div class="modal-dialog modal-dialog-centered">
             <div class="modal-content">
                 <div class="modal-header bg-danger text-white">
                     <h5 class="modal-title" id="deleteAllNotificationsModalLabel">
                         <i class="fas fa-trash me-2"></i>Tüm Bildirimleri Sil
                     </h5>
                     <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                 </div>
                 <div class="modal-body">
                     <div class="text-center mb-3">
                         <i class="fas fa-exclamation-triangle fa-3x text-danger mb-3"></i>
                         <h5>Tüm bildirimleri silmek istediğinizden emin misiniz?</h5>
                         <p class="text-muted">Bu işlem geri alınamaz ve tüm bildirimler kalıcı olarak silinecektir.</p>
                     </div>
                     <div class="alert alert-danger">
                         <i class="fas fa-exclamation-triangle me-2"></i>
                         <strong><?php echo count($notifications); ?> bildirim</strong> kalıcı olarak silinecektir.
                     </div>
                 </div>
                 <div class="modal-footer">
                     <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                         <i class="fas fa-times me-1"></i>İptal
                     </button>
                     <button type="button" class="btn btn-danger" onclick="confirmDeleteAllNotifications()">
                         <i class="fas fa-trash me-1"></i>Evet, Tümünü Sil
                     </button>
                 </div>
             </div>
         </div>
     </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function markAsRead(id) {
            fetch('index.php?action=mark-as-read', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: 'id=' + id
            })
            .then(response => response.json())
            .then(data => {
                                 if (data.success) {
                     const item = document.querySelector(`[data-id="${id}"]`);
                     item.classList.remove('unread');
                     const button = item.querySelector('button');
                     if (button) {
                         // Butonu "Okundu" badge'i ile değiştir
                         const readBadge = document.createElement('span');
                         readBadge.className = 'read-badge';
                         readBadge.innerHTML = '<i class="fas fa-check"></i>Okundu';
                         button.parentNode.replaceChild(readBadge, button);
                     }
                     
                     // Bildirim sayısını güncelle
                     updateNotificationCount();
                 }
            });
        }

        let currentNotificationId = null;

        function markAllAsRead() {
            const modal = new bootstrap.Modal(document.getElementById('markAllAsReadModal'));
            modal.show();
        }

        function confirmMarkAllAsRead() {
            fetch('index.php?action=mark-all-as-read', {
                method: 'POST'
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Modal'ı kapat
                    const modal = bootstrap.Modal.getInstance(document.getElementById('markAllAsReadModal'));
                    modal.hide();
                    
                    // Sayfayı yenile
                    location.reload();
                }
            })
            .catch(error => {
                console.error('Hata:', error);
                alert('Bir hata oluştu. Lütfen tekrar deneyin.');
            });
        }

        function deleteNotification(id) {
            currentNotificationId = id;
            const modal = new bootstrap.Modal(document.getElementById('deleteNotificationModal'));
            modal.show();
        }

        function confirmDeleteNotification() {
            if (!currentNotificationId) return;
            
            fetch('index.php?action=delete-notification', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: 'id=' + currentNotificationId
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Modal'ı kapat
                    const modal = bootstrap.Modal.getInstance(document.getElementById('deleteNotificationModal'));
                    modal.hide();
                    
                    // Bildirimi DOM'dan kaldır
                    const item = document.querySelector(`[data-id="${currentNotificationId}"]`);
                    if (item) {
                        item.remove();
                    }
                    
                    // Bildirim sayısını güncelle
                    updateNotificationCount();
                    
                    // Eğer hiç bildirim kalmadıysa sayfayı yenile
                    const remainingNotifications = document.querySelectorAll('.notification-item');
                    if (remainingNotifications.length === 0) {
                        location.reload();
                    }
                    
                    currentNotificationId = null;
                }
            })
            .catch(error => {
                console.error('Hata:', error);
                alert('Bir hata oluştu. Lütfen tekrar deneyin.');
            });
        }

        function deleteAllNotifications() {
            const modal = new bootstrap.Modal(document.getElementById('deleteAllNotificationsModal'));
            modal.show();
        }

        function confirmDeleteAllNotifications() {
            fetch('index.php?action=delete-all-notifications', {
                method: 'POST'
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Modal'ı kapat
                    const modal = bootstrap.Modal.getInstance(document.getElementById('deleteAllNotificationsModal'));
                    modal.hide();
                    
                    // Sayfayı yenile
                    location.reload();
                }
            })
            .catch(error => {
                console.error('Hata:', error);
                alert('Bir hata oluştu. Lütfen tekrar deneyin.');
            });
        }

        function updateNotificationCount() {
            fetch('index.php?action=get-unread-count')
            .then(response => response.json())
            .then(data => {
                const badge = document.querySelector('.badge');
                if (data.count > 0) {
                    if (badge) {
                        badge.textContent = data.count;
                    } else {
                        const link = document.querySelector('.nav-link.active');
                        link.innerHTML += `<span class="badge bg-danger ms-2">${data.count}</span>`;
                    }
                } else {
                    if (badge) badge.remove();
                }
            });
        }

                 // Zaman formatını güncelle
         function updateTimeDisplay() {
             const timeElements = document.querySelectorAll('.notification-time');
             const now = Math.floor(Date.now() / 1000);
             
             timeElements.forEach(element => {
                 const timestamp = parseInt(element.getAttribute('data-timestamp'));
                 const diff = now - timestamp; // Normal hesaplama
                 const timeText = element.querySelector('.time-text');
                 
                 let timeString;
                 if (diff < 60) {
                     timeString = 'Az önce';
                 } else if (diff < 3600) {
                     const minutes = Math.floor(diff / 60);
                     timeString = minutes + ' dakika önce';
                 } else if (diff < 86400) {
                     const hours = Math.floor(diff / 3600);
                     timeString = hours + ' saat önce';
                 } else if (diff < 604800) { // 7 gün
                     const days = Math.floor(diff / 86400);
                     timeString = days + ' gün önce';
                 } else if (diff < 2592000) { // 30 gün
                     const weeks = Math.floor(diff / 604800);
                     timeString = weeks + ' hafta önce';
                 } else {
                     const months = Math.floor(diff / 2592000);
                     timeString = months + ' ay önce';
                 }
                 
                 if (timeText) {
                     timeText.textContent = timeString;
                 }
             });
         }

                 // Sayfa yüklendiğinde bildirim sayısını güncelle ve zamanları güncelle
         document.addEventListener('DOMContentLoaded', function() {
             updateNotificationCount();
             updateTimeDisplay();
             
             // Her 2 saniyede bir zamanları güncelle (gerçek zamanlı)
             setInterval(updateTimeDisplay, 2000);
         });
    </script>
</body>
</html>

<?php
function getActionColor($actionType) {
    switch ($actionType) {
        case 'create': return 'success';
        case 'update': return 'primary';
        case 'delete': return 'danger';
        case 'stock_update': return 'warning';
        default: return 'secondary';
    }
}

function getActionText($actionType) {
    switch ($actionType) {
        case 'create': return 'Ekleme';
        case 'update': return 'Güncelleme';
        case 'delete': return 'Silme';
        case 'stock_update': return 'Stok Güncelleme';
        default: return 'Diğer';
    }
}

function getActionIcon($actionType) {
    switch ($actionType) {
        case 'create': return 'plus';
        case 'update': return 'edit';
        case 'delete': return 'trash';
        case 'stock_update': return 'warehouse';
        default: return 'info';
    }
}

function formatDate($date) {
    $timestamp = strtotime($date);
    $now = time();
    $diff = $now - $timestamp;
    
    if ($diff < 60) {
        return 'Az önce';
    } elseif ($diff < 3600) {
        $minutes = floor($diff / 60);
        return $minutes . ' dakika önce';
    } elseif ($diff < 86400) {
        $hours = floor($diff / 3600);
        return $hours . ' saat önce';
    } elseif ($diff < 604800) { // 7 gün
        $days = floor($diff / 86400);
        return $days . ' gün önce';
    } elseif ($diff < 2592000) { // 30 gün
        $weeks = floor($diff / 604800);
        return $weeks . ' hafta önce';
    } else {
        $months = floor($diff / 2592000);
        return $months . ' ay önce';
    }
}
?>
