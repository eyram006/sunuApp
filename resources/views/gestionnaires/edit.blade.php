@extends('layouts.app')

@section('title', 'Modifier Gestionnaire')

@section('content')
<div class="page-header">
    <h1 class="page-title">Modifier Gestionnaire</h1>
    <p class="page-subtitle">Mettez à jour les informations du gestionnaire.</p>
    <a href="{{ route('gestionnaires.index') }}" class="btn btn-light btn-sm"><i class="fas fa-arrow-left me-1"></i>Retour</a>
</div>

<div class="content-card">
    <form action="{{ route('gestionnaires.update', $gestionnaire) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="row">
            <div class="col-md-6">
                <div class="mb-3">
                    <label for="prenoms" class="form-label">Prénoms *</label>
                    <input type="text" class="form-control @error('prenoms') is-invalid @enderror" id="prenoms" name="prenoms" value="{{ old('prenoms', $gestionnaire->prenoms) }}" required>
                    @error('prenoms')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="mb-3">
                    <label for="nom" class="form-label">Nom *</label>
                    <input type="text" class="form-control @error('nom') is-invalid @enderror" id="nom" name="nom" value="{{ old('nom', $gestionnaire->nom) }}" required>
                    @error('nom')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Email *</label>
                    <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email', $gestionnaire->email) }}" required>
                    @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
            </div>
            <div class="col-md-6">
                <div class="mb-3">
                    <label for="telephone" class="form-label">Téléphone</label>
                    <input type="tel" class="form-control @error('telephone') is-invalid @enderror" id="telephone" name="telephone" value="{{ old('telephone', $gestionnaire->telephone) }}">
                    @error('telephone')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="mb-3">
                    <label for="statut" class="form-label">Statut *</label>
                    <select class="form-select @error('statut') is-invalid @enderror" id="statut" name="statut" required>
                        @php($current = old('statut', $gestionnaire->statut))
                        <option value="actif" {{ $current == 'actif' ? 'selected' : '' }}>Actif</option>
                        <option value="inactif" {{ $current == 'inactif' ? 'selected' : '' }}>Inactif</option>
                        <option value="suspendu" {{ $current == 'suspendu' ? 'selected' : '' }}>Suspendu</option>
                        <option value="en_conge" {{ $current == 'en_conge' ? 'selected' : '' }}>En congé</option>
                    </select>
                    @error('statut')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="mb-3">
                    <label for="notes" class="form-label">Notes</label>
                    <textarea class="form-control @error('notes') is-invalid @enderror" id="notes" name="notes" rows="3">{{ old('notes', $gestionnaire->notes) }}</textarea>
                    @error('notes')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
            </div>
        </div>

        <div class="d-flex justify-content-end gap-2">
            <a href="{{ route('gestionnaires.index') }}" class="btn btn-light">Annuler</a>
            <button type="submit" class="btn btn-primary"><i class="fas fa-save me-1"></i>Enregistrer</button>
        </div>
    </form>
</div>
@endsection


