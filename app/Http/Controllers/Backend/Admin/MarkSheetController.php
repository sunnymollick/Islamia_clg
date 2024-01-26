<?php

namespace App\Http\Controllers\Backend\Admin;

use App\Helper\GenerateMarksheet;
use App\Http\Controllers\Controller;
use App\Models\Exam;
use App\Models\Session;
use App\Models\StdClass;
use Illuminate\Http\Request;
use View;
use DB;
use PDF;


class MarkSheetController extends Controller
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

    public function jrhalfYearlyExamSummery()
    {

        try {

            $session=Session::where('status',1)->first();
            $stdclass = StdClass::where('session_id',$session->id)->whereIn('in_digit', ['06','11', '12','13'])->get();
            // dd($stdclass);
            return view('backend.admin.exam.junior_result.half_yearly_exam', compact('stdclass'));
        } catch (\Exception $e) {
            abort(404);
        }
    }

   public function jrhalfSummeryResult(Request $request)
   {
      if ($request->ajax()) {


         $class_id = $request->input('class_id');
         $section_id = $request->input('section_id');
         $exam_id = $request->input('exam_id');
         $session=Session::where('status',1)->first();
         $year = $session->name;

         $data = array();
         $data['class_id'] = $class_id;
         $data['section_id'] = $section_id;
         $data['exam_id'] = $exam_id;
         $data['class_name'] = $request->input('class_name');
         $data['section_name'] = $request->input('section_name');
         $data['exam_name'] = $request->input('exam_name');
         $data['year'] = $year;

         $data['result'] = $data['result'] = GenerateMarksheet::jrhalfSummeryResult($exam_id, $class_id, $section_id, $year);

         $view = View::make('backend.admin.exam.junior_result.half_yearly_summery', compact('data'))->render();
         return response()->json(['html' => $view]);
      } else {
         return response()->json(['status' => 'false', 'message' => "Access only ajax request"]);
      }
   }

   public function jrhalfExamMarksheet(Request $request)
   {

      if ($request->ajax()) {

         $class_id = $request->input('class_id');
         $section_id = $request->input('section_id');
         $exam_id = $request->input('exam_id');
         $student_code = $request->input('student_code');

         $session=Session::where('status',1)->first();
         $year = $session->name;

         $exam = Exam::where('id', $exam_id)->first();

         $data = array();

         DB::statement(DB::raw("set @class_id='$class_id'"));

         $total_student = DB::select("SELECT COUNT(*) as total_student
                                FROM enrolls
                                LEFT JOIN sections ON sections.id=enrolls.section_id
                                LEFT JOIN std_classes ON std_classes.id=sections.std_class_id
                                WHERE std_classes.id=@class_id");

        if(count($total_student)!=0){
            $data['total_student']=$total_student[0]->total_student;
        }else{
            $data['total_student']=0;
        }




         $data['student_code'] = $student_code;
         $data['student_name'] = $request->input('student_name');
         $data['std_roll'] = $request->input('std_roll');
         $data['class_id'] = $class_id;
         $data['section_id'] = $section_id;
         $data['exam_id'] = $exam_id;
         $data['class_name'] = $request->input('class_name');
         $data['section_name'] = $request->input('section_name');
         $data['exam_name'] = $request->input('exam_name');
         $data['year'] = $year;
         $data['has_ct'] = $exam->ct_marks_percentage;
         $data['mmp'] = $exam->main_marks_percentage;

         $data['result'] = GenerateMarksheet::jrhalfExamMarksheet($exam_id, $class_id, $section_id, $student_code, $year);

         $view = View::make('backend.admin.exam.junior_result.half_yearly_marksheet', compact('data'))->render();
         return response()->json(['html' => $view]);
      } else {
         return response()->json(['status' => 'false', 'message' => "Access only ajax request"]);
      }
   }

   public function jrHalfyearlyprintMarksheet(Request $request)
   {

      $class_id = $request->input('class_id');
      $section_id = $request->input('section_id');
      $exam_id = $request->input('exam_id');
      $student_code = $request->input('student_code');

      $session=Session::where('status',1)->first();
      $year = $session->name;

      $exam = Exam::where('id', $exam_id)->first();

      $data = array();
      $data['student_code'] = $student_code;
      $data['student_name'] = $request->input('student_name');
      $data['std_roll'] = $request->input('std_roll');
      $data['class_id'] = $class_id;
      $data['section_id'] = $section_id;
      $data['exam_id'] = $exam_id;
      $data['class_name'] = $request->input('class_name');
      $data['section_name'] = $request->input('section_name');
      $data['exam_name'] = $request->input('exam_name');
      $data['year'] = $year;
      $data['has_ct'] = $exam->ct_marks_percentage;
      $data['mmp'] = $exam->main_marks_percentage;

      $data['total_std'] = $request->input('total_std');
      $data['total_atd'] = $request->input('total_atd');
      $data['total_wd'] = $request->input('total_wd');
      $data['position'] = $request->input('position');

      $data['result'] = GenerateMarksheet::jrhalfExamMarksheet($exam_id, $class_id, $section_id, $student_code, $year);
      $view = View::make('backend.admin.exam.junior_result.half_yearly_printMarksheet', compact('data'));

      $html = '<!DOCTYPE html><html lang="en">';
      $html .= $view->render();
      $html .= '</html>';
      $pdf = PDF::loadHTML($html);
      $sheet = $pdf->setPaper('a4', 'landscape');
      return $sheet->download('Marksheet_' . $data['student_code'] . '_' . $data['class_name'] . '.pdf');

   }


   public function jrfullMarksheet()
   {
      try {
         $session=Session::where('status',1)->first();
         $stdclass = StdClass::where('session_id',$session->id)->whereIn('in_digit', ['11', '12','13'])->get();
         return view('backend.admin.exam.junior_result.final_exam', compact('stdclass'));
      } catch (\Exception $e) {
         abort(404);
      }
   }

   public function jrfinalSummeryResult(Request $request)
   {
      if ($request->ajax()) {

         $class_id = $request->input('class_id');
         $section_id = $request->input('section_id');
         $exam_id_half = $request->input('exam_id_half');
         $exam_id_final = $request->input('exam_id_final');

         $session=Session::where('status',1)->first();
         $year = $session->name;

         $data = array();
         $data['class_id'] = $class_id;
         $data['section_id'] = $section_id;
         $data['exam_id_half'] = $exam_id_half;
         $data['exam_id_final'] = $exam_id_final;
         $data['class_name'] = $request->input('class_name');
         $data['section_name'] = $request->input('section_name');
         $data['exam_name_half'] = $request->input('exam_name_half');
         $data['exam_name_final'] = $request->input('exam_name_final');
         $data['year'] = $year;

         $data['result'] = $data['result'] = GenerateMarksheet::jrfinalSummeryResult($exam_id_half, $exam_id_final, $class_id, $section_id, $year);

         $view = View::make('backend.admin.exam.junior_result.final_summery', compact('data'))->render();
         return response()->json(['html' => $view]);
      } else {
         return response()->json(['status' => 'false', 'message' => "Access only ajax request"]);
      }
   }

   public function jrfinalMarksheet(Request $request)
   {
      if ($request->ajax()) {

         $class_id = $request->input('class_id');
         $section_id = $request->input('section_id');
         $exam_id_half = $request->input('exam_id_half');
         $exam_id_final = $request->input('exam_id_final');
         $student_code = $request->input('student_code');

         $session=Session::where('status',1)->first();
         $year = $session->name;

         $data = array();

         DB::statement(DB::raw("set @class_id='$class_id'"));

         $total_student = DB::select("SELECT COUNT(*) as total_student
            FROM enrolls
            LEFT JOIN sections ON sections.id=enrolls.section_id
            LEFT JOIN std_classes ON std_classes.id=sections.std_class_id
            WHERE std_classes.id=@class_id");

        if(count($total_student)!=0){
            $data['total_student']=$total_student[0]->total_student;
        }else{
            $data['total_student']=0;
        }



         $data['student_code'] = $student_code;
         $data['student_name'] = $request->input('student_name');
         $data['std_roll'] = $request->input('std_roll');
         $data['class_id'] = $class_id;
         $data['section_id'] = $section_id;
         $data['exam_id_half'] = $exam_id_half;
         $data['exam_id_final'] = $exam_id_final;
         $data['class_name'] = $request->input('class_name');
         $data['section_name'] = $request->input('section_name');
         $data['exam_name_half'] = $request->input('exam_name_half');
         $data['exam_name_final'] = $request->input('exam_name_final');
         $data['year'] = $year;


         $data['result'] = GenerateMarksheet::jrfinalMarksheet($exam_id_half, $exam_id_final, $class_id, $section_id, $student_code, $year);


         $view = View::make('backend.admin.exam.junior_result.final_marksheet', compact('data'))->render();
         return response()->json(['html' => $view]);
      } else {
         return response()->json(['status' => 'false', 'message' => "Access only ajax request"]);
      }
   }

   public function jrfinalyprintMarksheet(Request $request)
   {

      $class_id = $request->input('class_id');
      $section_id = $request->input('section_id');
      $exam_id_half = $request->input('exam_id_half');
      $exam_id_final = $request->input('exam_id_final');
      $student_code = $request->input('student_code');
      $session=Session::where('status',1)->first();
      $year = $session->name;

      $data = array();
      $data['student_code'] = $student_code;
      $data['student_name'] = $request->input('student_name');
      $data['std_roll'] = $request->input('std_roll');
      $data['class_id'] = $class_id;
      $data['section_id'] = $section_id;
      $data['exam_id_half'] = $exam_id_half;
      $data['exam_id_final'] = $exam_id_final;
      $data['class_name'] = $request->input('class_name');
      $data['section_name'] = $request->input('section_name');
      $data['exam_name_half'] = $request->input('exam_name_half');
      $data['exam_name_final'] = $request->input('exam_name_final');
      $data['year'] = $year;


      $data['total_std'] = $request->input('total_std');
      $data['total_atd'] = $request->input('total_atd');
      $data['total_wd'] = $request->input('total_wd');
      $data['position'] = $request->input('position');

      $data['result'] = GenerateMarksheet::jrfinalMarksheet($exam_id_half, $exam_id_final, $class_id, $section_id, $student_code, $year);
      $view = View::make('backend.admin.exam.junior_result.final_printMarksheet', compact('data'));

      $html = '<!DOCTYPE html><html lang="en">';
      $html .= $view->render();
      $html .= '</html>';
      $pdf = PDF::loadHTML($html);
      $sheet = $pdf->setPaper('a4', 'landscape');
      return $sheet->download('Marksheet_' . $data['student_code'] . '_' . $data['class_name'] . '.pdf');

   }

// ______________________________________Senior Result________________________________________________________

public function srResult()
   {
      try {
         $session=Session::where('status',1)->first();
         $stdclass = StdClass::where('session_id',$session->id)->whereIn('in_digit', ['09', '10','11','12','13'])->get();
         return view('backend.admin.exam.senior_result.index', compact('stdclass'));
      } catch (\Exception $e) {
         abort(404);
      }
   }

public function srResultPublish()
   {
      try {
         $session=Session::where('status',1)->first();
         $stdclass = StdClass::where('session_id',$session->id)->whereIn('in_digit', ['09', '10','11','12','13'])->get();
        //  $stdclass = StdClass::where('session_id',$session->id)->whereIn('in_digit', ['06', '07'])->get();
         return view('backend.admin.exam.senior_result.senior_result_publish', compact('stdclass'));
      } catch (\Exception $e) {
         abort(404);
      }
   }

   public function testResult(){
        try {
            $session = Session::where('status',1)->first();
            $stdClass = StdClass::where('session_id',$session->id)
                                    ->whereIn('in_digit',[
                                             '11','12'
                                          ])->get();
            return view('backend.admin.exam.test_result.index',['stdClass'=>$stdClass]);
        } catch (\Throwable $th) {
            //throw $th;
        }
   }

   public function srSummeryResultPublish(Request $request)
   {
      if ($request->ajax()) {

        $class_id = $request->input('class_id');
        $section_id = $request->input('section_id');
        $exam_id = $request->input('exam_id');
        $session=Session::where('status',1)->first();
        $year = $session->name;

        $data = array();
        $data['class_id'] = $class_id;
        $data['section_id'] = $section_id;
        $data['exam_id'] = $exam_id;
        $data['class_name'] = $request->input('class_name');
        $data['section_name'] = $request->input('section_name');
        $data['exam_name'] = $request->input('exam_name');
        $data['year'] = $year;

        $data['result'] = GenerateMarksheet::srSummeryResult($exam_id, $class_id, $section_id, $year);

        // dd($data['result']);

        $student= array();

        for ($i=0; $i < count($data['result']); $i++) {
                $student[$i] = GenerateMarksheet::srExamMarksheet($exam_id, $class_id, $section_id, $data['result'][$i]->stdCode, $year);
        }

        // dd($data['result'][0]->result);
        // dd($student);


        //  dd($data['result'][0]->result);

         $view = View::make('backend.admin.exam.senior_result.result_publish_details', compact('data','student'))->render();
         return response()->json(['html' => $view]);
      } else {
         return response()->json(['status' => 'false', 'message' => "Access only ajax request"]);
      }
   }

   public function srTabulationSheetPrint(Request $request)
   {


        $class_id = $request->class_id;
        $section_id = $request->section_id;
        $exam_id = $request->exam_id;
        $session=Session::where('status',1)->first();
        $year = $session->name;

        $data = array();
        $data['class_id'] = $class_id;
        $data['section_id'] = $section_id;
        $data['exam_id'] = $exam_id;
        $data['class_name'] = $request->class_name;
        $data['section_name'] = $request->section_name;
        $data['exam_name'] = $request->exam_name;
        $data['year'] = $year;



        $data['result'] = GenerateMarksheet::srSummeryResult($exam_id, $class_id, $section_id, $year);

        // dd($data);

        $student= array();

        for ($i=0; $i < count($data['result']); $i++) {
                $student[$i] = GenerateMarksheet::srExamMarksheet($exam_id, $class_id, $section_id, $data['result'][$i]->stdCode, $year);
        }

        // dd($data);
        // dd($student);


        //  dd($data['result'][0]->result);

        $view = View::make('backend.admin.exam.senior_result.print_tabulation_sheet', compact('data','student'));

        $html = '<!DOCTYPE html><html lang="en">';
        $html .= $view->render();
        $html .= '</html>';
        $pdf = PDF::loadHTML($html);
        $sheet = $pdf->setPaper('a4', 'landscape');
        return $sheet->download('TabulationSheet_' . $data['class_name'] . '_' . $data['section_name'] . '_' . $data['year'] . '.pdf');

   }
   public function srSummeryResult(Request $request)
   {
      if ($request->ajax()) {

         $class_id = $request->input('class_id');
         $section_id = $request->input('section_id');
         $exam_id = $request->input('exam_id');
         $session=Session::where('status',1)->first();
         $year = $session->name;

         $data = array();
         $data['class_id'] = $class_id;
         $data['section_id'] = $section_id;
         $data['exam_id'] = $exam_id;
         $data['class_name'] = $request->input('class_name');
         $data['section_name'] = $request->input('section_name');
         $data['exam_name'] = $request->input('exam_name');
         $data['year'] = $year;

         $data['result'] = $data['result'] = GenerateMarksheet::srSummeryResult($exam_id, $class_id, $section_id, $year);

         $view = View::make('backend.admin.exam.senior_result.summery', compact('data'))->render();
         return response()->json(['html' => $view]);
      } else {
         return response()->json(['status' => 'false', 'message' => "Access only ajax request"]);
      }
   }

   public function srMarksheet(Request $request)
   {
      if ($request->ajax()) {

         $class_id = $request->input('class_id');
         $section_id = $request->input('section_id');
         $exam_id = $request->input('exam_id');
         $student_code = $request->input('student_code');

         $session=Session::where('status',1)->first();
         $year = $session->name;

         $exam = Exam::where('id', $exam_id)->first();


         $data = array();
        //  $data['total_student'] = Enroll::where('class_id', $class_id)->where('year', $year)->count();

         DB::statement(DB::raw("set @class_id='$class_id'"));

         $total_student = DB::select("SELECT COUNT(*) as total_student
                        FROM enrolls
                        LEFT JOIN sections ON sections.id=enrolls.section_id
                        LEFT JOIN std_classes ON std_classes.id=sections.std_class_id
                        WHERE std_classes.id=@class_id");

         if(count($total_student)!=0){
               $data['total_student']=$total_student[0]->total_student;
         }else{
               $data['total_student']=0;
         }


         $data['student_code'] = $student_code;
         $data['student_name'] = $request->input('student_name');
         $data['std_roll'] = $request->input('std_roll');
         $data['class_id'] = $class_id;
         $data['section_id'] = $section_id;
         $data['exam_id'] = $exam_id;
         $data['class_name'] = $request->input('class_name');
         $data['section_name'] = $request->input('section_name');
         $data['exam_name'] = $request->input('exam_name');
         $data['year'] = $year;
         $data['has_ct'] = $exam->ct_marks_percentage;
         $data['mmp'] = $exam->main_marks_percentage;

         $data['result'] = GenerateMarksheet::srExamMarksheet($exam_id, $class_id, $section_id, $student_code, $year);

        //  dd($data);

         $view = View::make('backend.admin.exam.senior_result.marksheet', compact('data'))->render();
         return response()->json(['html' => $view]);
      } else {
         return response()->json(['status' => 'false', 'message' => "Access only ajax request"]);
      }
   }

   public function srTranscript(Request $request)
   {
      if ($request->ajax()) {

         $class_id = $request->input('class_id');
         $section_id = $request->input('section_id');
         $exam_id = $request->input('exam_id');
         $student_code = $request->input('student_code');

         $session=Session::where('status',1)->first();
         $year = $session->name;

         $exam = Exam::where('id', $exam_id)->first();


         $data = array();
        //  $data['total_student'] = Enroll::where('class_id', $class_id)->where('year', $year)->count();


        DB::statement(DB::raw("set @class_id='$class_id'"));

         $total_student = DB::select("SELECT COUNT(*) as total_student
                        FROM enrolls
                        LEFT JOIN sections ON sections.id=enrolls.section_id
                        LEFT JOIN std_classes ON std_classes.id=sections.std_class_id
                        WHERE std_classes.id=@class_id");

         if(count($total_student)!=0){
               $data['total_student']=$total_student[0]->total_student;
         }else{
               $data['total_student']=0;
         }


         $data['student_code'] = $student_code;
         $data['student_name'] = $request->input('student_name');
         $data['std_roll'] = $request->input('std_roll');
         $data['class_id'] = $class_id;
         $data['section_id'] = $section_id;
         $data['exam_id'] = $exam_id;
         $data['class_name'] = $request->input('class_name');
         $data['section_name'] = $request->input('section_name');
         $data['exam_name'] = $request->input('exam_name');
         $data['year'] = $year;
         $data['has_ct'] = $exam->ct_marks_percentage;
         $data['mmp'] = $exam->main_marks_percentage;

         $data['result'] = GenerateMarksheet::srExamMarksheet($exam_id, $class_id, $section_id, $student_code, $year);

         //  dd($data);
         foreach ($data['result'] as $key => $value) {
            if ($data['result'][$key]->subject_id == $data['result'][$key]->optional_subject) {
               $optional_subject = $data['result'][$key];
            }
         }


         $view = View::make('backend.admin.exam.senior_result.transcript', compact('data','optional_subject'))->render();
         return response()->json(['html' => $view]);
      } else {
         return response()->json(['status' => 'false', 'message' => "Access only ajax request"]);
      }
   }

   public function srPrintMarksheet(Request $request)
   {

      $class_id = $request->input('class_id');
      $section_id = $request->input('section_id');
      $exam_id = $request->input('exam_id');
      $student_code = $request->input('student_code');
      $session=Session::where('status',1)->first();
      $year = $session->name;

      $exam = Exam::where('id', $exam_id)->first();

      $data = array();
      $data['student_code'] = $student_code;
      $data['student_name'] = $request->input('student_name');
      $data['std_roll'] = $request->input('std_roll');
      $data['class_id'] = $class_id;
      $data['section_id'] = $section_id;
      $data['exam_id'] = $exam_id;
      $data['class_name'] = $request->input('class_name');
      $data['section_name'] = $request->input('section_name');
      $data['exam_name'] = $request->input('exam_name');
      $data['year'] = $year;
      $data['has_ct'] = $exam->ct_marks_percentage;
      $data['mmp'] = $exam->main_marks_percentage;

      $data['total_std'] = $request->input('total_std');
      $data['total_atd'] = $request->input('total_atd');
      $data['total_wd'] = $request->input('total_wd');
      $data['position'] = $request->input('position');

      $data['result'] = GenerateMarksheet::srExamMarksheet($exam_id, $class_id, $section_id, $student_code, $year);

      $view = View::make('backend.admin.exam.senior_result.printMarksheet', compact('data'));

      $html = '<!DOCTYPE html><html lang="en">';
      $html .= $view->render();
      $html .= '</html>';
      $pdf = PDF::loadHTML($html);
      $sheet = $pdf->setPaper('a4', 'landscape');
      return $sheet->download('Marksheet_' . $data['student_code'] . '_' . $data['class_name'] . '.pdf');

   }

   public function srPrintTranscript(Request $request)
   {

      $class_id = $request->input('class_id');
      $section_id = $request->input('section_id');
      $exam_id = $request->input('exam_id');
      $student_code = $request->input('student_code');
      $session=Session::where('status',1)->first();
      $year = $session->name;

      $exam = Exam::where('id', $exam_id)->first();

      $data = array();
      $data['student_code'] = $student_code;
      $data['student_name'] = $request->input('student_name');
      $data['std_roll'] = $request->input('std_roll');
      $data['class_id'] = $class_id;
      $data['section_id'] = $section_id;
      $data['exam_id'] = $exam_id;
      $data['class_name'] = $request->input('class_name');
      $data['section_name'] = $request->input('section_name');
      $data['exam_name'] = $request->input('exam_name');
      $data['year'] = $year;
      $data['has_ct'] = $exam->ct_marks_percentage;
      $data['mmp'] = $exam->main_marks_percentage;

      $data['total_std'] = $request->input('total_std');
      $data['total_atd'] = $request->input('total_atd');
      $data['total_wd'] = $request->input('total_wd');
      $data['position'] = $request->input('position');

      $data['result'] = GenerateMarksheet::srExamMarksheet($exam_id, $class_id, $section_id, $student_code, $year);




      foreach ($data['result'] as $key => $value) {
         if ($data['result'][$key]->subject_id == $data['result'][$key]->optional_subject) {
               $optional_subject = $data['result'][$key];
         }
      }



        $view = View::make('backend.admin.exam.senior_result.printTranscript', compact('data', 'optional_subject'));

        $html = '<!DOCTYPE html><html lang="en">';
        $html .= $view->render();
        $html .= '</html>';
        $pdf = PDF::loadHTML($html);
        $sheet = $pdf->setPaper('a4', 'potrait');
        return $sheet->download('Transcript_' . $data['student_code'] . '_' . $data['class_name'] . '.pdf');

    }

//    ______________Senior Final ___________________________________________________________

   public function srfullMarksheet()
   {
      try {
         $session=Session::where('status',1)->first();
        //  $stdclass = StdClass::where('session_id',$session->id)->whereIn('in_digit', ['06', '07', '08'])->get();
        $stdclass = StdClass::where('session_id', $session->id)->whereIn('in_digit', ['09', '10', '11','12'])->get();
         return view('backend.admin.exam.senior_result.final_exam', compact('stdclass'));
      } catch (\Exception $e) {
         abort(404);
      }
   }

    public function srfinalSummeryResult(Request $request)
   {
      if ($request->ajax()) {

         $class_id = $request->input('class_id');
         $section_id = $request->input('section_id');
         $exam_id_half = $request->input('exam_id_half');
         $exam_id_final = $request->input('exam_id_final');

         $session=Session::where('status',1)->first();
         $year = $session->name;

         $data = array();
         $data['class_id'] = $class_id;
         $data['section_id'] = $section_id;
         $data['exam_id_half'] = $exam_id_half;
         $data['exam_id_final'] = $exam_id_final;
         $data['class_name'] = $request->input('class_name');
         $data['section_name'] = $request->input('section_name');
         $data['exam_name_half'] = $request->input('exam_name_half');
         $data['exam_name_final'] = $request->input('exam_name_final');
         $data['year'] = $year;

         $data['result'] = $data['result'] = GenerateMarksheet::srfinalSummeryResult($exam_id_half, $exam_id_final, $class_id, $section_id, $year);

         $view = View::make('backend.admin.exam.senior_result.final_summery', compact('data'))->render();
         return response()->json(['html' => $view]);
      } else {
         return response()->json(['status' => 'false', 'message' => "Access only ajax request"]);
      }
   }

   public function srfinalMarksheet(Request $request)
   {
      if ($request->ajax()) {

         $class_id = $request->input('class_id');
         $section_id = $request->input('section_id');
         $exam_id_half = $request->input('exam_id_half');
         $exam_id_final = $request->input('exam_id_final');
         $student_code = $request->input('student_code');

         $session=Session::where('status',1)->first();
         $year = $session->name;


         $data = array();

         DB::statement(DB::raw("set @class_id='$class_id'"));

         $total_student = DB::select("SELECT COUNT(*) as total_student
                                FROM enrolls
                                LEFT JOIN sections ON sections.id=enrolls.section_id
                                LEFT JOIN std_classes ON std_classes.id=sections.std_class_id
                                WHERE std_classes.id=@class_id");

        if(count($total_student)!=0){
            $data['total_student']=$total_student[0]->total_student;
        }else{
            $data['total_student']=0;
        }



         $data['student_code'] = $student_code;
         $data['student_name'] = $request->input('student_name');
         $data['std_roll'] = $request->input('std_roll');
         $data['class_id'] = $class_id;
         $data['section_id'] = $section_id;
         $data['exam_id_half'] = $exam_id_half;
         $data['exam_id_final'] = $exam_id_final;
         $data['class_name'] = $request->input('class_name');
         $data['section_name'] = $request->input('section_name');
         $data['exam_name_half'] = $request->input('exam_name_half');
         $data['exam_name_final'] = $request->input('exam_name_final');
         $data['year'] = $year;


         $data['result'] = GenerateMarksheet::srfinalMarksheet($exam_id_half, $exam_id_final, $class_id, $section_id, $student_code, $year);

        //  dd($data);

         $view = View::make('backend.admin.exam.senior_result.final_marksheet', compact('data'))->render();
         return response()->json(['html' => $view]);
      } else {
         return response()->json(['status' => 'false', 'message' => "Access only ajax request"]);
      }
   }

   public function srfinalyprintMarksheet(Request $request)
   {

      $class_id = $request->input('class_id');
      $section_id = $request->input('section_id');
      $exam_id_half = $request->input('exam_id_half');
      $exam_id_final = $request->input('exam_id_final');
      $student_code = $request->input('student_code');
      $session=Session::where('status',1)->first();
      $year = $session->name;

      //dd($exam_id_half,$exam_id_final,$student_code);
      $data = array();
      $data['student_code'] = $student_code;
      $data['student_name'] = $request->input('student_name');
      $data['std_roll'] = $request->input('std_roll');
      $data['class_id'] = $class_id;
      $data['section_id'] = $section_id;
      $data['exam_id_half'] = $exam_id_half;
      $data['exam_id_final'] = $exam_id_final;
      $data['class_name'] = $request->input('class_name');
      $data['section_name'] = $request->input('section_name');
      $data['exam_name_half'] = $request->input('exam_name_half');
      $data['exam_name_final'] = $request->input('exam_name_final');
      $data['year'] = $year;


      $data['total_std'] = $request->input('total_std');
      $data['total_atd'] = $request->input('total_atd');
      $data['total_wd'] = $request->input('total_wd');
      $data['position'] = $request->input('position');

      $data['result'] = GenerateMarksheet::srfinalMarksheet($exam_id_half, $exam_id_final, $class_id, $section_id, $student_code, $year);
    //   dd($data);
      $view = View::make('backend.admin.exam.senior_result.final_printMarksheet', compact('data'));

      $html = '<!DOCTYPE html><html lang="en">';
      $html .= $view->render();
      $html .= '</html>';
      $pdf = PDF::loadHTML($html);
      $sheet = $pdf->setPaper('a4', 'landscape');
      return $sheet->download('Marksheet_' . $data['student_code'] . '_' . $data['class_name'] . '.pdf');

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
}
