<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Matiere extends Model
{
    use HasFactory;
    protected $table = 'matieres';
    protected $primaryKey = 'idmatiere';
    protected $fillable = ['nom' , 'reference' , 'coefficient' , 'idsemestre' , 'created_at' , 'updated_at'];

    public function matieroption()
    {
        return $this->hasOne(Matieroption::class, 'codematiere', 'reference');
    }


}
