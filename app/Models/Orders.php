<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Orders extends Model
{
    protected $guarded = [];
    
    public function student(){
        return $this->belongsTo(Student::class, 'student_id');
    }

    public function students()
    {
        return $this->hasMany(Student::class);
    }

    protected $casts = [
        'students' => 'array'
    ];
}
