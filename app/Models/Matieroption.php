<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Matieroption extends Model
{
    use HasFactory;
    protected $table = 'matieroption';
    protected $primaryKey = 'idmatopt';
    protected $fillable = ['codematiere' , 'groupe'];

    public function matiere()
    {
        return $this->belongsTo(Matiere::class, 'codematiere', 'reference');
    }
}
