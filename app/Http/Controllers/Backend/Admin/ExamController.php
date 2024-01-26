<?php

namespace App\Http\Controllers\backend\admin;

use App\Helper\Academic;
use App\Http\Controllers\Controller;
use App\Models\Exam;
use App\Models\StdClass;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Yajra\DataTables\DataTables;
use View;
use DB;
use Auth;

use Barryvdh\DomPDF\Facade\Pdf as PDF;

class ExamController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $stdclass = StdClass::all();
        return view('backend.admin.exam.index',compact('stdclass'));
    }

    public function getAll(Request $request)
    {


       if ($request->ajax()) {
         $can_view = $can_edit = $can_delete = '';
         if (!auth()->user()->can('exam-view')) {
            $can_view = "style='display:none;'";
         }
          if (!auth()->user()->can('exam-edit')) {
             $can_edit = "style='display:none;'";
          }
          if (!auth()->user()->can('exam-delete')) {
             $can_delete = "style='display:none;'";
          }

            //   $exam = Exam::orderby('created_at', 'desc')->get();
        $exam = Exam::where('std_class_id', $request->std_class_id)->where('year', config('running_session'))->get();
          return Datatables::of($exam)

                // ->addColumn('project_name', function ($exam) {
                //     return $project->client_id? $project->client->name.'-'.$project->name:'n/a';
                // })
                ->addColumn('file_path', function ($exam) {
                    return $exam->file_path ? "<a class='btn btn-primary' href='" . asset($exam->file_path) . "' target='_blank' download>Download</a>" : '';
                })
                ->addColumn('main_marks_percentage', function ($exam) {
                    return $exam->main_marks_percentage ? $exam->main_marks_percentage . '%' : '';
                })
                ->addColumn('ct_marks_percentage', function ($exam) {
                    return $exam->ct_marks_percentage ? $exam->ct_marks_percentage . '%' : '0%';
                })

                ->addColumn('status', function ($exam) {
                    return $exam->status ? '<span class="badge badge-success">Active</span>' : '<span class="badge badge-danger">Inactive</span>';
                })

            ->addColumn('action', function ($exam) use ($can_view, $can_edit, $can_delete) {
               $html = '<div class="btn-group">';
               $html .= '<a data-toggle="tooltip" ' . $can_view . '  id="' . $exam->id . '" class="btn btn-xs btn-success mr-1 view" title="View"><i class="fa fa-eye"></i> </a>';
               $html .= '<a data-toggle="tooltip" ' . $can_edit . '  id="' . $exam->id . '" class="btn btn-xs btn-info mr-1 edit" title="Edit"><i class="fa fa-edit"></i> </a>';
                if (Auth::user()->id == 1) {
                $html .= '<a data-toggle="tooltip" ' . $can_delete . ' id="' . $exam->id . '" class="btn btn-xs btn-danger delete" title="Delete"><i class="fa fa-trash"></i> </a>';
                }
               $html .= '</div>';
               return $html;
            })
            ->rawColumns(['action', 'file_path', 'status', 'marks_percentage'])
            ->addIndexColumn()
            ->make(true);
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
         $haspermision = auth()->user()->can('exam-create');
         if ($haspermision) {
            $std_classes = StdClass::where('status',1)->orderBy('id', 'asc')->get();
            $view = View::make('backend.admin.exam.create',compact('std_classes'))->render();
            return response()->json(['html' => $view]);
         } else {
            abort(403, 'Sorry, you are not authorized to access the page');
         }
      } else {
         return response()->json(['status' => 'false', 'message' => "Access only ajax request"]);
      }
   }

    public function admitCard()
    {

        $haspermision = auth()->user()->can('admit-card-print');
        if ($haspermision) {
            $stdclass = StdClass::all();
            return view('backend.admin.exam.admit_card.index', compact('stdclass'));
        } else {
            abort(403, 'Sorry, you are not authorized to access the page');
        }
    }

    public function seatPlan()
    {

        $haspermision = auth()->user()->can('seat-plan-print');
        if ($haspermision) {
            $stdclass = StdClass::all();
            return view('backend.admin.exam.seat_plan.index', compact('stdclass'));
        } else {
            abort(403, 'Sorry, you are not authorized to access the page');
        }
    }

    public function generateAdmitCard(Request $request)
    {

        $class_id = $request->input('class_id');
        $section_id = $request->input('section_id');
        $exam_id = $request->input('exam_id');
        $student_id = $request->input('student_id');

        $class_name = $request->input('class_name');
        $section_name = $request->input('section_name');

        $year = config('running_session');

        if ($student_id == '') {
            $student_id = 'Null';
        }

        // dd($student_id);


        $students = Academic::generateAdmitCard($exam_id, $class_id, $section_id, $student_id, $year);

        // dd($students);

        if ($students) {

            $html = '<!DOCTYPE html><html lang="en">';
            // foreach ($students as $std) {
            //     $view = view('backend.admin.exam.admit_card.myPDF', compact('std'));
            //     $html .= $view->render();
            // }
            $view = view('backend.admin.exam.admit_card.myPDF', compact('students'));
            $html .= $view->render();
            $html .= '</html>';
            $pdf = PDF::loadHTML($html);
            $sheet = $pdf->setPaper('a4', 'portrait');
            // return $sheet->download('admin_card_' . $class_name . '_' . $section_name . '.pdf');
            return $sheet->download('admin_card_' . $class_name . '_' . $section_name . '.pdf');
        } else {
            return response()->json(['type' => 'error', 'message' => "No data found"]);
        }

        // $data = [
        //     'title' => 'Welcome to CodeSolutionStuff.com',
        //     'date' => date('m/d/Y')
        // ];

        // $pdf = PDF::loadView('backend.admin.exam.admit_card.myPDF', $data);

        // return $pdf->download('codesolutionstuff.pdf');

        // dd($students);
        // if ($students) {

        //     $html = '<!DOCTYPE html><html lang="en">';
        //     foreach ($students as $std) {
        //         $view = view('backend.admin.exam.admit_card.print_admin_card', compact('std'));
        //         $html .= $view->render();
        //     }
        //     $html .= '</html>';
        //     $pdf = PDF::loadHTML($html);
        //     $sheet = $pdf->setPaper('a4', 'portrait');
        //     return $sheet->download('admin_card_' . $class_name . '_' . $section_name . '.pdf');
        // } else {
        //     return response()->json(['type' => 'error', 'message' => "No data found"]);
        // }
    }

    public function generateSeatPlan(Request $request)
    {

        $class_id = $request->input('class_id');
        $section_id = $request->input('section_id');
        $exam_id = $request->input('exam_id');
        $student_id = $request->input('student_id');

        $class_name = $request->input('class_name');
        $section_name = $request->input('section_name');

        $year = config('running_session');

        if ($student_id == '') {
            $student_id = 'Null';
        }

        // dd($student_id);


        $students = Academic::generateAdmitCard($exam_id, $class_id, $section_id, $student_id, $year);

        // dd($students);

        if ($students) {

            $html = '<!DOCTYPE html><html lang="en">';
            // foreach ($students as $std) {
            //     $view = view('backend.admin.exam.admit_card.myPDF', compact('std'));
            //     $html .= $view->render();
            // }
            $view = view('backend.admin.exam.seat_plan.seat_plan_pdf', compact('students'));
            $html .= $view->render();
            $html .= '</html>';
            $pdf = PDF::loadHTML($html);
            $sheet = $pdf->setPaper('a4', 'portrait');
            // return $sheet->download('admin_card_' . $class_name . '_' . $section_name . '.pdf');
            return $sheet->download('seat_plan' . $class_name . '_' . $section_name . '.pdf');
        } else {
            return response()->json(['type' => 'error', 'message' => "No data found"]);
        }
    }

    public function getExams(Request $request, $class_id)
    {
        if ($request->ajax()) {

            $exams = Exam::where('std_class_id', $class_id)->where('year', config('running_session'))->get();
            if ($exams) {
                echo "<option value='' selected disabled> Select a exam</option>";
                foreach ($exams as $exam) {
                    echo "<option  value='$exam->id'>$exam->name</option>";
                }
            }
        } else {
            return response()->json(['status' => 'false', 'message' => "Access only ajax request"]);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if ($request->ajax()) {
            $haspermision = auth()->user()->can('exam-create');
            if ($haspermision) {

                $rules = [
                    'name' => 'required',
                    'std_class_id' => 'required',
                    'main_marks_percentage' => 'required',
                    'ct_marks_percentage' => 'required',
                    'start_date' => 'required',
                    'end_date' => 'required'
                ];

                $validator = Validator::make($request->all(), $rules);
                if ($validator->fails()) {
                    return response()->json([
                        'type' => 'error',
                        'errors' => $validator->getMessageBag()->toArray()
                    ]);
                } else {
                    $upload_ok = 1;


                    if ($request->hasFile('photo')) {
                        $extension = $request->file('photo')->getClientOriginalExtension();;
                        if ($extension == "doc" || $extension == "docx" || $extension == "pdf" || $extension == "jpg" || $extension == "jpeg" || $extension == "png") {
                            if ($request->file('photo')->isValid()) {
                                $destinationPath = public_path('assets/uploads/exam_routine');
                                $extension = $request->file('photo')->getClientOriginalExtension(); // getting image extension
                                $fileName = time() . '.' . $extension; // renameing image
                                $file_path = 'assets/uploads/exam_routine/' . $fileName;
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
                        return response()->json([
                            'type' => 'error',
                            'message' => "<div class='alert alert-warning'>Error! File not selected</div>"
                        ]);
                    }


                    if ($upload_ok == 0) {
                        return response()->json([
                            'type' => 'error',
                            'message' => "<div class='alert alert-warning'>Sorry Failed</div>"
                        ]);
                    } else {
                        $name = $request->input('name');
                        $rows = DB::table('exams')
                            ->where('start_date', $request->input('start_date'))
                            ->where('name', $request->input('name'))
                            ->where('std_class_id', $request->input('std_class_id'))
                            ->count();
                        if ($rows == 0) {
                            $exam = new Exam;
                            $exam->name = $request->input('name');
                            $exam->std_class_id = $request->input('std_class_id');
                            $exam->description = $request->input('description');
                            $exam->start_date = $request->input('start_date');
                            $exam->end_date = $request->input('end_date');
                            $exam->result_modification_last_date = $request->input('result_modification_last_date');
                            $exam->main_marks_percentage = $request->input('main_marks_percentage');
                            $exam->ct_marks_percentage = $request->input('ct_marks_percentage');
                            $exam->file_path = $file_path;
                            $exam->year = config('running_session');
                            $exam->uploaded_by = auth()->user()->id;
                            $exam->save(); //
                            return response()->json(['type' => 'success', 'message' => "Successfully Created"]);
                        } else {
                            return response()->json(['type' => 'error', 'message' => "<div class='alert alert-warning'> Exam Name $name  already exist in same class</div>"]);
                        }
                    }
                }
            } else {
                abort(403, 'Sorry, you are not authorized to access the page');
            }
        } else {
            return response()->json(['status' => 'false', 'message' => "Access only ajax request"]);
        }
    //    if ($request->ajax()) {
    //       $haspermision = auth()->user()->can('exam-create');
    //       if ($haspermision) {

    //          $rules = [
    //            'std_class_id' => 'required',
    //            'name' => 'required',
    //            'start_date' => 'required',
    //            'end_date' => 'required',
    //            'result_modification_last_date' => 'required',
    //            'main_marks_percentage' => 'required',
    //            'ct_marks_percentage' => 'required',
    //          ];

    //          $validator = Validator::make($request->all(), $rules);
    //          if ($validator->fails()) {
    //             return response()->json([
    //               'type' => 'error',
    //               'errors' => $validator->getMessageBag()->toArray()
    //             ]);
    //          } else {

    //             DB::beginTransaction();
    //             try {

    //                 // if ($request->hasFile('photo')) {
    //                 //    $extension = strtolower($request->file('photo')->getClientOriginalExtension());
    //                 //    if ($extension == "jpg" || $extension == "jpeg" || $extension == "png") {
    //                 //       if ($request->file('photo')->isValid()) {
    //                 //          $destinationPath = public_path('assets/images/blog'); // upload path
    //                 //          $extension = $request->file('photo')->getClientOriginalExtension(); // getting image extension
    //                 //          $fileName = time() . '.' . $extension; // renameing image
    //                 //          $file_path = 'assets/images/blog/' . $fileName;
    //                 //          $request->file('photo')->move($destinationPath, $fileName); // uploading file to given path
    //                 //          $upload_ok = 1;

    //                 //       } else {
    //                 //          return response()->json([
    //                 //            'type' => 'error',
    //                 //            'message' => "<div class='alert alert-warning'>File is not valid</div>"
    //                 //          ]);
    //                 //       }
    //                 //    } else {
    //                 //       return response()->json([
    //                 //         'type' => 'error',
    //                 //         'message' => "<div class='alert alert-warning'>Error! File type is not valid</div>"
    //                 //       ]);
    //                 //    }
    //                 // }

    //                 // if ($upload_ok == 0) {
    //                 //    return response()->json([
    //                 //      'type' => 'error',
    //                 //      'message' => "<div class='alert alert-warning'>Sorry Failed</div>"
    //                 //    ]);
    //                 // } else {
    //                 $exam = new Exam;
    //                 $exam->std_class_id = $request->input('std_class_id');
    //                 $exam->name = $request->input('name');
    //                 $exam->description = $request->input('description');
    //                 $exam->start_date = $request->input('start_date');
    //                 $exam->end_date = $request->input('end_date');
    //                 $exam->result_modification_last_date = $request->input('result_modification_last_date');
    //                 $exam->main_marks_percentage = $request->input('main_marks_percentage');
    //                 $exam->ct_marks_percentage = $request->input('ct_marks_percentage');
    //                 $exam->uploaded_by = auth()->user()->id;
    //                 $exam->save(); //
    //                 DB::commit();
    //                 return response()->json(['type' => 'success', 'message' =>            "Successfully Updated"]);
    //             } catch (\Exception $e) {
    //                 DB::rollback();
    //                 return response()->json(['type' => 'error', 'message' => "Please Fill With Correct data"]);
    //             }
    //             // }
    //          }
    //       } else {
    //          abort(403, 'Sorry, you are not authorized to access the page');
    //       }
    //    } else {
    //       return response()->json(['status' => 'false', 'message' => "Access only ajax request"]);
    //    }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Exam $exam)
   {
      if ($request->ajax()) {
         $haspermision = auth()->user()->can('exam-view');
         if ($haspermision) {
            $std_classes = StdClass::where('status',1)->orderBy('id', 'asc')->get();
            $view = View::make('backend.admin.exam.view', compact('exam'))->render();
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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, Exam $exam)
   {

      if ($request->ajax()) {
         $haspermision = auth()->user()->can('exam-edit');
         if ($haspermision) {
            $std_classes = StdClass::orderBy('id', 'asc')->get();
            $view = View::make('backend.admin.exam.edit', compact('exam','std_classes'))->render();
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
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Exam $exam)
   {

        if ($request->ajax()) {
            $haspermision = auth()->user()->can('exam-edit');
            if ($haspermision) {

                Exam::findOrFail($exam->id);

                $rules = [
                    'name' => 'required',
                    'std_class_id' => 'required',
                    'main_marks_percentage' => 'required',
                    'ct_marks_percentage' => 'required',
                    'start_date' => 'required',
                    'end_date' => 'required'
                ];

                $validator = Validator::make($request->all(), $rules);
                if ($validator->fails()) {
                    return response()->json([
                        'type' => 'error',
                        'errors' => $validator->getMessageBag()->toArray()
                    ]);
                } else {
                    $upload_ok = 1;

                    if ($request->hasFile('photo')) {
                        $extension = $request->file('photo')->getClientOriginalExtension();;
                        if ($extension == "doc" || $extension == "docx" || $extension == "pdf" || $extension == "jpg" || $extension == "jpeg" || $extension == "png") {
                            if ($request->file('photo')->isValid()) {
                                $destinationPath = public_path('assets/uploads/exam_routine');
                                $extension = $request->file('photo')->getClientOriginalExtension(); // getting image extension
                                $fileName = time() . '.' . $extension; // renameing image
                                $file_path = 'assets/uploads/exam_routine/' . $fileName;
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
                        $name = $request->input('name');
                        $rows = DB::table('exams')
                        ->where('start_date', $request->input('start_date'))
                        ->where('name', $request->input('name'))
                        ->where('std_class_id', $request->input('std_class_id'))
                        ->whereNotIn('id', [$exam->id])
                            ->count();
                        if ($rows == 0) {
                            $exam->name = $request->input('name');
                            $exam->std_class_id = $request->input('std_class_id');
                            $exam->description = $request->input('description');
                            $exam->start_date = $request->input('start_date');
                            $exam->end_date = $request->input('end_date');
                            $exam->result_modification_last_date = $request->input('result_modification_last_date');
                            $exam->main_marks_percentage = $request->input('main_marks_percentage');
                            $exam->ct_marks_percentage = $request->input('ct_marks_percentage');
                            $exam->file_path = $file_path;
                            $exam->status = $request->input('status');
                            $exam->save(); //
                            return response()->json(['type' => 'success', 'message' => "Successfully Updated"]);
                        } else {
                            return response()->json(['type' => 'error', 'message' => "<div class='alert alert-warning'> Exam Name $name  already exist in same date</div>"]);
                        }
                    }
                }
            } else {
                abort(403, 'Sorry, you are not authorized to access the page');
            }
        } else {
            return response()->json(['status' => 'false', 'message' => "Access only ajax request"]);
        }

    //   if ($request->ajax()) {
    //      $haspermision = auth()->user()->can('exam-edit');
    //      if ($haspermision) {

    //         $rules = [
    //             'std_class_id' => 'required',
    //             'name' => 'required',


    //         ];

    //         $validator = Validator::make($request->all(), $rules);
    //         if ($validator->fails()) {
    //            return response()->json([
    //              'type' => 'error',
    //              'errors' => $validator->getMessageBag()->toArray()
    //            ]);
    //         } else {

    //             DB::beginTransaction();
    //             try {
    //                 // if ($request->hasFile('photo')) {
    //                 //    $extension = strtolower($request->file('photo')->getClientOriginalExtension());
    //                 //    if ($extension == "jpg" || $extension == "jpeg" || $extension == "png") {
    //                 //       if ($request->file('photo')->isValid()) {
    //                 //          $destinationPath = public_path('assets/images/blog'); // upload path
    //                 //          $extension = $request->file('photo')->getClientOriginalExtension(); // getting image extension
    //                 //          $fileName = time() . '.' . $extension; // renameing image
    //                 //          $file_path = 'assets/images/blog/' . $fileName;
    //                 //          $request->file('photo')->move($destinationPath, $fileName); // uploading file to given path
    //                 //          $upload_ok = 1;

    //                 //       } else {
    //                 //          return response()->json([
    //                 //            'type' => 'error',
    //                 //            'message' => "<div class='alert alert-warning'>File is not valid</div>"
    //                 //          ]);
    //                 //       }
    //                 //    } else {
    //                 //       return response()->json([
    //                 //         'type' => 'error',
    //                 //         'message' => "<div class='alert alert-warning'>Error! File type is not valid</div>"
    //                 //       ]);
    //                 //    }
    //                 // } else {
    //                 //    $upload_ok = 1;
    //                 //    $file_path = $request->input('SelectedFileName');
    //                 // }

    //                 // if ($upload_ok == 0) {
    //                 //    return response()->json([
    //                 //      'type' => 'error',
    //                 //      'message' => "<div class='alert alert-warning'>Sorry Failed</div>"
    //                 //    ]);
    //                 // } else {
    //                 $exam = exam::findOrFail($exam->id);
    //                 $exam->std_class_id = $request->input('std_class_id');
    //                 $exam->name = $request->input('name');
    //                 $exam->description = $request->input('description');
    //                 $exam->start_date = $request->input('start_date');
    //                 $exam->end_date = $request->input('end_date');
    //                 $exam->result_modification_last_date = $request->input('result_modification_last_date');
    //                 $exam->main_marks_percentage = $request->input('main_marks_percentage');
    //                 $exam->ct_marks_percentage = $request->input('ct_marks_percentage');
    //                 $exam->status = $request->input('status');
    //                 $exam->uploaded_by = auth()->user()->id;
    //                 $exam->save(); //
    //                 DB::commit();
    //                 return response()->json(['type' => 'success', 'message' => "Successfully Updated"]);
    //             } catch (\Exception $e) {
    //                 DB::rollback();
    //                 return response()->json(['type' => 'error', 'message' => "Please Fill With Correct data"]);
    //             }
    //            // }
    //         }
    //      } else {
    //         abort(403, 'Sorry, you are not authorized to access the page');
    //      }
    //   } else {
    //      return response()->json(['status' => 'false', 'message' => "Access only ajax request"]);
    //   }
   }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Exam $exam)
   {
      if ($request->ajax()) {
         $haspermision = auth()->user()->can('exam-delete');
         if ($haspermision) {
            $exam->delete();
            return response()->json(['type' => 'success', 'message' => 'Successfully Deleted']);
         } else {
            abort(403, 'Sorry, you are not authorized to access the page');
         }
      } else {
         return response()->json(['status' => 'false', 'message' => "Access only ajax request"]);
      }
   }
}
