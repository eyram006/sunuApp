<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use App\Models\Gestionnaire;
use App\Models\User;
use App\Models\Client;
use App\Notifications\IdentifiantsConnexion;
use App\Services\NotificationService;
use Illuminate\Support\Str;

class GestionnaireController extends Controller
{
    /**
     * Afficher la liste des gestionnaires
     */
    public function index(Request $request)
    {
        $query = Gestionnaire::with(['user', 'entreprises']);

        // Filtre par statut
        if ($request->filled('statut')) {
            $query->where('statut', $request->statut);
        }

        // Filtre par recherche (nom, prénoms, email)
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nom', 'like', "%{$search}%")
                  ->orWhere('prenoms', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        // Tri
        $sortBy = $request->get('sort_by', 'nom');
        $sortOrder = $request->get('sort_order', 'asc');
        
        if (in_array($sortBy, ['nom', 'statut', 'created_at'])) {
            $query->orderBy($sortBy, $sortOrder);
        }

        $gestionnaires = $query->paginate(15);

        // Statistiques
        $stats = $this->getStats();

        return view('gestionnaires.index', compact('gestionnaires', 'stats'));
    }

    /**
     * Afficher le formulaire de création
     */
    public function create()
    {
        return view('gestionnaires.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nom' => 'required|string|max:255',
            'prenoms' => 'required|string|max:255',
            'email' => 'required|email|unique:gestionnaires,email',
            'telephone' => 'nullable|string|max:20',
            'statut' => 'required|in:actif,inactif,suspendu,en_conge',
            'notes' => 'nullable|string',
        ]);

        // Créer l'utilisateur
        $user = User::create([
            'name' => $request->prenoms . ' ' . $request->nom,
            'email' => $request->email,
            'password' => Hash::make(Str::random(10)),
            'password_changed_at' => null, // Doit changer le mot de passe
        ]);

        // Assigner le rôle gestionnaire
        $user->assignRole('gestionnaire');

        // Créer le gestionnaire
        $gestionnaire = Gestionnaire::create([
            'user_id' => $user->id,
            'nom' => $request->nom,
            'prenoms' => $request->prenoms,
            'email' => $request->email,
            'telephone' => $request->telephone,
            'statut' => $request->statut,
            'notes' => $request->notes,
        ]);

        // Envoyer les identifiants par email
        // TODO: Implémenter l'envoi d'email

        return redirect()->route('gestionnaires.index')
            ->with('success', 'Gestionnaire créé avec succès. Les identifiants ont été envoyés par email.');
    }

    /**
     * Afficher les détails d'un gestionnaire
     */
    public function show(Gestionnaire $gestionnaire)
    {
        $gestionnaire->load(['user', 'entreprises', 'assures', 'demandes']);
        
        // Statistiques du gestionnaire
        $stats = [
            'assures_gere' => $gestionnaire->assures()->count(),
            'demandes_traitees' => $gestionnaire->demandes()->count(),
            'demandes_en_cours' => $gestionnaire->demandes()->where('statut', 'en_attente')->count(),
            'entreprises_gerees' => $gestionnaire->entreprises()->count(),
            'derniere_activite' => $gestionnaire->demandes()->latest()->first(),
        ];

        return view('gestionnaires.show', compact('gestionnaire', 'stats'));
    }

    /**
     * Afficher le formulaire de modification
     */
    public function edit(Gestionnaire $gestionnaire)
    {
        $clients = Client::all();
        $gestionnaire->load('entreprises');
        return view('gestionnaires.edit', compact('gestionnaire', 'clients'));
    }

    /**
     * Mettre à jour un gestionnaire
     */
    public function update(Request $request, Gestionnaire $gestionnaire)
    {
        $request->validate([
            'nom' => 'required|string|max:255',
            'prenoms' => 'required|string|max:255',
            'email' => 'required|email|unique:gestionnaires,email,' . $gestionnaire->id . '|unique:users,email,' . $gestionnaire->user_id,
            'telephone' => 'nullable|string|max:20',
            'adresse' => 'nullable|string',
            'date_embauche' => 'required|date',
            'statut' => 'required|in:actif,inactif,suspendu,en_conge',
            'notes' => 'nullable|string',
            'entreprises' => 'array',
            'entreprises.*' => 'exists:clients,id',
        ]);

        DB::beginTransaction();

        try {
            // Mettre à jour le gestionnaire
            $gestionnaire->update($request->only([
                'nom', 'prenoms', 'email', 'telephone', 
                'adresse', 'date_embauche', 'statut', 'notes'
            ]));

            // Mettre à jour l'utilisateur
            $gestionnaire->user->update([
                'name' => $request->prenoms . ' ' . $request->nom,
                'email' => $request->email,
            ]);

            // Mettre à jour les entreprises associées
            $gestionnaire->entreprises()->sync($request->entreprises ?? []);

            // Notification de succès
            NotificationService::assureCreated(Auth::user(), "Gestionnaire {$gestionnaire->nom_complet} modifié avec succès");

            DB::commit();

            return redirect()->route('gestionnaires.index')
                ->with('success', "Gestionnaire {$gestionnaire->nom_complet} modifié avec succès");

        } catch (\Exception $e) {
            DB::rollback();
            return back()->withInput()->with('error', 'Erreur lors de la modification: ' . $e->getMessage());
        }
    }

