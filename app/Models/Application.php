<?php

namespace App\Models;

use App\Observers\ApplicationObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Model;

#[ObservedBy([ApplicationObserver::class])]
class Application extends Model
{
    protected $guarded = [];

    public function student(){
        return $this->belongsTo(Student::class, 'student_id');
    }

    public function groups()
    {
        return $this->hasManyThrough(Group::class, Application::class);
    }

    public function getGroupNameAttribute(){
        return $this->student->group->name ?? null;
    }
}
