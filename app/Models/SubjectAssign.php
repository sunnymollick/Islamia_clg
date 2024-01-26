<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubjectAssign extends Model
{
    use HasFactory;

    public function section()
    {
         return $this->belongsTo(Section::class, 'section_id');
    }

    public function subject()
    {
         return $this->belongsTo(Subject::class, 'subject_id');
    }

    public function teacher()
    {
         return $this->belongsTo(Teacher::class, 'teacher_id');
    }

    public function mark()
    {
        return $this->hasMany(Mark::class, 'subject_assign_id');
    }


}
