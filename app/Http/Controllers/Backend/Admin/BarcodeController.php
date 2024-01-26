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

class BarcodeController extends Controller
{
    public function index($id){
        $productCode = Student::findOrfail($id);
        return view('backend.admin.barcode.barcode',['productCode'=>$productCode]);
    }
}
