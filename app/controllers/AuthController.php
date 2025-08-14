<?php
$basePath = dirname(dirname(__DIR__));
require_once $basePath . '/app/Database.php';
require_once $basePath . '/app/User.php';
require_once $basePath . '/vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

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
                    
                    // PHPMailer ile e-posta gönderimi
                    $resetLink = "http://" . $_SERVER['HTTP_HOST'] . "/index.php?action=reset-password&token=" . $token;
                    
                    $mail = new PHPMailer(true);
                    
                    try {
                        // Konfigürasyon dosyasını yükle
                        $config = include __DIR__ . '/../../config/mail.php';
                        
                        // SMTP ayarları
                        $mail->isSMTP();
                        $mail->Host = $config['smtp']['host'];
                        $mail->SMTPAuth = true;
                        $mail->Username = $config['smtp']['username'];
                        $mail->Password = $config['smtp']['password'];
                        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                        $mail->Port = $config['smtp']['port'];
                        $mail->CharSet = 'UTF-8';
                        
                        // Gönderici ve alıcı
                        $mail->setFrom($config['smtp']['from_email'], $config['smtp']['from_name']);
                        $mail->addAddress($email);
                        
                        // İçerik
                        $mail->isHTML(true);
                        $mail->Subject = 'Hanzade Cafe - Şifre Sıfırlama';
                        $mail->Body = "
                        <html>
                        <head>
                            <title>Şifre Sıfırlama</title>
                        </head>
                        <body style='font-family: Arial, sans-serif; line-height: 1.6; color: #333;'>
                            <div style='max-width: 600px; margin: 0 auto; padding: 20px;'>
                                <div style='text-align: center; margin-bottom: 30px;'>
                                    <h2 style='color: #667eea;'>Hanzade Cafe</h2>
                                    <h3 style='color: #764ba2;'>Stok Yönetim Sistemi</h3>
                                </div>
                                
                                <div style='background: #f8f9fa; padding: 30px; border-radius: 10px;'>
                                    <h3 style='color: #333; margin-bottom: 20px;'>Şifre Sıfırlama</h3>
                                    
                                    <p>Merhaba,</p>
                                    <p>Şifrenizi sıfırlamak için aşağıdaki butona tıklayın:</p>
                                    
                                    <div style='text-align: center; margin: 30px 0;'>
                                        <a href='{$resetLink}' style='background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; padding: 15px 30px; text-decoration: none; border-radius: 25px; font-weight: bold; display: inline-block;'>
                                            Şifremi Sıfırla
                                        </a>
                                    </div>
                                    
                                    <p style='font-size: 14px; color: #666;'>
                                        <strong>Önemli:</strong> Bu bağlantı 1 saat süreyle geçerlidir.
                                    </p>
                                    
                                    <p style='font-size: 14px; color: #666;'>
                                        Eğer bu isteği siz yapmadıysanız, bu e-postayı görmezden gelebilirsiniz.
                                    </p>
                                </div>
                                
                                <div style='text-align: center; margin-top: 30px; padding-top: 20px; border-top: 1px solid #eee;'>
                                    <p style='color: #666; font-size: 14px;'>
                                        Saygılarımızla,<br>
                                        <strong>Hanzade Cafe</strong>
                                    </p>
                                </div>
                            </div>
                        </body>
                        </html>
                        ";
                        
                        $mail->send();
                        $success = "Şifre sıfırlama bağlantısı email adresinize gönderildi.";
                        
                    } catch (Exception $e) {
                        // Geliştirme ortamında hata durumunda linki göster
                        if (isset($_SERVER['HTTP_HOST']) && strpos($_SERVER['HTTP_HOST'], 'localhost') !== false) {
                            $success = "E-posta gönderilemedi (SMTP ayarları gerekli). Şifre sıfırlama bağlantısı: <br><a href='{$resetLink}' target='_blank'>{$resetLink}</a>";
                        } else {
                            $error = "E-posta gönderilirken bir hata oluştu: " . $mail->ErrorInfo;
                        }
                    }
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
                    // Şifre başarıyla güncellendi, e-posta bildirimi gönder
                    $mail = new PHPMailer(true);
                    
                    try {
                        // Konfigürasyon dosyasını yükle
                        $config = include __DIR__ . '/../../config/mail.php';
                        
                        // SMTP ayarları
                        $mail->isSMTP();
                        $mail->Host = $config['smtp']['host'];
                        $mail->SMTPAuth = true;
                        $mail->Username = $config['smtp']['username'];
                        $mail->Password = $config['smtp']['password'];
                        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                        $mail->Port = $config['smtp']['port'];
                        $mail->CharSet = 'UTF-8';
                        
                        // Gönderici ve alıcı
                        $mail->setFrom($config['smtp']['from_email'], $config['smtp']['from_name']);
                        $mail->addAddress($resetToken['email']);
                        
                        // İçerik
                        $mail->isHTML(true);
                        $mail->Subject = 'Hanzade Cafe - Şifreniz Başarıyla Güncellendi';
                        $mail->Body = "
                        <html>
                        <head>
                            <title>Şifre Güncellendi</title>
                        </head>
                        <body style='font-family: Arial, sans-serif; line-height: 1.6; color: #333;'>
                            <div style='max-width: 600px; margin: 0 auto; padding: 20px;'>
                                <div style='text-align: center; margin-bottom: 30px;'>
                                    <h2 style='color: #667eea;'>Hanzade Cafe</h2>
                                    <h3 style='color: #764ba2;'>Stok Yönetim Sistemi</h3>
                                </div>
                                
                                <div style='background: #f8f9fa; padding: 30px; border-radius: 10px;'>
                                    <div style='text-align: center; margin-bottom: 20px;'>
                                        <div style='background: #28a745; color: white; width: 60px; height: 60px; border-radius: 50%; display: inline-flex; align-items: center; justify-content: center; font-size: 24px;'>
                                            ✓
                                        </div>
                                    </div>
                                    
                                    <h3 style='color: #333; margin-bottom: 20px; text-align: center;'>Şifreniz Başarıyla Güncellendi!</h3>
                                    
                                    <p>Merhaba {$user['name']},</p>
                                    <p>Hanzade Cafe Stok Yönetim Sistemi hesabınızın şifresi başarıyla güncellendi.</p>
                                    
                                    <div style='background: #e8f5e8; border-left: 4px solid #28a745; padding: 15px; margin: 20px 0; border-radius: 5px;'>
                                        <p style='margin: 0; color: #155724;'>
                                            <strong>Önemli:</strong> Artık yeni şifrenizle sisteme giriş yapabilirsiniz.
                                        </p>
                                    </div>
                                    
                                    <p style='font-size: 14px; color: #666;'>
                                        Eğer bu işlemi siz yapmadıysanız, lütfen hemen bizimle iletişime geçin.
                                    </p>
                                </div>
                                
                                <div style='text-align: center; margin-top: 30px; padding-top: 20px; border-top: 1px solid #eee;'>
                                    <p style='color: #666; font-size: 14px;'>
                                        Saygılarımızla,<br>
                                        <strong>Hanzade Cafe</strong>
                                    </p>
                                </div>
                            </div>
                        </body>
                        </html>
                        ";
                        
                        $mail->send();
                        
                    } catch (Exception $e) {
                        // E-posta gönderilemese bile şifre güncellendi, sadece log tutabiliriz
                        error_log("Şifre güncelleme bildirimi gönderilemedi: " . $mail->ErrorInfo);
                    }
                    
                    // Token'ı sil ve başarı mesajı göster
                    $this->user->deletePasswordResetToken($resetToken['email']);
                    $success = "Şifreniz başarıyla güncellendi! Yeni şifrenizle giriş yapabilirsiniz.";
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
