<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Promotion extends Model
{
    use HasFactory;

    protected $table = 'promotions';
    protected $primaryKey = 'idpromotion';
    protected $fillable = ['nom' , 'datedebut' , 'datefin' , 'created_at' , 'updated_at'];
}
