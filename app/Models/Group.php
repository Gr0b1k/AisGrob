<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    protected $guarded = [];

    public function course(){
        return $this->belongsTo(Course::class, 'course_id');
    }
    
    public function specialization(){
        return $this->belongsTo(Specialization::class, 'specialization_id');
    }

    public function student()
    {
        return $this->hasMany(Student::class);
    }

        public function statement()
    {
        return $this->hasMany(Statement::class);
    }
}