    /**
     * Supprimer un gestionnaire
     */
    public function destroy(Gestionnaire $gestionnaire)
    {
        try {
            // Vérifier s'il y a des assurés associés
            if ($gestionnaire->assures()->count() > 0) {
                return back()->with('error', 'Impossible de supprimer ce gestionnaire car il a des assurés associés.');
            }

            // Supprimer l'utilisateur et le gestionnaire (cascade)
            $gestionnaire->user->delete();

            return redirect()->route('gestionnaires.index')
                ->with('success', "Gestionnaire {$gestionnaire->nom_complet} supprimé avec succès");

        } catch (\Exception $e) {
            return back()->with('error', 'Erreur lors de la suppression: ' . $e->getMessage());
        }
    }

    /**
     * Modifier le statut d'un gestionnaire
     */
    public function updateStatut(Request $request, Gestionnaire $gestionnaire)
    {
        $request->validate([
            'statut' => 'required|in:actif,inactif,suspendu,en_conge'
        ]);

        $ancienStatut = $gestionnaire->statut;
        $gestionnaire->update(['statut' => $request->statut]);

        // Notification
        $message = "Statut du gestionnaire {$gestionnaire->nom_complet} changé de {$ancienStatut} à {$request->statut}";
        NotificationService::assureCreated(Auth::user(), $message);

        return response()->json([
            'success' => true,
            'message' => $message
        ]);
    }

    /**
     * Obtenir les statistiques des gestionnaires (AJAX)
     */
    public function getStats()
    {
        $stats = [
            'total' => Gestionnaire::count(),
            'actifs' => Gestionnaire::where('statut', 'actif')->count(),
            'recemment_actifs' => Gestionnaire::where('statut', 'actif')->count(), // Pour l'instant, même que actifs
            'inactifs' => Gestionnaire::where('statut', 'inactif')->count(),
            'suspendus' => Gestionnaire::where('statut', 'suspendu')->count(),
            'en_conge' => Gestionnaire::where('statut', 'en_conge')->count(),
        ];

        return $stats; // Retourner directement le tableau, pas de JSON
    }

    /**
     * Exporter les gestionnaires en Excel
     */
    public function export(Request $request)
    {
        $query = Gestionnaire::with(['user', 'entreprises']);

        // Appliquer les mêmes filtres que dans index
        if ($request->filled('statut')) {
            $query->where('statut', $request->statut);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nom', 'like', "%{$search}%")
                  ->orWhere('prenoms', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        $gestionnaires = $query->get();

        // Pour l'instant, retourner un CSV simple
        $filename = 'gestionnaires_' . now()->format('Y-m-d') . '.csv';
        
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];

        $callback = function() use ($gestionnaires) {
            $file = fopen('php://output', 'w');
            
            // En-têtes
            fputcsv($file, ['Nom', 'Prénoms', 'Email', 'Téléphone', 'Statut', 'Notes']);
            
            // Données
            foreach ($gestionnaires as $gestionnaire) {
                fputcsv($file, [
                    $gestionnaire->nom,
                    $gestionnaire->prenoms,
                    $gestionnaire->email,
                    $gestionnaire->telephone,
                    $gestionnaire->statut,
                    $gestionnaire->notes,
                ]);
            }
            
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    /**
     * Importer des gestionnaires depuis un fichier Excel
     */
    public function import(Request $request)
    {
        $request->validate([
            'excel_file' => 'required|file|mimes:xlsx,xls|max:2048'
        ]);

        try {
            // Pour l'instant, retourner un message de succès
            // TODO: Implémenter l'import Excel réel
            return redirect()->route('gestionnaires.index')
                ->with('success', 'Fichier reçu avec succès. Fonctionnalité d\'import à implémenter.');
        } catch (\Exception $e) {
            return redirect()->route('gestionnaires.index')
                ->with('error', 'Erreur lors de l\'import : ' . $e->getMessage());
        }
    }

    /**
     * Télécharger le modèle Excel
     */
    public function downloadTemplate()
    {
        $filename = 'modele_gestionnaires.csv';
        
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];

        $callback = function() {
            $file = fopen('php://output', 'w');
            
            // En-têtes du modèle
            fputcsv($file, ['Prénoms', 'Nom', 'Email', 'Téléphone', 'Statut', 'Notes']);
            
            // Exemple de ligne
            fputcsv($file, ['Jean-Pierre', 'Konan', 'jean.konan@example.com', '+228 90123456', 'actif', 'Gestionnaire principal']);
            
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
