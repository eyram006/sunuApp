@extends('layouts.app')

@section('title', 'Gestion des Gestionnaires')

@section('content')
<!-- En-tête de page -->
<div class="page-header">
    <h1 class="page-title">Gestion des Gestionnaires</h1>
    <p class="page-subtitle">Gérez les gestionnaires de votre plateforme d'assurance.</p>
</div>

<!-- Statistiques -->
<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-header">
            <div class="stat-icon">
                <i class="fas fa-users"></i>
            </div>
            <div class="stat-change positive">
                <i class="fas fa-arrow-up"></i>
                <span>+5%</span>
            </div>
        </div>
        <div class="stat-content">
            <div class="stat-value">{{ $stats['total'] }}</div>
            <div class="stat-label">Total Gestionnaires</div>
        </div>
    </div>
    
    <div class="stat-card">
        <div class="stat-header">
            <div class="stat-icon">
                <i class="fas fa-user-check"></i>
            </div>
            <div class="stat-change positive">
                <i class="fas fa-arrow-up"></i>
                <span>+12%</span>
            </div>
        </div>
        <div class="stat-content">
            <div class="stat-value">{{ $stats['actifs'] }}</div>
            <div class="stat-label">Gestionnaires Actifs</div>
        </div>
    </div>
    
    <div class="stat-card">
        <div class="stat-header">
            <div class="stat-icon">
                <i class="fas fa-clock"></i>
            </div>
            <div class="stat-change positive">
                <i class="fas fa-arrow-up"></i>
                <span>+8%</span>
            </div>
        </div>
        <div class="stat-content">
            <div class="stat-value">{{ $stats['recemment_actifs'] }}</div>
            <div class="stat-label">Récemment Actifs</div>
        </div>
    </div>
    
    <div class="stat-card">
        <div class="stat-header">
            <div class="stat-icon">
                <i class="fas fa-user-slash"></i>
            </div>
            <div class="stat-change negative">
                <i class="fas fa-arrow-down"></i>
                <span>-3%</span>
            </div>
        </div>
        <div class="stat-content">
            <div class="stat-value">{{ $stats['inactifs'] + $stats['suspendus'] + $stats['en_conge'] }}</div>
            <div class="stat-label">Inactifs/Suspendus</div>
        </div>
    </div>
</div>

