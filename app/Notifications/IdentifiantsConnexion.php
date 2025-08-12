<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class IdentifiantsConnexion extends Notification implements ShouldQueue
{
    use Queueable;

    protected $email;
    protected $password;
    protected $nomComplet;

    /**
     * Create a new notification instance.
     */
    public function __construct($email, $password, $nomComplet)
    {
        $this->email = $email;
        $this->password = $password;
        $this->nomComplet = $nomComplet;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Vos identifiants de connexion - Sunu Santé')
            ->greeting('Bonjour ' . $this->nomComplet . ',')
            ->line('Votre compte a été créé avec succès sur la plateforme Sunu Santé.')
            ->line('Voici vos identifiants de connexion :')
            ->line('**Email :** ' . $this->email)
            ->line('**Mot de passe temporaire :** ' . $this->password)
            ->line('**⚠️ IMPORTANT :** Vous devez changer votre mot de passe lors de votre première connexion.')
            ->action('Se connecter', url('/login'))
            ->line('Si vous avez des questions, n\'hésitez pas à contacter votre gestionnaire d\'assurance.')
            ->salutation('Cordialement, l\'équipe Sunu Santé');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'email' => $this->email,
            'password' => $this->password,
            'nom_complet' => $this->nomComplet,
        ];
    }
}
