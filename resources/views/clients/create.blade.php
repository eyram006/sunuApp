@extends('layouts.app')

@section('title', 'Nouveau Client')

@section('content')
<div class="page-header" style="margin-bottom: 12px;">
    <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
        <div>
            <h1 class="page-title" style="margin: 0; font-size: 1.25rem;">Nouvelle Entreprise Cliente</h1>
            <p class="page-subtitle" style="margin: 4px 0 0; font-size: .9rem;">Créer une entreprise et ses informations de contact.</p>
        </div>
        <a href="{{ route('clients.index') }}" class="btn btn-light btn-sm"><i class="fas fa-arrow-left me-1"></i>Retour</a>
    </div>
</div>

<div class="content-card compact-card">
    <form action="{{ route('clients.store') }}" method="POST" class="compact-form">
        @csrf
        <div class="row g-3">
            <div class="col-md-6">
                <label for="nom_entreprise" class="form-label">Nom de l'entreprise *</label>
                <input type="text" class="form-control form-control-sm @error('nom_entreprise') is-invalid @enderror" id="nom_entreprise" name="nom_entreprise" value="{{ old('nom_entreprise') }}" required>
                @error('nom_entreprise')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="col-md-6">
                <label for="raison_sociale" class="form-label">Raison sociale</label>
                <input type="text" class="form-control form-control-sm @error('raison_sociale') is-invalid @enderror" id="raison_sociale" name="raison_sociale" value="{{ old('raison_sociale') }}">
                @error('raison_sociale')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="col-md-6">
                <label for="email" class="form-label">Email *</label>
                <input type="email" class="form-control form-control-sm @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email') }}" required>
                @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div class="col-md-6">
                <label for="telephone" class="form-label">Téléphone *</label>
                <input type="text" class="form-control form-control-sm @error('telephone') is-invalid @enderror" id="telephone" name="telephone" value="{{ old('telephone') }}" required>
                @error('telephone')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="col-md-6">
                <label for="adresse" class="form-label">Adresse *</label>
                <input type="text" class="form-control form-control-sm @error('adresse') is-invalid @enderror" id="adresse" name="adresse" value="{{ old('adresse') }}" required>
                @error('adresse')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
        </div>

        <div class="alert alert-info mt-3" style="padding: 8px 12px; font-size: .9rem;">
            <i class="fas fa-info-circle me-2"></i>
            Un jeton d'accès sera généré automatiquement pour l'intégration (statut par défaut: actif).
        </div>

        <div class="sticky-actions">
            <a href="{{ route('clients.index') }}" class="btn btn-light btn-sm">Annuler</a>
            <button type="submit" class="btn btn-primary btn-sm"><i class="fas fa-save me-1"></i>Créer</button>
        </div>
    </form>
</div>

@push('styles')
<style>
.compact-card { padding: 16px; }
.compact-form .form-label { margin-bottom: 0.25rem; font-size: .9rem; }
.compact-form .form-control { padding: .375rem .5rem; font-size: .9rem; }
.sticky-actions { position: sticky; bottom: 0; background: #fff; padding: 8px 0 0; margin-top: 8px; border-top: 1px solid var(--gray-200); display: flex; justify-content: flex-end; gap: 8px; }
</style>
@endpush
@endsection