<!-- Actions et Filtres -->
<div class="row mb-4">
    <div class="col-12">
        <div class="content-card">
            <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
                <div class="d-flex gap-2">
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createModal">
                        <i class="fas fa-plus me-1"></i>
                        Nouveau Gestionnaire
                    </button>
                    <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#importModal">
                        <i class="fas fa-upload me-1"></i>
                        Import Excel
                    </button>
                    <a href="{{ route('gestionnaires.export') }}" class="btn btn-outline-secondary">
                        <i class="fas fa-download me-1"></i>
                        Exporter
                    </a>
                </div>
                
                <div class="d-flex gap-2">
                    <form method="GET" action="{{ route('gestionnaires.index') }}" class="d-flex gap-2">
                        <select name="statut" class="form-select form-select-sm" style="min-width: 150px;">
                            <option value="">Tous les statuts</option>
                            <option value="actif" {{ request('statut') == 'actif' ? 'selected' : '' }}>Actif</option>
                            <option value="inactif" {{ request('statut') == 'inactif' ? 'selected' : '' }}>Inactif</option>
                            <option value="suspendu" {{ request('statut') == 'suspendu' ? 'selected' : '' }}>Suspendu</option>
                            <option value="en_conge" {{ request('statut') == 'en_conge' ? 'selected' : '' }}>En congé</option>
                        </select>
                        
                        <input type="text" name="search" class="form-control form-control-sm" 
                               placeholder="Rechercher..." value="{{ request('search') }}" style="min-width: 200px;">
                        
                        <button type="submit" class="btn btn-outline-primary btn-sm">
                            <i class="fas fa-search"></i>
                        </button>
                        
                        @if(request('statut') || request('search'))
                            <a href="{{ route('gestionnaires.index') }}" class="btn btn-outline-secondary btn-sm">
                                <i class="fas fa-times"></i>
                            </a>
                        @endif
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Liste des Gestionnaires -->
<div class="row">
    <div class="col-12">
        <div class="content-card">
            @if($gestionnaires->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>
                                    <a href="{{ request()->fullUrlWithQuery(['sort_by' => 'nom', 'sort_order' => request('sort_by') == 'nom' && request('sort_order') == 'asc' ? 'desc' : 'asc']) }}" 
                                       class="text-decoration-none text-dark">
                                        Nom Complet
                                        @if(request('sort_by') == 'nom')
                                            <i class="fas fa-sort-{{ request('sort_order') == 'asc' ? 'up' : 'down' }} ms-1"></i>
                                        @else
                                            <i class="fas fa-sort ms-1 text-muted"></i>
                                        @endif
                                    </a>
                                </th>
                                <th>Email</th>
                                <th>Entreprise</th>
                                <th>
                                    <a href="{{ request()->fullUrlWithQuery(['sort_by' => 'statut', 'sort_order' => request('sort_by') == 'statut' && request('sort_order') == 'asc' ? 'desc' : 'asc']) }}" 
                                       class="text-decoration-none text-dark">
                                        Statut
                                        @if(request('sort_by') == 'statut')
                                            <i class="fas fa-sort-{{ request('sort_order') == 'asc' ? 'up' : 'down' }} ms-1"></i>
                                        @else
                                            <i class="fas fa-sort ms-1 text-muted"></i>
                                        @endif
                                    </a>
                                </th>
                                <th>Dernière Connexion</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($gestionnaires as $gestionnaire)
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="avatar me-3">
                                                {{ strtoupper(substr($gestionnaire->prenoms, 0, 1) . substr($gestionnaire->nom, 0, 1)) }}
                                            </div>
                                            <div>
                                                <div class="fw-semibold">{{ $gestionnaire->nom_complet }}</div>
                                                <small class="text-muted">{{ $gestionnaire->telephone }}</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td>{{ $gestionnaire->email }}</td>
                                    <td>
                                        @if($gestionnaire->entreprises->count() > 0)
                                            <div class="d-flex flex-wrap gap-1">
                                                @foreach($gestionnaire->entreprises->take(2) as $entreprise)
                                                    <span class="badge bg-light text-dark">{{ $entreprise->nom_entreprise }}</span>
                                                @endforeach
                                                @if($gestionnaire->entreprises->count() > 2)
                                                    <span class="badge bg-secondary">+{{ $gestionnaire->entreprises->count() - 2 }} autres</span>
                                                @endif
                                            </div>
                                        @else
                                            <span class="text-muted">Aucune entreprise assignée</span>
                                        @endif
                                    </td>
                                    <td>
                                        <span class="badge bg-{{ $gestionnaire->statut == 'actif' ? 'success' : ($gestionnaire->statut == 'inactif' ? 'secondary' : ($gestionnaire->statut == 'suspendu' ? 'danger' : 'warning')) }}">
                                            {{ ucfirst(str_replace('_', ' ', $gestionnaire->statut)) }}
                                        </span>
                                    </td>
                                    <td>
                                        <small class="text-muted">Non disponible</small>
                                    </td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('gestionnaires.show', $gestionnaire) }}" 
                                               class="btn btn-sm btn-outline-primary" title="Voir">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="{{ route('gestionnaires.edit', $gestionnaire) }}" 
                                               class="btn btn-sm btn-outline-secondary" title="Modifier">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <button type="button" class="btn btn-sm btn-outline-info dropdown-toggle dropdown-toggle-split" 
                                                    data-bs-toggle="dropdown" title="Plus d'actions">
                                            </button>
                                            <ul class="dropdown-menu">
                                                <li>
                                                    <a class="dropdown-item" href="#" onclick="updateStatut({{ $gestionnaire->id }}, 'actif')">
                                                        <i class="fas fa-check text-success me-2"></i>Activer
                                                    </a>
                                                </li>
                                                <li>
                                                    <a class="dropdown-item" href="#" onclick="updateStatut({{ $gestionnaire->id }}, 'inactif')">
                                                        <i class="fas fa-pause text-warning me-2"></i>Désactiver
                                                    </a>
                                                </li>
                                                <li>
                                                    <a class="dropdown-item" href="#" onclick="updateStatut({{ $gestionnaire->id }}, 'suspendu')">
                                                        <i class="fas fa-ban text-danger me-2"></i>Suspendre
                                                    </a>
                                                </li>
                                                <li><hr class="dropdown-divider"></li>
                                                <li>
                                                    <form action="{{ route('gestionnaires.destroy', $gestionnaire) }}" method="POST" class="d-inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="dropdown-item text-danger" 
                                                                onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce gestionnaire ?')">
                                                            <i class="fas fa-trash me-2"></i>Supprimer
                                                        </button>
                                                    </form>
                                                </li>
                                            </ul>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                
                <!-- Pagination -->
                <div class="d-flex justify-content-center mt-4">
                    {{ $gestionnaires->appends(request()->query())->links() }}
                </div>
            @else
                <div class="text-center py-5">
                    <i class="fas fa-users" style="font-size: 4rem; color: var(--gray-300); margin-bottom: 20px;"></i>
                    <h4 style="color: var(--gray-500); margin-bottom: 10px;">Aucun gestionnaire trouvé</h4>
                    <p style="color: var(--gray-400);">Aucun gestionnaire ne correspond à vos critères de recherche.</p>
                    <a href="{{ route('gestionnaires.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus me-1"></i>
                        Créer le premier gestionnaire
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>

