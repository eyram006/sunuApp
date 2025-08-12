<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Client;
use App\Models\Assure;
use App\Models\Demande;
use App\Models\Notification;
use App\Services\NotificationService;

class DashboardController extends Controller
{
    /**
     * Afficher le tableau de bord
     */
    public function index()
    {
        $user = Auth::user();
        
        // Statistiques
        $stats = $this->getStats();
        
        // Activité récente
        $recentActivity = $this->getRecentActivity();
        
        // Notifications récentes
        $recentNotifications = $this->getRecentNotifications();
        
        // Envoyer une notification de connexion si c'est la première fois aujourd'hui
        $this->sendLoginNotification($user);
        
        return view('dashboard', compact('stats', 'recentActivity', 'recentNotifications'));
    }

    /**
     * Obtenir les statistiques
     */
    private function getStats()
    {
        $user = Auth::user();
        
        // Statistiques de base
        $stats = [
            'clients' => Client::count(),
            'assures' => Assure::count(),
            'demandes' => Demande::count(),
            'en_attente' => Demande::where('statut', 'en_attente')->count(),
        ];
        
        // Si l'utilisateur est authentifié et est un gestionnaire, filtrer par client
        if ($user && $user->hasRole('gestionnaire') && $user->client_id) {
            $stats['clients'] = 1; // Son propre client
            $stats['assures'] = Assure::where('client_id', $user->client_id)->count();
            $stats['demandes'] = Demande::whereHas('assure', function($query) use ($user) {
                $query->where('client_id', $user->client_id);
            })->count();
            $stats['en_attente'] = Demande::whereHas('assure', function($query) use ($user) {
                $query->where('client_id', $user->client_id);
            })->where('statut', 'en_attente')->count();
        }
        
        return $stats;
    }

    /**
     * Obtenir l'activité récente
     */
    private function getRecentActivity()
    {
        $user = Auth::user();
        $activities = [];
        
        // Dernières demandes créées (limité à 1 pour équilibrer)
        $recentDemandes = Demande::with(['assure', 'assure.client'])
            ->when($user && $user->hasRole('gestionnaire') && $user->client_id, function($query) use ($user) {
                $query->whereHas('assure', function($q) use ($user) {
                    $q->where('client_id', $user->client_id);
                });
            })
            ->latest()
            ->take(1)
            ->get();
        
        foreach ($recentDemandes as $demande) {
            $activities[] = [
                'type' => 'info',
                'icon' => 'file-alt',
                'title' => 'Nouvelle demande créée',
                'description' => "Demande #{$demande->id} pour {$demande->assure->nom_complet}",
                'time' => $demande->created_at->diffForHumans()
            ];
        }
        
        // Derniers assurés créés (limité à 1 pour équilibrer)
        $recentAssures = Assure::with('client')
            ->when($user && $user->hasRole('gestionnaire') && $user->client_id, function($query) use ($user) {
                $query->where('client_id', $user->client_id);
            })
            ->latest()
            ->take(1)
            ->get();
        
        foreach ($recentAssures as $assure) {
            $activities[] = [
                'type' => 'success',
                'icon' => 'user-plus',
                'title' => 'Nouvel assuré ajouté',
                'description' => "{$assure->nom_complet} - {$assure->client->nom}",
                'time' => $assure->created_at->diffForHumans()
            ];
        }
        
        // Derniers clients créés (admin seulement, limité à 1)
        if ($user && $user->hasRole('admin')) {
            $recentClients = Client::latest()->take(1)->get();
            
            foreach ($recentClients as $client) {
                $activities[] = [
                    'type' => 'success',
                    'icon' => 'building',
                    'title' => 'Nouvelle entreprise ajoutée',
                    'description' => $client->nom,
                    'time' => $client->created_at->diffForHumans()
                ];
            }
        }
        
        // Trier par date et prendre les 2 plus récentes
        usort($activities, function($a, $b) {
            return strtotime($b['time']) - strtotime($a['time']);
        });
        
        return array_slice($activities, 0, 2);
    }

    /**
     * Obtenir les notifications récentes
     */
    private function getRecentNotifications()
    {
        $user = Auth::user();
        
        if (!$user) {
            return collect();
        }
        
        // Retourner seulement les 2 dernières notifications
        return $user->notifications()->take(2)->get();
    }

    /**
     * Obtenir l'icône pour le type de notification
     */
    private function getNotificationIcon($type)
    {
        $icons = [
            'success' => 'check-circle',
            'error' => 'exclamation-circle',
            'warning' => 'exclamation-triangle',
            'info' => 'info-circle'
        ];
        
        return $icons[$type] ?? 'info-circle';
    }

    /**
     * Envoyer une notification de connexion
     */
    private function sendLoginNotification($user)
    {
        if (!$user) {
            return;
        }
        
        // Vérifier si l'utilisateur s'est déjà connecté aujourd'hui
        $todayLogin = $user->notifications()
            ->where('type', 'App\Notifications\CustomNotification')
            ->where('data->message', 'like', '%Connexion réussie%')
            ->whereDate('created_at', today())
            ->exists();
        
        if (!$todayLogin) {
            NotificationService::loginSuccess($user);
        }
    }

    /**
     * Obtenir les statistiques en temps réel (AJAX)
     */
    public function getStatsAjax()
    {
        $stats = $this->getStats();
        
        return response()->json($stats);
    }

    /**
     * Obtenir l'activité récente en temps réel (AJAX)
     */
    public function getActivityAjax()
    {
        $recentActivity = $this->getRecentActivity();
        
        return response()->json($recentActivity);
    }
}
