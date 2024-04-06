<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserRole extends Model
{
    protected $primaryKey = 'user_role_id';
    public $timestamps = false;

    protected $fillable = [
        'user_id', 
        'role_id'
    ];

}
