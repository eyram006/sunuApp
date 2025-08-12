<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Connexion - Sunu Santé</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        :root {
            --primary-red: #dc2626;
            --secondary-red: #b91c1c;
            --dark-red: #991b1b;
            --light-red: #fef2f2;
            --white: #ffffff;
            --gray-50: #f9fafb;
            --gray-100: #f3f4f6;
            --gray-200: #e5e7eb;
            --gray-600: #4b5563;
            --gray-700: #374151;
            --gray-800: #1f2937;
            --gray-900: #111827;
        }
        
        body {
            background: linear-gradient(135deg, var(--primary-red) 0%, var(--secondary-red) 50%, var(--dark-red) 100%);
            min-height: 100vh;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .auth-container {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .auth-card {
            background: var(--white);
            border-radius: 20px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.15);
            overflow: hidden;
            max-width: 900px;
            width: 100%;
            min-height: 450px;
            display: flex;
            position: relative;
        }

        .brand-section {
            background: linear-gradient(135deg, var(--primary-red) 0%, var(--secondary-red) 100%);
            flex: 1;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 35px 25px;
            color: var(--white);
            position: relative;
            overflow: hidden;
        }

        .brand-section::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 70%);
            animation: pulse 4s ease-in-out infinite;
        }

        @keyframes pulse {
            0%, 100% { transform: scale(1); opacity: 0.3; }
            50% { transform: scale(1.1); opacity: 0.5; }
        }

        .brand-logo {
            width: 140px;
            height: 140px;
            background: rgba(255, 255, 255, 0.15);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 25px;
            backdrop-filter: blur(10px);
            border: 2px solid rgba(255, 255, 255, 0.2);
            position: relative;
            z-index: 2;
        }

        .brand-logo img {
            width: 100px;
            height: 100px;
            object-fit: contain;
        }

        .brand-text {
            text-align: center;
            position: relative;
            z-index: 2;
        }

        .brand-text h2 {
            font-size: 2.2rem;
            font-weight: 700;
            margin-bottom: 15px;
            text-shadow: 0 2px 10px rgba(0,0,0,0.2);
        }

        .brand-text p {
            font-size: 1rem;
            opacity: 0.9;
            line-height: 1.5;
        }

        .form-section {
            flex: 1;
            padding: 35px 35px;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .form-header {
            text-align: center;
            margin-bottom: 25px;
        }

        .form-header h3 {
            color: var(--gray-800);
            font-weight: 700;
            font-size: 1.7rem;
            margin-bottom: 8px;
        }

        .form-header p {
            color: var(--gray-600);
            font-size: 0.95rem;
        }

        .form-group {
            margin-bottom: 18px;
            position: relative;
        }

        .form-label {
            color: var(--gray-700);
            font-weight: 600;
            margin-bottom: 8px;
            font-size: 0.95rem;
        }

        .form-control {
            border: 2px solid var(--gray-200);
            border-radius: 12px;
            padding: 11px 16px;
            font-size: 1rem;
            transition: all 0.3s ease;
            background: var(--gray-50);
        }

        .form-control:focus {
            border-color: var(--primary-red);
            box-shadow: 0 0 0 0.2rem rgba(220, 38, 38, 0.1);
            background: var(--white);
        }

        .input-icon {
            position: absolute;
            right: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--gray-600);
            font-size: 1.1rem;
        }

        .password-toggle {
            cursor: pointer;
            transition: color 0.3s ease;
        }

        .password-toggle:hover {
            color: var(--primary-red);
        }

        .btn-login {
            background: linear-gradient(135deg, var(--primary-red) 0%, var(--secondary-red) 100%);
            border: none;
            border-radius: 12px;
            padding: 11px;
            font-weight: 600;
            font-size: 1rem;
            color: var(--white);
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .btn-login::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
            transition: left 0.6s;
        }

        .btn-login:hover::before {
            left: 100%;
        }

        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 30px rgba(220, 38, 38, 0.3);
        }

        .forgot-password {
            text-align: center;
            margin-top: 20px;
        }

        .forgot-password a {
            color: var(--primary-red);
            text-decoration: none;
            font-weight: 500;
            transition: color 0.3s ease;
        }

        .forgot-password a:hover {
            color: var(--secondary-red);
            text-decoration: underline;
        }

        .remember-me {
            display: flex;
            align-items: center;
            margin-bottom: 20px;
        }

        .form-check-input:checked {
            background-color: var(--primary-red);
            border-color: var(--primary-red);
        }

        .form-check-input:focus {
            box-shadow: 0 0 0 0.2rem rgba(220, 38, 38, 0.25);
        }

        .alert {
            border-radius: 12px;
            border: none;
            padding: 11px 16px;
            margin-bottom: 18px;
            font-size: 0.9rem;
        }

        .alert-info {
            background-color: rgba(220, 38, 38, 0.1);
            color: var(--primary-red);
            border-left: 4px solid var(--primary-red);
        }

        .floating-shapes {
            position: absolute;
            width: 100%;
            height: 100%;
            overflow: hidden;
            z-index: 1;
        }

        .shape {
            position: absolute;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.1);
            animation: float 6s ease-in-out infinite;
        }

        .shape:nth-child(1) {
            width: 80px;
            height: 80px;
            top: 20%;
            left: 20%;
            animation-delay: 0s;
        }

        .shape:nth-child(2) {
            width: 120px;
            height: 120px;
            top: 60%;
            right: 20%;
            animation-delay: 2s;
        }

        .shape:nth-child(3) {
            width: 60px;
            height: 60px;
            bottom: 20%;
            left: 30%;
            animation-delay: 4s;
        }

        @keyframes float {
            0%, 100% { transform: translateY(0) rotate(0deg); }
            50% { transform: translateY(-20px) rotate(180deg); }
        }

        @media (max-width: 768px) {
            .auth-card {
                flex-direction: column;
                min-height: auto;
            }
            
            .brand-section {
                padding: 40px 20px;
            }
            
            .form-section {
                padding: 40px 30px;
            }
            
            .brand-text h2 {
                font-size: 2rem;
            }
        }
    </style>
