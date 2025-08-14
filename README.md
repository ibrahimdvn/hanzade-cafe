# ☕ Hanzade Cafe - Stok Yönetim Sistemi

Modern ve kullanıcı dostu bir cafe stok yönetim sistemi. PHP, MySQL ve Bootstrap 5 kullanılarak geliştirilmiştir.

## 🚀 Özellikler

### 📊 Dashboard
- **İstatistik Kartları**: Toplam ürün, düşük stok, kategori sayısı, toplam stok değeri
- **Gerçek Zamanlı Veriler**: Anlık stok durumu ve uyarılar
- **Responsive Tasarım**: Mobil ve masaüstü uyumlu
- **Düşük Stok Uyarıları**: Modal ile anlık bildirimler

### 🔍 Arama Sistemi
- **Akıllı Arama**: Ürün adı, kategori ve açıklamada arama
- **Gerçek Zamanlı Öneriler**: AJAX ile anında sonuçlar
- **Animasyonlu Arayüz**: Modern ve kullanıcı dostu
- **Otomatik Tamamlama**: Kullanıcı dostu arama deneyimi

### 📦 Ürün Yönetimi
- **Kategori Sistemi**: İçecekler, Yemekler, Tatlılar, Kahvaltı, Diğer
- **Stok Takibi**: Minimum stok seviyesi uyarıları
- **Fiyat Yönetimi**: 2025 güncel fiyatlarla birim fiyat ve toplam değer hesaplama
- **CRUD İşlemleri**: Ekleme, düzenleme, silme, görüntüleme
- **Kategori Filtreleme**: Hover efektli kategori butonları

### 🔔 Bildirim Sistemi
- **Gerçek Zamanlı Bildirimler**: Staff işlemlerinin admin'e bildirimi
- **Dinamik Zaman Gösterimi**: "Az önce", "5 dk önce" gibi akıllı zaman formatı
- **Bildirim Yönetimi**: Okundu işaretleme, tekli ve toplu silme
- **Admin Paneli**: Özel bildirim yönetim sayfası

### 🔐 Güvenlik
- **Kullanıcı Kimlik Doğrulama**: Login/Register sistemi
- **Şifre Hashleme**: Bcrypt ile güvenli şifre saklama
- **Oturum Yönetimi**: Güvenli session kontrolü
- **Middleware**: Yetkilendirme kontrolü
- **Rol Tabanlı Erişim**: Admin, Manager, Staff rolleri
- **Şifre Sıfırlama**: Email tabanlı şifre sıfırlama sistemi

### 🎨 Kullanıcı Arayüzü
- **Bootstrap 5**: Modern ve responsive tasarım
- **Font Awesome**: İkonlar ve görsel zenginlik
- **Özel CSS**: Kategori renkleri ve hover efektleri
- **Modal Dialoglar**: Kullanıcı dostu onay ekranları
- **Favicon**: Özel Hanzade Cafe ikonu
- **Animasyonlar**: Smooth geçişler ve hover efektleri

## 🛠️ Teknolojiler

- **Backend**: PHP 8.0+
- **Veritabanı**: MySQL 5.7+
- **Frontend**: HTML5, CSS3, JavaScript (ES6+)
- **Framework**: Bootstrap 5.3.0
- **İkonlar**: Font Awesome 6.0.0
- **Mimari**: MVC Pattern
- **Zaman Yönetimi**: Europe/Istanbul timezone

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
- `database/migrations/create_products_table.sql` dosyasını çalıştırın

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
│   │   ├── AuthController.php
│   │   └── NotificationController.php
│   ├── middleware/
│   │   └── Auth.php
│   ├── Database.php
│   ├── Product.php
│   ├── Category.php
│   ├── User.php
│   └── Notification.php
├── resources/
│   └── views/
│       ├── index.php
│       ├── add.php
│       ├── update.php
│       ├── category.php
│       ├── admin/
│       │   └── notifications.php
│       └── auth/
│           ├── login.php
│           ├── register.php
│           ├── forgot-password.php
│           └── reset-password.php
├── public/
│   ├── index.php
│   ├── .htaccess
│   └── favicon-32x32.png
├── database/
│   └── migrations/
│       └── create_products_table.sql
└── README.md
```

## 🎯 Özellik Detayları

### Kategori Sistemi
- **İçecekler**: Mor renk (#6f42c1)
- **Yemekler**: Kırmızı renk (#dc3545)
- **Tatlılar**: Sarı renk (#ffc107)
- **Kahvaltı**: Mavi renk (#17a2b8)
- **Diğer**: Turuncu renk (#fd7e14)

### 2025 Fiyat Yapısı
- **Kahve Çeşitleri**: ₺25-70 arası
- **İçecekler**: ₺25-55 arası
- **Tatlılar**: ₺22-85 arası
- **Kahvaltı**: ₺25-85 arası
- **Yemekler**: ₺16-45 arası
- **Minimum Fiyat**: ₺25.00

### Arama Özellikleri
- Minimum 2 karakter ile arama
- 300ms debounce ile performans optimizasyonu
- Kategori ve fiyat bilgisi ile sonuçlar
- Tıklanabilir sonuçlar (ürün düzenleme sayfasına yönlendirme)

### Bildirim Sistemi
- **Staff İşlemleri**: Ürün ekleme, güncelleme, silme işlemleri
- **Dinamik Zaman**: JavaScript ile gerçek zamanlı güncelleme
- **Admin Paneli**: Özel bildirim yönetim sayfası
- **Bildirim Türleri**: create, update, delete işlemleri

### Güvenlik Özellikleri
- SQL Injection koruması (Prepared Statements)
- XSS koruması (htmlspecialchars)
- CSRF koruması (Session tabanlı)
- Şifre hashleme (Bcrypt)
- Rol tabanlı yetkilendirme

## 🔧 Geliştirme

### Yeni Özellik Ekleme
1. Model dosyasını oluşturun (`app/` klasöründe)
2. Controller dosyasını oluşturun (`app/controllers/` klasöründe)
3. View dosyasını oluşturun (`resources/views/` klasöründe)
4. Route'u ekleyin (`public/index.php` dosyasında)

### Veritabanı Değişiklikleri
1. `database/migrations/` klasöründe migration dosyası oluşturun
2. Model dosyalarını güncelleyin
3. Gerekirse test script'i çalıştırın

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

## 🔄 Son Güncellemeler

### v2.1.0 (2025-08-14)
- ✅ 2025 güncel fiyat yapısı eklendi
- ✅ Bildirim sistemi geliştirildi
- ✅ Favicon implementasyonu tamamlandı
- ✅ Dinamik zaman gösterimi iyileştirildi
- ✅ Admin paneli bildirim yönetimi eklendi
- ✅ Kategori filtreleme sistemi güncellendi

### v2.0.0 (2025-08-13)
- ✅ Kullanıcı kimlik doğrulama sistemi
- ✅ Rol tabanlı yetkilendirme
- ✅ Şifre sıfırlama sistemi
- ✅ Bildirim sistemi
- ✅ Gelişmiş arama özellikleri

---

⭐ Bu projeyi beğendiyseniz yıldız vermeyi unutmayın!
