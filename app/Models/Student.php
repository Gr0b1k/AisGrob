<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    protected $guarded = [];

    public function group(){
        return $this->belongsTo(Group::class, 'group_id');
    }

    public function orders(){
        return $this->belongsTo(Orders::class, 'orders_id');
    }

    public function applications()
    {
        return $this->hasMany(Application::class);
    }
}
