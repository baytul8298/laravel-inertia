<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TechStack extends Model
{
    protected $fillable = [
        'name',
        'title',
        'description',
        'image',
        'slug',
        'sort',
        'is_active'
    ];
}
