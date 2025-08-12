<?php

namespace App\Services;

use App\Models\User;
use App\Notifications\CustomNotification;
use Illuminate\Support\Facades\Log;

class NotificationService
{
    /**
     * Notification de connexion réussie
     */
    public static function loginSuccess(User $user)
    {
        try {
            $user->notify(new \App\Notifications\CustomNotification(
                "Connexion réussie - Bienvenue {$user->name} !",
                'success'
            ));
            
            Log::info("Notification de connexion envoyée à l'utilisateur {$user->id}");
        } catch (\Exception $e) {
            Log::error("Erreur lors de l'envoi de la notification de connexion: " . $e->getMessage());
        }
    }

    /**
     * Notification de déconnexion
     */
    public static function logout(User $user)
    {
        try {
            $user->notify(new \App\Notifications\CustomNotification(
                "Déconnexion - À bientôt {$user->name} !",
                'info'
            ));
            
            Log::info("Notification de déconnexion envoyée à l'utilisateur {$user->id}");
        } catch (\Exception $e) {
            Log::error("Erreur lors de l'envoi de la notification de déconnexion: " . $e->getMessage());
        }
    }

    /**
     * Notification de changement de mot de passe
     */
    public static function passwordChanged(User $user)
    {
        try {
            $user->notify(new \App\Notifications\CustomNotification(
                "Votre mot de passe a été changé avec succès",
                'success'
            ));
            
            Log::info("Notification de changement de mot de passe envoyée à l'utilisateur {$user->id}");
        } catch (\Exception $e) {
            Log::error("Erreur lors de l'envoi de la notification de changement de mot de passe: " . $e->getMessage());
        }
    }

    /**
     * Notification de réinitialisation de mot de passe
     */
    public static function passwordReset(User $user)
    {
        try {
            $user->notify(new \App\Notifications\CustomNotification(
                "Un lien de réinitialisation de mot de passe vous a été envoyé par email",
                'info'
            ));
            
            Log::info("Notification de réinitialisation de mot de passe envoyée à l'utilisateur {$user->id}");
        } catch (\Exception $e) {
            Log::error("Erreur lors de l'envoi de la notification de réinitialisation: " . $e->getMessage());
        }
    }

    /**
     * Notification de création d'assuré
     */
    public static function assureCreated(User $user, $assureName)
    {
        try {
            $user->notify(new \App\Notifications\CustomNotification(
                "L'assuré {$assureName} a été créé avec succès",
                'success'
            ));
            
            Log::info("Notification de création d'assuré envoyée à l'utilisateur {$user->id}");
        } catch (\Exception $e) {
            Log::error("Erreur lors de l'envoi de la notification de création d'assuré: " . $e->getMessage());
        }
    }

    /**
     * Notification d'import Excel
     */
    public static function importSuccess(User $user, $count)
    {
        try {
            $user->notify(new \App\Notifications\CustomNotification(
                "Import Excel réussi - {$count} assuré(s) importé(s)",
                'success'
            ));
            
            Log::info("Notification d'import Excel envoyée à l'utilisateur {$user->id}");
        } catch (\Exception $e) {
            Log::error("Erreur lors de l'envoi de la notification d'import: " . $e->getMessage());
        }
    }

    /**
     * Notification d'erreur d'import
     */
    public static function importError(User $user, $error)
    {
        try {
            $user->notify(new \App\Notifications\CustomNotification(
                "Erreur lors de l'import Excel: {$error}",
                'error'
            ));
            
            Log::info("Notification d'erreur d'import envoyée à l'utilisateur {$user->id}");
        } catch (\Exception $e) {
            Log::error("Erreur lors de l'envoi de la notification d'erreur d'import: " . $e->getMessage());
        }
    }

    /**
     * Notification de traitement de demande
     */
    public static function demandeProcessed(User $user, $demandeId, $status)
    {
        try {
            $user->notify(new \App\Notifications\CustomNotification(
                "Demande #{$demandeId} traitée - Statut: {$status}",
                'info'
            ));
            
            Log::info("Notification de traitement de demande envoyée à l'utilisateur {$user->id}");
        } catch (\Exception $e) {
            Log::error("Erreur lors de l'envoi de la notification de traitement: " . $e->getMessage());
        }
    }

    /**
     * Notification d'erreur système
     */
    public static function systemError(User $user, $error)
    {
        try {
            $user->notify(new \App\Notifications\CustomNotification(
                "Erreur système: {$error}",
                'error'
            ));
            
            Log::error("Notification d'erreur système envoyée à l'utilisateur {$user->id}");
        } catch (\Exception $e) {
            Log::error("Erreur lors de l'envoi de la notification d'erreur système: " . $e->getMessage());
        }
    }

    /**
     * Notification d'avertissement
     */
    public static function warning(User $user, $message)
    {
        try {
            $user->notify(new \App\Notifications\CustomNotification($message, 'warning'));
            
            Log::warning("Notification d'avertissement envoyée à l'utilisateur {$user->id}: {$message}");
        } catch (\Exception $e) {
            Log::error("Erreur lors de l'envoi de la notification d'avertissement: " . $e->getMessage());
        }
    }
}
