
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <title>Ürün Güncelle - Hanzade Cafe</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
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
        .form-control:focus {
            border-color: #667eea;
            box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
        }
        .btn-primary {
            background-color: #667eea;
            border-color: #667eea;
        }
        .btn-primary:hover {
            background-color: #5a67d8;
            border-color: #5a67d8;
        }
        .nav-tabs .nav-link.active {
            background-color: #667eea;
            border-color: #667eea;
            color: white;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light border-bottom">
        <div class="container">
            <a class="navbar-brand" href="index.php">
                <i class="fas fa-coffee me-2"></i>Hanzade Cafe
            </a>
            <div class="navbar-nav ms-auto">
                <a class="nav-link" href="index.php">
                    <i class="fas fa-arrow-left me-1"></i>Geri Dön
                </a>
            </div>
        </div>
    </nav>

    <div class="container mt-4">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">
                            <i class="fas fa-edit me-2"></i>Ürün Güncelle - <?php echo htmlspecialchars($product['product_name']); ?>
                        </h5>
                    </div>
                    <div class="card-body">
                        <?php if (!empty($error)): ?>
                        <div class="alert alert-danger">
                            <i class="fas fa-exclamation-triangle me-2"></i>
                            <?php echo htmlspecialchars($error); ?>
                        </div>
                        <?php endif; ?>

                        <?php if (!empty($success)): ?>
                        <div class="alert alert-success">
                            <i class="fas fa-check-circle me-2"></i>
                            <?php echo htmlspecialchars($success); ?>
                        </div>
                        <?php endif; ?>

                        <!-- Tab Navigation -->
                        <ul class="nav nav-tabs mb-4" id="updateTabs" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active" id="stock-tab" data-bs-toggle="tab" data-bs-target="#stock" type="button" role="tab">
                                    <i class="fas fa-minus-circle me-1"></i>Stok Düşür
                                </button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="edit-tab" data-bs-toggle="tab" data-bs-target="#edit" type="button" role="tab">
                                    <i class="fas fa-edit me-1"></i>Ürün Bilgilerini Düzenle
                                </button>
                            </li>
                        </ul>

                        <!-- Tab Content -->
                        <div class="tab-content" id="updateTabsContent">
                            <!-- Stok Düşürme Tab -->
                            <div class="tab-pane fade show active" id="stock" role="tabpanel">
                                <div class="alert alert-info">
                                    <i class="fas fa-info-circle me-2"></i>
                                    <strong><?php echo htmlspecialchars($product['product_name']); ?></strong>
                                    <br>
                                    Mevcut stok: <span class="badge bg-primary fs-6"><?php echo (int)$product['stock_quantity']; ?> <?php echo htmlspecialchars($product['unit']); ?></span>
                                </div>

                                <form method="post" action="index.php?action=update&id=<?php echo (int)$product['id']; ?>" novalidate>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="sold_quantity" class="form-label">
                                                    <i class="fas fa-minus-circle me-1"></i>Satılan Miktar
                                                </label>
                                                <input 
                                                    type="number" 
                                                    class="form-control" 
                                                    id="sold_quantity" 
                                                    name="sold_quantity" 
                                                    min="1" 
                                                    max="<?php echo (int)$product['stock_quantity']; ?>"
                                                    required 
                                                    placeholder="Satılan miktarı girin"
                                                >
                                                <div class="form-text">
                                                    Maksimum: <?php echo (int)$product['stock_quantity']; ?> <?php echo htmlspecialchars($product['unit']); ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="d-grid gap-2">
                                        <button type="submit" class="btn btn-primary btn-lg">
                                            <i class="fas fa-save me-2"></i>Stoku Güncelle
                                        </button>
                                    </div>
                                </form>
                            </div>

                            <!-- Ürün Düzenleme Tab -->
                            <div class="tab-pane fade" id="edit" role="tabpanel">
                                <form method="post" action="index.php?action=edit&id=<?php echo (int)$product['id']; ?>" novalidate>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="edit_product_name" class="form-label">
                                                    <i class="fas fa-tag me-1"></i>Ürün Adı *
                                                </label>
                                                <input 
                                                    type="text" 
                                                    class="form-control" 
                                                    id="edit_product_name" 
                                                    name="product_name" 
                                                    required 
                                                    placeholder="Ürün adını girin"
                                                    value="<?php echo htmlspecialchars($product['product_name']); ?>"
                                                >
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="edit_category_id" class="form-label">
                                                    <i class="fas fa-folder me-1"></i>Kategori *
                                                </label>
                                                <select class="form-select" id="edit_category_id" name="category_id" required>
                                                    <option value="">Kategori seçin</option>
                                                    <?php while ($cat = $categories->fetch_assoc()): ?>
                                                    <option value="<?php echo $cat['id']; ?>" 
                                                            <?php echo $product['category_id'] == $cat['id'] ? 'selected' : ''; ?>>
                                                        <?php echo htmlspecialchars($cat['name']); ?>
                                                    </option>
                                                    <?php endwhile; ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="mb-3">
                                                <label for="edit_stock_quantity" class="form-label">
                                                    <i class="fas fa-boxes me-1"></i>Stok Miktarı
                                                </label>
                                                <input 
                                                    type="number" 
                                                    class="form-control" 
                                                    id="edit_stock_quantity" 
                                                    name="stock_quantity" 
                                                    min="0" 
                                                    required 
                                                    placeholder="0"
                                                    value="<?php echo (int)$product['stock_quantity']; ?>"
                                                >
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="mb-3">
                                                <label for="edit_min_stock_level" class="form-label">
                                                    <i class="fas fa-exclamation-triangle me-1"></i>Minimum Stok Seviyesi
                                                </label>
                                                <input 
                                                    type="number" 
                                                    class="form-control" 
                                                    id="edit_min_stock_level" 
                                                    name="min_stock_level" 
                                                    min="0" 
                                                    required 
                                                    placeholder="10"
                                                    value="<?php echo (int)$product['min_stock_level']; ?>"
                                                >
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="mb-3">
                                                <label for="edit_unit" class="form-label">
                                                    <i class="fas fa-ruler me-1"></i>Birim
                                                </label>
                                                <select class="form-select" id="edit_unit" name="unit">
                                                    <option value="adet" <?php echo $product['unit'] == 'adet' ? 'selected' : ''; ?>>Adet</option>
                                                    <option value="kg" <?php echo $product['unit'] == 'kg' ? 'selected' : ''; ?>>Kilogram</option>
                                                    <option value="lt" <?php echo $product['unit'] == 'lt' ? 'selected' : ''; ?>>Litre</option>
                                                    <option value="paket" <?php echo $product['unit'] == 'paket' ? 'selected' : ''; ?>>Paket</option>
                                                    <option value="kutu" <?php echo $product['unit'] == 'kutu' ? 'selected' : ''; ?>>Kutu</option>
                                                    <option value="kavanoz" <?php echo $product['unit'] == 'kavanoz' ? 'selected' : ''; ?>>Kavanoz</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="edit_price" class="form-label">
                                                    <i class="fas fa-lira-sign me-1"></i>Birim Fiyat (₺)
                                                </label>
                                                <input 
                                                    type="number" 
                                                    class="form-control" 
                                                    id="edit_price" 
                                                    name="price" 
                                                    min="0" 
                                                    step="0.01" 
                                                    placeholder="0.00"
                                                    value="<?php echo number_format($product['price'], 2); ?>"
                                                >
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="edit_description" class="form-label">
                                                    <i class="fas fa-info-circle me-1"></i>Açıklama
                                                </label>
                                                <textarea 
                                                    class="form-control" 
                                                    id="edit_description" 
                                                    name="description" 
                                                    rows="1" 
                                                    placeholder="Ürün açıklaması (opsiyonel)"
                                                ><?php echo htmlspecialchars($product['description'] ?? ''); ?></textarea>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="d-grid gap-2">
                                        <button type="submit" class="btn btn-success btn-lg">
                                            <i class="fas fa-save me-2"></i>Ürün Bilgilerini Güncelle
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>

                        <div class="mt-4">
                            <a href="index.php" class="btn btn-outline-secondary">
                                <i class="fas fa-times me-2"></i>İptal
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
