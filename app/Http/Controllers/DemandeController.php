<?php

namespace App\Http\Controllers;

use App\Models\Demande;
use App\Models\Assure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class DemandeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();
        
        if ($user->hasRole('admin')) {
            $demandes = Demande::with(['assure.user', 'assure.client', 'gestionnaire'])
                ->latest()
                ->paginate(15);
        } elseif ($user->hasRole('gestionnaire')) {
            $demandes = Demande::with(['assure.user', 'assure.client'])
                ->where('gestionnaire_id', $user->id)
                ->orWhereNull('gestionnaire_id')
                ->latest()
                ->paginate(15);
        } else {
            // Assuré - voir seulement ses propres demandes
            $demandes = Demande::with(['assure.user', 'assure.client', 'gestionnaire'])
                ->whereHas('assure', function($query) use ($user) {
                    $query->where('user_id', $user->id);
                })
                ->latest()
                ->paginate(15);
        }
        
        return view('demandes.index', compact('demandes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $user = Auth::user();
        
        if ($user->hasRole('assure')) {
            $assure = $user->assure;
            if (!$assure) {
                return redirect()->back()->with('error', 'Vous devez d\'abord créer votre profil d\'assuré');
            }
        }
        
        return view('demandes.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $user = Auth::user();
        
        if (!$user->hasRole('assure')) {
            return redirect()->back()->with('error', 'Accès non autorisé');
        }
        
        $request->validate([
            'pieces_justificatives' => 'required|string',
        ]);

        try {
            $assure = $user->assure;
            
            if (!$assure) {
                return redirect()->back()->with('error', 'Profil d\'assuré non trouvé');
            }
            
            $demande = Demande::create([
                'assure_id' => $assure->id,
                'statut' => 'en_attente',
                'pieces_justificatives' => $request->pieces_justificatives,
            ]);

            return redirect()->route('demandes.index')->with('success', 'Demande créée avec succès !');
        } catch (\Exception $e) {
            Log::error('Erreur lors de la création de la demande: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Erreur lors de la création de la demande');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $demande = Demande::with(['assure.user', 'assure.client', 'gestionnaire'])->findOrFail($id);
        
        // Vérifier les permissions
        $user = Auth::user();
        if (!$user->hasRole('admin') && !$user->hasRole('gestionnaire')) {
            if ($demande->assure->user_id !== $user->id) {
                abort(403);
            }
        }
        
        return view('demandes.show', compact('demande'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $demande = Demande::with(['assure.user', 'assure.client'])->findOrFail($id);
        
        // Seuls les gestionnaires et admins peuvent modifier les demandes
        $user = Auth::user();
        if (!$user->hasRole('admin') && !$user->hasRole('gestionnaire')) {
            abort(403);
        }
        
        return view('demandes.edit', compact('demande'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $demande = Demande::findOrFail($id);
        
        // Seuls les gestionnaires et admins peuvent modifier les demandes
        $user = Auth::user();
        if (!$user->hasRole('admin') && !$user->hasRole('gestionnaire')) {
            abort(403);
        }
        
        $request->validate([
            'statut' => 'required|in:en_attente,validee,rejetee',
            'commentaires_gestionnaire' => 'nullable|string',
        ]);

        try {
            $demande->update([
                'statut' => $request->statut,
                'commentaires_gestionnaire' => $request->commentaires_gestionnaire,
                'gestionnaire_id' => Auth::id(),
                'date_traitement' => now(),
            ]);

            // TODO: Envoyer une notification à l'assuré

            return redirect()->route('demandes.index')->with('success', 'Demande mise à jour avec succès !');
        } catch (\Exception $e) {
            Log::error('Erreur lors de la mise à jour de la demande: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Erreur lors de la mise à jour de la demande');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $demande = Demande::findOrFail($id);
        
        // Seuls les admins peuvent supprimer les demandes
        if (!Auth::user()->hasRole('admin')) {
            abort(403);
        }
        
        try {
            $demande->delete();
            return redirect()->route('demandes.index')->with('success', 'Demande supprimée avec succès !');
        } catch (\Exception $e) {
            Log::error('Erreur lors de la suppression de la demande: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Erreur lors de la suppression de la demande');
        }
    }

    /**
     * Traiter une demande (pour les gestionnaires)
     */
    public function traiter(Request $request, string $id)
    {
        $demande = Demande::findOrFail($id);
        
        $user = Auth::user();
        if (!$user->hasRole('admin') && !$user->hasRole('gestionnaire')) {
            abort(403);
        }
        
        $request->validate([
            'statut' => 'required|in:validee,rejetee',
            'commentaires_gestionnaire' => 'nullable|string',
        ]);

        try {
            $demande->update([
                'statut' => $request->statut,
                'commentaires_gestionnaire' => $request->commentaires_gestionnaire,
                'gestionnaire_id' => Auth::id(),
                'date_traitement' => now(),
            ]);

            // TODO: Envoyer une notification à l'assuré

            return redirect()->back()->with('success', 'Demande traitée avec succès !');
        } catch (\Exception $e) {
            Log::error('Erreur lors du traitement de la demande: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Erreur lors du traitement de la demande');
        }
    }
}
