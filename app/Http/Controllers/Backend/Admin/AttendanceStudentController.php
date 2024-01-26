<?php

namespace App\Http\Controllers\backend\admin;

use App\Helper\Academic;
use App\Helper\AttendanceHelper;
use App\Http\Controllers\Controller;
use App\Imports\AttendanceStudentImport;
use App\Models\Exam;
use App\Models\StdClass;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Yajra\DataTables\DataTables;
use View;
use DB;
use Carbon\Carbon;

use Barryvdh\DomPDF\Facade\Pdf as PDF;

use App\Models\AttendanceStudent;
use App\Models\Enroll;
use App\Models\ExcelImportRecord;
use App\Models\Student;
use Excel;

class AttendanceStudentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $std_classes = StdClass::all();
        return view('backend.admin.attendance_student.index',['std_classes'=>$std_classes]);
    }

    public function importStdAttendance(Request $request){
        $std_classes = StdClass::all();
        return view('backend.admin.attendance_student.daily_import',compact('std_classes'));
    }

    public function importStdattendancesProcess(Request $request)
    {
        if ($request->ajax()) {
            $haspermision = auth()->user()->can('student-import');
            if ($haspermision) {

                $rules = [
                    'excel_upload' => 'required',
                    'section_id' => 'required',
                    'class_id' => 'required',

                ];

                $validator = Validator::make($request->all(), $rules);
                if ($validator->fails()) {
                    return response()->json([
                        'type' => 'error',
                        'errors' => $validator->getMessageBag()->toArray()
                    ]);
                } else {

                    DB::beginTransaction();
                    try {

                        $class_id = $request->input('class_id');
                        $section_id = $request->input('section_id');
                        // $attendance_date = $request->input('atten_date');

                        // dd($request->input('class_id'));

                        // DB::table('attendance_students')->where('attendance_date', $attendance_date)->delete();

                        $path = $request->file('excel_upload');
                        $data = Excel::import(new AttendanceStudentImport($class_id, $section_id), $path);

                        // if ($data) {
                        //     AttendanceHelper::updateStudentDailyAttendance($attendance_date);
                        // }

                        if ($request->hasFile('excel_upload')) {
                            $extension = strtolower($request->file('excel_upload')->getClientOriginalExtension());
                            if ($extension == "xlsx" || $extension == "xls") {
                                if ($request->file('excel_upload')->isValid()) {
                                    $destinationPath = public_path('assets/documents/attendance'); // upload path
                                    $extension = $request->file('excel_upload')->getClientOriginalExtension(); // getting image extension
                                    $fileName = date("Y.m.d") . '-' . date("h-i-sa") . '-' . 'clsId-' . $request->std_class_id . '-' . 'secId-' . $request->section_id . '-' . uniqid() . '.' . $extension; // renameing image
                                    $file_path = 'assets/documents/attendance/' . $fileName;
                                    $request->file('excel_upload')->move($destinationPath, $fileName); // uploading file to given path
                                    $upload_ok = 1;
                                } else {
                                    return response()->json([
                                        'type' => 'error',
                                        'message' => "<div class='alert alert-warning'>File is not valid</div>"
                                    ]);
                                }
                            } else {
                                return response()->json([
                                    'type' => 'error',
                                    'message' => "<div class='alert alert-warning'>Error! File type is not valid</div>"
                                ]);
                            }
                        }


                        $excel_import_record = new ExcelImportRecord();
                        $excel_import_record->file_path = $file_path;
                        $excel_import_record->uploaded_by = auth()->user()->id;
                        $excel_import_record->save();

                        DB::commit();
                        return response()->json(['type' => 'success', 'message' => "Successfully Updated"]);
                    } catch (\Exception $e) {
                        DB::rollback();
                        return response()->json(['type' => 'error', 'message' => "Please Filled with Valid Data"]);
                    }
                }
                // }
            } else {
                abort(403, 'Sorry, you are not authorized to access the page');
            }
        } else {
            return response()->json(['status' => 'false', 'message' => "Access only ajax request"]);
        }
    }

    public function studentDailyAttendanceReport(Request $request){
        $std_classes = StdClass::where('status',1)->get();
        return view('backend.admin.attendance_student.daily_report',compact('std_classes'));
    }

    public function getStudentDailyAttendanceReport(Request $request)
    {
        if ($request->ajax()) {

            $class_id = $request->input('class_id');
            $section_id = $request->input('section_id');
            $class_name = $request->input('class_name');
            $section_name = $request->input('section_name');
            $atten_date = $request->input('atten_date');
            $year = config('running_session');

            $data = DB::table('enrolls')
            ->leftJoin('students', 'students.id', '=', 'enrolls.student_id')
            ->leftJoin('attendance_students as attendances', function ($join) use ($atten_date) {
                $join->on('attendances.student_code', '=', 'students.std_code');
                $join->where('attendances.attendance_date', '=', $atten_date);
            })
                ->select(
                    'students.name as std_name',
                    'students.id as std_id',
                    'students.std_code',
                    'attendances.status as attn_status',
                    'attendances.id as attend_id',
                    'attendances.in_time',
                    'attendances.out_time',
                    'attendances.late',
                    'attendances.remarks'
                )
                ->where('enrolls.class_id', $class_id)
                ->where('enrolls.section_id', $section_id)
                ->where('enrolls.year', $year)
                ->orderBy('students.std_code', 'asc')
                ->get();

            // dd($data);

            $view = View::make('backend.admin.attendance_student.daily_report_details', compact('class_name', 'section_name', 'atten_date', 'data'))->render();
            return response()->json(['html' => $view]);
        } else {
            return response()->json(['status' => 'false', 'message' => "Access only ajax request"]);
        }
    }

    public function getAllStudentForAttendance(Request $request){
        if ($request->ajax()) {
            $students = DB::table('enrolls')
                ->join('students', 'students.id', '=', 'enrolls.student_id')
                ->join('sections', 'sections.id', '=', 'enrolls.section_id')
                ->join('std_classes','std_classes.id','=','enrolls.class_id')
                ->select('students.*', 'enrolls.*', 'sections.name as section_name','std_classes.name as class_name', 'students.id as s_id', 'students.name as std_name')
                ->where('enrolls.class_id', $request->class_id)
                ->where('enrolls.section_id', $request->section_id)
                ->where('enrolls.year', config('running_session'))
                ->orderBy('enrolls.student_code', 'asc')
                ->get();
            // dd($students);
            // $students =
            // Enroll::join('students','students.std_code','enrolls.student_code')
            //         ->where('enrolls.class_id',$request->class_id)
            //         ->where('enrolls.section_id',$request->section_id)
            //         ->select('enrolls.*','students.*')
            //         ->orderBy('enrolls.student_code','asc')
            //         ->get();
            if ($students) {
                $view = View::make('backend.admin.attendance_student.attendance_sheet',compact('students'))->render();
            } else {
                $view = '<div class="alert alert-danger"> Sorry no subject found of that course. Please create subjects.</div>';
                $status = false;
            }
            return response()->json(['html' => $view]);


        }else{
            return response()->json(['status'=>'false','message'=> "Access only ajax request"]);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $class_id = $request->class_id;
        $section_id = $request->section_id;
        $student_roll = $request->roll;
        $student_code = $request->std_code;
        $student_attendance = $request->student_codes;
        $array = explode(',', $student_attendance);

        // if (in_array($student_code[0], $array)) {
        //     echo "Match found";
        // } else {
        //     echo "Match not found";
        // }

        // dd($student_code);

        for ($count = 0; $count < count($student_roll); $count++) {
            // $data = array(
            //     'attendance_date' => Carbon::now(),
            //     'student_code'  => $student_code[$count],
            //     'class_id'  => $class_id,
            //     'section_id'  => $section_id,
            //     'year'  => config('running_session'),
            //     'status' => in_array($student_code[$count], $array) ? 'P' : 'A',
            //     'created_at' => Carbon::now(),
            //     'updated_at' => Carbon::now(),

            // );

            // $insert_schedule[] = $data;
            DB::table('attendance_students')
            ->updateOrInsert(
                [
                    'attendance_date' => date("Y-m-d"),
                    'student_code' => $student_code[$count],
                    'class_id' => $class_id,
                    'section_id' => $section_id,
                ],
                [
                    'status' =>
                    in_array($student_code[$count], $array) ? 'P' : 'A',
                    'year' => config('running_session'),
                    'created_at' => now(),
                    'updated_at' => now(),
                ]
            );
        }
        // AttendanceStudent::insert($insert_schedule);
        // Schedule::insert($insert_schedule);
        return response()->json(['type' => 'success', 'message' => "Successfully Inserted"]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\AttendanceStudent  $attendanceStudent
     * @return \Illuminate\Http\Response
     */
    public function show(AttendanceStudent $attendanceStudent)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\AttendanceStudent  $attendanceStudent
     * @return \Illuminate\Http\Response
     */
    public function edit(AttendanceStudent $attendanceStudent)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\AttendanceStudent  $attendanceStudent
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, AttendanceStudent $attendanceStudent)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\AttendanceStudent  $attendanceStudent
     * @return \Illuminate\Http\Response
     */
    public function destroy(AttendanceStudent $attendanceStudent)
    {
        //
    }
}
