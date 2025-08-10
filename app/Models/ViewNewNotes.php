<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ViewNewNotes extends Model
{
    use HasFactory;
    protected $table = 'v_ensembletable';
    protected $fillable = ['idetudiant' , 'nom' , 'prenom' , 'etu' , 'genre' , 'idpromotion' , 'idsemestre' , 'semestre' , 'idmatiere' , 'reference' , 'matiere' , 'coefficient' , 'etat' , 'promotion' , 'note' , 'idcategorie' , 'categorie'];
}
