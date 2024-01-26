<?php

namespace App\Http\Controllers\backend\admin;

use App\Helper\CRMS;
use App\Http\Controllers\Controller;
use App\Imports\MarksImport;
use App\Models\Enroll;
use App\Models\Exam;
use App\Models\ExcelImportRecord;
use App\Models\Mark;
use App\Models\Session;
use App\Models\StdClass;
use App\Models\Subject;
use App\Models\SubjectAssign;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Yajra\DataTables\DataTables;
use View;
use DB;
use Maatwebsite\Excel\Facades\Excel;

class MarkController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       $stdclass = StdClass::all();
       return view('backend.admin.mark.index', compact('stdclass'));
    }

    public function import()
   {
      $haspermision = auth()->user()->can('mark-import');
      if ($haspermision) {
         $std_classes = StdClass::orderBy('id', 'asc')->get();
         return view('backend.admin.mark.import',compact('std_classes'));
      } else {
         abort(403, 'Sorry, you are not authorized to access the page');
      }
   }

   public function importStore(Request $request)
   {

      if ($request->ajax()) {
         $haspermision = auth()->user()->can('promotion-import');
         if ($haspermision) {

            $rules = [
              'excel_upload' => 'required',
              'std_class_id' => 'required',
              'section_id' => 'required',
              'exam_id' => 'required',
              'subject_id' => 'required',

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
                    $subject_assign=SubjectAssign::where('subject_id',$request->subject_id)->where('section_id',$request->section_id)->first();
                    $data = Excel::import(new MarksImport($subject_assign->id,$request->exam_id), $path);

                    if ($request->hasFile('excel_upload')) {
                        $extension = strtolower($request->file('excel_upload')->getClientOriginalExtension());
                        if ($extension == "xlsx" || $extension == "xls") {
                            if ($request->file('excel_upload')->isValid()) {
                                $destinationPath = public_path('assets/documents'); // upload path
                                $extension = $request->file('excel_upload')->getClientOriginalExtension(); // getting image extension
                                $fileName = date("Y.m.d").'-'.date("h-i-sa").'-'.'clsId-'.$request->std_class_id.'-'.'secId-'.$request->section_id.'-'.uniqid() . '.' . $extension; // renameing image
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

    public function getMarks(Request $request)
   {

        // dd($request);
      if ($request->ajax()) {

         $class_id = $request->input('class_id');
         $section_id = $request->input('section_id');
         $exam_id = $request->input('exam_id');
         $subject_id = $request->input('subject_id');

         $data = CRMS::getSubjectMarks($section_id, $subject_id, $exam_id);


         $view = View::make('backend.admin.mark.view', compact('data','class_id','section_id','exam_id','subject_id'))->render();

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

        // return $request;

        if ($request->ajax()) {
            $haspermision = auth()->user()->can('part-material-create');
            if ($haspermision) {

                $rules = [
                    // 'invoice_id' => 'required | unique:product_purchase_masters,invoice_id',
                    // 'date' => 'required',
                    // 'project_id' => 'required',

                ];

                $validator = Validator::make($request->all(), $rules);
                if ($validator->fails()) {
                    return response()->json([
                        'type' => 'error',
                        'errors' => $validator->getMessageBag()->toArray(),
                        'message' => "<div class='alert alert-warning'>Invalid Field</div>"
                    ]);
                } else {

                    // $product_issues = $request->product_issues;

                    // foreach($product_issues as $item){
                    //     if($item["product_id"]==null or $item["quantity"]==null){
                    //         return response()->json([
                    //             'type' => 'error',
                    //             'message' => "<div class='alert alert-warning'>The Receipt Field is Required</div>"
                    //           ]);
                    //     }
                    // }

                    DB::beginTransaction();
                    try {

                        // dd($request->subject_id,'+',$request->section_id);
                        $subject_assign=SubjectAssign::where('subject_id',$request->subject_id)->where('section_id',$request->section_id)->first();
                        $exam=Exam::where('std_class_id',$request->class_id)->first();
                        $students=$request->student;
                        // dd($subject_assign->id);

                        foreach ($students as $student) {

                            $mark = Mark::where('student_code',$student["student_code"])->first();

                            if($mark==null){
                                $mark=new Mark;
                            }

                            $mark->subject_assign_id = $subject_assign->id;
                            $mark->exam_id = $exam->id;
                            $mark->student_code = $student["student_code"];
                            if($student["theory_marks"]!=null){
                                $mark->theory_marks = $student["theory_marks"];
                            }else{
                                $mark->theory_marks = 0;
                            }

                            if($student["mcq_marks"]!=null){
                                $mark->mcq_marks = $student["mcq_marks"];
                            }else{
                                $mark->mcq_marks=0;
                            }

                            if($student["practical_marks"]!=null){
                                $mark->practical_marks = $student["practical_marks"];
                            }else{
                                $mark->practical_marks = 0;
                            }

                            if($student["ct_marks"]!=null){
                                $mark->ct_marks = $student["ct_marks"];
                            }else{
                                $mark->ct_marks = 0;
                            }
                            $mark->uploaded_by = auth()->user()->id;
                            $mark->save();
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

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function getExam(Request $request, $std_class_id)
    {
        if ($request->ajax()) {

            $exams=Exam::where('std_class_id',$std_class_id)->get();
            if ($exams) {
                echo "<option value='' selected disabled> Select Section </option>";
                foreach ($exams as $exam) {
                    echo "<option  value='$exam->id'>$exam->name</option>";
                }
            }
        } else {
            return response()->json(['status' => 'false', 'message' => "Access only ajax request"]);
        }
    }

    public function getSubject(Request $request, $std_class_id)
    {
        if ($request->ajax()) {

            $subjects=Subject::where('std_class_id',$std_class_id)->get();
            if ($subjects) {
                echo "<option value='' selected disabled> Select Section </option>";
                foreach ($subjects as $subject) {
                    echo "<option  value='$subject->id'>$subject->name</option>";
                }
            }
        } else {
            return response()->json(['status' => 'false', 'message' => "Access only ajax request"]);
        }
    }
}
