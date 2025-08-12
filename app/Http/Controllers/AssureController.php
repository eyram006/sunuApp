<?php

namespace App\Http\Controllers;

use App\Models\Assure;
use App\Models\Beneficiaire;
use App\Models\Client;
use App\Exports\AssuresExport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Log;

class AssureController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $assures = Assure::with(['user', 'client'])
            ->when(request('client_id'), function($query, $clientId) {
                return $query->where('client_id', $clientId);
            })
            ->paginate(15);
        
        $clients = Client::all();
        return view('assures.index', compact('assures', 'clients'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $clients = Client::all();
        return view('assures.create', compact('clients'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'client_id' => 'required|exists:clients,id',
            'nom' => 'required|string|max:255',
            'prenoms' => 'required|string|max:255',
            'sexe' => 'required|in:M,F',
            'email' => 'required|email|unique:users,email',
            'contact' => 'required|string|max:255',
            'addresse' => 'required|string',
            'date_de_naissance' => 'required|date',
            'anciennete' => 'nullable|string|max:255',
            'statut' => 'nullable|string|max:255',
        ]);

        try {
            // Créer l'utilisateur
            $user = \App\Models\User::create([
                'name' => $request->nom . ' ' . $request->prenoms,
                'email' => $request->email,
                'password' => bcrypt('password123'), // Mot de passe temporaire
                'client_id' => $request->client_id,
            ]);

            $user->assignRole('assure');

            // Créer l'assuré
            $assure = Assure::create([
                'user_id' => $user->id,
                'client_id' => $request->client_id,
                'nom' => $request->nom,
                'prenoms' => $request->prenoms,
                'sexe' => $request->sexe,
                'contact' => $request->contact,
                'addresse' => $request->addresse,
                'date_de_naissance' => $request->date_de_naissance,
                'anciennete' => $request->anciennete,
                'statut' => $request->statut ?? 'actif',
                'type' => 'principal'
            ]);

            return redirect()->route('assures.index')->with('success', 'Assuré créé avec succès !');
        } catch (\Exception $e) {
            Log::error('Erreur lors de la création de l\'assuré: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Erreur lors de la création de l\'assuré');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $assure = Assure::with(['user', 'client', 'beneficiaires', 'demandes', 'cartes'])->findOrFail($id);
        return view('assures.show', compact('assure'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $assure = Assure::with('user')->findOrFail($id);
        $clients = Client::all();
        return view('assures.edit', compact('assure', 'clients'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $assure = Assure::with('user')->findOrFail($id);
        
        $request->validate([
            'client_id' => 'required|exists:clients,id',
            'nom' => 'required|string|max:255',
            'prenoms' => 'required|string|max:255',
            'sexe' => 'required|in:M,F',
            'email' => 'required|email|unique:users,email,' . $assure->user_id,
            'contact' => 'required|string|max:255',
            'addresse' => 'required|string',
            'date_de_naissance' => 'required|date',
            'anciennete' => 'nullable|string|max:255',
            'statut' => 'nullable|string|max:255',
        ]);

        try {
            // Mettre à jour l'utilisateur
            $assure->user->update([
                'name' => $request->nom . ' ' . $request->prenoms,
                'email' => $request->email,
                'client_id' => $request->client_id,
            ]);

            // Mettre à jour l'assuré
            $assure->update($request->only([
                'client_id', 'nom', 'prenoms', 'sexe', 'contact', 
                'addresse', 'date_de_naissance', 'anciennete', 'statut'
            ]));

            return redirect()->route('assures.index')->with('success', 'Assuré mis à jour avec succès !');
        } catch (\Exception $e) {
            Log::error('Erreur lors de la mise à jour de l\'assuré: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Erreur lors de la mise à jour de l\'assuré');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $assure = Assure::with('user')->findOrFail($id);
            $assure->user->delete(); // Cela supprimera aussi l'assuré grâce à la contrainte CASCADE
            return redirect()->route('assures.index')->with('success', 'Assuré supprimé avec succès !');
        } catch (\Exception $e) {
            Log::error('Erreur lors de la suppression de l\'assuré: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Erreur lors de la suppression de l\'assuré');
        }
    }

    /**
     * Exporter les assurés en Excel
     */
    public function export(Request $request)
    {
        $clientId = $request->get('client_id');
        $filename = 'assures_' . date('Y-m-d_H-i-s') . '.xlsx';
        
        return Excel::download(new AssuresExport($clientId), $filename);
    }

    /**
     * Ajouter un bénéficiaire
     */
    public function addBeneficiaire(Request $request, string $id)
    {
        $assure = Assure::findOrFail($id);
        
        $request->validate([
            'nom' => 'required|string|max:255',
            'prenoms' => 'required|string|max:255',
            'sexe' => 'required|in:M,F',
            'contact' => 'required|string|max:255',
            'addresse' => 'required|string',
            'date_de_naissance' => 'required|date',
            'type_beneficiaire' => 'required|in:enfant,epoux,epouse',
        ]);

        try {
            Beneficiaire::create([
                'assure_principal_id' => $assure->id,
                'nom' => $request->nom,
                'prenoms' => $request->prenoms,
                'sexe' => $request->sexe,
                'contact' => $request->contact,
                'addresse' => $request->addresse,
                'date_de_naissance' => $request->date_de_naissance,
                'type_beneficiaire' => $request->type_beneficiaire,
                'statut' => 'actif'
            ]);

            return redirect()->back()->with('success', 'Bénéficiaire ajouté avec succès !');
        } catch (\Exception $e) {
            Log::error('Erreur lors de l\'ajout du bénéficiaire: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Erreur lors de l\'ajout du bénéficiaire');
        }
    }
}
