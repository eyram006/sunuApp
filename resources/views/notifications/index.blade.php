@extends('layouts.app')

@section('title', 'Notifications')

@section('content')
<!-- En-tête de page -->
<div class="page-header">
    <h1 class="page-title">Notifications</h1>
    <p class="page-subtitle">Gérez vos notifications et restez informé de l'activité de votre compte.</p>
</div>

<!-- Actions de gestion -->
<div class="row mb-4">
    <div class="col-12">
        <div class="content-card">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h5 style="margin: 0; color: var(--gray-800);">
                        <i class="fas fa-bell me-2" style="color: var(--primary-color);"></i>
                        {{ $notifications->total() }} notification(s)
                    </h5>
                    <small style="color: var(--gray-600);">
                        {{ $notifications->where('read_at', null)->count() }} non lue(s)
                    </small>
                </div>
                <div class="d-flex gap-2">
                    @if($notifications->where('read_at', null)->count() > 0)
                        <button class="btn btn-outline-primary btn-sm" onclick="markAllAsRead()">
                            <i class="fas fa-check-double me-1"></i>
                            Tout marquer comme lu
                        </button>
                    @endif
                    @if($notifications->count() > 0)
                        <button class="btn btn-outline-danger btn-sm" onclick="deleteAllNotifications()">
                            <i class="fas fa-trash me-1"></i>
                            Supprimer tout
                        </button>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Liste des notifications -->
<div class="row">
    <div class="col-12">
        <div class="content-card">
            @if($notifications->count() > 0)
                <div class="notifications-list">
                    @foreach($notifications as $notification)
                        <div class="notification-item {{ $notification->read_at ? 'read' : 'unread' }}" id="notification-{{ $notification->id }}">
                            <div class="d-flex align-items-start justify-content-between">
                                <div class="d-flex align-items-start flex-grow-1">
                                    <div class="notification-icon me-3">
                                        <i class="fas fa-{{ getNotificationIcon($notification->data['type'] ?? 'info') }}" 
                                           style="color: var(--{{ $notification->data['type'] ?? 'info' == 'success' ? 'success' : ($notification->data['type'] ?? 'info' == 'error' ? 'danger' : 'primary') }});"></i>
                                    </div>
                                    <div class="flex-grow-1">
                                        <div class="fw-semibold" style="color: var(--gray-800); margin-bottom: 5px;">
                                            {{ $notification->data['message'] ?? 'Notification' }}
                                        </div>
                                        <small style="color: var(--gray-500);">
                                            <i class="fas fa-clock me-1"></i>
                                            {{ $notification->created_at->diffForHumans() }}
                                            @if($notification->read_at)
                                                <span class="ms-2">
                                                    <i class="fas fa-check me-1"></i>
                                                    Lu le {{ $notification->read_at->format('d/m/Y à H:i') }}
                                                </span>
                                            @endif
                                        </small>
                                    </div>
                                </div>
                                <div class="notification-actions ms-3">
                                    @if(!$notification->read_at)
                                        <button class="btn btn-sm btn-outline-success me-1" onclick="markAsRead({{ $notification->id }})" title="Marquer comme lu">
                                            <i class="fas fa-check"></i>
                                        </button>
                                    @endif
                                    <button class="btn btn-sm btn-outline-danger" onclick="deleteNotification({{ $notification->id }})" title="Supprimer">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                
                <!-- Pagination -->
                @if($notifications->hasPages())
                    <div class="pagination-container mt-4">
                        {{ $notifications->links() }}
                    </div>
                @endif
            @else
                <div class="text-center py-5">
                    <i class="fas fa-bell" style="font-size: 4rem; color: var(--gray-300); margin-bottom: 20px;"></i>
                    <h4 style="color: var(--gray-500); margin-bottom: 10px;">Aucune notification</h4>
                    <p style="color: var(--gray-400);">Vous n'avez pas encore de notifications.</p>
                    <a href="{{ route('dashboard') }}" class="btn btn-primary">
                        <i class="fas fa-arrow-left me-1"></i>
                        Retour au dashboard
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>

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

@endsection

@push('styles')
<style>
.notification-item {
    padding: 20px;
    border-bottom: 1px solid var(--gray-200);
    transition: all 0.2s ease;
    border-radius: 8px;
    margin-bottom: 8px;
}

.notification-item:hover {
    background: var(--gray-50);
    transform: translateX(5px);
}

.notification-item.unread {
    background: rgba(220, 38, 38, 0.05);
    border-left: 4px solid var(--primary-color);
}

.notification-item.read {
    opacity: 0.7;
}

.notification-item:last-child {
    border-bottom: none;
}

.notification-icon {
    width: 24px;
    text-align: center;
    margin-right: 15px;
}

.notification-actions {
    opacity: 0;
    transition: opacity 0.2s ease;
}

.notification-item:hover .notification-actions {
    opacity: 1;
}

.btn-sm {
    padding: 0.25rem 0.5rem;
    font-size: 0.875rem;
}

/* Pagination styles */
.pagination-container {
    display: flex;
    justify-content: center;
    align-items: center;
    padding: 20px 0;
    border-top: 1px solid var(--gray-200);
    margin-top: 20px;
}

