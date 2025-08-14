# ☕ Hanzade Cafe - Stok Yönetim Sistemi

Modern ve kullanıcı dostu bir cafe stok yönetim sistemi. PHP, MySQL ve Bootstrap 5 kullanılarak geliştirilmiştir.

## 🚀 Özellikler

### 📊 Dashboard
- **İstatistik Kartları**: Toplam ürün, düşük stok, kategori sayısı, toplam stok değeri
- **Gerçek Zamanlı Veriler**: Anlık stok durumu ve uyarılar
- **Responsive Tasarım**: Mobil ve masaüstü uyumlu

### 🔍 Arama Sistemi
- **Akıllı Arama**: Ürün adı, kategori ve açıklamada arama
- **Gerçek Zamanlı Öneriler**: AJAX ile anında sonuçlar
- **Animasyonlu Arayüz**: Modern ve kullanıcı dostu

### 📦 Ürün Yönetimi
- **Kategori Sistemi**: İçecekler, Yemekler, Tatlılar, Kahvaltı, Diğer
- **Stok Takibi**: Minimum stok seviyesi uyarıları
- **Fiyat Yönetimi**: Birim fiyat ve toplam değer hesaplama
- **CRUD İşlemleri**: Ekleme, düzenleme, silme, görüntüleme

### 🔐 Güvenlik
- **Kullanıcı Kimlik Doğrulama**: Login/Register sistemi
- **Şifre Hashleme**: Bcrypt ile güvenli şifre saklama
- **Oturum Yönetimi**: Güvenli session kontrolü
- **Middleware**: Yetkilendirme kontrolü

### 🎨 Kullanıcı Arayüzü
- **Bootstrap 5**: Modern ve responsive tasarım
- **Font Awesome**: İkonlar ve görsel zenginlik
- **Özel CSS**: Kategori renkleri ve hover efektleri
- **Modal Dialoglar**: Kullanıcı dostu onay ekranları

## 🛠️ Teknolojiler

- **Backend**: PHP 8.0+
- **Veritabanı**: MySQL 5.7+
- **Frontend**: HTML5, CSS3, JavaScript (ES6+)
- **Framework**: Bootstrap 5.3.0
- **İkonlar**: Font Awesome 6.0.0
- **Mimari**: MVC Pattern

## 📋 Gereksinimler

- PHP 8.0 veya üzeri
- MySQL 5.7 veya üzeri
- Apache/Nginx web sunucusu
- Composer (opsiyonel)

## 🚀 Kurulum

### 1. Projeyi İndirin
```bash
git clone https://github.com/ibrahimdvn/hanzade-cafe.git
cd hanzade-cafe
```

### 2. Veritabanını Kurun
- MySQL'de `hanzade_inventory` adında veritabanı oluşturun
- `setup.sql` dosyasını çalıştırın

### 3. Veritabanı Bağlantısını Yapılandırın
`app/Database.php` dosyasında veritabanı bilgilerini güncelleyin:
```php
private $host = 'localhost';
private $db_name = 'hanzade_inventory';
private $username = 'your_username';
private $password = 'your_password';
```

### 4. Web Sunucusunu Başlatın
```bash
php -S localhost:8000 -t public
```

### 5. Tarayıcıda Açın
```
http://localhost:8000
```

## 👤 Varsayılan Kullanıcı

- **Email**: admin@hanzade.com
- **Şifre**: admin123

## 📁 Proje Yapısı

```
hanzade-cafe/
├── app/
│   ├── controllers/
│   │   ├── ProductController.php
│   │   └── AuthController.php
│   ├── middleware/
│   │   └── Auth.php
│   ├── Database.php
│   ├── Product.php
│   ├── Category.php
│   └── User.php
├── resources/
│   └── views/
│       ├── index.php
│       ├── add.php
│       ├── update.php
│       ├── category.php
│       └── auth/
│           ├── login.php
│           ├── register.php
│           ├── forgot-password.php
│           └── reset-password.php
├── public/
│   ├── index.php
│   └── .htaccess
├── setup.sql
└── README.md
```

## 🎯 Özellik Detayları

### Kategori Sistemi
- **İçecekler**: Mor renk (#6f42c1)
- **Yemekler**: Kırmızı renk (#dc3545)
- **Tatlılar**: Sarı renk (#ffc107)
- **Kahvaltı**: Mavi renk (#17a2b8)
- **Diğer**: Turuncu renk (#fd7e14)

### Arama Özellikleri
- Minimum 2 karakter ile arama
- 300ms debounce ile performans optimizasyonu
- Kategori ve fiyat bilgisi ile sonuçlar
- Tıklanabilir sonuçlar (ürün düzenleme sayfasına yönlendirme)

### Güvenlik Özellikleri
- SQL Injection koruması (Prepared Statements)
- XSS koruması (htmlspecialchars)
- CSRF koruması (Session tabanlı)
- Şifre hashleme (Bcrypt)

## 🔧 Geliştirme

### Yeni Özellik Ekleme
1. Model dosyasını oluşturun (`app/` klasöründe)
2. Controller dosyasını oluşturun (`app/controllers/` klasöründe)
3. View dosyasını oluşturun (`resources/views/` klasöründe)
4. Route'u ekleyin (`public/index.php` dosyasında)

### Veritabanı Değişiklikleri
1. `setup.sql` dosyasını güncelleyin
2. Migration script'i oluşturun (gerekirse)
3. Model dosyalarını güncelleyin

## 📝 Lisans

Bu proje MIT lisansı altında lisanslanmıştır.

## 👨‍💻 Geliştirici

**İbrahim Devran**
- GitHub: [@ibrahimdvn](https://github.com/ibrahimdvn)
- Email: ibrahim@hanzade.com

## 🤝 Katkıda Bulunma

1. Fork edin
2. Feature branch oluşturun (`git checkout -b feature/AmazingFeature`)
3. Commit edin (`git commit -m 'Add some AmazingFeature'`)
4. Push edin (`git push origin feature/AmazingFeature`)
5. Pull Request oluşturun

## 📞 İletişim

Proje ile ilgili sorularınız için:
- GitHub Issues: [Proje Issues](https://github.com/ibrahimdvn/hanzade-cafe/issues)
- Email: ibrahim@hanzade.com

---

⭐ Bu projeyi beğendiyseniz yıldız vermeyi unutmayın!