<!-- Modal Création Gestionnaire -->
<div class="modal fade" id="createModal" tabindex="-1" aria-labelledby="createModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createModalLabel">
                    <i class="fas fa-user-plus me-2"></i>
                    Créer un Nouveau Gestionnaire
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('gestionnaires.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="row">
                        <!-- Colonne gauche -->
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="prenoms" class="form-label">Prénoms *</label>
                                <input type="text" class="form-control @error('prenoms') is-invalid @enderror" 
                                       id="prenoms" name="prenoms" value="{{ old('prenoms') }}" required>
                                @error('prenoms')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="mb-3">
                                <label for="nom" class="form-label">Nom *</label>
                                <input type="text" class="form-control @error('nom') is-invalid @enderror" 
                                       id="nom" name="nom" value="{{ old('nom') }}" required>
                                @error('nom')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="mb-3">
                                <label for="email" class="form-label">Email *</label>
                                <input type="email" class="form-control @error('email') is-invalid @enderror" 
                                       id="email" name="email" value="{{ old('email') }}" required>
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        
                        <!-- Colonne droite -->
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="telephone" class="form-label">Téléphone</label>
                                <input type="tel" class="form-control @error('telephone') is-invalid @enderror" 
                                       id="telephone" name="telephone" value="{{ old('telephone') }}">
                                @error('telephone')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="mb-3">
                                <label for="statut" class="form-label">Statut *</label>
                                <select class="form-select @error('statut') is-invalid @enderror" 
                                        id="statut" name="statut" required>
                                    <option value="">Sélectionner un statut</option>
                                    <option value="actif" {{ old('statut') == 'actif' ? 'selected' : '' }}>Actif</option>
                                    <option value="inactif" {{ old('statut') == 'inactif' ? 'selected' : '' }}>Inactif</option>
                                    <option value="suspendu" {{ old('statut') == 'suspendu' ? 'selected' : '' }}>Suspendu</option>
                                    <option value="en_conge" {{ old('statut') == 'en_conge' ? 'selected' : '' }}>En congé</option>
                                </select>
                                @error('statut')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="mb-3">
                                <label for="notes" class="form-label">Notes</label>
                                <textarea class="form-control @error('notes') is-invalid @enderror" 
                                          id="notes" name="notes" rows="3" 
                                          placeholder="Informations supplémentaires">{{ old('notes') }}</textarea>
                                @error('notes')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    
                    <!-- Informations importantes -->
                    <div class="alert alert-info mt-3">
                        <div class="d-flex align-items-start">
                            <i class="fas fa-info-circle me-2 mt-1"></i>
                            <div>
                                <strong>Information importante :</strong>
                                <ul class="mb-0 mt-2">
                                    <li>Un compte utilisateur sera automatiquement créé</li>
                                    <li>Les identifiants seront envoyés par email</li>
                                    <li>Le gestionnaire devra changer son mot de passe</li>
                                    <li>Les entreprises seront assignées après la création</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-1"></i>
                        Créer le gestionnaire
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Import Excel -->
<div class="modal fade" id="importModal" tabindex="-1" aria-labelledby="importModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="importModalLabel">
                    <i class="fas fa-upload me-2"></i>
                    Import de Gestionnaires
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('gestionnaires.import') }}" method="POST" enctype="multipart/form-data" id="importForm">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="excel_file" class="form-label">Fichier Excel</label>
                        <input type="file" class="form-control" id="excel_file" name="excel_file" 
                               accept=".xlsx,.xls" required>
                        <div class="form-text">
                            Formats acceptés : .xlsx, .xls (Max: 2MB)
                        </div>
                    </div>
                    
                    <div class="alert alert-info">
                        <h6 class="alert-heading">
                            <i class="fas fa-info-circle me-2"></i>
                            Instructions d'import
                        </h6>
                        <ul class="mb-0">
                            <li>Le fichier doit contenir les colonnes : Prénoms, Nom, Email, Téléphone, Statut</li>
                            <li>Les statuts valides sont : actif, inactif, suspendu, en_conge</li>
                            <li>Un compte utilisateur sera créé pour chaque gestionnaire</li>
                            <li>Les identifiants seront envoyés par email</li>
                        </ul>
                    </div>
                    
                    <div class="mb-3">
                        <a href="{{ route('gestionnaires.template') }}" class="btn btn-outline-primary btn-sm">
                            <i class="fas fa-download me-1"></i>
                            Télécharger le modèle
                        </a>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                    <button type="submit" class="btn btn-primary" id="importBtn">
                        <i class="fas fa-upload me-1"></i>
                        Importer
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
.avatar {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    background: linear-gradient(135deg, var(--primary-color), var(--primary-dark));
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-weight: 600;
    font-size: 0.9rem;
}

