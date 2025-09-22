<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

class Profession extends Model
{
    use HasFactory;

    protected $fillable = [
        'job_title',
        'company_name',
        'city_id',
        'start',
        'end',
        'description',
        'candidate_id'
    ];

    protected $casts = [
        'start' => 'date',
        'end' => 'date',
    ];

    /**
     * Get the candidate that owns the profession.
     */
    public function candidate(): BelongsTo
    {
        return $this->belongsTo(Candidate::class);
    }

    /**
     * Get the city that owns the profession.
     */
    public function city(): BelongsTo
    {
        return $this->belongsTo(City::class);
    }

    /**
     * Get all of the skills for the profession.
     */
    public function skills(): MorphToMany
    {
        return $this->morphToMany(Skill::class, 'skillable');
    }
}