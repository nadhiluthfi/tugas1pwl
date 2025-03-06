<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    protected $fillable = ['name', 'email', 'school_id'];

    public function school()
    {
        return $this->belongsTo(School::class);
    }
}

