<?php

namespace App\Exports;

use App\Models\Assure;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class AssuresExport implements FromCollection, WithHeadings, WithMapping
{
    protected $clientId;

    public function __construct($clientId = null)
    {
        $this->clientId = $clientId;
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        $query = Assure::with(['user', 'client']);
        
        if ($this->clientId) {
            $query->where('client_id', $this->clientId);
        }
        
        return $query->get();
    }

    /**
     * En-têtes des colonnes
     */
    public function headings(): array
    {
        return [
            'ID',
            'Nom',
            'Prénoms',
            'Sexe',
            'Email',
            'Contact',
            'Adresse',
            'Date de naissance',
            'Ancienneté',
            'Statut',
            'Type',
            'Entreprise',
            'Date de création'
        ];
    }

    /**
     * Mapping des données
     */
    public function map($assure): array
    {
        return [
            $assure->id,
            $assure->nom,
            $assure->prenoms,
            $assure->sexe,
            $assure->user->email ?? '',
            $assure->contact,
            $assure->addresse,
            $assure->date_de_naissance->format('d/m/Y'),
            $assure->anciennete,
            $assure->statut,
            $assure->type,
            $assure->client->nom_entreprise ?? '',
            $assure->created_at->format('d/m/Y H:i')
        ];
    }
}