.pagination {
    display: flex;
    list-style: none;
    padding: 0;
    margin: 0;
    gap: 5px;
}

.pagination li {
    margin: 0;
}

.pagination .page-link {
    padding: 8px 12px;
    border: 1px solid var(--gray-300);
    background: var(--white);
    color: var(--gray-700);
    text-decoration: none;
    border-radius: 6px;
    transition: all 0.2s ease;
}

.pagination .page-link:hover {
    background: var(--gray-50);
    border-color: var(--primary-color);
    color: var(--primary-color);
}

.pagination .page-item.active .page-link {
    background: var(--primary-color);
    border-color: var(--primary-color);
    color: var(--white);
}

.pagination .page-item.disabled .page-link {
    background: var(--gray-100);
    border-color: var(--gray-200);
    color: var(--gray-400);
    cursor: not-allowed;
}
</style>
@endpush

@push('scripts')
<script>
function markAsRead(notificationId) {
    fetch(`/notifications/${notificationId}/mark-read`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'Content-Type': 'application/json',
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            const notification = document.getElementById(`notification-${notificationId}`);
            notification.classList.remove('unread');
            notification.classList.add('read');
            
            // Mettre à jour le compteur
            updateNotificationCount();
            
            showToast('success', data.message);
        }
    })
    .catch(error => {
        console.error('Erreur:', error);
        showToast('error', 'Erreur lors du marquage comme lu');
    });
}

function markAllAsRead() {
    if (!confirm('Marquer toutes les notifications comme lues ?')) {
        return;
    }
    
    fetch('/notifications/mark-all-read', {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'Content-Type': 'application/json',
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Marquer toutes les notifications comme lues visuellement
            document.querySelectorAll('.notification-item.unread').forEach(item => {
                item.classList.remove('unread');
                item.classList.add('read');
            });
            
            updateNotificationCount();
            showToast('success', data.message);
        }
    })
    .catch(error => {
        console.error('Erreur:', error);
        showToast('error', 'Erreur lors du marquage en masse');
    });
}

function deleteNotification(notificationId) {
    if (!confirm('Supprimer cette notification ?')) {
        return;
    }
    
    fetch(`/notifications/${notificationId}`, {
        method: 'DELETE',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'Content-Type': 'application/json',
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            const notification = document.getElementById(`notification-${notificationId}`);
            notification.style.opacity = '0';
            notification.style.transform = 'translateX(-100%)';
            
            setTimeout(() => {
                notification.remove();
                updateNotificationCount();
            }, 300);
            
            showToast('success', data.message);
        }
    })
    .catch(error => {
        console.error('Erreur:', error);
        showToast('error', 'Erreur lors de la suppression');
    });
}

function deleteAllNotifications() {
    if (!confirm('Êtes-vous sûr de vouloir supprimer TOUTES les notifications ? Cette action est irréversible.')) {
        return;
    }
    
    console.log('Tentative de suppression en masse...');
    
    fetch('/notifications/destroy-all', {
        method: 'DELETE',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'Content-Type': 'application/json',
            'Accept': 'application/json',
        }
    })
    .then(response => {
        console.log('Response status:', response.status);
        console.log('Response headers:', response.headers);
        return response.json();
    })
    .then(data => {
        console.log('Response data:', data);
        if (data.success) {
            // Supprimer toutes les notifications visuellement
            document.querySelectorAll('.notification-item').forEach(item => {
                item.style.opacity = '0';
                item.style.transform = 'translateX(-100%)';
            });
            
            setTimeout(() => {
                location.reload();
            }, 500);
            
            showToast('success', data.message);
        } else {
            showToast('error', data.message || 'Erreur lors de la suppression');
        }
    })
    .catch(error => {
        console.error('Erreur complète:', error);
        showToast('error', 'Erreur lors de la suppression en masse');
    });
}

function updateNotificationCount() {
    const unreadCount = document.querySelectorAll('.notification-item.unread').length;
    const totalCount = document.querySelectorAll('.notification-item').length;
    
    // Mettre à jour l'affichage du compteur
    const countElement = document.querySelector('h5');
    if (countElement) {
        countElement.innerHTML = `<i class="fas fa-bell me-2" style="color: var(--primary-color);"></i>${totalCount} notification(s)`;
    }
    
    const unreadElement = document.querySelector('small');
    if (unreadElement) {
        unreadElement.textContent = `${unreadCount} non lue(s)`;
    }
}

function showToast(type, message) {
    // Créer un toast simple
    const toast = document.createElement('div');
    toast.className = `alert alert-${type === 'success' ? 'success' : 'danger'} alert-dismissible fade show position-fixed`;
    toast.style.cssText = 'top: 20px; right: 20px; z-index: 9999; min-width: 300px;';
    toast.innerHTML = `
        <i class="fas fa-${type === 'success' ? 'check-circle' : 'exclamation-circle'} me-2"></i>
        ${message}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    `;
    
    document.body.appendChild(toast);
    
    // Auto-dismiss après 3 secondes
    setTimeout(() => {
        toast.remove();
    }, 3000);
}
</script>
@endpush
