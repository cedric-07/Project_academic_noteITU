<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExportCSV extends Model
{
    use HasFactory;
    protected $notes;

    public function __construct($notes)
    {
        $this->notes = $notes;
    }

    public function collection()
    {
        return collect($this->notes);
    }

    public function headings(): array
    {
        return [
            'UE',
            'Intitulé',
            'Crédit',
            'Note/20',
            'Résultat',
            'Session',
        ];
    }

    public function map($note): array
    {
        return [
            $note->reference,
            $note->matiere,
            $note->coefficient,
            $note->note,
            $this->getResult($note->note),
            \Carbon\Carbon::parse($note->date)->format('d/m/Y'),
        ];
    }

    private function getResult($note)
    {
        if ($note >= 10 && $note <= 11.99) return 'P';
        if ($note >= 12 && $note <= 13.99) return 'AB';
        if ($note >= 14 && $note <= 15.99) return 'B';
        if ($note >= 16 && $note <= 20) return 'TB';
        return 'Aj';
    }
}
