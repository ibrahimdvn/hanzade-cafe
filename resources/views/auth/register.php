<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <title>Kayıt Ol - Hanzade Cafe</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
        }
        .register-card {
            background: white;
            border-radius: 1rem;
            box-shadow: 0 1rem 3rem rgba(0, 0, 0, 0.175);
            overflow: hidden;
        }
        .register-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 2rem;
            text-align: center;
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
        }
        .form-floating > label i {
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
        }
        .divider span {
            background: white;
            padding: 0 1rem;
            color: #6c757d;
            font-size: 0.875rem;
        }
        .password-strength {
            font-size: 0.875rem;
            margin-top: 0.25rem;
        }
        .strength-weak { color: #dc3545; }
        .strength-medium { color: #ffc107; }
        .strength-strong { color: #28a745; }
    </style>
</head>
<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6 col-lg-5">
                <div class="register-card">
                    <div class="register-header">
                        <i class="fas fa-coffee fa-3x mb-3"></i>
                        <h3 class="mb-0">Hanzade Cafe</h3>
                        <p class="mb-0 opacity-75">Stok Yönetim Sistemi</p>
                    </div>
                    
                    <div class="p-4 p-md-5">
                        <h4 class="text-center mb-4">Yeni Hesap Oluştur</h4>
                        
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
                                    type="text" 
                                    class="form-control" 
                                    id="name" 
                                    name="name" 
                                    placeholder="Ad Soyad"
                                    value="<?php echo htmlspecialchars($_POST['name'] ?? ''); ?>"
                                    required
                                >
                                <label for="name">
                                    <i class="fas fa-user me-1"></i>Ad Soyad
                                </label>
                            </div>

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

                            <div class="form-floating mb-3">
                                <input 
                                    type="password" 
                                    class="form-control" 
                                    id="password" 
                                    name="password" 
                                    placeholder="Şifre"
                                    required
                                    minlength="6"
                                >
                                <label for="password">
                                    <i class="fas fa-lock me-1"></i>Şifre
                                </label>
                                <div class="password-strength" id="password-strength"></div>
                            </div>

                            <div class="form-floating mb-3">
                                <input 
                                    type="password" 
                                    class="form-control" 
                                    id="password_confirm" 
                                    name="password_confirm" 
                                    placeholder="Şifre Tekrar"
                                    required
                                >
                                <label for="password_confirm">
                                    <i class="fas fa-lock me-1"></i>Şifre Tekrar
                                </label>
                            </div>

                            <div class="d-grid mb-3">
                                <button type="submit" class="btn btn-primary btn-lg">
                                    <i class="fas fa-user-plus me-2"></i>Hesap Oluştur
                                </button>
                            </div>

                            <div class="divider">
                                <span>veya</span>
                            </div>

                            <div class="d-grid">
                                <a href="index.php?action=login" class="btn btn-outline-primary">
                                    <i class="fas fa-sign-in-alt me-2"></i>Zaten hesabım var
                                </a>
                            </div>
                        </form>

                        <div class="text-center mt-4">
                            <small class="text-muted">
                                <i class="fas fa-shield-alt me-1"></i>
                                Hesabınız güvenle korunur
                            </small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Şifre gücü kontrolü
        document.getElementById('password').addEventListener('input', function() {
            const password = this.value;
            const strengthDiv = document.getElementById('password-strength');
            
            let strength = 0;
            let message = '';
            let className = '';
            
            if (password.length >= 6) strength++;
            if (password.match(/[a-z]/)) strength++;
            if (password.match(/[A-Z]/)) strength++;
            if (password.match(/[0-9]/)) strength++;
            if (password.match(/[^a-zA-Z0-9]/)) strength++;
            
            switch(strength) {
                case 0:
                case 1:
                    message = 'Zayıf';
                    className = 'strength-weak';
                    break;
                case 2:
                case 3:
                    message = 'Orta';
                    className = 'strength-medium';
                    break;
                case 4:
                case 5:
                    message = 'Güçlü';
                    className = 'strength-strong';
                    break;
            }
            
            strengthDiv.textContent = message;
            strengthDiv.className = 'password-strength ' + className;
        });
    </script>
</body>
</html>
