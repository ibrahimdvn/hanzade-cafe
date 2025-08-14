<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <title>Şifremi Unuttum - Hanzade Cafe</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/png" href="favicon-32x32.png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
        }
        .forgot-card {
            background: white;
            border-radius: 1rem;
            box-shadow: 0 1rem 3rem rgba(0, 0, 0, 0.175);
            overflow: hidden;
        }
        .forgot-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 2rem;
            text-align: center;
        }
        .form-control {
            padding-left: 2.5rem;
        }
        .form-control:focus {
            border-color: #667eea;
            box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
        }
        .btn-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
            padding: 0.75rem 2rem;
            font-weight: 600;
        }
        .btn-primary:hover {
            background: linear-gradient(135deg, #5a67d8 0%, #6b46c1 100%);
            transform: translateY(-1px);
        }
        .form-floating > label {
            color: #6c757d;
            display: flex !important;
            align-items: center !important;
            flex-direction: row !important;
            padding-left: 0.75rem !important;
        }
        .form-floating > label i {
            margin-right: 0.5rem;
            flex-shrink: 0;
            width: 1rem;
            text-align: center;
        }
        .form-floating > .form-control:focus ~ label,
        .form-floating > .form-control:not(:placeholder-shown) ~ label {
            transform: scale(0.85) translateY(-1rem) translateX(0.15rem);
            opacity: 0.65;
        }
        .form-floating > .form-control:focus ~ label i,
        .form-floating > .form-control:not(:placeholder-shown) ~ label i {
            margin-right: 0.5rem;
        }
        .alert {
            border: none;
            border-radius: 0.5rem;
        }
        .divider {
            position: relative;
            text-align: center;
            margin: 1.5rem 0;
        }
        .divider::before {
            content: '';
            position: absolute;
            top: 50%;
            left: 0;
            right: 0;
            height: 1px;
            background: #dee2e6;
            transform: translateY(-50%);
        }
        .divider span {
            background: white;
            padding: 0 1rem;
            color: #6c757d;
            font-size: 0.875rem;
            position: relative;
            z-index: 1;
            top: 2px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6 col-lg-5">
                <div class="forgot-card">
                    <div class="forgot-header">
                        <img src="favicon-32x32.png" alt="Hanzade Cafe" style="width: 48px; height: 48px;" class="mb-3">
                        <h3 class="mb-0">Hanzade Cafe</h3>
                        <p class="mb-0 opacity-75">Stok Yönetim Sistemi</p>
                    </div>
                    
                    <div class="p-4 p-md-5">
                        <h4 class="text-center mb-4">Şifremi Unuttum</h4>
                        
                        <p class="text-muted text-center mb-4">
                            Email adresinizi girin, şifrenizi sıfırlamak için size bir link göndereceğiz.
                        </p>
                        
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

                        <form method="post" novalidate>
                            <div class="form-floating mb-3">
                                <input 
                                    type="email" 
                                    class="form-control" 
                                    id="email" 
                                    name="email" 
                                    placeholder="Email"
                                    value="<?php echo htmlspecialchars($_POST['email'] ?? ''); ?>"
                                    required
                                >
                                <label for="email">
                                    <i class="fas fa-envelope me-1"></i>Email Adresi
                                </label>
                            </div>

                            <div class="d-grid mb-3">
                                <button type="submit" class="btn btn-primary btn-lg">
                                    <i class="fas fa-paper-plane me-2"></i>Şifre Sıfırlama Linki Gönder
                                </button>
                            </div>

                            <div class="divider">
                                <span>veya</span>
                            </div>

                            <div class="d-grid">
                                <a href="index.php?action=login" class="btn btn-outline-primary">
                                    <i class="fas fa-sign-in-alt me-2"></i>Giriş Yap
                                </a>
                            </div>
                        </form>

                        <div class="text-center mt-4">
                            <small class="text-muted">
                                <i class="fas fa-shield-alt me-1"></i>
                                Güvenli şifre sıfırlama
                            </small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
