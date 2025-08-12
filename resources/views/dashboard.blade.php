@extends('layouts.app')

@section('title', 'Tableau de bord')

@php
    function getNotificationIcon($type) {
        $icons = [
            'success' => 'check-circle',
            'error' => 'exclamation-circle',
            'warning' => 'exclamation-triangle',
            'info' => 'info-circle'
        ];
        
        return $icons[$type] ?? 'info-circle';
    }
@endphp

@section('content')
<!-- En-tête de page -->
<div class="page-header">
    <h1 class="page-title">Tableau de bord Sunu Santé</h1>
    <p class="page-subtitle">Bienvenue, {{ auth()->user()->name }} ! Voici un aperçu de votre activité.</p>
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
                <span>+12%</span>
            </div>
        </div>
        <div class="stat-content">
            <div class="stat-value">{{ $stats['assures'] ?? 0 }}</div>
            <div class="stat-label">Assurés actifs</div>
        </div>
    </div>
    
    <div class="stat-card">
        <div class="stat-header">
            <div class="stat-icon">
                <i class="fas fa-file-alt"></i>
            </div>
            <div class="stat-change positive">
                <i class="fas fa-arrow-up"></i>
                <span>+8%</span>
            </div>
        </div>
        <div class="stat-content">
            <div class="stat-value">{{ $stats['demandes'] ?? 0 }}</div>
            <div class="stat-label">Demandes en cours</div>
        </div>
    </div>
    
    <div class="stat-card">
        <div class="stat-header">
            <div class="stat-icon">
                <i class="fas fa-clock"></i>
            </div>
            <div class="stat-change negative">
                <i class="fas fa-arrow-down"></i>
                <span>-3%</span>
            </div>
        </div>
        <div class="stat-content">
            <div class="stat-value">{{ $stats['en_attente'] ?? 0 }}</div>
            <div class="stat-label">En attente</div>
        </div>
    </div>
    
    @if(auth()->user()->hasRole('admin'))
    <div class="stat-card">
        <div class="stat-header">
            <div class="stat-icon">
                <i class="fas fa-building"></i>
            </div>
            <div class="stat-change positive">
                <i class="fas fa-arrow-up"></i>
                <span>+5%</span>
            </div>
        </div>
        <div class="stat-content">
            <div class="stat-value">{{ $stats['clients'] ?? 0 }}</div>
            <div class="stat-label">Entreprises</div>
        </div>
    </div>
    @endif
</div>

<!-- Contenu principal -->
<div class="dashboard-cards-row">
    <!-- Activité récente -->
    <div class="col-xl-8">
        <div class="content-card">
            <h3 style="margin-bottom: 25px; color: var(--gray-800); display: flex; align-items: center; gap: 12px;">
                <i class="fas fa-chart-line" style="color: var(--primary-color); font-size: 1.5rem;"></i>
                Activité récente
            </h3>
            
            @if(count($recentActivity) > 0)
                <div class="timeline">
                    @foreach($recentActivity as $activity)
                        <div class="timeline-item">
                            <div class="timeline-marker" style="background: var(--{{ $activity['type'] == 'success' ? 'success' : ($activity['type'] == 'error' ? 'danger' : 'primary') }});">
                                <i class="fas fa-{{ $activity['icon'] }}"></i>
                            </div>
                            <div class="timeline-content">
                                <h4 class="timeline-title">{{ $activity['title'] }}</h4>
                                <p class="timeline-text">{{ $activity['description'] }}</p>
                                <div class="timeline-meta">
                                    <i class="fas fa-clock"></i>
                                    <span>{{ $activity['time'] }}</span>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-5">
                    <i class="fas fa-chart-line" style="font-size: 3rem; color: var(--gray-300); margin-bottom: 20px;"></i>
                    <h5 style="color: var(--gray-500); margin-bottom: 10px;">Aucune activité récente</h5>
                    <p style="color: var(--gray-400);">Les activités récentes apparaîtront ici</p>
                </div>
            @endif
        </div>
    </div>
    
    <!-- Notifications récentes -->
    <div class="col-xl-4">
        <div class="content-card">
            <h3 style="margin-bottom: 25px; color: var(--gray-800); display: flex; align-items: center; gap: 12px;">
                <i class="fas fa-bell" style="color: var(--primary-color); font-size: 1.5rem;"></i>
                Notifications récentes
            </h3>
            
            @if(count($recentNotifications) > 0)
                <div class="notifications-list">
                    @foreach($recentNotifications as $notification)
                        <div class="notification-item">
                            <div class="d-flex align-items-start">
                                <div class="notification-icon">
                                    <i class="fas fa-{{ getNotificationIcon($notification->data['type'] ?? 'info') }}" 
                                       style="color: var(--primary-color);"></i>
                                </div>
                                <div class="flex-grow-1">
                                    <div class="fw-semibold" style="color: var(--gray-800); margin-bottom: 5px;">
                                        {{ $notification->data['message'] ?? 'Notification' }}
                                    </div>
                                    <small style="color: var(--gray-500);">
                                        <i class="fas fa-clock me-1"></i>
                                        {{ $notification->created_at->diffForHumans() }}
                                    </small>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                
                <div class="text-center mt-4">
                    <a href="{{ route('notifications.index') }}" class="btn btn-outline-primary btn-sm">
                        <i class="fas fa-eye me-1"></i>
                        Voir toutes les notifications
                    </a>
                </div>
            @else
                <div class="text-center py-5">
                    <i class="fas fa-bell" style="font-size: 3rem; color: var(--gray-300); margin-bottom: 20px;"></i>
                    <h5 style="color: var(--gray-500); margin-bottom: 10px;">Aucune notification</h5>
                    <p style="color: var(--gray-400);">Vous recevrez des notifications ici</p>
                </div>
            @endif
        </div>
    </div>
