<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Section extends Model
{
    use HasFactory;

    public function stdClass()
    {
         return $this->belongsTo(StdClass::class, 'std_class_id');
    }

    public function subjectAssign()
    {
        return $this->hasMany(SubjectAssign::class, 'section_id');
    }

    public function enroll()
    {
        return $this->hasMany(Enroll::class);
    }

}
