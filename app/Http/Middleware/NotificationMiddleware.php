<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class NotificationMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        // Si l'utilisateur est connecté et que c'est une requête AJAX
        if (Auth::check() && $request->ajax()) {
            // Ajouter le nombre de notifications non lues à la réponse
            $unreadCount = Auth::user()->unreadNotifications()->count();
            $response->headers->set('X-Unread-Notifications', $unreadCount);
        }

        return $response;
    }
}
