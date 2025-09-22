<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Field extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'is_system_field'
    ];

    protected $casts = [
        'is_system_field' => 'boolean',
    ];

    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }

    public function educations(): HasMany
    {
        return $this->hasMany(Education::class);
    }
}