</div>

<!-- Actions rapides -->
<div class="row">
    <div class="col-12">
        <div class="content-card">
            <h3 style="margin-bottom: 25px; color: var(--gray-800); display: flex; align-items: center; gap: 12px;">
                <i class="fas fa-bolt" style="color: var(--primary-color); font-size: 1.5rem;"></i>
                Actions rapides
            </h3>
            
            <div class="quick-actions">
                @can('create clients')
                <a href="{{ route('clients.create') }}" class="quick-action-btn">
                    <i class="fas fa-plus-circle"></i>
                    <span>Nouvelle entreprise</span>
                </a>
                @endcan
                
                @can('create assures')
                <a href="{{ route('assures.create') }}" class="quick-action-btn">
                    <i class="fas fa-user-plus"></i>
                    <span>Nouvel assuré</span>
                </a>
                @endcan
                
                @can('create demandes')
                <a href="{{ route('demandes.create') }}" class="quick-action-btn">
                    <i class="fas fa-file-medical"></i>
                    <span>Nouvelle demande</span>
                </a>
                @endcan
                
                @can('view import')
                <a href="{{ route('import.index') }}" class="quick-action-btn">
                    <i class="fas fa-upload"></i>
                    <span>Import Excel</span>
                </a>
                @endcan
                
                @if(auth()->user()->hasRole('admin'))
                <a href="#" class="quick-action-btn">
                    <i class="fas fa-cog"></i>
                    <span>Paramètres</span>
                </a>
                @endif
                
                <a href="{{ route('dashboard') }}" class="quick-action-btn">
                    <i class="fas fa-sync-alt"></i>
                    <span>Actualiser</span>
                </a>
            </div>
        </div>
    </div>
</div>

<!-- Résumé des performances -->
<div class="row">
    <div class="col-12">
        <div class="content-card">
            <h3 style="margin-bottom: 25px; color: var(--gray-800); display: flex; align-items: center; gap: 12px;">
                <i class="fas fa-trophy" style="color: var(--primary-color); font-size: 1.5rem;"></i>
                Résumé des performances
            </h3>
            
            <div class="row">
                <div class="col-md-3">
                    <div class="text-center">
                        <div class="h4 mb-2" style="color: var(--primary-color);">{{ number_format(($stats['assures'] / max($stats['clients'], 1)) * 100, 1) }}%</div>
                        <div class="text-muted">Taux de couverture</div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="text-center">
                        <div class="h4 mb-2" style="color: var(--success);">{{ number_format(($stats['demandes'] - $stats['en_attente']) / max($stats['demandes'], 1) * 100, 1) }}%</div>
                        <div class="text-muted">Taux de traitement</div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="text-center">
                        <div class="h4 mb-2" style="color: var(--warning);">{{ $stats['en_attente'] }}</div>
                        <div class="text-muted">Demandes en attente</div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="text-center">
                        <div class="h4 mb-2" style="color: var(--info);">{{ $stats['clients'] }}</div>
                        <div class="text-muted">Entreprises partenaires</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
