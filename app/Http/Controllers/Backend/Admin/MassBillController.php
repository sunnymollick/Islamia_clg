<?php

namespace App\Http\Controllers\Backend\Admin;

use App\Http\Controllers\Controller;
use App\Models\Bill;
use App\Models\BillDetail;
use App\Models\EducationalFee;
use App\Models\StdClass;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\DataTables;
use DB;
use View;

class MassBillController extends Controller
{
    public function index()
    {
        $stdclass = StdClass::all();
        return view('backend.admin.finance.mass_bills.index', compact('stdclass'));
    }

    
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function create(Request $request)
    {
        if ($request->ajax()) {
            $student_id = $request->student_id;
            $std_class_id = $request->std_class_id;
            $educationalFees = EducationalFee::where('std_class_id', $std_class_id)->get();
            $view = View::make('backend.admin.finance.mass_bills.create', compact('educationalFees', 'std_class_id', 'student_id'))->render();

            return response()->json(['html' => $view]);

        } else {
            return response()->json(['status' => false, 'message' => 'Ajax request only!']);
        }
    }
}