.table th {
    border-top: none;
    font-weight: 600;
    color: var(--gray-700);
    background: var(--gray-50);
}

.table td {
    vertical-align: middle;
    border-top: 1px solid var(--gray-200);
}

.btn-group .dropdown-toggle-split {
    border-left: 1px solid var(--gray-300);
}

.dropdown-item {
    padding: 8px 16px;
    font-size: 0.9rem;
}

.dropdown-item:hover {
    background: var(--gray-50);
}
</style>
@endpush

@push('scripts')
<script>
function updateStatut(gestionnaireId, statut) {
    if (!confirm('Êtes-vous sûr de vouloir modifier le statut de ce gestionnaire ?')) {
        return;
    }
    
    fetch(`/gestionnaires/${gestionnaireId}/statut`, {
        method: 'PATCH',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'Content-Type': 'application/json',
            'Accept': 'application/json',
        },
        body: JSON.stringify({ statut: statut })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            location.reload();
        } else {
            alert('Erreur lors de la modification du statut');
        }
    })
    .catch(error => {
        console.error('Erreur:', error);
        alert('Erreur lors de la modification du statut');
    });
}

// Gestion des modals - Solution Radicale
document.addEventListener('DOMContentLoaded', function() {
    console.log('🚀 Initialisation des modals...');
    
    // Initialiser Bootstrap si disponible
    if (typeof bootstrap !== 'undefined') {
        console.log('✅ Bootstrap est chargé, version:', bootstrap.Modal.VERSION);
    } else {
        console.error('❌ Bootstrap n\'est pas chargé!');
        // Fallback: créer nos propres modals
        initCustomModals();
        return;
    }
    
    // Initialiser les modals Bootstrap
    initBootstrapModals();
});

