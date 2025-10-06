<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Feaure extends Model
{
    protected $fillable = ['name', 'key', 'description'];

    public function plans()
    {
        return $this->belongsToMany(Plan::class, 'feature_plan');
    }
}
