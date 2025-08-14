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
                    <a href="{{ route('gestionnaires.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus me-1"></i>
                        Nouveau Gestionnaire
                    </a>
                    <a href="{{ route('gestionnaires.import.form') }}" class="btn btn-success">
                        <i class="fas fa-upload me-1"></i>
                        Import Excel
                    </a>
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
                                        @php
                                            $statut = $gestionnaire->statut;
                                            $badgeClass = match ($statut) {
                                                'actif' => 'bg-success',                    // vert
                                                'inactif' => 'bg-warning text-dark',        // orange
                                                'suspendu' => 'bg-danger',                  // rouge
                                                default => 'bg-secondary',
                                            };
                                        @endphp
                                        <span class="badge {{ $badgeClass }}">
                                            {{ ucfirst(str_replace('_', ' ', $statut)) }}
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

<!-- Les formulaires de création et d'import sont désormais sur des pages dédiées -->
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
// Gestion des modals - Utilisation des modals personnalisés
document.addEventListener('DOMContentLoaded', function() {
    console.log('🚀 Page gestionnaires chargée, modals personnalisés prêts !');
    
    // Les modals sont maintenant gérés automatiquement par custom-modals.js
    // Plus besoin de code complexe ici !
});

// Fonction pour mettre à jour le statut
function updateStatut(gestionnaireId, newStatut) {
    if (confirm('Êtes-vous sûr de vouloir modifier le statut de ce gestionnaire ?')) {
        fetch(`/gestionnaires/${gestionnaireId}/update-statut`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({ statut: newStatut })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Mettre à jour l'affichage
                const statutCell = document.querySelector(`#statut-${gestionnaireId}`);
                if (statutCell) {
                    statutCell.textContent = newStatut;
                    statutCell.className = `badge bg-${getStatutColor(newStatut)}`;
                }
                
                // Afficher un message de succès
                alert('Statut mis à jour avec succès !');
                
                // Recharger la page pour mettre à jour les statistiques
                location.reload();
            } else {
                alert('Erreur lors de la mise à jour du statut');
            }
        })
        .catch(error => {
            console.error('Erreur:', error);
            alert('Erreur lors de la mise à jour du statut');
        });
    }
}

// Fonction pour obtenir la couleur du badge selon le statut
function getStatutColor(statut) {
    switch(statut) {
        case 'actif': return 'success';
        case 'inactif': return 'secondary';
        case 'suspendu': return 'warning';
        case 'en_conge': return 'info';
        default: return 'secondary';
    }
}
</script>
@endpush
