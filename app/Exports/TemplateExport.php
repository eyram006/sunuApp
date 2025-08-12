<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Fill;

class TemplateExport implements FromArray, WithHeadings, WithStyles
{
    /**
     * @return array
     */
    public function array(): array
    {
        return [
            [
                'Doe',
                'John',
                'M',
                'john.doe@example.com',
                '+1234567890',
                '123 Main Street, Ville',
                '15/01/1990',
                '5 ans',
                'actif'
            ],
            [
                'Smith',
                'Jane',
                'F',
                'jane.smith@example.com',
                '+1234567891',
                '456 Oak Avenue, Ville',
                '22/03/1985',
                '3 ans',
                'actif'
            ],
            [
                'Johnson',
                'Mike',
                'M',
                'mike.johnson@example.com',
                '+1234567892',
                '789 Pine Road, Ville',
                '10/07/1992',
                '1 an',
                'actif'
            ]
        ];
    }

    /**
     * @return array
     */
    public function headings(): array
    {
        return [
            'nom',
            'prenoms',
            'sexe',
            'email',
            'contact',
            'addresse',
            'date_de_naissance',
            'anciennete',
            'statut'
        ];
    }

    /**
     * @param Worksheet $sheet
     */
    public function styles(Worksheet $sheet)
    {
        // Style pour l'en-tête
        $sheet->getStyle('A1:I1')->applyFromArray([
            'font' => [
                'bold' => true,
                'color' => ['rgb' => 'FFFFFF'],
            ],
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => ['rgb' => '2E86AB'],
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical' => Alignment::VERTICAL_CENTER,
            ],
        ]);

        // Style pour les exemples
        $sheet->getStyle('A2:I4')->applyFromArray([
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => ['rgb' => 'F8F9FA'],
            ],
            'font' => [
                'color' => ['rgb' => '6C757D'],
            ],
        ]);

        // Ajuster la largeur des colonnes
        $sheet->getColumnDimension('A')->setWidth(15); // nom
        $sheet->getColumnDimension('B')->setWidth(15); // prenoms
        $sheet->getColumnDimension('C')->setWidth(10); // sexe
        $sheet->getColumnDimension('D')->setWidth(25); // email
        $sheet->getColumnDimension('E')->setWidth(15); // contact
        $sheet->getColumnDimension('F')->setWidth(30); // addresse
        $sheet->getColumnDimension('G')->setWidth(20); // date_de_naissance
        $sheet->getColumnDimension('H')->setWidth(15); // anciennete
        $sheet->getColumnDimension('I')->setWidth(15); // statut

        // Centrer le contenu
        $sheet->getStyle('A:I')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('A:I')->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);

        // Ajouter des instructions
        $sheet->insertNewRowBefore(1, 3);
        $sheet->mergeCells('A1:I1');
        $sheet->setCellValue('A1', 'TEMPLATE D\'IMPORT DES ASSURÉS - SUNU SANTÉ');
        $sheet->getStyle('A1')->applyFromArray([
            'font' => [
                'bold' => true,
                'size' => 16,
                'color' => ['rgb' => '2E86AB'],
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
            ],
        ]);

        $sheet->mergeCells('A2:I2');
        $sheet->setCellValue('A2', 'Instructions : Remplissez ce template avec les informations de vos employés, puis importez-le dans le système.');
        $sheet->getStyle('A2')->applyFromArray([
            'font' => [
                'italic' => true,
                'color' => ['rgb' => '6C757D'],
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
            ],
        ]);

        $sheet->mergeCells('A3:I3');
        $sheet->setCellValue('A3', 'Format des dates : JJ/MM/AAAA | Sexe : M (Masculin) ou F (Féminin) | Statut : actif ou inactif');
        $sheet->getStyle('A3')->applyFromArray([
            'font' => [
                'size' => 10,
                'color' => ['rgb' => '6C757D'],
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
            ],
        ]);

        // Ajuster les numéros de ligne après l'insertion
        $sheet->getStyle('A4:I4')->applyFromArray([
            'font' => [
                'bold' => true,
                'color' => ['rgb' => 'FFFFFF'],
            ],
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => ['rgb' => '2E86AB'],
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical' => Alignment::VERTICAL_CENTER,
            ],
        ]);

        $sheet->getStyle('A5:I7')->applyFromArray([
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => ['rgb' => 'F8F9FA'],
            ],
            'font' => [
                'color' => ['rgb' => '6C757D'],
            ],
        ]);
    }
}
