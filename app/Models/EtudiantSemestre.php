<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EtudiantSemestre extends Model
{
    use HasFactory;

    protected $table = 'etudiantsemestre';
    protected $primaryKey = 'id';
    protected $fillable = ['idetudiant' , 'idsemestre' , 'date' , 'created_at' , 'updated_at'];
}
