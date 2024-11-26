<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Consultation extends Model
{
    use HasFactory;

    protected $fillable = ['title'];

    
    public function students()
    {
        return $this->belongsToMany(Student::class, 'consultation_student')
        ->withPivot(['topic', 'date', 'time', 'cancellation_reason', 'status'])
        ->withTimestamps();
}
    }

