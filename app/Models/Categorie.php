<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Categorie extends Model
{
    use HasFactory;
    protected $table = 'categories';
    protected $primaryKey = 'idcategorie';
    protected $fillable = ['nom' , 'created_at' , 'updated_at'];

    public function semestre()
    {
        return $this->belongsTo(Semestre::class , 'idsemestre');
    }
}
