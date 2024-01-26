<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mark extends Model
{
    use HasFactory;

    protected $fillable = [
        'subject_assign_id',
        'student_code',
        'exam_id',
        'theory_marks',
        'mcq_marks',
        'practical_marks',
        'ct_marks',
        'total_marks',
        'pass_status',
        'uploaded_by'
    ];


    public function subjectAssign()
    {
         return $this->belongsTo(SubjectAssign::class, 'subject_assign_id');
    }

    public function enroll()
    {
        return $this->belongsTo(Enroll::class, 'enroll_id');
    }

    public function exam()
    {
         return $this->belongsTo(Exam::class, 'exam_id');
    }
}
