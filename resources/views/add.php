
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <title>Yeni Ürün Ekle - Hanzade Cafe</title>
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
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">
                            <i class="fas fa-plus me-2"></i>Yeni Ürün Ekle
                        </h5>
                    </div>
                    <div class="card-body">
                        <?php if (!empty($error)): ?>
                        <div class="alert alert-danger">
                            <i class="fas fa-exclamation-triangle me-2"></i>
                            <?php echo htmlspecialchars($error); ?>
                        </div>
                        <?php endif; ?>

                        <form method="post" novalidate>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="product_name" class="form-label">
                                            <i class="fas fa-tag me-1"></i>Ürün Adı *
                                        </label>
                                        <input 
                                            type="text" 
                                            class="form-control" 
                                            id="product_name" 
                                            name="product_name" 
                                            required 
                                            placeholder="Ürün adını girin"
                                            value="<?php echo htmlspecialchars($_POST['product_name'] ?? ''); ?>"
                                        >
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="category_id" class="form-label">
                                            <i class="fas fa-folder me-1"></i>Kategori *
                                        </label>
                                        <select class="form-select" id="category_id" name="category_id" required>
                                            <option value="">Kategori seçin</option>
                                            <?php while ($cat = $categories->fetch_assoc()): ?>
                                            <option value="<?php echo $cat['id']; ?>" 
                                                    <?php echo (isset($_POST['category_id']) && $_POST['category_id'] == $cat['id']) ? 'selected' : ''; ?>>
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
                                        <label for="initial_stock" class="form-label">
                                            <i class="fas fa-boxes me-1"></i>Başlangıç Stok Miktarı
                                        </label>
                                        <input 
                                            type="number" 
                                            class="form-control" 
                                            id="initial_stock" 
                                            name="initial_stock" 
                                            min="0" 
                                            required 
                                            placeholder="0"
                                            value="<?php echo htmlspecialchars($_POST['initial_stock'] ?? '0'); ?>"
                                        >
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label for="min_stock_level" class="form-label">
                                            <i class="fas fa-exclamation-triangle me-1"></i>Minimum Stok Seviyesi
                                        </label>
                                        <input 
                                            type="number" 
                                            class="form-control" 
                                            id="min_stock_level" 
                                            name="min_stock_level" 
                                            min="0" 
                                            required 
                                            placeholder="10"
                                            value="<?php echo htmlspecialchars($_POST['min_stock_level'] ?? '10'); ?>"
                                        >
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label for="unit" class="form-label">
                                            <i class="fas fa-ruler me-1"></i>Birim
                                        </label>
                                        <select class="form-select" id="unit" name="unit">
                                            <option value="adet" <?php echo (isset($_POST['unit']) && $_POST['unit'] == 'adet') ? 'selected' : ''; ?>>Adet</option>
                                            <option value="kg" <?php echo (isset($_POST['unit']) && $_POST['unit'] == 'kg') ? 'selected' : ''; ?>>Kilogram</option>
                                            <option value="lt" <?php echo (isset($_POST['unit']) && $_POST['unit'] == 'lt') ? 'selected' : ''; ?>>Litre</option>
                                            <option value="paket" <?php echo (isset($_POST['unit']) && $_POST['unit'] == 'paket') ? 'selected' : ''; ?>>Paket</option>
                                            <option value="kutu" <?php echo (isset($_POST['unit']) && $_POST['unit'] == 'kutu') ? 'selected' : ''; ?>>Kutu</option>
                                            <option value="kavanoz" <?php echo (isset($_POST['unit']) && $_POST['unit'] == 'kavanoz') ? 'selected' : ''; ?>>Kavanoz</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="price" class="form-label">
                                            <i class="fas fa-lira-sign me-1"></i>Birim Fiyat (₺)
                                        </label>
                                        <input 
                                            type="number" 
                                            class="form-control" 
                                            id="price" 
                                            name="price" 
                                            min="0" 
                                            step="0.01" 
                                            placeholder="0.00"
                                            value="<?php echo htmlspecialchars($_POST['price'] ?? '0.00'); ?>"
                                        >
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="description" class="form-label">
                                            <i class="fas fa-info-circle me-1"></i>Açıklama
                                        </label>
                                        <textarea 
                                            class="form-control" 
                                            id="description" 
                                            name="description" 
                                            rows="1" 
                                            placeholder="Ürün açıklaması (opsiyonel)"
                                        ><?php echo htmlspecialchars($_POST['description'] ?? ''); ?></textarea>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="d-grid gap-2">
                                <button type="submit" class="btn btn-primary btn-lg">
                                    <i class="fas fa-save me-2"></i>Ürünü Kaydet
                                </button>
                                <a href="index.php" class="btn btn-outline-secondary">
                                    <i class="fas fa-times me-2"></i>İptal
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
