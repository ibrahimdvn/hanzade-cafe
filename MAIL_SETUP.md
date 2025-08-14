# 📧 E-posta Kurulum Talimatları

## Gmail SMTP Ayarları

### 1. Gmail Hesabı Hazırlama

1. **Gmail hesabınızda 2 Adımlı Doğrulama'yı etkinleştirin:**
   - Gmail → Ayarlar → Güvenlik
   - "2 Adımlı Doğrulama" → Etkinleştir

2. **App Password oluşturun:**
   - Gmail → Ayarlar → Güvenlik
   - "Uygulama Şifreleri" → "Diğer" seçin
   - Uygulama adı: `Hanzade Cafe`
   - Oluşturulan 16 haneli şifreyi kopyalayın

### 2. Konfigürasyon Dosyasını Güncelleyin

`config/mail.php` dosyasını düzenleyin:

```php
<?php
return [
    'smtp' => [
        'host' => 'smtp.gmail.com',
        'port' => 587,
        'encryption' => 'tls',
        'username' => 'your_email@gmail.com', // Gmail adresiniz
        'password' => 'your_16_digit_app_password', // App Password
        'from_name' => 'Hanzade Cafe',
        'from_email' => 'your_email@gmail.com'
    ]
];
```

### 3. Test Etme

1. Projeyi çalıştırın: `php -S localhost:8000 -t public`
2. Şifremi Unuttum sayfasına gidin
3. E-posta adresinizi girin
4. "Şifre Sıfırlama Linki Gönder" butonuna tıklayın
5. E-postanızı kontrol edin

### 4. Güvenlik Notları

- ✅ App Password kullanın (normal şifre değil)
- ✅ 2 Adımlı Doğrulama zorunlu
- ✅ `config/mail.php` dosyasını `.gitignore`'a ekleyin
- ✅ Canlı ortamda environment variables kullanın

### 5. Alternatif SMTP Sağlayıcıları

**Gmail yerine kullanabileceğiniz alternatifler:**

- **Outlook/Hotmail:** `smtp-mail.outlook.com:587`
- **Yandex:** `smtp.yandex.com:587`
- **SendGrid:** `smtp.sendgrid.net:587`
- **Mailgun:** `smtp.mailgun.org:587`

### 6. Hata Ayıklama

Eğer e-posta gönderilmiyorsa:

1. **Gmail ayarlarını kontrol edin**
2. **App Password'ün doğru olduğundan emin olun**
3. **Firewall/antivirus ayarlarını kontrol edin**
4. **PHP error log'unu kontrol edin**

### 7. Canlı Ortam İçin

Hosting sağlayıcınızın SMTP ayarlarını kullanın:

```php
// Örnek: cPanel SMTP
'host' => 'mail.yourdomain.com',
'port' => 587,
'username' => 'noreply@yourdomain.com',
'password' => 'your_email_password'
```
