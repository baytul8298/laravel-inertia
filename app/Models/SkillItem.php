<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SkillItem extends Model
{
    protected $table = 'skill_items';
    protected $fillable = ['skill_id', 'name', 'percentage'];

    public function skill(): BelongsTo
    {
        return $this->belongsTo(Skill::class);
    }
}
