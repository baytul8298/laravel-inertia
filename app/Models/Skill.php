<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Skill extends Model
{
    protected $table = 'skills';

    protected $fillable = ['name', 'title', 'description', 'image', 'is_active'];

    public function skillItems(): HasMany
    {
        return $this->hasMany(SkillItem::class);
    }
}
