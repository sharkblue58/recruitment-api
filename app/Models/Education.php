<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

class Education extends Model
{
    protected $fillable = [
        'college_name',
        'degree',
        'start',
        'end',
        'description',
        'candidate_id',
        'field_id'
    ];

    protected $casts = [
        'start' => 'date',
        'end' => 'date',
    ];

    /**
     * Get the candidate that owns the education.
     */
    public function candidate(): BelongsTo
    {
        return $this->belongsTo(Candidate::class);
    }

    /**
     * Get the field that owns the education.
     */
    public function field(): BelongsTo
    {
        return $this->belongsTo(Field::class);
    }

    /**
     * Get all of the skills for the education.
     */
    public function skills(): MorphToMany
    {
        return $this->morphToMany(Skill::class, 'skillable');
    }
}