</head>
<body>
    <div class="auth-container">
        <div class="auth-card">
            <!-- Section Branding à gauche -->
            <div class="brand-section">
                <div class="floating-shapes">
                    <div class="shape"></div>
                    <div class="shape"></div>
                    <div class="shape"></div>
                </div>
                
                <div class="brand-logo">
                    <img src="{{ asset('images/logo-sunuSante.jpg') }}" alt="Sunu Santé Logo">
                </div>
                
                <div class="brand-text">
                    <h2>Sunu Santé</h2>
                    <p>Connectez-vous à votre espace et accédez à tous vos outils professionnels en un clic.</p>
                </div>
            </div>

            <!-- Formulaire de connexion à droite -->
            <div class="form-section">
                <div class="form-header">
                    <h3>Bienvenue !</h3>
                    <p>Connectez-vous à votre compte</p>
                </div>

                @if(session('status'))
                    <div class="alert alert-info alert-dismissible fade show" role="alert">
                        {{ session('status') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                <div class="alert alert-info">
                    <i class="fas fa-info-circle me-2"></i>
                    <strong>Important :</strong> Vos identifiants vous ont été envoyés par email lors de la création de votre compte
                </div>

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <!-- Email Address -->
                    <div class="form-group">
                        <label class="form-label">Adresse e-mail</label>
                        <div style="position: relative;">
                            <input type="email" 
                                   class="form-control @error('email') is-invalid @enderror" 
                                   id="email" 
                                   name="email" 
                                   value="{{ old('email') }}" 
                                   placeholder="votre@email.com" 
                                   required 
                                   autofocus 
                                   autocomplete="username" />
                            <i class="fas fa-envelope input-icon"></i>
                        </div>
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
        </div>

        <!-- Password -->
                    <div class="form-group">
                        <label class="form-label">Mot de passe</label>
                        <div style="position: relative;">
                            <input type="password" 
                                   class="form-control @error('password') is-invalid @enderror"
                                   id="password"
                            name="password"
                                   placeholder="••••••••" 
                                   required 
                                   autocomplete="current-password" />
                            <i class="fas fa-eye password-toggle input-icon" onclick="togglePassword()"></i>
                        </div>
                        @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
        </div>

        <!-- Remember Me -->
                    <div class="remember-me">
                        <input class="form-check-input" type="checkbox" id="remember_me" name="remember">
                        <label class="form-check-label ms-2" for="remember_me">
                            Se souvenir de moi
            </label>
        </div>

                    <button type="submit" class="btn btn-login w-100">
                        <i class="fas fa-sign-in-alt me-2"></i>
                        Se connecter
                    </button>

                    <div class="forgot-password">
            @if (Route::has('password.request'))
                            <a href="{{ route('password.request') }}">Mot de passe oublié ?</a>
            @endif
                    </div>
                </form>

                <hr class="my-4">

                <div class="text-center">
                    <a href="{{ route('welcome') }}" class="text-decoration-none" style="color: var(--gray-600);">
                        <i class="fas fa-arrow-left me-2"></i>
                        Retour à l'accueil
                    </a>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function togglePassword() {
            const passwordInput = document.getElementById('password');
            const toggleIcon = document.querySelector('.password-toggle');
            
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                toggleIcon.classList.remove('fa-eye');
                toggleIcon.classList.add('fa-eye-slash');
            } else {
                passwordInput.type = 'password';
                toggleIcon.classList.remove('fa-eye-slash');
                toggleIcon.classList.add('fa-eye');
            }
        }

        // Animation d'entrée
        document.addEventListener('DOMContentLoaded', function() {
            const authCard = document.querySelector('.auth-card');
            authCard.style.opacity = '0';
            authCard.style.transform = 'translateY(50px)';
            
            setTimeout(() => {
                authCard.style.transition = 'all 0.8s ease';
                authCard.style.opacity = '1';
                authCard.style.transform = 'translateY(0)';
            }, 100);
        });
    </script>
</body>
</html>
