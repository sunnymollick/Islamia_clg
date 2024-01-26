<?php

namespace App\Http\Controllers\Backend\Admin;

use App\Http\Controllers\Controller;
use App\Models\Session;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Yajra\DataTables\DataTables;
use View;
use DB;

use App\Imports\StudentsImport;
use App\Models\Enroll;
use App\Models\Section;
use App\Models\StdClass;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Hash;

use App\Helper\CRMS;
use App\Models\EducationalFee;
use App\Models\ExcelImportRecord;
use App\Models\Subject;
use App\Models\SubjectAssign;
use Auth;
use Async;

class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $stdclass = StdClass::all();
        return view('backend.admin.student.index', compact('stdclass'));
    }

    public function getAll(Request $request)
    {

        if ($request->ajax()) {

            $can_edit = $can_delete = '';
            if (!auth()->user()->can('student-edit')) {
                $can_edit = "style='display:none;'";
            }
            if (!auth()->user()->can('student-delete')) {
                $can_delete = "style='display:none;'";
            }

            $class_id = $request->input('class_id');

            $class_name = $request->input('class_name');
            $section = $request->input('section');

            // dd($class_name);

            $section_id = $request->input('section_id');
            if ($section_id == 'all') {
                $section_id = 'null';
            }



            DB::statement(DB::raw("SET @section_id = $section_id"));

            $students = DB::table('enrolls')
                ->join('students', 'students.id', '=', 'enrolls.student_id')
                ->join('sections', 'sections.id', '=', 'enrolls.section_id')
                ->select('students.*', 'enrolls.*', 'sections.name as section_name', 'students.id as s_id', 'students.name as std_name')
                ->where('enrolls.class_id', $class_id)
                ->where('enrolls.section_id', DB::raw('COALESCE(@section_id, enrolls.section_id)'))
                ->where('enrolls.year', config('running_session'))
                ->orderBy('enrolls.student_code', 'asc')
                ->get();


            // dd($students);

            $subjects = SubjectAssign::join('subjects', 'subjects.id', 'subject_assigns.subject_id')
                ->where('subject_assigns.section_id', $section_id)
                ->where('subjects.std_class_id', $class_id)
                ->select('subjects.*')
                ->get();


            // $view = View::make('backend.admin.student.all_student_show', compact('students', 'class_name', 'section', 'class_id', 'section_id', 'subjects'))->render();
            // return response()->json(['html' => $view]);


            return Datatables::of($students)
            ->addColumn('file_path', function ($student) {
                return "<img src='" . asset($student->file_path) . "' class='img-thumbnail' width='50px'>";
            })
            ->addColumn('class_name', function ($student) use ($class_name) {
                return $class_name;
            })
            ->addColumn('status', function ($student) {
                return $student->status ?
                '<span class="badge badge-success">Active</span>' : '<span class="badge badge-danger">Inactive</span>';
            })
            ->addColumn('action', function ($student) use ($can_edit, $can_delete) {
                $html = '<div class="btn-group" style="position:relative;">';
                $html .= '<a data-toggle="tooltip" id="' . $student->s_id . '" class="btn btn-xs btn-info margin-r-5 view" title="View"><i class="fa fa-eye fa-fw"></i> </a>';
                $html .= '<a data-toggle="tooltip" ' . $can_edit . '  id="' . $student->s_id . '" class="btn btn-xs btn-warning margin-r-5 edit" title="Edit"><i class="fa fa-edit fa-fw"></i> </a>';
                $html .= '<a data-toggle="tooltip"  id="' . $student->s_id . '" class="btn btn-xs btn-primary margin-r-5 bill" title="Bill"><i class="fa fa-money-bill"></i></a>';
                if (Auth::user()->id == 1) {
                    $html .= '<a data-toggle="tooltip" ' . $can_delete . ' id="' . $student->s_id . '" class="btn btn-xs btn-danger margin-r-5 delete" title="Delete"><i class="fa fa-trash fa-fw"></i> </a>';
                    $html .= '<a data-toggle="tooltip" ' . $can_edit . ' id="' . $student->s_id . '" class="btn btn-xs btn-success margin-r-5 password" title="Change Password"><i class="fa fa-lock fa-fw"></i> </a>';
                }
                $html .= '</div>';
                return $html;
            })
            ->rawColumns(['action', 'file_path', 'status'])
                ->addIndexColumn()
                ->make(true);
        } else {
            return response()->json(['status' => 'false', 'message' => "Access only ajax request"]);
        }
    }

    public function getAllStudentList(Request $request)
    {

        if ($request->ajax()) {

            $can_edit = $can_delete = '';
            if (!auth()->user()->can('student-edit')) {
                $can_edit = "style='display:none;'";
            }
            if (!auth()->user()->can('student-delete')) {
                $can_delete = "style='display:none;'";
            }

            $class_id = $request->input('class_id');

            $class_name = $request->input('class_name');
            $section = $request->input('section');

            // dd($class_name);

            $section_id = $request->input('section_id');

            if ($section_id == 'all') {
                $section_id = 'null';
            }

            DB::statement(DB::raw("SET @section_id = $section_id"));

            $students = DB::table('enrolls')
                ->join('students', 'students.id', '=', 'enrolls.student_id')
                ->join('sections', 'sections.id', '=', 'enrolls.section_id')
                ->select('students.*', 'enrolls.*', 'sections.name as section_name', 'students.id as s_id', 'students.name as std_name')
                ->where('enrolls.class_id', $class_id)
                ->where('enrolls.section_id', DB::raw('COALESCE(@section_id, enrolls.section_id)'))
                ->where('enrolls.year', config('running_session'))
                ->orderBy('enrolls.student_code', 'asc')
                ->get();


            // dd($students);

            $subjects = SubjectAssign::join('subjects', 'subjects.id', 'subject_assigns.subject_id')
                ->where('subject_assigns.section_id', $section_id)
                ->where('subjects.std_class_id', $class_id)
                ->select('subjects.*')
                ->get();



            $stdclass = StdClass::all();

            $view = View::make('backend.admin.student.all_student_show', compact('students', 'class_name', 'section', 'class_id', 'section_id', 'subjects','stdclass'))->render();
            return response()->json(['html' => $view]);

        } else {
            return response()->json(['status' => 'false', 'message' => "Access only ajax request"]);
        }
    }

    public function allStudentsForSubject(Request $request)
    {

        if ($request->ajax()) {

            $can_edit = $can_delete = '';
            if (!auth()->user()->can('student-edit')) {
                $can_edit = "style='display:none;'";
            }
            if (!auth()->user()->can('student-delete')) {
                $can_delete = "style='display:none;'";
            }

            $class_id = $request->input('class_id');
            $subject_id = $request->input('subject_id');
            $section_id = $request->input('section_id');

            // dd($section_id);



            // DB::statement(DB::raw("SET @section_id = $section_id"));

            $students = DB::table('enrolls')
                ->join('students', 'students.id', '=', 'enrolls.student_id')
                ->join('sections', 'sections.id', '=', 'enrolls.section_id')
                ->select('students.*', 'enrolls.*', 'sections.name as section_name', 'students.id as s_id', 'students.name as std_name')
                ->where('enrolls.class_id', $class_id)
                ->where('enrolls.section_id',$section_id)
                ->where('enrolls.year', config('running_session'))
                ->orderBy('enrolls.student_code', 'asc')
                ->get();

            $students = $students->filter(function($student) use($subject_id){
                return ($student->compulsory_1 == $subject_id || $student->compulsory_2 == $subject_id || $student->compulsory_3 == $subject_id);
            });
            // dd($students);

            $subjects = SubjectAssign::join('subjects', 'subjects.id', 'subject_assigns.subject_id')
                ->where('subject_assigns.section_id', $section_id)
                ->where('subjects.std_class_id', $class_id)
                ->select('subjects.*')
                ->get();

            $stdclass = StdClass::all();

            return Datatables::of($students)

            ->addColumn('status', function ($student) {
                return $student->status ? '<span class="label label-success">Active</span>' : '<span class="label label-danger">Inactive</span>';
            })
            ->rawColumns(['status'])
            ->addIndexColumn()
                ->make(true);

        } else {
            return response()->json(['status' => 'false', 'message' => "Access only ajax request"]);
        }
    }
    public function allStudentsForOptionalSubject(Request $request)
    {

        if ($request->ajax()) {

            $can_edit = $can_delete = '';
            if (!auth()->user()->can('student-edit')) {
                $can_edit = "style='display:none;'";
            }
            if (!auth()->user()->can('student-delete')) {
                $can_delete = "style='display:none;'";
            }

            $class_id = $request->input('class_id');
            $subject_id = $request->input('subject_id');
            $section_id = $request->input('section_id');

            // dd($section_id);



            DB::statement(DB::raw("SET @section_id = $section_id"));

            $students = DB::table('enrolls')
                ->join('students', 'students.id', '=', 'enrolls.student_id')
                ->join('sections', 'sections.id', '=', 'enrolls.section_id')
                ->select('students.*', 'enrolls.*', 'sections.name as section_name', 'students.id as s_id', 'students.name as std_name')
                ->where('enrolls.class_id', $class_id)
                ->where('enrolls.optional_subject_id', $subject_id)
                ->where('enrolls.section_id', DB::raw('COALESCE(@section_id, enrolls.section_id)'))
                ->where('enrolls.year', config('running_session'))
                ->orderBy('enrolls.student_code', 'asc')
                ->get();


            // dd($students);

            $subjects = SubjectAssign::join('subjects', 'subjects.id', 'subject_assigns.subject_id')
                ->where('subject_assigns.section_id', $section_id)
                ->where('subjects.std_class_id', $class_id)
                ->select('subjects.*')
                ->get();

            $stdclass = StdClass::all();

            return Datatables::of($students)

            ->addColumn('status', function ($student) {
                return $student->status ? '<span class="label label-success">Active</span>' : '<span class="label label-danger">Inactive</span>';
            })
            ->rawColumns(['status'])
            ->addIndexColumn()
                ->make(true);

        } else {
            return response()->json(['status' => 'false', 'message' => "Access only ajax request"]);
        }
    }

    public function selectCompulsorySubject(){
        $stdclass = StdClass::all();
        return view('backend.admin.student.compulsory_subject',compact('stdclass'));
    }

    public function import()
    {
        $haspermision = auth()->user()->can('student-import');
        if ($haspermision) {
            $std_classes = StdClass::orderBy('id', 'asc')->get();
            return view('backend.admin.student.import', compact('std_classes'));
        } else {
            abort(403, 'Sorry, you are not authorized to access the page');
        }
    }

    public function importImages()
    {
        $haspermision = auth()->user()->can('student-import');
        if ($haspermision) {
            $std_classes = StdClass::orderBy('id', 'asc')->get();
            return view('backend.admin.student.upload_images', compact('std_classes'));
        } else {
            abort(403, 'Sorry, you are not authorized to access the page');
        }
    }

    public function importStore(Request $request)
    {

        if ($request->ajax()) {
            $haspermision = auth()->user()->can('student-import');
            if ($haspermision) {

                $rules = [
                    'excel_upload' => 'required',
                    'section_id' => 'required',

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

                        // return response()->json([
                        //     'class_id' => $request->std_class_id
                        // ]);


                        $section = Section::findOrFail($request->section_id);
                        // $path = $request->file('excel_upload')->getRealPath();
                        $path = $request->file('excel_upload');
                        $data = Excel::import(new StudentsImport($section->identification_number, $request->section_id, $request->std_class_id, $request->has_optional), $path);

                        if ($request->hasFile('excel_upload')) {
                            $extension = strtolower($request->file('excel_upload')->getClientOriginalExtension());
                            if ($extension == "xlsx" || $extension == "xls") {
                                if ($request->file('excel_upload')->isValid()) {
                                    $destinationPath = public_path('assets/documents'); // upload path
                                    $extension = $request->file('excel_upload')->getClientOriginalExtension(); // getting image extension
                                    $fileName = date("Y.m.d") . '-' . date("h-i-sa") . '-' . 'clsId-' . $request->std_class_id . '-' . 'secId-' . $request->section_id . '-' . uniqid() . '.' . $extension; // renameing image
                                    $file_path = 'assets/documents/' . $fileName;
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


                        $excel_import_record = new ExcelImportRecord;
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

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        if ($request->ajax()) {
            $haspermision = auth()->user()->can('student-create');
            if ($haspermision) {
                $std_classes = StdClass::orderBy('id', 'asc')->get();
                $view = View::make('backend.admin.student.create', compact('std_classes'))->render();
                return response()->json(['html' => $view]);
            } else {
                abort(403, 'Sorry, you are not authorized to access the page');
            }
        } else {
            return response()->json(['status' => 'false', 'message' => "Access only ajax request"]);
        }
    }

    public function getAllStudents(Request $request)
    {
        if ($request->ajax()) {

            $class_id = $request->input('class_id');
            $section_id = $request->input('section_id');

            $students = DB::table('enrolls')
                ->join('students', 'students.id', '=', 'enrolls.student_id')
                ->select('students.*')
                ->where('enrolls.class_id', $class_id)
                ->where('enrolls.section_id', $section_id)
                ->where('enrolls.year', config('running_session'))->get();

            if ($students) {
                echo "<option value='' selected disabled> Choose Student</option>";
                foreach ($students as $std) {
                    echo "<option  value='$std->std_code'> $std->name ($std->std_code)</option>";
                }
            }
        } else {
            return response()->json(['status' => 'false', 'message' => "Access only ajax request"]);
        }
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {


        // return $request;
        if ($request->ajax()) {
            $haspermision = auth()->user()->can('student-create');
            if ($haspermision) {

                $rules = [
                    'name' => 'required',
                ];

                $validator = Validator::make($request->all(), $rules);
                if ($validator->fails()) {
                    return response()->json([
                        'type' => 'error',
                        'errors' => $validator->getMessageBag()->toArray()
                    ]);
                } else {

                    // DB::beginTransaction();
                    try {

                        if ($request->hasFile('photo')) {
                            $extension = strtolower($request->file('photo')->getClientOriginalExtension());
                            if ($extension == "jpg" || $extension == "jpeg" || $extension == "png") {
                                if ($request->file('photo')->isValid()) {
                                    $destinationPath = public_path('assets/images/student'); // upload path
                                    $extension = $request->file('photo')->getClientOriginalExtension(); // getting image extension
                                    $fileName = time() . uniqid() . '.' . $extension; // renameing image
                                    $file_path = 'assets/images/student/' . $fileName;
                                    $request->file('photo')->move($destinationPath, $fileName); // uploading file to given path
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

                        if ($upload_ok == 0) {
                            return response()->json([
                                'type' => 'error',
                                'message' => "<div class='alert alert-warning'>Sorry Failed</div>"
                            ]);
                        } else {

                            $section = Section::findOrFail($request->section_id);
                            $student_code = CRMS::uniqueNumberConvertor($request->input('year'), $section->identification_number, $request->input('roll'));

                            $student = new Student;
                            $student->name = $request->input('name');
                            $student->code = $student_code;
                            $student->std_code = $student_code;
                            $student->year = $request->input('year');
                            $student->dob = $request->input('dob');
                            $student->gender = $request->input('gender');
                            $student->religion = $request->input('religion');
                            $student->blood_group = $request->input('blood_group');
                            $student->present_address = $request->input('present_address');
                            $student->permanent_address = $request->input('permanent_address');
                            $student->phone = $request->input('phone');
                            $student->email = $request->input('email');
                            $student->password = Hash::make("123456");
                            $student->file_path = $file_path;
                            $student->uploaded_by = auth()->user()->id;

                            $student->save();

                            $enroll = new Enroll;
                            $enroll->student_code = $student->std_code;
                            $enroll->student_id = $student->id;
                            $enroll->class_id = $request->input('std_class_id');
                            $enroll->section_id = $request->input('section_id');
                            $enroll->optional_subject_id = $request->input('subject_id');
                            $enroll->roll = $request->input('roll');
                            $enroll->date_added = date('Y-m-d');
                            $enroll->year = config('running_session');
                            $enroll->uploaded_by = auth()->user()->id;
                            $enroll->save();
                        }
                        DB::commit();
                        return response()->json(['type' => 'success', 'message' => "Successfully Updated"]);
                    } catch (\Exception $e) {
                        DB::rollback();
                        return response()->json(['type' => 'error', 'message' => $e->getMessage()]);
                    }
                }
            } else {
                abort(403, 'Sorry, you are not authorized to access the page');
            }
        } else {
            return response()->json(['status' => 'false', 'message' => "Access only ajax request"]);
        }
    }

    public function compulsorySubject(Request $request){
        $students = $request->student_id;
        $compulsory_1 = $request->compulsory_1;
        $compulsory_2 = $request->compulsory_2;
        $compulsory_3 = $request->compulsory_3;
        // dd($compulsory_1);
        for ($i=0; $i < count($students); $i++) {
            $enroll = Enroll::where('student_id','=',$students[$i])->first();
            $enroll->compulsory_1 = $compulsory_1[$i];
            $enroll->compulsory_2 = $compulsory_2[$i];
            $enroll->compulsory_3 = $compulsory_3[$i];
            $enroll->save();
        }
        return response()->json(['type' => 'success', 'message' => "Successfully Updated"]);

    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Student $student)
    {
        if ($request->ajax()) {
            $haspermision = auth()->user()->can('student-view');
            if ($haspermision) {
                $view = View::make('backend.admin.student.view', compact('student'))->render();
                return response()->json(['html' => $view]);
            } else {
                abort(403, 'Sorry, you are not authorized to access the page');
            }
        } else {
            return response()->json(['status' => 'false', 'message' => "Access only ajax request"]);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, Student $student)
    {
        if ($request->ajax()) {
            $haspermision = auth()->user()->can('student-edit');
            if ($haspermision) {
                $stdclass = StdClass::all();
                $sections = Section::all();

                $enroll = Enroll::where('student_id', $student->id)
                    ->where('year', config('running_session'))
                    ->first();
                $subjects = Subject::where('std_class_id',$enroll->class_id)->get();
                $view = View::make('backend.admin.student.edit', compact('student', 'stdclass', 'enroll', 'sections', 'subjects'))->render();
                return response()->json(['html' => $view]);
            } else {
                abort(403, 'Sorry, you are not authorized to access the page');
            }
        } else {
            return response()->json(['status' => 'false', 'message' => "Access only ajax request"]);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Student $student)
    {
        if ($request->ajax()) {
            $haspermision = auth()->user()->can('student-edit');
            if ($haspermision) {

                $rules = [
                    'name' => 'required',
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

                        if ($request->hasFile('photo')) {
                            $extension = strtolower($request->file('photo')->getClientOriginalExtension());
                            if ($extension == "jpg" || $extension == "jpeg" || $extension == "png") {
                                if ($request->file('photo')->isValid()) {
                                    $destinationPath = public_path('assets/images/blog'); // upload path
                                    $extension = $request->file('photo')->getClientOriginalExtension(); // getting image extension
                                    $fileName = time() . '.' . $extension; // renameing image
                                    $file_path = 'assets/images/blog/' . $fileName;
                                    $request->file('photo')->move($destinationPath, $fileName); // uploading file to given path
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
                        } else {
                            $upload_ok = 1;
                            $file_path = $request->input('SelectedFileName');
                        }

                        if ($upload_ok == 0) {
                            return response()->json([
                                'type' => 'error',
                                'message' => "<div class='alert alert-warning'>Sorry Failed</div>"
                            ]);
                        } else {
                            $student = Student::findOrFail($student->id);
                            $student->name = $request->input('name');
                            $student->dob = $request->input('dob');
                            $student->gender = $request->input('gender');
                            $student->religion = $request->input('religion');
                            $student->blood_group = $request->input('blood_group');
                            $student->present_address = $request->input('present_address');
                            $student->permanent_address = $request->input('permanent_address');
                            $student->phone = $request->input('phone');
                            $student->email = $request->input('email');
                            $student->password = Hash::make("123456");
                            $student->file_path = $file_path;
                            $student->status = $request->input('status');
                            $student->uploaded_by = auth()->user()->id;
                            $student->save(); //
                            if ($student) {
                                $enroll = Enroll::findOrFail($request->input('enroll_id'));
                                $enroll->class_id = $request->input('class_id');
                                $enroll->section_id = $request->input('section_id');
                                $enroll->optional_subject_id = $request->input('subject_id') ? $request->input('subject_id') : 0;
                                $enroll->roll = $request->input('roll');
                                $enroll->date_added = date('Y-m-d');
                                $enroll->save();
                            }
                        }
                        DB::commit();
                        return response()->json(['type' => 'success', 'message' => "Successfully Updated"]);
                    } catch (\Exception $e) {
                        DB::rollback();
                        return response()->json(['type' => 'error', 'message' => "Please Fill With Correct data"]);
                    }
                }
            } else {
                abort(403, 'Sorry, you are not authorized to access the page');
            }
        } else {
            return response()->json(['status' => 'false', 'message' => "Access only ajax request"]);
        }
    }

    public function change_password(Request $request, $student_id)
    {
        if ($request->ajax()) {
            $view = View::make('backend.admin.student.change_password', compact('student_id'))->render();
            return response()->json(['html' => $view]);
        } else {
            return response()->json(['status' => 'false', 'message' => "Access only ajax request"]);
        }
    }

    public function update_password(Request $request)
    {
        if ($request->ajax()) {
            $student = Student::findOrFail($request->input('student_id'));

            $rules = [
                'password' => 'required'
            ];

            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return response()->json([
                    'type' => 'error',
                    'errors' => $validator->getMessageBag()->toArray()
                ]);
            } else {
                $student->password = Hash::make($request->input('password'));
                $student->save(); //
                return response()->json(['type' => 'success', 'message' => "Successfully Updated"]);
            }
        } else {
            return response()->json(['status' => 'false', 'message' => "Access only ajax request"]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Student $student)
    {
        if ($request->ajax()) {
            $haspermision = auth()->user()->can('student-delete');
            if ($haspermision) {
                $student->delete();
                return response()->json(['type' => 'success', 'message' => 'Successfully Deleted']);
            } else {
                abort(403, 'Sorry, you are not authorized to access the page');
            }
        } else {
            return response()->json(['status' => 'false', 'message' => "Access only ajax request"]);
        }
    }

    public function storeStudentImages(Request $request)
    {

        $class_name = $request->class_name;
        $section_name = $request->section_name;
        $files = $request->file('photo');
        $session = config('running_session');
        // dd(count($files));

        if ($request->file('photo')) {

            for ($i = 0; $i < count($files); $i++) {

                $extension = strtolower($request->file('photo')[$i]->getClientOriginalExtension());

                if ($extension == "jpg" || $extension == "jpeg" || $extension == "png") {
                    if ($request->file('photo')[$i]->isValid()) {
                        $destinationPath = public_path('assets/images/student/' . $session . '/' . $class_name . '/' . $section_name); // upload path

                        $fileName = $request->file('photo')[$i]->getClientOriginalName(); // renameing image
                        $file_path = 'assets/images/student/' . $fileName;
                        $request->file('photo')[$i]->move($destinationPath, $fileName); //

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
            return response()->json([
                'type' => 'success',
                'message' => "Successfully image inserted"
            ]);
        }
    }

    public function getSection(Request $request, $std_class_id)
    {

        if ($request->ajax()) {

            $sections = Section::where('std_class_id', $std_class_id)->get();
            if ($sections) {
                echo "<option value='' disabled selected> Select Section </option>";
                foreach ($sections as $section) {
                    echo "<option  value='$section->id'>$section->name</option>";
                }
            }
        } else {
            return response()->json(['status' => 'false', 'message' => "Access only ajax request"]);
        }
    }

    public function checkOptionalSubject(Request $request, $std_class_id)
    {

        if ($request->ajax()) {

            $class = StdClass::where('id', $std_class_id)->first();
            return $class->has_optional;
            // if ($class) {
            //     echo "<option  value='$class->has_optional'>$class->has_optional</option>";
            // }
        } else {
            return response()->json(['status' => 'false', 'message' => "Access only ajax request"]);
        }
    }


    /**
     * Show the form for creating a new resource.
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function smsCreate(Request $request)
    {
        if ($request->ajax()) {
            $haspermision = auth()->user()->can('sms-send');
            if ($haspermision) {
                $session = Session::where('status', 1)->first();
                $classes = $session->StdClass;
                $view = View::make('backend.admin.student.smsSend', compact('classes'))->render();
                return response()->json(['html' => $view]);
            } else {
                abort(403, 'Sorry, you are not authorized to access the page');
            }
        } else {
            return response()->json(['status' => 'false', 'message' => "Access only ajax request"]);
        }
    }


    /**
     * Sending sms to recipient.
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function smsSend(Request $request)
    {
        $rules = [
            'class_id' => 'required',
            'sections_id' => 'required',
            'message' => 'required',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($request->ajax()) {

            if ($validator->fails()) {
                return response()->json([
                    'type' => 'error',
                    'errors' => $validator->getMessageBag()->toArray()
                ]);
            } else {

                try {
                    Async::run(function($request) {
                        if (empty($request->students_id) && empty($request->sections_id)) {
                            $class = StdClass::find($request->class_id);
                            $sections = $class->section;
                            foreach ($sections as $section) {
                                foreach ($section->enroll as $enroll) {
                                    if (!empty($enroll->student->phone)) {
                                        $this->httpRequest($enroll->student->phone, $request->message);
                                    }
                                }
                            }
                        } else if (!empty($request->sections_id) && empty($request->students_id )) {
                            $sections = Section::whereIn('id', $request->sections_id)->get();
                            foreach ($sections as $section) {
                                foreach ($section->enroll as $enroll) {
                                    if (!empty($enroll->student->phone)) {
                                        $this->httpRequest($enroll->student->phone, $request->message);
                                    }
                                }
                            }
                        } else {
                            $students = Student::whereIn('id', $request->students_id)->get();
                            foreach ($students as $student) {
                                if (!empty($student->phone)) {
                                    $this->httpRequest($student->phone, $request->message);
                                }
                            }
                        }
                    });

                    return response()->json(['type' => 'success', 'message' => 'Message send successfully']);
                } catch (\Exception $e) {

                    return response()->json(['type' => 'error', 'message' => $e->getMessage()]);
                }
            }
        } else {
            return response()->json(['type' => 'error', 'message' => 'Access only ajax request']);
        }
    }


    /**
     *Collecting students name by ajax request
     * @param Request $request
     */

    public function getStudents(Request $request)
    {
        if ($request->ajax()) {
            $sections = $request->input('sections');
            $sections = Section::whereIn('id', $sections)->get();
            foreach ($sections as $section) {
                $enrolls[] = $section->enroll;
            }


            foreach ($enrolls as $enroll) {
                foreach ($enroll as $en) {
                    $students[] = $en->student;
                }
            }

            return response()->json(['data' => $students, 'messagae' => 'success']);
        }
    }




    /**
     * Method for client request
     * @param $phone
     */
    private function httpRequest($phone, $msg)
    {
        Http::post(config('services.sms.url'), [
            'api_key' => config('services.sms.api_key'),
            'type' => config('services.sms.type'),
            'contacts' => $phone,
            'senderid' => config('services.sms.senderid'),
            'msg' => $msg

        ]);
    }

}
