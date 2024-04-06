<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;
        /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $primaryKey = 'categories_id';
    public $timestamps = true;

    protected $fillable = [
        'name',
        'active',
        'status'
    ];

    protected $guarded = [
        'categories_id'
    ];
}
