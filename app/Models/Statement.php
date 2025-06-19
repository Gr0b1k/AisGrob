<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Statement extends Model
{
    protected $guarded = [];

    public function group(){
        return $this->belongsTo(Group::class, 'group_id');
    }
    
    public function student()
    {
        return $this->hasMany(Student::class);
    }
}
