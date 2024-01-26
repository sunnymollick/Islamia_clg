<?php

namespace App\Http\Controllers\Backend\Admin;

use App\Http\Controllers\Controller;
use App\Models\Session;
use App\Models\StdClass;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Yajra\DataTables\DataTables;
use View;
use DB;

class QrCodeController extends Controller
{
    public function index($id){
        return view('backend.admin.qrcode.qrcode',['id'=>$id]);
    }

    public function getInfo($id){
        $student = Student::findOrfail($id);
        return view('backend.admin.student.info',compact('student'));
    }
}
