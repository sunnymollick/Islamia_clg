<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Teacher extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'code',
        'qualification',
        'marital_status',
        'dob','doj',
        'gender',
        'religion',
        'blood_group',
        'address',
        'phone',
        'email',
        'password',
        'designation',
        'order',
        'file_path',
        'uploaded_by'
    ];

    public function subjectAssign()
    {
        return $this->hasMany(SubjectAssign::class, 'teacher_id');
    }


}
