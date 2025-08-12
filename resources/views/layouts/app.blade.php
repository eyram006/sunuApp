<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <title>@yield('title', 'Sunu Santé') - Dashboard</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    
    <!-- Custom CSS -->
    <link href="{{ asset('css/sunu-sante.css') }}" rel="stylesheet">
    <link href="{{ asset('css/dashboard.css') }}" rel="stylesheet">
    <link href="{{ asset('css/modal-fix.css') }}" rel="stylesheet">
    
    <!-- Alpine.js -->
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    
    @stack('styles')
</head>
<body>
    <div id="app" x-data="{ sidebarOpen: false, notifications: [], userMenuOpen: false, darkTheme: false }">
        <!-- Header -->
        <header class="header">
            <div class="header-left">
                <button class="menu-toggle" onclick="toggleSidebar()">
                    <i class="fas fa-bars"></i>
                </button>
                <div class="logo">
                    <img src="{{ asset('images/logo-sunuSante.jpg') }}" alt="Sunu Santé" class="logo-image">
                </div>
            </div>
            <div class="header-right">
                <div class="role-badge" id="currentRole">
                    {{ auth()->user()->roles->first()->name ?? 'Utilisateur' }}
                </div>
                <div class="user-profile" onclick="toggleUserMenu()">
                    <div class="user-avatar">
                        {{ strtoupper(substr(auth()->user()->name, 0, 2)) }}
                    </div>
                    <div>
                        <div style="font-weight: 600; font-size: 0.9rem;">{{ auth()->user()->name }}</div>
                        <div style="font-size: 0.8rem; color: #6b7280;">{{ auth()->user()->email }}</div>
                    </div>
                    <i class="fas fa-chevron-down" style="margin-left: 10px; color: #6b7280;"></i>
                    
                    <!-- User Dropdown Menu -->
                    <div class="user-dropdown-menu" id="userDropdownMenu">
                        <div class="user-dropdown-header">
                            <h6>{{ auth()->user()->name }}</h6>
                            <small>{{ auth()->user()->email }}</small>
                        </div>
                        <div class="user-dropdown-body">
                            <a href="#" class="user-dropdown-item" onclick="showProfile()">
                                <i class="fas fa-user"></i>
                                <span>Mon Profil</span>
                            </a>
                            <a href="#" class="user-dropdown-item" onclick="showSettings()">
                                <i class="fas fa-cog"></i>
                                <span>Paramètres</span>
                            </a>
                        </div>
                        <div class="theme-toggle">
                            <div class="theme-toggle-label">
                                <i class="fas fa-moon"></i>
                                <span>Mode sombre</span>
                            </div>
                            <div class="theme-toggle-switch" id="themeToggle" onclick="toggleTheme()"></div>
                        </div>
                        <div class="user-dropdown-body">
                            <form method="POST" action="{{ route('logout') }}" style="display: inline;">
                                @csrf
                                <button type="submit" class="user-dropdown-item" style="background: none; border: none; width: 100%; text-align: left; cursor: pointer;" onclick="return confirm('Êtes-vous sûr de vouloir vous déconnecter ?')">
                                    <i class="fas fa-sign-out-alt"></i>
                                    <span>Déconnexion</span>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </header>

        <!-- Sidebar -->
        <nav class="sidebar" id="sidebar">
            <div class="sidebar-menu">
                <div class="menu-section">Tableau de bord</div>
                <a href="{{ route('dashboard') }}" class="menu-item {{ request()->routeIs('dashboard') ? 'active' : '' }}" onclick="showView('dashboard')">
                    <i class="fas fa-tachometer-alt"></i>
                    <span>Vue d'ensemble</span>
                </a>

                <!-- Menu Gestion -->
                <div class="menu-section">
                    <div class="menu-section-title">
                        <i class="fas fa-cogs"></i>
                        <span>Gestion</span>
                    </div>
                    
                    @if(auth()->user()->hasRole('admin'))
                        <a href="{{ route('clients.index') }}" class="menu-item {{ request()->routeIs('clients.*') ? 'active' : '' }}">
                            <i class="fas fa-building"></i>
                            <span>Entreprises</span>
                        </a>
                        
                        <a href="{{ route('gestionnaires.index') }}" class="menu-item {{ request()->routeIs('gestionnaires.*') ? 'active' : '' }}">
                            <i class="fas fa-users-cog"></i>
                            <span>Gestionnaires</span>
                        </a>
                    @endif
                    
                    @if(auth()->user()->hasRole('admin') || auth()->user()->hasRole('gestionnaire'))
                        <a href="{{ route('assures.index') }}" class="menu-item {{ request()->routeIs('assures.*') ? 'active' : '' }}">
                            <i class="fas fa-user-friends"></i>
                            <span>Assurés</span>
                        </a>
                        
                        <a href="{{ route('demandes.index') }}" class="menu-item {{ request()->routeIs('demandes.*') ? 'active' : '' }}">
                            <i class="fas fa-file-alt"></i>
                            <span>Demandes</span>
                        </a>
                    @endif
                </div>

                <div class="menu-section">Administration</div>
                @if(auth()->user()->hasRole('admin'))
                <a href="#" class="menu-item" data-permission="manage_settings">
                    <i class="fas fa-cog"></i>
                    <span>Paramètres</span>
                </a>
                @endif
            </div>
        </nav>

        <!-- Overlay pour mobile -->
        <div class="sidebar-overlay" id="sidebarOverlay" onclick="closeSidebar()"></div>

        <!-- Main Content -->
        <main class="main-content" id="mainContent">
            <div id="content-area">
                @yield('content')
            </div>
        </main>
    </div>
    
    <!-- Bootstrap JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Custom JS -->
    <script>
        // Configuration des rôles et permissions
        const roles = {
            'admin': {
                name: 'Administrateur',
                permissions: ['manage_clients', 'manage_assures', 'manage_claims', 'manage_import', 'manage_settings']
            },
            'gestionnaire': {
                name: 'Gestionnaire',
                permissions: ['manage_clients', 'manage_assures', 'manage_claims', 'manage_import']
            },
            'assure': {
                name: 'Assuré',
                permissions: ['view_claims']
            }
        };

        // Rôle actuel
        let currentUserRole = '{{ auth()->user()->roles->first()->name ?? "assure" }}';

        // Initialisation
        document.addEventListener('DOMContentLoaded', function() {
            initializeApp();
            loadTheme();
        });

        function initializeApp() {
            updateRoleDisplay();
            updateMenuPermissions();
        }

        function updateRoleDisplay() {
            const roleElement = document.getElementById('currentRole');
            if (roleElement) {
                roleElement.textContent = roles[currentUserRole]?.name || 'Utilisateur';
            }
        }

        function updateMenuPermissions() {
            const menuItems = document.querySelectorAll('[data-permission]');
            const userPermissions = roles[currentUserRole]?.permissions || [];

            menuItems.forEach(item => {
                const requiredPermission = item.getAttribute('data-permission');
                if (!userPermissions.includes(requiredPermission)) {
                    item.classList.add('disabled');
                } else {
                    item.classList.remove('disabled');
                }
            });
        }

        function hasPermission(permission) {
            return roles[currentUserRole]?.permissions?.includes(permission) || false;
        }

        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            const mainContent = document.getElementById('mainContent');
            const overlay = document.getElementById('sidebarOverlay');
            
            if (window.innerWidth <= 768) {
                sidebar.classList.toggle('show');
                overlay.classList.toggle('show');
            } else {
                sidebar.classList.toggle('collapsed');
                mainContent.classList.toggle('expanded');
            }
        }

        function closeSidebar() {
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('sidebarOverlay');
            
            sidebar.classList.remove('show');
            overlay.classList.remove('show');
        }

        function toggleUserMenu() {
            const userMenu = document.getElementById('userDropdownMenu');
            userMenu.classList.toggle('show');
        }

        // Fermer le menu utilisateur en cliquant ailleurs
        document.addEventListener('click', function(event) {
            const userProfile = document.querySelector('.user-profile');
            const userMenu = document.getElementById('userDropdownMenu');
            
            if (!userProfile.contains(event.target)) {
                userMenu.classList.remove('show');
            }
        });

        function showProfile() {
            // À implémenter : afficher le profil utilisateur
            console.log('Afficher le profil');
            document.getElementById('userDropdownMenu').classList.remove('show');
        }

        function showSettings() {
            // À implémenter : afficher les paramètres
            console.log('Afficher les paramètres');
            document.getElementById('userDropdownMenu').classList.remove('show');
        }

        function toggleTheme() {
            const themeToggle = document.getElementById('themeToggle');
            const body = document.body;
            
            if (themeToggle.classList.contains('active')) {
                // Désactiver le mode sombre
                themeToggle.classList.remove('active');
                body.classList.remove('dark-theme');
                localStorage.setItem('theme', 'light');
            } else {
                // Activer le mode sombre
                themeToggle.classList.add('active');
                body.classList.add('dark-theme');
                localStorage.setItem('theme', 'dark');
            }
        }

        function loadTheme() {
            const savedTheme = localStorage.getItem('theme');
            const themeToggle = document.getElementById('themeToggle');
            
            if (savedTheme === 'dark') {
                themeToggle.classList.add('active');
                document.body.classList.add('dark-theme');
            }
        }

        // Gestion responsive
        window.addEventListener('resize', function() {
            if (window.innerWidth > 768) {
                closeSidebar();
            }
        });
    </script>
    
    @stack('scripts')
</body>
</html>
