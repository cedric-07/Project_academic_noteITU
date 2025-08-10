<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AvgNote extends Model
{
    use HasFactory;
    protected $table = 'v_avgnotes';
    protected $fillable = ['idetudiant' , 'idmatiere' , 'idsemestre' , 'note' , 'created_at' , 'updated_at'];

    public function etudiant()
    {
        return $this->belongsTo(Etudiant::class , 'idetudiant');
    }

    public function matiere()
    {
        return $this->belongsTo(Matiere::class , 'idmatiere');
    }

    public function semestre()
    {
        return $this->belongsTo(Semestre::class , 'idsemestre');
    }
}
