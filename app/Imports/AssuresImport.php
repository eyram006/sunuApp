<?php

namespace App\Imports;

use App\Models\User;
use App\Models\Assure;
use App\Models\Client;
use App\Notifications\IdentifiantsConnexion;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use Maatwebsite\Excel\Concerns\SkipsErrors;
use Illuminate\Support\Facades\Log;

class AssuresImport implements ToCollection, WithHeadingRow, WithValidation, SkipsOnError, SkipsErrors
{
    protected $clientId;

    public function __construct($clientId = null)
    {
        $this->clientId = $clientId;
    }

    /**
     * @param Collection $collection
     */
    public function collection(Collection $collection)
    {
        foreach ($collection as $row) {
            try {
                // Générer un mot de passe sécurisé
                $password = $this->generatePassword();
                
                // Créer l'utilisateur
                $user = User::create([
                    'name' => $row['nom'] . ' ' . $row['prenoms'],
                    'email' => $row['email'],
                    'password' => Hash::make($password),
                    'client_id' => $this->clientId,
                ]);

                // Attribuer le rôle assuré
                $user->assignRole('assure');

                // Créer l'assuré
                Assure::create([
                    'user_id' => $user->id,
                    'client_id' => $this->clientId,
                    'nom' => $row['nom'],
                    'prenoms' => $row['prenoms'],
                    'sexe' => $row['sexe'],
                    'contact' => $row['contact'] ?? '',
                    'addresse' => $row['addresse'] ?? '',
                    'date_de_naissance' => $this->parseDate($row['date_de_naissance']),
                    'anciennete' => $row['anciennete'] ?? '',
                    'statut' => $row['statut'] ?? 'actif',
                    'type' => 'principal'
                ]);

                // Envoyer l'email avec les identifiants
                $user->notify(new IdentifiantsConnexion(
                    $row['email'],
                    $password,
                    $row['nom'] . ' ' . $row['prenoms']
                ));

            } catch (\Exception $e) {
                Log::error('Erreur lors de l\'import de l\'assuré: ' . $e->getMessage(), [
                    'row' => $row->toArray()
                ]);
            }
        }
    }

    /**
     * Règles de validation
     */
    public function rules(): array
    {
        return [
            'nom' => 'required|string|max:255',
            'prenoms' => 'required|string|max:255',
            'sexe' => 'required|in:M,F',
            'email' => 'required|email|unique:users,email',
            'contact' => 'nullable|string|max:255',
            'addresse' => 'nullable|string',
            'date_de_naissance' => 'required|string',
            'anciennete' => 'nullable|string|max:255',
            'statut' => 'nullable|string|max:255',
        ];
    }

    /**
     * Gérer les erreurs
     */
    public function onError(\Throwable $e)
    {
        Log::error('Erreur lors de l\'import Excel: ' . $e->getMessage());
    }

    /**
     * Générer un mot de passe sécurisé
     */
    private function generatePassword()
    {
        return Str::random(10);
    }

    /**
     * Parser la date de naissance
     */
    private function parseDate($dateString)
    {
        // Supprimer les espaces
        $dateString = trim($dateString);
        
        // Essayer différents formats
        $formats = ['d/m/Y', 'Y-m-d', 'd-m-Y'];
        
        foreach ($formats as $format) {
            $date = \DateTime::createFromFormat($format, $dateString);
            if ($date !== false) {
                return $date->format('Y-m-d');
            }
        }
        
        // Si aucun format ne fonctionne, retourner la date actuelle
        return now()->format('Y-m-d');
    }
}
