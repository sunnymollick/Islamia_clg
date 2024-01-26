<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'std_class_id', 'subject_marks', 'pass_marks'];

    public function stdClass()
    {
         return $this->belongsTo(StdClass::class, 'std_class_id');
    }
    

    public function subjectAssign()
    {
        return $this->hasMany(SubjectAssign::class, 'subject_id');
    }

    public function enroll()
    {
        return $this->hasMany(Enroll::class, 'subject_id');
    }
}
