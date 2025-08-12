@extends('layouts.app')

@section('title', 'Créer un Gestionnaire')

@section('content')
<!-- En-tête de page -->
<div class="page-header">
    <h1 class="page-title">Créer un Gestionnaire</h1>
    <p class="page-subtitle">Ajoutez un nouveau gestionnaire à votre plateforme.</p>
</div>

<div class="row justify-content-center">
    <div class="col-lg-6">
        <div class="content-card">
            <form action="{{ route('gestionnaires.store') }}" method="POST">
                @csrf
                
                <div class="row">
                    <!-- Informations personnelles -->
                    <div class="col-md-6">
                        <h5 class="mb-3" style="color: var(--gray-800);">
                            <i class="fas fa-user me-2" style="color: var(--primary-color);"></i>
                            Informations personnelles
                        </h5>
                        
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
                        
                        <div class="mb-3">
                            <label for="telephone" class="form-label">Téléphone</label>
                            <input type="tel" class="form-control @error('telephone') is-invalid @enderror" 
                                   id="telephone" name="telephone" value="{{ old('telephone') }}">
                            @error('telephone')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    <!-- Informations professionnelles -->
                    <div class="col-md-6">
                        <h5 class="mb-3" style="color: var(--gray-800);">
                            <i class="fas fa-briefcase me-2" style="color: var(--primary-color);"></i>
                            Informations professionnelles
                        </h5>
                        
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
                                      placeholder="Informations supplémentaires sur le gestionnaire">{{ old('notes') }}</textarea>
                            @error('notes')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
                
                <!-- Informations importantes -->
                <div class="alert alert-info">
                    <div class="d-flex align-items-start">
                        <i class="fas fa-info-circle me-2 mt-1" style="color: var(--primary-color);"></i>
                        <div>
                            <strong>Information importante :</strong>
                            <ul class="mb-0 mt-2">
                                <li>Un compte utilisateur sera automatiquement créé pour ce gestionnaire</li>
                                <li>Les identifiants de connexion (email + mot de passe généré) seront envoyés par email</li>
                                <li>Le gestionnaire devra changer son mot de passe lors de sa première connexion</li>
                                <li>Le rôle "gestionnaire" sera automatiquement assigné</li>
                                <li>Les entreprises à gérer seront assignées après la création</li>
                            </ul>
                        </div>
                    </div>
                </div>
                
                <!-- Actions -->
                <div class="d-flex justify-content-between align-items-center">
                    <a href="{{ route('gestionnaires.index') }}" class="btn btn-outline-secondary">
                        <i class="fas fa-arrow-left me-1"></i>
                        Retour à la liste
                    </a>
                    
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-1"></i>
                        Créer le gestionnaire
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
.form-label {
    font-weight: 600;
    color: var(--gray-700);
    margin-bottom: 0.5rem;
}

.form-control, .form-select {
    border: 1px solid var(--gray-300);
    border-radius: 8px;
    padding: 0.75rem;
    transition: all 0.2s ease;
}

.form-control:focus, .form-select:focus {
    border-color: var(--primary-color);
    box-shadow: 0 0 0 0.2rem rgba(220, 38, 38, 0.15);
}

.alert {
    border-radius: 12px;
    border: none;
    background: rgba(59, 130, 246, 0.1);
}

.alert-info {
    background: rgba(59, 130, 246, 0.1);
    color: var(--gray-700);
}
</style>
@endpush
