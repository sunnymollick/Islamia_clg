<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Enroll extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_code',
        'student_id',
        'class_id',
        'section_id',
        'optional_subject_id',
        'roll',
        'year',
        'uploaded_by'
    ];

    public function section()
    {
         return $this->belongsTo(Section::class, 'section_id');
    }

    public function student()
    {
        return $this->belongsTo(Student::class, 'student_code', 'code');
    }

    public function subject()
    {
        // return $this->belongsTo(Student::class, 'optional_subject_id');
        return $this->belongsTo(Subject::class, 'optional_subject_id');
    }

    public function mark()
    {
        return $this->hasMany(Mark::class, 'enroll_id');
    }
}
