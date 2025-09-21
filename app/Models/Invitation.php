<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Invitation extends Model
{
    protected $fillable = [
        'token',
        'email',
        'is_used',
        'expires_at',
    ];
}
