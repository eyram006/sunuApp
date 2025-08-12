<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Sunu Santé - Plateforme d'Assurance Santé</title>
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
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
            color: var(--gray-800);
            background: var(--white);
        }
        
        /* Navigation */
        .navbar {
            background: var(--white) !important;
            box-shadow: 0 2px 20px rgba(220, 38, 38, 0.1);
            padding: 1rem 0;
        }
        
        .navbar-brand {
            font-weight: 700;
            font-size: 1.8rem;
            color: var(--primary-red) !important;
        }
        
        .navbar-brand img {
            height: 40px;
            margin-right: 10px;
        }
        
        .navbar-nav .nav-link {
            font-weight: 600;
            color: var(--gray-700) !important;
            margin: 0 10px;
            transition: all 0.3s ease;
            border-radius: 8px;
            padding: 8px 16px;
        }
        
        .navbar-nav .nav-link:hover {
            color: var(--primary-red) !important;
            background: var(--light-red);
        }
        
        /* Hero Section */
        .hero-section {
            background: linear-gradient(135deg, var(--primary-red) 0%, var(--secondary-red) 50%, var(--dark-red) 100%);
            color: var(--white);
            padding: 120px 0 100px;
            position: relative;
            overflow: hidden;
        }
        
        .hero-section::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="grain" width="100" height="100" patternUnits="userSpaceOnUse"><circle cx="25" cy="25" r="1" fill="white" opacity="0.1"/><circle cx="75" cy="75" r="1" fill="white" opacity="0.1"/><circle cx="50" cy="10" r="0.5" fill="white" opacity="0.1"/><circle cx="10" cy="60" r="0.5" fill="white" opacity="0.1"/><circle cx="90" cy="40" r="0.5" fill="white" opacity="0.1"/></pattern></defs><rect width="100" height="100" fill="url(%23grain)"/></svg>');
            opacity: 0.3;
        }
        
        .hero-content {
            position: relative;
            z-index: 2;
        }
        
        .hero-logo {
            width: 120px;
            height: 120px;
            background: rgba(255, 255, 255, 0.15);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 30px;
            backdrop-filter: blur(10px);
            border: 2px solid rgba(255, 255, 255, 0.2);
        }
        
        .hero-logo img {
            width: 80px;
            height: 80px;
            object-fit: contain;
        }
        
        .hero-title {
            font-size: 3.5rem;
            font-weight: 800;
            margin-bottom: 1.5rem;
            text-shadow: 0 2px 10px rgba(0,0,0,0.2);
        }
        
        .hero-subtitle {
            font-size: 1.3rem;
            margin-bottom: 2rem;
            opacity: 0.95;
            max-width: 600px;
            margin-left: auto;
            margin-right: auto;
        }
        
        .hero-description {
            font-size: 1.1rem;
            margin-bottom: 3rem;
            opacity: 0.85;
            max-width: 700px;
            margin-left: auto;
            margin-right: auto;
        }
        
        /* Boutons */
        .btn-primary {
            background: linear-gradient(135deg, var(--primary-red) 0%, var(--secondary-red) 100%);
            border: none;
            border-radius: 12px;
            padding: 15px 40px;
            font-weight: 700;
            font-size: 1.1rem;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(220, 38, 38, 0.3);
        }
        
        .btn-primary:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 30px rgba(220, 38, 38, 0.4);
        }
        
        .btn-outline-light {
            border: 2px solid var(--white);
            border-radius: 12px;
            padding: 15px 40px;
            font-weight: 700;
            font-size: 1.1rem;
            transition: all 0.3s ease;
            background: transparent;
        }
        
        .btn-outline-light:hover {
            background: var(--white);
            color: var(--primary-red) !important;
            transform: translateY(-3px);
        }
        
        /* Sections */
        .section {
            padding: 80px 0;
        }
        
        .section-title {
            color: var(--gray-800);
            font-weight: 800;
            font-size: 2.5rem;
            margin-bottom: 1rem;
            text-align: center;
        }
        
        .section-subtitle {
            color: var(--gray-600);
            font-size: 1.2rem;
            text-align: center;
            margin-bottom: 3rem;
            max-width: 600px;
            margin-left: auto;
            margin-right: auto;
        }
        
        /* Feature Cards */
        .feature-card {
            background: var(--white);
            border-radius: 20px;
            padding: 40px 30px;
            text-align: center;
            box-shadow: 0 10px 40px rgba(0,0,0,0.08);
            transition: all 0.3s ease;
            border: 1px solid var(--gray-100);
            height: 100%;
        }
        
        .feature-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 20px 60px rgba(220, 38, 38, 0.15);
            border-color: var(--primary-red);
        }
        
        .feature-icon {
            width: 80px;
            height: 80px;
            background: linear-gradient(135deg, var(--primary-red) 0%, var(--secondary-red) 100%);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 25px;
            color: var(--white);
            font-size: 2rem;
        }
        
        .feature-title {
            color: var(--gray-800);
            font-weight: 700;
            font-size: 1.3rem;
            margin-bottom: 15px;
        }
        
        .feature-text {
            color: var(--gray-600);
            line-height: 1.6;
        }
        
        /* Workflow Section */
        .workflow-section {
            background: var(--gray-50);
        }
        
        .workflow-step {
            text-align: center;
            padding: 30px 20px;
        }
        
        .workflow-step .icon {
            width: 100px;
            height: 100px;
            background: linear-gradient(135deg, var(--primary-red) 0%, var(--secondary-red) 100%);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 25px;
            color: var(--white);
            font-size: 2.5rem;
            box-shadow: 0 10px 30px rgba(220, 38, 38, 0.3);
        }
        
        .workflow-step h5 {
            color: var(--gray-800);
            font-weight: 700;
            font-size: 1.2rem;
            margin-bottom: 15px;
        }
        
        .workflow-step p {
            color: var(--gray-600);
            font-size: 1rem;
        }
        
        /* Stats Section */
        .stats-card {
            background: linear-gradient(135deg, var(--primary-red) 0%, var(--secondary-red) 100%);
            border-radius: 20px;
            color: var(--white);
            padding: 40px 30px;
            text-align: center;
            transition: all 0.3s ease;
            box-shadow: 0 10px 30px rgba(220, 38, 38, 0.2);
        }
        
        .stats-card:hover {
            transform: scale(1.05);
            box-shadow: 0 20px 50px rgba(220, 38, 38, 0.3);
        }
        
        .stats-card .icon {
            width: 60px;
            height: 60px;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 20px;
            color: var(--white);
            font-size: 1.5rem;
        }
        
        .stats-card h3 {
            font-weight: 800;
            font-size: 2.5rem;
            margin-bottom: 10px;
        }
        
        .stats-card p {
            font-weight: 600;
            opacity: 0.9;
        }
        
        /* Footer */
        .footer {
            background: var(--gray-900);
            color: var(--white);
            padding: 60px 0 30px;
        }
        
        .footer-brand {
            font-weight: 700;
            font-size: 1.5rem;
            color: var(--primary-red);
            margin-bottom: 20px;
        }
        
        .footer-brand img {
            height: 35px;
            margin-right: 10px;
        }
        
        .footer-text {
            color: var(--gray-300);
            line-height: 1.6;
        }
        
        .footer-bottom {
            border-top: 1px solid var(--gray-800);
            padding-top: 30px;
            margin-top: 40px;
            text-align: center;
            color: var(--gray-400);
        }
        
        /* Responsive */
        @media (max-width: 768px) {
            .hero-title {
                font-size: 2.5rem;
            }
            
            .hero-subtitle {
                font-size: 1.1rem;
            }
            
            .section-title {
                font-size: 2rem;
            }
            
            .btn-primary,
            .btn-outline-light {
                padding: 12px 30px;
                font-size: 1rem;
            }
        }
        
        /* Animations */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        .fade-in-up {
            animation: fadeInUp 0.8s ease-out;
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
            </style>
    </head>
<body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-light fixed-top">
        <div class="container">
            <a class="navbar-brand" href="#">
                <img src="{{ asset('images/logo-sunuSante.jpg') }}" alt="Sunu Santé Logo">
                Sunu Santé
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <div class="navbar-nav ms-auto">
                    @auth
                        <a class="nav-link" href="{{ route('dashboard') }}">
                            <i class="fas fa-tachometer-alt me-2"></i>
                            Tableau de bord
                        </a>
                        <form method="POST" action="{{ route('logout') }}" class="d-inline">
                            @csrf
                            <button type="submit" class="nav-link btn btn-link">
                                <i class="fas fa-sign-out-alt me-2"></i>
                                Déconnexion
                            </button>
                        </form>
                    @else
                        <a class="nav-link" href="{{ route('login') }}">
                            <i class="fas fa-sign-in-alt me-2"></i>
                            Connexion
                        </a>
                    @endauth
                </div>
            </div>
        </div>
                </nav>

    <!-- Hero Section -->
    <section class="hero-section">
        <div class="floating-shapes">
            <div class="shape"></div>
            <div class="shape"></div>
            <div class="shape"></div>
        </div>
        
        <div class="container text-center hero-content">
            <div class="hero-logo">
                <img src="{{ asset('images/logo-sunuSante.jpg') }}" alt="Sunu Santé">
            </div>
            
            <h1 class="hero-title">
                Sunu Santé
            </h1>
            <p class="hero-subtitle">
                Plateforme professionnelle de gestion des demandes d'assurance santé
            </p>
            <p class="hero-description">
                Simplifiez la gestion de vos polices d'assurance santé avec notre solution complète et sécurisée. 
                Gestion des entreprises, import des employés et suivi des demandes en temps réel.
            </p>
            
            <div class="d-flex gap-3 justify-content-center flex-wrap">
                @auth
                    <a href="{{ route('dashboard') }}" class="btn btn-outline-light">
                        <i class="fas fa-tachometer-alt me-2"></i>
                        Accéder au tableau de bord
                    </a>
                @else
                    <a href="{{ route('login') }}" class="btn btn-outline-light">
                        <i class="fas fa-sign-in-alt me-2"></i>
                        Se connecter
                    </a>
                    <a href="#features" class="btn btn-primary">
                        <i class="fas fa-info-circle me-2"></i>
                        En savoir plus
                    </a>
                @endauth
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section class="section" id="features">
        <div class="container">
            <h2 class="section-title">Fonctionnalités principales</h2>
            <p class="section-subtitle">Découvrez ce que Sunu Santé peut faire pour votre entreprise</p>
            
            <div class="row g-4">
                <div class="col-lg-4 col-md-6">
                    <div class="feature-card fade-in-up">
                        <div class="feature-icon">
                            <i class="fas fa-users"></i>
                        </div>
                        <h5 class="feature-title">Gestion des assurés</h5>
                        <p class="feature-text">
                            Import en masse de vos employés via Excel, création automatique des comptes et attribution des rôles.
                        </p>
                    </div>
                </div>
                
                <div class="col-lg-4 col-md-6">
                    <div class="feature-card fade-in-up">
                        <div class="feature-icon">
                            <i class="fas fa-file-alt"></i>
                        </div>
                        <h5 class="feature-title">Workflow des demandes</h5>
                        <p class="feature-text">
                            Processus complet de validation des demandes avec suivi des statuts et notifications automatiques.
                        </p>
                    </div>
                </div>
                
                <div class="col-lg-4 col-md-6">
                    <div class="feature-card fade-in-up">
                        <div class="feature-icon">
                            <i class="fas fa-id-card"></i>
                        </div>
                        <h5 class="feature-title">Cartes d'assurance</h5>
                        <p class="feature-text">
                            Génération automatique des cartes d'assurance avec export PDF et gestion des validités.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Workflow Section -->
    <section class="section workflow-section">
        <div class="container">
            <h2 class="section-title">Comment ça fonctionne</h2>
            <p class="section-subtitle">Processus simplifié pour votre équipe</p>
            
            <div class="row">
                <div class="col-lg-3 col-md-6">
                    <div class="workflow-step">
                        <div class="icon">
                            <i class="fas fa-building"></i>
                        </div>
                        <h5>1. Création d'entreprise</h5>
                        <p>L'administrateur crée le profil de votre entreprise</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="workflow-step">
                        <div class="icon">
                            <i class="fas fa-user-tie"></i>
                        </div>
                        <h5>2. Gestionnaire assigné</h5>
                        <p>Un gestionnaire d'assurance est assigné à votre entreprise</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="workflow-step">
                        <div class="icon">
                            <i class="fas fa-upload"></i>
                        </div>
                        <h5>3. Import des employés</h5>
                        <p>Import en masse de vos employés via fichier Excel</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="workflow-step">
                        <div class="icon">
                            <i class="fas fa-check-circle"></i>
                        </div>
                        <h5>4. Gestion des demandes</h5>
                        <p>Suivi et validation des demandes d'assurance</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Stats Section -->
    <section class="section">
        <div class="container">
            <div class="row g-4">
                <div class="col-lg-3 col-md-6">
                    <div class="stats-card">
                        <div class="icon">
                            <i class="fas fa-building"></i>
                        </div>
                        <h3>Entreprises</h3>
                        <p>Gestion multi-entreprises</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="stats-card">
                        <div class="icon">
                            <i class="fas fa-user-friends"></i>
                        </div>
                        <h3>Assurés</h3>
                        <p>Profils complets</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="stats-card">
                        <div class="icon">
                            <i class="fas fa-chart-line"></i>
                        </div>
                        <h3>Demandes</h3>
                        <p>Suivi en temps réel</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="stats-card">
                        <div class="icon">
                            <i class="fas fa-shield-alt"></i>
                        </div>
                        <h3>Sécurité</h3>
                        <p>Protection des données</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <div class="row">
                <div class="col-lg-6">
                    <div class="footer-brand">
                        <img src="{{ asset('images/logo-sunuSante.jpg') }}" alt="Sunu Santé">
                        Sunu Santé
                    </div>
                    <p class="footer-text">
                        Votre partenaire de confiance pour la gestion des demandes d'assurance santé. 
                        Une solution moderne, sécurisée et adaptée aux besoins de votre entreprise.
                    </p>
                </div>
                <div class="col-lg-6 text-lg-end">
                    <h5 class="text-white mb-3">Contact</h5>
                    <p class="footer-text">
                        <i class="fas fa-envelope me-2"></i>
                        contact@sunusante.com<br>
                        <i class="fas fa-phone me-2"></i>
                        +228 XX XX XX XX
                    </p>
                </div>
            </div>
            <div class="footer-bottom">
                <p>&copy; 2025 Sunu Santé. Tous droits réservés.</p>
                <p class="mb-0">
                    <i class="fas fa-heartbeat text-danger me-2"></i>
                    Votre santé, notre priorité
                </p>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Animation au scroll
        const observerOptions = {
            threshold: 0.1,
            rootMargin: '0px 0px -50px 0px'
        };

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.style.opacity = '1';
                    entry.target.style.transform = 'translateY(0)';
                }
            });
        }, observerOptions);

        // Observer les éléments avec animation
        document.querySelectorAll('.feature-card, .workflow-step, .stats-card').forEach(el => {
            el.style.opacity = '0';
            el.style.transform = 'translateY(30px)';
            el.style.transition = 'all 0.6s ease';
            observer.observe(el);
        });
    </script>
    </body>
</html>
