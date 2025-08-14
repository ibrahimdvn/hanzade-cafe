<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <title><?php echo htmlspecialchars($category['name']); ?> - Hanzade Cafe</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/png" href="favicon-32x32.png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        .navbar-brand {
            font-weight: bold;
            color: #2c3e50 !important;
        }
        .card {
            border: none;
            box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
            border-radius: 0.5rem;
        }
        .card-header {
            background-color: #f8f9fa;
            border-bottom: 1px solid #dee2e6;
            font-weight: 600;
        }
        .table th {
            border-top: none;
            font-weight: 600;
            color: #495057;
        }
        .btn-sm {
            padding: 0.25rem 0.5rem;
            font-size: 0.875rem;
        }
        .stock-low {
            background-color: #fff5f5;
            border-left: 4px solid #dc3545;
        }
        .stock-ok {
            border-left: 4px solid #28a745;
        }
        .category-badge {
            font-size: 0.75rem;
            padding: 0.25rem 0.5rem;
        }
        .category-filter {
            background: #f8f9fa;
            border-radius: 0.5rem;
            padding: 1rem;
            margin-bottom: 1rem;
        }
        .category-btn {
            margin: 0.25rem;
            border-radius: 20px;
            font-size: 0.875rem;
        }
        .category-btn.active {
            transform: scale(1.05);
        }
        .category-btn:hover {
            transform: scale(1.05);
            box-shadow: 0 0.25rem 0.5rem rgba(0, 0, 0, 0.15);
        }
        /* Kategori butonları için özel hover stilleri */
        .category-btn[style*="color: #28a745"]:hover,
        .category-btn[style*="border-color: #28a745"]:hover {
            background-color: #0A3D0A !important;
            color: white !important;
            border-color: #0A3D0A !important;
        }
        .category-btn[style*="color: #dc3545"]:hover {
            background-color: #dc3545 !important;
            color: white !important;
            border-color: #dc3545 !important;
        }
        .category-btn[style*="color: #ffc107"]:hover {
            background-color: #ffc107 !important;
            color: #212529 !important;
            border-color: #ffc107 !important;
        }
        .category-btn[style*="color: #17a2b8"]:hover {
            background-color: #17a2b8 !important;
            color: white !important;
            border-color: #17a2b8 !important;
        }
        .category-btn[style*="color: #fd7e14"]:hover {
            background-color: #fd7e14 !important;
            color: white !important;
            border-color: #fd7e14 !important;
        }
        .category-btn[style*="color: #6f42c1"]:hover {
            background-color: #6f42c1 !important;
            color: white !important;
            border-color: #6f42c1 !important;
        }
        
        /* Kategori butonları için kalıcı aktif durum */
        .category-btn.active-permanent {
            transform: scale(1.05);
            box-shadow: 0 0.25rem 0.5rem rgba(0, 0, 0, 0.15);
        }
        
        /* İçecekler kategorisi için özel stiller - normal durumda içi boş, hover'da dolu */
        .category-icecekler,
        .btn-outline-primary.category-icecekler,
        .btn.category-icecekler,
        .btn.btn-outline-primary.category-icecekler,
        a.category-icecekler,
        a.btn.category-icecekler,
        a.btn.btn-outline-primary.category-icecekler {
            background-color: transparent !important;
            color: #6f42c1 !important;
            border-color: #6f42c1 !important;
        }
        
        /* İçecekler kategorisi için özel hover stili - artık mor renk kullanıyor */
        .category-icecekler:hover,
        .category-icecekler.active:hover,
        .btn-outline-primary.category-icecekler:hover,
        .btn-outline-primary.category-icecekler.active:hover,
        .btn.category-icecekler:hover,
        .btn.category-icecekler.active:hover,
        .btn.btn-outline-primary.category-icecekler:hover,
        .btn.btn-outline-primary.category-icecekler.active:hover,
        a.category-icecekler:hover,
        a.category-icecekler.active:hover,
        a.btn.category-icecekler:hover,
        a.btn.category-icecekler.active:hover,
        a.btn.btn-outline-primary.category-icecekler:hover,
        a.btn.btn-outline-primary.category-icecekler.active:hover {
            background-color: #6f42c1 !important;
            color: white !important;
            border-color: #6f42c1 !important;
        }
        
        /* Arama Çubuğu Stilleri */
        .search-section {
            margin-top: 2rem;
        }
        
        .search-container {
            position: relative;
            max-width: 600px;
            margin: 0 auto;
        }
        
        .search-box {
            position: relative;
            display: flex;
            align-items: center;
            background: white;
            border-radius: 50px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
            overflow: hidden;
        }
        
        .search-box:focus-within {
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.15);
            transform: translateY(-2px);
        }
        
        .search-input {
            flex: 1;
            border: none;
            outline: none;
            padding: 15px 20px 15px 50px;
            font-size: 16px;
            background: transparent;
            color: #333;
        }
        
        .search-input::placeholder {
            color: #999;
            transition: color 0.3s ease;
        }
        
        .search-input:focus::placeholder {
            color: #ccc;
        }
        
        .search-btn {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
            color: white;
            padding: 15px 20px;
            border-radius: 0 50px 50px 0;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .search-btn:hover {
            background: linear-gradient(135deg, #5a6fd8 0%, #6a4190 100%);
            transform: scale(1.05);
        }
        
        .search-icon {
            position: absolute;
            left: 20px;
            color: #999;
            pointer-events: none;
            transition: all 0.3s ease;
        }
        
        .search-box:focus-within .search-icon {
            color: #667eea;
            transform: scale(1.1);
        }
        
        .search-suggestions {
            position: absolute;
            top: 100%;
            left: 0;
            right: 0;
            background: white;
            border-radius: 15px;
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.1);
            margin-top: 10px;
            max-height: 300px;
            overflow-y: auto;
            z-index: 1000;
            opacity: 0;
            visibility: hidden;
            transform: translateY(-10px);
            transition: all 0.3s ease;
        }
        
        .search-suggestions.show {
            opacity: 1;
            visibility: visible;
            transform: translateY(0);
        }
        
        .suggestion-item {
            padding: 12px 20px;
            cursor: pointer;
            border-bottom: 1px solid #f0f0f0;
            transition: all 0.2s ease;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        
        .suggestion-item:last-child {
            border-bottom: none;
        }
        
        .suggestion-item:hover {
            background: #f8f9fa;
            transform: translateX(5px);
        }
        
        .suggestion-item .product-name {
            font-weight: 500;
            color: #333;
        }
        
        .suggestion-item .product-category {
            font-size: 12px;
            color: #666;
            background: #e9ecef;
            padding: 2px 8px;
            border-radius: 10px;
        }
        
        .suggestion-item .product-price {
            font-weight: 600;
            color: #28a745;
        }
        
        .no-results {
            padding: 20px;
            text-align: center;
            color: #666;
            font-style: italic;
        }
        
        /* Arama animasyonu */
        @keyframes searchPulse {
            0% { transform: scale(1); }
            50% { transform: scale(1.05); }
            100% { transform: scale(1); }
        }
        
        .search-box.searching {
            animation: searchPulse 1s ease-in-out;
        }
        
        /* Responsive tasarım */
        @media (max-width: 768px) {
            .search-container {
                max-width: 100%;
            }
            
            .search-input {
                font-size: 14px;
                padding: 12px 15px 12px 45px;
            }
            
            .search-btn {
                padding: 12px 15px;
            }
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light border-bottom">
        <div class="container">
            <a class="navbar-brand" href="index.php">
                <img src="favicon-32x32.png" alt="Hanzade Cafe" class="me-2" style="width: 24px; height: 24px;">Hanzade Cafe
            </a>
            <div class="navbar-nav ms-auto">
                <a class="nav-link" href="index.php">
                    <i class="fas fa-arrow-left me-1"></i>Geri Dön
                </a>
            </div>
        </div>
    </nav>

    <div class="container mt-4">
        <!-- Search Bar -->
        <div class="search-section mb-4">
            <div class="row">
                <div class="col-md-8 mx-auto">
                    <div class="search-container">
                        <div class="search-box">
                            <input type="text" id="searchInput" class="search-input" placeholder="Ürün ara..." autocomplete="off">
                            <button class="search-btn" onclick="performSearch()">
                                <i class="fas fa-search"></i>
                            </button>
                            <div class="search-icon">
                                <i class="fas fa-search"></i>
                            </div>
                        </div>
                        <div class="search-suggestions" id="searchSuggestions"></div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Category Header -->
        <div class="row mb-4">
            <div class="col-md-12">
                <div class="card" style="border-left: 4px solid <?php echo $category['color']; ?>;">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h4 class="mb-1">
                                    <i class="fas fa-tag me-2" style="color: <?php echo $category['color']; ?>;"></i>
                                    <?php echo htmlspecialchars($category['name']); ?>
                                </h4>
                                <p class="text-muted mb-0"><?php echo htmlspecialchars($category['description']); ?></p>
                            </div>
                            <div class="text-end">
                                <h5 class="mb-0"><?php echo $products->num_rows; ?> Ürün</h5>
                                <small class="text-muted">Bu kategoride</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Category Filter -->
        <div class="category-filter">
            <h6 class="mb-3"><i class="fas fa-filter me-2"></i>Kategori Filtresi</h6>
            <a href="index.php" class="btn btn-outline-primary category-btn">
                <i class="fas fa-list me-1"></i>Tümü
                <span class="badge bg-secondary ms-1"><?php echo $allProducts->num_rows; ?></span>
            </a>
                         <?php while ($cat = $categories->fetch_assoc()): ?>
             <a href="index.php?action=category&id=<?php echo $cat['id']; ?>" 
                class="btn btn-outline-primary category-btn category-<?php echo strtolower(str_replace(' ', '-', $cat['name'])); ?> <?php echo $cat['id'] == $category['id'] ? 'active' : ''; ?>"
                style="border-color: <?php echo $cat['color']; ?>; color: <?php echo $cat['color']; ?>;">
                 <i class="fas fa-tag me-1"></i><?php echo htmlspecialchars($cat['name']); ?>
                 <span class="badge ms-1" style="background-color: <?php echo $cat['color']; ?>; color: white;"><?php echo $cat['product_count']; ?></span>
             </a>
             <?php endwhile; ?>
        </div>

        <!-- Products Table -->
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">
                    <i class="fas fa-boxes me-2"></i><?php echo htmlspecialchars($category['name']); ?> Ürünleri
                </h5>
                <a href="index.php?action=add" class="btn btn-primary btn-sm">
                    <i class="fas fa-plus me-1"></i>Yeni Ürün
                </a>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Ürün Adı</th>
                                <th class="text-center">Stok Miktarı</th>
                                <th class="text-center">Birim Fiyat</th>
                                <th class="text-center">Durum</th>
                                <th class="text-center">İşlemler</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while ($row = $products->fetch_assoc()): 
                                $isLow = (int)$row['stock_quantity'] <= (int)$row['min_stock_level'];
                                $statusClass = $isLow ? 'stock-low' : 'stock-ok';
                                $statusText = $isLow ? 'Düşük Stok' : 'Normal';
                                $statusIcon = $isLow ? 'fas fa-exclamation-triangle text-danger' : 'fas fa-check-circle text-success';
                            ?>
                            <tr class="<?php echo $statusClass; ?>">
                                <td>
                                    <strong><?php echo htmlspecialchars($row['product_name']); ?></strong>
                                    <?php if (!empty($row['description'])): ?>
                                    <br><small class="text-muted"><?php echo htmlspecialchars($row['description']); ?></small>
                                    <?php endif; ?>
                                </td>
                                <td class="text-center">
                                    <span class="badge bg-<?php echo $isLow ? 'danger' : 'success'; ?> fs-6">
                                        <?php echo (int)$row['stock_quantity']; ?> <?php echo htmlspecialchars($row['unit']); ?>
                                    </span>
                                    <br><small class="text-muted">Min: <?php echo (int)$row['min_stock_level']; ?></small>
                                </td>
                                <td class="text-center">
                                    <?php if ($row['price'] > 0): ?>
                                    <strong>₺<?php echo number_format($row['price'], 2); ?></strong>
                                    <?php else: ?>
                                    <span class="text-muted">-</span>
                                    <?php endif; ?>
                                </td>
                                <td class="text-center">
                                    <i class="<?php echo $statusIcon; ?> me-1"></i>
                                    <?php echo $statusText; ?>
                                </td>
                                <td class="text-center">
                                    <div class="btn-group" role="group">
                                        <a class="btn btn-outline-primary btn-sm" href="index.php?action=update&id=<?php echo (int)$row['id']; ?>">
                                            <i class="fas fa-edit me-1"></i>Düzenle
                                        </a>
                                        <button class="btn btn-outline-danger btn-sm" 
                                                onclick="showDeleteModal(<?php echo (int)$row['id']; ?>, '<?php echo htmlspecialchars($row['product_name']); ?>')">
                                            <i class="fas fa-trash me-1"></i>Sil
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <?php if ($products->num_rows === 0): ?>
        <div class="text-center mt-4">
            <i class="fas fa-box-open fa-3x text-muted mb-3"></i>
            <h5 class="text-muted">Bu kategoride henüz ürün yok</h5>
            <p class="text-muted">İlk ürününüzü eklemek için yukarıdaki "Yeni Ürün" butonunu kullanın.</p>
        </div>
        <?php endif; ?>
    </div>

    <!-- Delete Confirmation Modal -->
    <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title" id="deleteModalLabel">
                        <i class="fas fa-exclamation-triangle me-2"></i>Ürün Silme Onayı
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="text-center mb-3">
                        <i class="fas fa-trash-alt fa-3x text-danger mb-3"></i>
                        <h5>Bu ürünü silmek istediğinizden emin misiniz?</h5>
                        <p class="text-muted">Bu işlem geri alınamaz.</p>
                    </div>
                    <div class="alert alert-warning">
                        <i class="fas fa-info-circle me-2"></i>
                        <strong id="productNameToDelete"></strong> adlı ürün kalıcı olarak silinecektir.
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="fas fa-times me-1"></i>İptal
                    </button>
                    <a href="#" id="confirmDeleteBtn" class="btn btn-danger">
                        <i class="fas fa-trash me-1"></i>Evet, Sil
                    </a>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function showDeleteModal(productId, productName) {
            document.getElementById('productNameToDelete').textContent = productName;
            document.getElementById('confirmDeleteBtn').href = 'index.php?action=delete&id=' + productId;
            
            const modal = new bootstrap.Modal(document.getElementById('deleteModal'));
            modal.show();
        }
        
        // Arama fonksiyonları
        let searchTimeout;
        const searchInput = document.getElementById('searchInput');
        const searchSuggestions = document.getElementById('searchSuggestions');
        const searchBox = document.querySelector('.search-box');
        
        // Arama input event listener
        searchInput.addEventListener('input', function() {
            clearTimeout(searchTimeout);
            const query = this.value.trim();
            
            if (query.length < 2) {
                hideSuggestions();
                return;
            }
            
            // Arama animasyonu
            searchBox.classList.add('searching');
            
            searchTimeout = setTimeout(() => {
                performSearch(query);
                searchBox.classList.remove('searching');
            }, 300);
        });
        
        // Enter tuşu ile arama
        searchInput.addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                performSearch(this.value.trim());
            }
        });
        
        // Arama fonksiyonu
        function performSearch(query = null) {
            const searchTerm = query || searchInput.value.trim();
            
            if (!searchTerm) {
                hideSuggestions();
                return;
            }
            
            // AJAX ile arama yap
            fetch(`index.php?action=search&q=${encodeURIComponent(searchTerm)}`)
                .then(response => response.json())
                .then(data => {
                    showSuggestions(data);
                })
                .catch(error => {
                    console.error('Arama hatası:', error);
                    showSuggestions([]);
                });
        }
        
                 // Önerileri göster
         function showSuggestions(products) {
             if (!products || products.length === 0) {
                 searchSuggestions.innerHTML = '<div class="no-results">Sonuç bulunamadı</div>';
                 searchSuggestions.classList.add('show');
                 return;
             }
             
             let html = '';
             products.forEach(product => {
                 html += `
                     <div class="suggestion-item" onclick="selectProduct(${product.id}, '${product.product_name}')">
                         <div>
                             <div class="product-name">${product.product_name}</div>
                             <div class="product-category">${product.category_name || 'Kategorisiz'}</div>
                         </div>
                         <div class="product-price">₺${parseFloat(product.price).toFixed(2)}</div>
                     </div>
                 `;
             });
             
             searchSuggestions.innerHTML = html;
             searchSuggestions.classList.add('show');
         }
        
        // Önerileri gizle
        function hideSuggestions() {
            searchSuggestions.classList.remove('show');
        }
        
                 // Ürün seç
         function selectProduct(productId, productName) {
             // Ürün düzenleme sayfasına yönlendir
             window.location.href = `index.php?action=update&id=${productId}`;
         }
        
        // Dışarı tıklandığında önerileri gizle
        document.addEventListener('click', function(e) {
            if (!e.target.closest('.search-container')) {
                hideSuggestions();
            }
        });
        
        // Kategori butonları için kalıcı hover efekti
        document.addEventListener('DOMContentLoaded', function() {
            const categoryButtons = document.querySelectorAll('.category-btn');
            
            categoryButtons.forEach(button => {
                button.addEventListener('mouseenter', function() {
                    // Önceki aktif butonları temizle
                    categoryButtons.forEach(btn => {
                        btn.classList.remove('active-permanent');
                        btn.style.backgroundColor = '';
                        btn.style.color = '';
                        btn.style.borderColor = '';
                    });
                    
                    // Bu butonu kalıcı aktif yap
                    this.classList.add('active-permanent');
                    
                    // Renk bilgilerini al
                    const computedStyle = window.getComputedStyle(this);
                    const color = computedStyle.color;
                    const borderColor = computedStyle.borderColor;
                    
                    // Hover efektini kalıcı yap
                    this.style.backgroundColor = borderColor;
                    this.style.color = color === 'rgb(255, 193, 7)' ? '#212529' : 'white'; // Sarı için siyah yazı
                    this.style.borderColor = borderColor;
                });
            });
        });
    </script>
</body>
</html>
