<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

/**
 * Class Admin
 * @package App\Models
 * @property int $id
 * @property string $email
 * @property string $pwd
 * @method bool isAdmin()
 */
class Admin extends Authenticatable
{
    use HasFactory;

    protected $guard = 'admins';
    protected $table = 'admins';
    protected $primaryKey = 'id';
    protected $fillable = ['email', 'pwd'];

    public function isAdmin()
    {
        return true;
    }
}
