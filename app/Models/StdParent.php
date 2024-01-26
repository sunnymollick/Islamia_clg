<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StdParent extends Model
{
    use HasFactory;
    protected $fillable = [
        'student_code',
        'name',
        'dob',
        'gender',
        'religion',
        'blood_group',
        'address',
        'phone',
        'email',
        'password',
        'file_path',
        'uploaded_by'
    ];

    public function student()
    {
        return $this->belongsTo(Student::class, 'student_id');
    }
}
