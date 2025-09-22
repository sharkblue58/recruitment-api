<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

class Skill extends Model
{
    protected $fillable = [
        'title',
        'is_system_skill'
    ];

    protected $casts = [
        'is_system_skill' => 'boolean',
    ];

    /**
     * Get all of the professions that are assigned this skill.
     */
    public function professions(): MorphToMany
    {
        return $this->morphedByMany(Profession::class, 'skillable');
    }

    /**
     * Get all of the educations that are assigned this skill.
     */
    public function educations(): MorphToMany
    {
        return $this->morphedByMany(Education::class, 'skillable');
    }
}