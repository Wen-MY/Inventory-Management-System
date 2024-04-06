<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $primaryKey = 'role_id';
    public $timestamps = true;

    protected $fillable = [
        'name'
    ];

    public function user()
    {
        return $this->hasOne(User::class);
    }
}
