<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MoyenneSemester extends Model
{
    use HasFactory;

    protected $table = 'moyenneSemester';
    protected $primaryKey = 'idmoyenne';
    protected $fillable = ['idetudiant' , 'idsemestre' , 'moyenne' , 'created_at' , 'updated_at'];
}
