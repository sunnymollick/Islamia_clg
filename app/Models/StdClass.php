<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;

class StdClass extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function session()
    {
        return $this->belongsTo(Session::class, 'session_id');
    }

    public function section()
    {
        return $this->hasMany(Section::class, 'std_class_id');
    }

    public function exam()
    {
        return $this->hasMany(Exam::class, 'std_class_id');
    }

    public function subject()
    {
        return $this->hasMany(Subject::class, 'std_class_id');
    }

    public function educationalFees()
    {
        return $this->hasMany(EducationalFee::class);
    }

    public static function runningClasses()
    {
        return DB::table('std_classes')->leftJoin('sessions','std_classes.session_id' ,'=', 'sessions.id')
        ->select('sessions.name', 'sessions.status', 'std_classes.*')->where('sessions.status', 1)->get();
    }

    public function admission()
    {
        return $this->hasMany(AdmissionApplication::class, 'admitted_class');
    }

}
