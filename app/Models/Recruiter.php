<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Recruiter extends Model
{
    protected $fillable = [
        'user_id',
        'company_name',
        'job_title',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
