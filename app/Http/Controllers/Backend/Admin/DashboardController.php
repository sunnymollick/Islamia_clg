<?php

namespace App\Http\Controllers\Backend\Admin;

use App\Http\Controllers\Controller;
use App\Models\Enroll;
use App\Models\Student;
use App\Models\Teacher;
use Illuminate\Http\Request;
use View;

class DashboardController extends Controller
{
    //
    public function index()
    {
        $total_student = Enroll::all()->count();
        $total_teacher = Teacher::all()->count();
        $total_science_student =
                    Enroll::join('std_classes', 'enrolls.class_id', 'std_classes.id')
                            ->where('std_classes.name', 'XI-Science')
                            ->where('enrolls.year',config('running_session'))
                            ->get()
                            ->count();
        $total_business_student =
                    Enroll::join('std_classes', 'enrolls.class_id', 'std_classes.id')
                            ->where('std_classes.name', 'XI-Business')
                            ->where('enrolls.year', config('running_session'))
                            ->get()
                            ->count();
        $total_humanities_student =
                    Enroll::join('std_classes', 'enrolls.class_id', 'std_classes.id')
                            ->where('std_classes.name', 'XI-Humanities')
                            ->where('enrolls.year', config('running_session'))
                            ->get()
                            ->count();
        // dd($total_science_student);
        return View::make('backend.admin.home',compact('total_student','total_teacher', 'total_science_student', 'total_business_student', 'total_humanities_student'));
    }
}
