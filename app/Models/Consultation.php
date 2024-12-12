<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Consultation extends Model
{
    use HasFactory;

    protected $fillable = ['topic', 'date_time', 'is_active'];

    protected $casts = [
        'date_time' => 'datetime', 
    ];

    public function users()
    {
        return $this->belongsToMany(User::class, 'my_consultations')
                    ->withPivot('topic')
                    ->withTimestamps();
    }

    public function creator()
{
return $this->belongsTo(User::class, 'created_by');
}

}
    

