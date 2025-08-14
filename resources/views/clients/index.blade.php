@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="mb-0">
                        <i class="fas fa-building me-2"></i>
                        Gestion des Clients (Entreprises)
                    </h4>
                    <a href="{{ route('clients.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus me-2"></i>
                        Nouveau Client
                    </a>
                </div>
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            {{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Entreprise</th>
                                    <th>Raison sociale</th>
                                    <th>Email</th>
                                    <th>Téléphone</th>
                                    <th>Statut</th>
                                    <th>Assurés</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($clients as $client)
                                    <tr>
                                        <td>{{ $client->id }}</td>
                                        <td>
                                            <strong>{{ $client->nom_entreprise }}</strong>
                                            <br>
                                            <small class="text-muted">{{ $client->adresse }}</small>
                                        </td>
                                        <td>{{ $client->raison_sociale ?? '—' }}</td>
                                        <td>{{ $client->email }}</td>
                                        <td>{{ $client->telephone }}</td>
                                        <td>
                                            <span class="badge bg-{{ $client->statut === 'actif' ? 'success' : 'secondary' }}">
                                                {{ ucfirst($client->statut) }}
                                            </span>
                                        </td>
                                        <td>
                                            <span class="badge bg-info">{{ $client->assures_count ?? 0 }}</span>
                                        </td>
                                        <td>
                                            <div class="btn-group" role="group">
                                                <a href="{{ route('clients.show', $client) }}" 
                                                   class="btn btn-sm btn-outline-primary">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                <a href="{{ route('clients.edit', $client) }}" 
                                                   class="btn btn-sm btn-outline-warning">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <form action="{{ route('clients.destroy', $client) }}" 
                                                      method="POST" 
                                                      class="d-inline"
                                                      onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce client ?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-outline-danger">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center text-muted py-4">
                                            <i class="fas fa-inbox fa-3x mb-3"></i>
                                            <p>Aucun client trouvé</p>
                                            <a href="{{ route('clients.create') }}" class="btn btn-primary">
                                                Créer le premier client
                                            </a>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    @if($clients->hasPages())
                        <div class="d-flex justify-content-center">
                            {{ $clients->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
