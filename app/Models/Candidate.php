<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Candidate extends Model
{
    protected $fillable = [
        'user_id',
        'city_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
