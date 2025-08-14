@extends('layouts.app')

@section('title', 'Détails du Gestionnaire')

@section('content')
<div class="page-header">
    <h1 class="page-title">{{ $gestionnaire->nom_complet }}</h1>
    <p class="page-subtitle">Fiche détaillée du gestionnaire</p>
    <div class="d-flex gap-2">
        <a href="{{ route('gestionnaires.index') }}" class="btn btn-light btn-sm"><i class="fas fa-arrow-left me-1"></i>Retour</a>
        <a href="{{ route('gestionnaires.edit', $gestionnaire) }}" class="btn btn-secondary btn-sm"><i class="fas fa-edit me-1"></i>Modifier</a>
    </div>
</div>

<div class="content-card mb-4">
    <div class="row">
        <div class="col-md-6">
            <div class="mb-2"><strong>Email:</strong> {{ $gestionnaire->email }}</div>
            <div class="mb-2"><strong>Téléphone:</strong> {{ $gestionnaire->telephone ?? '—' }}</div>
            <div class="mb-2">
                <strong>Statut:</strong>
                <span class="badge bg-{{ $gestionnaire->statut == 'actif' ? 'success' : ($gestionnaire->statut == 'inactif' ? 'secondary' : ($gestionnaire->statut == 'suspendu' ? 'danger' : 'warning')) }}">
                    {{ ucfirst(str_replace('_', ' ', $gestionnaire->statut)) }}
                </span>
            </div>
        </div>
        <div class="col-md-6">
            <div class="mb-2"><strong>Entreprises gérées:</strong>
                @if($gestionnaire->entreprises->count() > 0)
                    @foreach($gestionnaire->entreprises as $entreprise)
                        <span class="badge bg-light text-dark me-1">{{ $entreprise->nom_entreprise }}</span>
                    @endforeach
                @else
                    <span class="text-muted">Aucune</span>
                @endif
            </div>
            <div class="mb-2"><strong>Notes:</strong> {{ $gestionnaire->notes ?? '—' }}</div>
        </div>
    </div>
</div>

<div class="stats-grid" style="margin-top: 0;">
    <div class="stat-card" style="padding: 16px;">
        <h5 class="mb-3" style="margin: 0 0 8px;">Résumé</h5>
        <ul class="list-unstyled mb-0" style="font-size: .95rem;">
            <li><strong>Assurés gérés:</strong> {{ $stats['assures_gere'] }}</li>
            <li><strong>Demandes traitées:</strong> {{ $stats['demandes_traitees'] }}</li>
            <li><strong>Demandes en cours:</strong> {{ $stats['demandes_en_cours'] }}</li>
            <li><strong>Entreprises:</strong> {{ $stats['entreprises_gerees'] }}</li>
        </ul>
    </div>
    <div class="stat-card" style="padding: 16px;">
        <h5 class="mb-3" style="margin: 0 0 8px;">Dernière activité</h5>
        @if($stats['derniere_activite'])
            <div>{{ $stats['derniere_activite']->created_at->diffForHumans() }}</div>
        @else
            <div class="text-muted">Aucune activité récente</div>
        @endif
    </div>
</div>
@endsection


