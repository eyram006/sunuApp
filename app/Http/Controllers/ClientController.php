<?php

namespace App\Http\Controllers;

use App\Models\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ClientController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $clients = Client::withCount(['users', 'assures'])->paginate(10);
        return view('clients.index', compact('clients'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('clients.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nom_entreprise' => 'required|string|max:255',
            'raison_sociale' => 'nullable|string|max:255',
            'adresse' => 'required|string',
            'telephone' => 'required|string|max:255',
            'email' => 'required|email|unique:clients,email',
        ]);

        try {
            $client = Client::create([
                'nom_entreprise' => $request->nom_entreprise,
                'raison_sociale' => $request->raison_sociale,
                'adresse' => $request->adresse,
                'telephone' => $request->telephone,
                'email' => $request->email,
                'token_acces' => Client::generateToken(),
                'statut' => 'actif'
            ]);

            return redirect()->route('clients.index')->with('success', 'Client créé avec succès !');
        } catch (\Exception $e) {
            Log::error('Erreur lors de la création du client: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Erreur lors de la création du client');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $client = Client::with(['users', 'assures'])->findOrFail($id);
        return view('clients.show', compact('client'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $client = Client::findOrFail($id);
        return view('clients.edit', compact('client'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $client = Client::findOrFail($id);
        
        $request->validate([
            'nom_entreprise' => 'required|string|max:255',
            'raison_sociale' => 'nullable|string|max:255',
            'adresse' => 'required|string',
            'telephone' => 'required|string|max:255',
            'email' => 'required|email|unique:clients,email,' . $id,
        ]);

        try {
            $client->update($request->only(['nom_entreprise', 'raison_sociale', 'adresse', 'telephone', 'email']));
            return redirect()->route('clients.index')->with('success', 'Client mis à jour avec succès !');
        } catch (\Exception $e) {
            Log::error('Erreur lors de la mise à jour du client: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Erreur lors de la mise à jour du client');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $client = Client::findOrFail($id);
            $client->delete();
            return redirect()->route('clients.index')->with('success', 'Client supprimé avec succès !');
        } catch (\Exception $e) {
            Log::error('Erreur lors de la suppression du client: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Erreur lors de la suppression du client');
        }
    }
}
