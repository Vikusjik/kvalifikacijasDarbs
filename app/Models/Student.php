<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    public function consultations()
    {
        return $this->belongsToMany(Consultation::class);
    }
}
