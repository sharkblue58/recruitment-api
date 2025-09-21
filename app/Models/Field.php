<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Field extends Model
{
    protected $fillable = [
        'title',
        'is_system_field'
    ];

    function users (){
        return $this->hasMany(User::class);
    }
}
