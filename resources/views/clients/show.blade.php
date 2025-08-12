@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="mb-0">
                        <i class="fas fa-building me-2"></i>
                        Détails du Client
                    </h4>
                    <div>
                        <a href="{{ route('clients.edit', $client) }}" class="btn btn-warning me-2">
                            <i class="fas fa-edit me-2"></i>
                            Modifier
                        </a>
                        <a href="{{ route('clients.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left me-2"></i>
                            Retour
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <h5 class="text-primary">Informations de l'entreprise</h5>
                            <table class="table table-borderless">
                                <tr>
                                    <td><strong>Nom :</strong></td>
                                    <td>{{ $client->nom_entreprise }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Adresse :</strong></td>
                                    <td>{{ $client->adresse }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Téléphone :</strong></td>
                                    <td>{{ $client->telephone }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Email :</strong></td>
                                    <td>{{ $client->email }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Statut :</strong></td>
                                    <td>
                                        <span class="badge bg-{{ $client->statut === 'actif' ? 'success' : 'secondary' }}">
                                            {{ ucfirst($client->statut) }}
                                        </span>
                                    </td>
                                </tr>
                                <tr>
                                    <td><strong>Token d'accès :</strong></td>
                                    <td>
                                        <code class="small">{{ $client->token_acces }}</code>
                                    </td>
                                </tr>
                            </table>
                        </div>
                        
                        <div class="col-md-6">
                            <h5 class="text-success">Statistiques</h5>
                            <div class="row text-center">
                                <div class="col-6">
                                    <div class="card bg-primary text-white">
                                        <div class="card-body">
                                            <h3>{{ $client->users_count ?? 0 }}</h3>
                                            <p class="mb-0">Utilisateurs</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="card bg-success text-white">
                                        <div class="card-body">
                                            <h3>{{ $client->assures_count ?? 0 }}</h3>
                                            <p class="mb-0">Assurés</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    @if($client->assures->count() > 0)
                        <hr class="my-4">
                        <h5 class="text-info">Liste des assurés</h5>
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Nom</th>
                                        <th>Email</th>
                                        <th>Contact</th>
                                        <th>Statut</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($client->assures as $assure)
                                        <tr>
                                            <td>{{ $assure->nom_complet }}</td>
                                            <td>{{ $assure->user->email ?? 'N/A' }}</td>
                                            <td>{{ $assure->contact }}</td>
                                            <td>
                                                <span class="badge bg-{{ $assure->statut === 'actif' ? 'success' : 'secondary' }}">
                                                    {{ ucfirst($assure->statut) }}
                                                </span>
                                            </td>
                                            <td>
                                                <a href="{{ route('assures.show', $assure) }}" 
                                                   class="btn btn-sm btn-outline-primary">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <hr class="my-4">
                        <div class="text-center text-muted">
                            <i class="fas fa-users fa-3x mb-3"></i>
                            <p>Aucun assuré trouvé pour ce client</p>
                            <a href="{{ route('assures.create') }}" class="btn btn-primary">
                                <i class="fas fa-plus me-2"></i>
                                Ajouter un assuré
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