function initBootstrapModals() {
    console.log('🔧 Initialisation des modals Bootstrap...');
    
    const createModal = document.getElementById('createModal');
    const importModal = document.getElementById('importModal');
    
    if (createModal) {
        console.log('📝 Modal de création trouvé');
        const bsModal = new bootstrap.Modal(createModal, {
            backdrop: 'static',
            keyboard: true,
            focus: true
        });
        
        // Gérer l'ouverture
        document.querySelector('[data-bs-target="#createModal"]').addEventListener('click', function(e) {
            e.preventDefault();
            console.log('🔓 Ouverture du modal de création');
            bsModal.show();
        });
        
        // Gérer la fermeture
        createModal.addEventListener('hidden.bs.modal', function() {
            console.log('🔒 Modal de création fermé');
            const form = createModal.querySelector('form');
            if (form) {
                form.reset();
                // Supprimer les messages d'erreur
                const invalidFeedbacks = createModal.querySelectorAll('.is-invalid');
                invalidFeedbacks.forEach(el => el.classList.remove('is-invalid'));
            }
        });
        
        // Focus sur le premier champ
        createModal.addEventListener('shown.bs.modal', function() {
            console.log('👁️ Modal de création affiché');
            const firstInput = createModal.querySelector('input, select, textarea');
            if (firstInput) {
                firstInput.focus();
            }
        });
    }
    
    if (importModal) {
        console.log('📤 Modal d\'import trouvé');
        const bsModal = new bootstrap.Modal(importModal, {
            backdrop: 'static',
            keyboard: true,
            focus: true
        });
        
        // Gérer l'ouverture
        document.querySelector('[data-bs-target="#importModal"]').addEventListener('click', function(e) {
            e.preventDefault();
            console.log('🔓 Ouverture du modal d\'import');
            bsModal.show();
        });
        
        // Gérer la fermeture
        importModal.addEventListener('hidden.bs.modal', function() {
            console.log('🔒 Modal d\'import fermé');
            const form = document.getElementById('importForm');
            if (form) {
                form.reset();
            }
        });
    }
    
    // Gestion de l'import
    const importForm = document.getElementById('importForm');
    if (importForm) {
        importForm.addEventListener('submit', function(e) {
            console.log('📤 Soumission du formulaire d\'import');
            const fileInput = document.getElementById('excel_file');
            const importBtn = document.getElementById('importBtn');
            
            if (fileInput.files.length === 0) {
                e.preventDefault();
                alert('Veuillez sélectionner un fichier');
                return;
            }
            
            // Désactiver le bouton pendant l'import
            importBtn.disabled = true;
            importBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-1"></i>Import en cours...';
        });
    }
}

function initCustomModals() {
    console.log('🔧 Initialisation des modals personnalisés...');
    
    // Créer des modals fonctionnels sans Bootstrap
    const modals = document.querySelectorAll('.modal');
    modals.forEach(modal => {
        const modalId = modal.id;
        const trigger = document.querySelector(`[data-bs-target="#${modalId}"]`);
        
        if (trigger) {
            trigger.addEventListener('click', function(e) {
                e.preventDefault();
                showCustomModal(modalId);
            });
        }
        
        // Bouton de fermeture
        const closeBtn = modal.querySelector('.btn-close');
        if (closeBtn) {
            closeBtn.addEventListener('click', function() {
                hideCustomModal(modalId);
            });
        }
        
        // Fermer en cliquant sur le backdrop
        modal.addEventListener('click', function(e) {
            if (e.target === modal) {
                hideCustomModal(modalId);
            }
        });
    });
}

function showCustomModal(modalId) {
    console.log('🔓 Ouverture du modal personnalisé:', modalId);
    const modal = document.getElementById(modalId);
    if (modal) {
        modal.style.display = 'block';
        modal.classList.add('show');
        
        // Créer le backdrop
        const backdrop = document.createElement('div');
        backdrop.className = 'modal-backdrop show';
        backdrop.id = 'custom-backdrop';
        document.body.appendChild(backdrop);
        
        // Focus sur le premier champ
        const firstInput = modal.querySelector('input, select, textarea');
        if (firstInput) {
            firstInput.focus();
        }
    }
}

function hideCustomModal(modalId) {
    console.log('🔒 Fermeture du modal personnalisé:', modalId);
    const modal = document.getElementById(modalId);
    if (modal) {
        modal.style.display = 'none';
        modal.classList.remove('show');
        
        // Supprimer le backdrop
        const backdrop = document.getElementById('custom-backdrop');
        if (backdrop) {
            backdrop.remove();
        }
        
        // Réinitialiser le formulaire
        const form = modal.querySelector('form');
        if (form) {
            form.reset();
        }
    }
}

// Fonction pour forcer la fermeture des modals
function forceCloseModals() {
    console.log('🔄 Fermeture forcée de tous les modals');
    const modals = document.querySelectorAll('.modal');
    modals.forEach(modal => {
        if (typeof bootstrap !== 'undefined') {
            const modalInstance = bootstrap.Modal.getInstance(modal);
            if (modalInstance) {
                modalInstance.hide();
            }
        } else {
            hideCustomModal(modal.id);
        }
    });
}

// Fermer les modals avec Escape
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        forceCloseModals();
    }
});

// Debug: Afficher l'état des modals
window.debugModals = function() {
    console.log('🔍 Debug des modals:');
    const modals = document.querySelectorAll('.modal');
    modals.forEach(modal => {
        console.log(`- ${modal.id}:`, {
            display: modal.style.display,
            classes: modal.className,
            visible: modal.classList.contains('show'),
            bootstrap: typeof bootstrap !== 'undefined'
        });
    });
};
</script>
@endpush
