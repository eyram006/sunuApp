<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Notification;

class NotificationController extends Controller
{
    /**
     * Afficher la liste des notifications
     */
    public function index()
    {
        $notifications = Auth::user()->notifications()->paginate(20);
        
        return view('notifications.index', compact('notifications'));
    }

    /**
     * Marquer une notification comme lue
     */
    public function markAsRead($id)
    {
        $notification = Auth::user()->notifications()->findOrFail($id);
        $notification->markAsRead();
        
        return response()->json([
            'success' => true,
            'message' => 'Notification marquée comme lue'
        ]);
    }

    /**
     * Marquer toutes les notifications comme lues
     */
    public function markAllAsRead()
    {
        Auth::user()->unreadNotifications->markAsRead();
        
        return response()->json([
            'success' => true,
            'message' => 'Toutes les notifications ont été marquées comme lues'
        ]);
    }

    /**
     * Supprimer une notification
     */
    public function destroy($id)
    {
        $notification = Auth::user()->notifications()->findOrFail($id);
        $notification->delete();
        
        return response()->json([
            'success' => true,
            'message' => 'Notification supprimée'
        ]);
    }

    /**
     * Supprimer toutes les notifications
     */
    public function destroyAll()
    {
        try {
            $user = Auth::user();
            $count = $user->notifications()->count();
            
            \Log::info("Tentative de suppression de {$count} notifications pour l'utilisateur {$user->id}");
            
            $user->notifications()->delete();
            
            \Log::info("Suppression réussie de {$count} notifications");
            
            return response()->json([
                'success' => true,
                'message' => "Toutes les notifications ({$count}) ont été supprimées"
            ]);
        } catch (\Exception $e) {
            \Log::error("Erreur lors de la suppression des notifications: " . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de la suppression: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Obtenir les notifications non lues (pour AJAX)
     */
    public function getUnread()
    {
        $unreadNotifications = Auth::user()->unreadNotifications()->take(5)->get();
        
        return response()->json([
            'notifications' => $unreadNotifications,
            'count' => Auth::user()->unreadNotifications()->count()
        ]);
    }

    /**
     * Créer une notification personnalisée
     */
    public function createCustom(Request $request)
    {
        $request->validate([
            'message' => 'required|string|max:255',
            'type' => 'required|in:success,error,warning,info',
            'user_id' => 'required|exists:users,id'
        ]);

        $user = \App\Models\User::findOrFail($request->user_id);
        
        $user->notify(new \App\Notifications\CustomNotification(
            $request->message,
            $request->type
        ));

        return response()->json([
            'success' => true,
            'message' => 'Notification créée avec succès'
        ]);
    }
}
