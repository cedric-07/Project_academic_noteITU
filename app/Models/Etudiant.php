<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Etudiant extends Authenticatable
{
    use HasFactory;

    protected $guard = 'etudiants';
    protected $table = 'etudiants';
    protected $primaryKey = 'idetudiant';
    protected $fillable = ['nom', 'prenom', 'numetu', 'dtn', 'idpromotion', 'created_at', 'updated_at' , 'genre'];

    public function notes()
    {
        return $this->hasMany(Note::class);
    }

    public function promotion()
    {
        return $this->belongsTo(Promotion::class, 'idpromotion');
    }

    public function isEtudiant()
    {
        return true;
    }


}

