@extends('layouts.app')

@section('title', 'Nouveau Gestionnaire')

@section('content')
<div class="page-header" style="margin-bottom: 12px;">
    <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
        <div>
            <h1 class="page-title" style="margin: 0; font-size: 1.25rem;">Nouveau Gestionnaire</h1>
            <p class="page-subtitle" style="margin: 4px 0 0; font-size: .9rem;">Créer un nouvel employé gestionnaire Sunu Santé.</p>
        </div>
        <a href="{{ route('gestionnaires.index') }}" class="btn btn-light btn-sm"><i class="fas fa-arrow-left me-1"></i>Retour</a>
    </div>
    </div>

<div class="content-card compact-card">
    <form action="{{ route('gestionnaires.store') }}" method="POST" class="compact-form">
        @csrf
        <div class="row g-3">
            <!-- Ligne 1: Prénoms / Nom -->
            <div class="col-md-6">
                <label for="prenoms" class="form-label">Prénoms *</label>
                <input type="text" class="form-control form-control-sm @error('prenoms') is-invalid @enderror" id="prenoms" name="prenoms" value="{{ old('prenoms') }}" required>
                @error('prenoms')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="col-md-6">
                <label for="nom" class="form-label">Nom *</label>
                <input type="text" class="form-control form-control-sm @error('nom') is-invalid @enderror" id="nom" name="nom" value="{{ old('nom') }}" required>
                @error('nom')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <!-- Ligne 2: Email / Téléphone -->
            <div class="col-md-6">
                <label for="email" class="form-label">Email *</label>
                <input type="email" class="form-control form-control-sm @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email') }}" required>
                @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="col-md-6">
                <label for="telephone" class="form-label">Téléphone</label>
                <input type="tel" class="form-control form-control-sm @error('telephone') is-invalid @enderror" id="telephone" name="telephone" value="{{ old('telephone') }}">
                @error('telephone')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <!-- Ligne 3: Statut / Notes -->
            <div class="col-md-4">
                <label for="statut" class="form-label">Statut *</label>
                <select class="form-select form-select-sm @error('statut') is-invalid @enderror" id="statut" name="statut" required>
                    <option value="">Sélectionner</option>
                    <option value="actif" {{ old('statut') == 'actif' ? 'selected' : '' }}>Actif</option>
                    <option value="inactif" {{ old('statut') == 'inactif' ? 'selected' : '' }}>Inactif</option>
                    <option value="suspendu" {{ old('statut') == 'suspendu' ? 'selected' : '' }}>Suspendu</option>
                    <option value="en_conge" {{ old('statut') == 'en_conge' ? 'selected' : '' }}>En congé</option>
                </select>
                @error('statut')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="col-md-8">
                <label for="notes" class="form-label">Notes</label>
                <textarea class="form-control form-control-sm @error('notes') is-invalid @enderror" id="notes" name="notes" rows="2" placeholder="Informations supplémentaires (facultatif)">{{ old('notes') }}</textarea>
                @error('notes')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
        </div>

        <div class="alert alert-info mt-3" style="padding: 8px 12px; font-size: .9rem;">
            <i class="fas fa-info-circle me-2"></i>
            Un compte utilisateur sera créé automatiquement et les identifiants seront envoyés par email. Le gestionnaire devra changer son mot de passe à la première connexion.
        </div>

        <div class="sticky-actions mb-0 pb-0" style="margin-bottom:0; padding-bottom:0;">
            <a href="{{ route('gestionnaires.index') }}" class="btn btn-light btn-sm">Annuler</a>
            <button type="submit" class="btn btn-primary btn-sm"><i class="fas fa-save me-1"></i>Créer</button>
        </div>
    </form>
</div>

@push('styles')
<style>
.compact-card { padding: 16px; }
.compact-form .form-label { margin-bottom: 0.25rem; font-size: .9rem; }
.compact-form .form-control, .compact-form .form-select { padding: .375rem .5rem; font-size: .9rem; }
.sticky-actions { position: sticky; bottom: 0; background: #fff; padding: 8px 0 0; margin-top: 8px; border-top: 1px solid var(--gray-200); display: flex; justify-content: flex-end; gap: 8px; }
@media (max-height: 800px) {
  .compact-card { padding: 12px; }
}
</style>
@endpush
@endsection

