<?php

namespace App\Http\Controllers;

use App\Imports\AssuresImport;
use App\Models\Client;
use App\Notifications\IdentifiantsConnexion;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Log;

class ImportController extends Controller
{
    /**
     * Afficher le formulaire d'import
     */
    public function index()
    {
        $clients = Client::all();
        return view('import.index', compact('clients'));
    }

    /**
     * Traiter l'import du fichier Excel
     */
    public function store(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls',
            'client_id' => 'required|exists:clients,id'
        ]);

        try {
            $import = new AssuresImport($request->client_id);
            
            Excel::import($import, $request->file('file'));

            return redirect()->back()->with('success', 'Import réalisé avec succès ! Les identifiants de connexion ont été envoyés par email aux nouveaux assurés.');
        } catch (\Exception $e) {
            Log::error('Erreur lors de l\'import: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Erreur lors de l\'import: ' . $e->getMessage());
        }
    }

    /**
     * Télécharger le template Excel
     */
    public function downloadTemplate()
    {
        $headers = [
            'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            'Content-Disposition' => 'attachment; filename="template_assures.xlsx"',
        ];

        // Créer le template Excel avec Maatwebsite Excel
        return Excel::download(new \App\Exports\TemplateExport(), 'template_assures.xlsx', \Maatwebsite\Excel\Excel::XLSX, $headers);
    }
}
