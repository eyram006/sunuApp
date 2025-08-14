@extends('layouts.app')

@section('title', 'Import de Gestionnaires')

@section('content')
<div class="page-header">
    <h1 class="page-title">Import de Gestionnaires</h1>
    <p class="page-subtitle">Importez en masse des gestionnaires depuis un fichier Excel.</p>
    <a href="{{ route('gestionnaires.index') }}" class="btn btn-light btn-sm"><i class="fas fa-arrow-left me-1"></i>Retour</a>
</div>

<div class="content-card">
    <form action="{{ route('gestionnaires.import') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="mb-3">
            <label for="excel_file" class="form-label">Fichier Excel</label>
            <input type="file" class="form-control @error('excel_file') is-invalid @enderror" id="excel_file" name="excel_file" accept=".xlsx,.xls" required>
            @error('excel_file')<div class="invalid-feedback">{{ $message }}</div>@enderror
            <div class="form-text">Formats acceptés : .xlsx, .xls (Max: 2MB)</div>
        </div>
        <div class="alert alert-info">
            <h6 class="alert-heading"><i class="fas fa-info-circle me-2"></i>Instructions d'import</h6>
            <ul class="mb-0">
                <li>Le fichier doit contenir les colonnes : Prénoms, Nom, Email, Téléphone, Statut, Notes</li>
                <li>Les statuts valides sont : actif, inactif, suspendu, en_conge</li>
                <li>Un compte utilisateur sera créé pour chaque gestionnaire</li>
            </ul>
        </div>
        <div class="d-flex justify-content-between">
            <a href="{{ route('gestionnaires.template') }}" class="btn btn-outline-primary"><i class="fas fa-download me-1"></i>Télécharger le modèle</a>
            <button type="submit" class="btn btn-success"><i class="fas fa-upload me-1"></i>Importer</button>
        </div>
    </form>
</div>
@endsection


