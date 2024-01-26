<?php





namespace App\Http\Controllers\backend\admin;

use App\Helper\Academic;
use App\Helper\AttendanceHelper;
use App\Http\Controllers\Controller;
use App\Imports\AttendanceStudentImport;
use App\Imports\TeacherImport;
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
use App\Models\AttendanceTeacher;
use App\Models\Enroll;
use App\Models\ExcelImportRecord;
use App\Models\Student;
use Excel;

class AttendanceTeacherController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    public function importTeacherAttendance(Request $request){
        return view('backend.admin.attendance_teacher.index');
    }

    public function importTeacherAttendanceProcess(Request $request)
    {
        if ($request->ajax()) {
            $haspermision = auth()->user()->can('student-import');
            if ($haspermision) {

                $rules = [
                    'excel_upload' => 'required',

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

                        $path = $request->file('excel_upload');
                        $data = Excel::import(new TeacherImport(), $path);

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

    public function teacherDailyAttendanceReport(){
        return view('backend.admin.attendance_teacher.daily_report');
    }

    public function getTeacherDailyAttendanceReport(Request $request){
        if ($request->ajax()) {

            $atten_date = $request->input('atten_date');
            $year = config('running_session');

            $data = AttendanceTeacher::join('teachers','teachers.code','attendance_teachers.teacher_id')
                ->where('attendance_teachers.attendance_date', $atten_date)
                ->where('attendance_teachers.year', $year)
                ->select('attendance_teachers.*','teachers.name as teacher_name')
                ->orderBy('attendance_teachers.teacher_id', 'asc')
                ->get();
            $view = View::make('backend.admin.attendance_teacher.daily_report_details', compact('atten_date', 'data'))->render();
            return response()->json(['html' => $view]);
        } else {
            return response()->json(['status' => 'false', 'message' => "Access only ajax request"]);
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\AttendanceTeacher  $attendanceTeacher
     * @return \Illuminate\Http\Response
     */
    public function show(AttendanceTeacher $attendanceTeacher)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\AttendanceTeacher  $attendanceTeacher
     * @return \Illuminate\Http\Response
     */
    public function edit(AttendanceTeacher $attendanceTeacher)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\AttendanceTeacher  $attendanceTeacher
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, AttendanceTeacher $attendanceTeacher)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\AttendanceTeacher  $attendanceTeacher
     * @return \Illuminate\Http\Response
     */
    public function destroy(AttendanceTeacher $attendanceTeacher)
    {
        //
    }
}
