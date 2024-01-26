<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Exam extends Model
{
    use HasFactory;

    public function stdClass()
    {
         return $this->belongsTo(StdClass::class, 'std_class_id');
    }

    public function mark()
    {
        return $this->hasMany(Mark::class, 'exam_id');
    }



}
