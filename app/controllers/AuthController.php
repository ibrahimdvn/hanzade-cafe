<?php
$basePath = dirname(dirname(__DIR__));
require_once $basePath . '/app/Database.php';
require_once $basePath . '/app/User.php';

class AuthController {
    private $user;
    
    public function __construct() {
        $db = Database::getInstance();
        $this->user = new User($db->getConnection());
    }
    
    public function login() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = trim($_POST['email'] ?? '');
            $password = $_POST['password'] ?? '';
            $remember = isset($_POST['remember']);
            
            if (empty($email) || empty($password)) {
                $error = "Email ve şifre gereklidir.";
            } else {
                $user = $this->user->findByEmail($email);
                
                if ($user && $this->user->verifyPassword($password, $user['password'])) {
                    // Session başlat
                    if (session_status() === PHP_SESSION_NONE) {
                        session_start();
                    }
                    $_SESSION['user_id'] = $user['id'];
                    $_SESSION['user_name'] = $user['name'];
                    $_SESSION['user_email'] = $user['email'];
                    $_SESSION['user_role'] = $user['role'];
                    
                    // Remember me
                    if ($remember) {
                        $token = bin2hex(random_bytes(32));
                        $this->user->updateRememberToken($user['id'], $token);
                        setcookie('remember_token', $token, time() + (30 * 24 * 60 * 60), '/'); // 30 gün
                    }
                    
                    header("Location: index.php");
                    exit;
                } else {
                    $error = "Geçersiz email veya şifre.";
                }
            }
        }
        
        include __DIR__ . '/../../resources/views/auth/login.php';
    }
    
    public function register() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = trim($_POST['name'] ?? '');
            $email = trim($_POST['email'] ?? '');
            $password = $_POST['password'] ?? '';
            $password_confirm = $_POST['password_confirm'] ?? '';
            
            if (empty($name) || empty($email) || empty($password)) {
                $error = "Tüm alanlar gereklidir.";
            } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $error = "Geçerli bir email adresi girin.";
            } elseif (strlen($password) < 6) {
                $error = "Şifre en az 6 karakter olmalıdır.";
            } elseif ($password !== $password_confirm) {
                $error = "Şifreler eşleşmiyor.";
            } else {
                // Email kontrolü
                $existingUser = $this->user->findByEmail($email);
                if ($existingUser) {
                    $error = "Bu email adresi zaten kullanılıyor.";
                } else {
                    if ($this->user->create($name, $email, $password)) {
                        $success = "Kayıt başarılı! Şimdi giriş yapabilirsiniz.";
                    } else {
                        $error = "Kayıt sırasında bir hata oluştu.";
                    }
                }
            }
        }
        
        include __DIR__ . '/../../resources/views/auth/register.php';
    }
    
    public function logout() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        session_destroy();
        setcookie('remember_token', '', time() - 3600, '/');
        header("Location: index.php?action=login");
        exit;
    }
    
    public function forgotPassword() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = trim($_POST['email'] ?? '');
            
            if (empty($email)) {
                $error = "Email adresi gereklidir.";
            } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $error = "Geçerli bir email adresi girin.";
            } else {
                $user = $this->user->findByEmail($email);
                if ($user) {
                    $token = bin2hex(random_bytes(32));
                    $this->user->createPasswordResetToken($email, $token);
                    
                    // Burada normalde email gönderilir
                    // Şimdilik sadece başarı mesajı gösterelim
                    $success = "Şifre sıfırlama bağlantısı email adresinize gönderildi.";
                } else {
                    $error = "Bu email adresi ile kayıtlı kullanıcı bulunamadı.";
                }
            }
        }
        
        include __DIR__ . '/../../resources/views/auth/forgot-password.php';
    }
    
    public function resetPassword($token) {
        $resetToken = $this->user->findPasswordResetToken($token);
        
        if (!$resetToken) {
            $error = "Geçersiz veya süresi dolmuş şifre sıfırlama bağlantısı.";
            include __DIR__ . '/../../resources/views/auth/login.php';
            return;
        }
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $password = $_POST['password'] ?? '';
            $password_confirm = $_POST['password_confirm'] ?? '';
            
            if (empty($password)) {
                $error = "Yeni şifre gereklidir.";
            } elseif (strlen($password) < 6) {
                $error = "Şifre en az 6 karakter olmalıdır.";
            } elseif ($password !== $password_confirm) {
                $error = "Şifreler eşleşmiyor.";
            } else {
                $user = $this->user->findByEmail($resetToken['email']);
                if ($user && $this->user->updatePassword($user['id'], $password)) {
                    $this->user->deletePasswordResetToken($resetToken['email']);
                    $success = "Şifreniz başarıyla güncellendi! Şimdi giriş yapabilirsiniz.";
                    include __DIR__ . '/../../resources/views/auth/login.php';
                    return;
                } else {
                    $error = "Şifre güncellenirken bir hata oluştu.";
                }
            }
        }
        
        include __DIR__ . '/../../resources/views/auth/reset-password.php';
    }
}
