<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AttendanceStudent extends Model
{
    use HasFactory;
    protected $fillable = [
        'attendance_date',
        'student_code',
        'class_id',
        'section_id',
        'year',
        'in_time',
        'out_time',
        'late',
        'status',
        'remarks',
    ];
}
