<?php

namespace App\Http\Controllers\Backend\Admin;

use App\Http\Controllers\Controller;
use App\Models\Section;
use App\Models\StdClass;
use App\Models\Subject;
use App\Models\SubjectAssign;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Yajra\DataTables\DataTables;
use View;
use DB;
use Auth;

class SubjectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $stdclass = StdClass::all();
        return view('backend.admin.subject.index', compact('stdclass'));
    }

    public function getAll(Request $request)
    {
       if ($request->ajax()) {
         $can_view = $can_edit = $can_delete = '';
         if (!auth()->user()->can('subject-view')) {
            $can_view = "style='display:none;'";
         }
          if (!auth()->user()->can('subject-edit')) {
             $can_edit = "style='display:none;'";
          }
          if (!auth()->user()->can('subject-delete')) {
             $can_delete = "style='display:none;'";
          }
          $class_id = $request->input('class_id');
        // $subjects = Subject::orderby('created_at', 'desc')->get();
        // $subjects = Subject::with('stdclasses')->where('std_class_id', $class_id)->orderBy('std_class_id', 'asc')->get();
        $subjects = Subject::join('std_classes', 'std_classes.id', 'subjects.std_class_id')->where('std_class_id', $class_id)
        ->select('subjects.*', 'std_classes.name as class')
        ->orderBy('std_class_id', 'asc')->get();
          return Datatables::of($subjects)

            // ->addColumn('project_name', function ($subject) {
            //     return $project->client_id? $project->client->name.'-'.$project->name:'n/a';
            // })

            ->addColumn('status', function ($subject) {
                return $subject->status ? '<span class="badge badge-success">Active</span>' : '<span class="badge badge-danger">Inactive</span>';
             })

            ->addColumn('action', function ($subject) use ($can_view, $can_edit, $can_delete) {
               $html = '<div class="btn-group">';
               $html .= '<a data-toggle="tooltip" ' . $can_view . '  id="' . $subject->id . '" class="btn btn-xs btn-success mr-1 view" title="View"><i class="fa fa-eye"></i> </a>';
               $html .= '<a data-toggle="tooltip" ' . $can_edit . '  id="' . $subject->id . '" class="btn btn-xs btn-info mr-1 edit" title="Edit"><i class="fa fa-edit"></i> </a>';
                if (Auth::user()->id == 1) {
                $html .= '<a data-toggle="tooltip" ' . $can_delete . ' id="' . $subject->id . '" class="btn btn-xs btn-danger delete" title="Delete"><i class="fa fa-trash"></i> </a>';
                }
               $html .= '</div>';
               return $html;
            })
            ->rawColumns(['project_name','status','action'])
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
         $haspermision = auth()->user()->can('subject-create');
         if ($haspermision) {
            $std_classes = StdClass::orderBy('id', 'asc')->get();
            $view = View::make('backend.admin.subject.create',compact('std_classes'))->render();
            return response()->json(['html' => $view]);
         } else {
            abort(403, 'Sorry, you are not authorized to access the page');
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
            // dd(count($request->section_id));

            // return $request;
        if ($request->ajax()) {
            $haspermision = auth()->user()->can('subject-create');
            if ($haspermision) {

                $rules = [
                'std_class_id' => 'required',
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

                        // if ($request->hasFile('photo')) {
                        //    $extension = strtolower($request->file('photo')->getClientOriginalExtension());
                        //    if ($extension == "jpg" || $extension == "jpeg" || $extension == "png") {
                        //       if ($request->file('photo')->isValid()) {
                        //          $destinationPath = public_path('assets/images/blog'); // upload path
                        //          $extension = $request->file('photo')->getClientOriginalExtension(); // getting image extension
                        //          $fileName = time() . '.' . $extension; // renameing image
                        //          $file_path = 'assets/images/blog/' . $fileName;
                        //          $request->file('photo')->move($destinationPath, $fileName); // uploading file to given path
                        //          $upload_ok = 1;

                        //       } else {
                        //          return response()->json([
                        //            'type' => 'error',
                        //            'message' => "<div class='alert alert-warning'>File is not valid</div>"
                        //          ]);
                        //       }
                        //    } else {
                        //       return response()->json([
                        //         'type' => 'error',
                        //         'message' => "<div class='alert alert-warning'>Error! File type is not valid</div>"
                        //       ]);
                        //    }
                        // }

                        // if ($upload_ok == 0) {
                        //    return response()->json([
                        //      'type' => 'error',
                        //      'message' => "<div class='alert alert-warning'>Sorry Failed</div>"
                        //    ]);
                        // } else {

                        $subject = new Subject;
                        $subject->std_class_id = $request->input('std_class_id');
                        $subject->name = $request->input('name');
                        $subject->code = $request->input('code');
                        $subject->order = $request->input('order');
                        $subject->teacher_id = 0;
                        $subject->marks = $request->input('marks');
                        $subject->pass_marks = $request->input('pass_marks');
                        $subject->theory_marks = $request->input('theory_marks');
                        $subject->theory_pass_marks = $request->input('theory_pass_marks');
                        $subject->mcq_marks = $request->input('mcq_marks');
                        $subject->mcq_pass_marks = $request->input('mcq_pass_marks');
                        $subject->mcq_pass_marks = $request->input('mcq_pass_marks');
                        $subject->practical_marks = $request->input('practical_marks');
                        // $subject->practical_marks = $request->input('practical_marks');
                        // $subject->practical_pass_marks = $request->input('practical_pass_marks');
                        $subject->practical_pass_marks = $request->input('practical_pass_marks');
                        // $subject->ct_marks = $request->input('ct_marks');
                        $subject->ct_marks = $request->input('ct_marks');
                        $subject->ct_pass_marks = $request->input('ct_pass_marks');
                        $subject->uploaded_by = auth()->user()->id;
                        $subject->save(); //

                        $section_ids=$request->input('section_id');

                        foreach($section_ids as $section_id){
                            $subject_assign=new SubjectAssign;
                            $subject_assign->subject_id = $subject->id;
                            $subject_assign->section_id = $section_id;
                            $subject_assign->uploaded_by = auth()->user()->id;
                            $subject_assign->save();
                        }


                        DB::commit();
                        return response()->json(['type' => 'success', 'message' => "Successfully Updated"]);
                    } catch (\Exception $e) {
                        DB::rollback();
                        return response()->json(['type' => 'error', 'message' => "Please Fill With Correct data"]);
                    }
                    // }
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
    public function show(Request $request, Subject $subject)
    {
        if ($request->ajax()) {
            $haspermision = auth()->user()->can('subject-view');
            if ($haspermision) {
                $view = View::make('backend.admin.subject.view', compact('subject'))->render();
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
    public function edit(Request $request, Subject $subject)
    {
        if ($request->ajax()) {
            $haspermision = auth()->user()->can('subject-edit');
            if ($haspermision) {
                $std_classes = StdClass::orderBy('id', 'asc')->get();
                $sections = Section::where('std_class_id',$subject->std_class_id)
                                        ->orderBy('id', 'asc')->get();
                $section_ids=array();
                foreach($subject->subjectAssign as $key=>$subject_assign){
                    $section_ids[$key]=$subject_assign->section_id;
                }

                $view = View::make('backend.admin.subject.edit', compact('subject','std_classes','sections','section_ids'))->render();
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
    public function update(Request $request, Subject $subject)
   {
      if ($request->ajax()) {
         $haspermision = auth()->user()->can('project-edit');
         if ($haspermision) {

            $rules = [
                'std_class_id' => 'required',
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
                    // if ($request->hasFile('photo')) {
                    //    $extension = strtolower($request->file('photo')->getClientOriginalExtension());
                    //    if ($extension == "jpg" || $extension == "jpeg" || $extension == "png") {
                    //       if ($request->file('photo')->isValid()) {
                    //          $destinationPath = public_path('assets/images/blog'); // upload path
                    //          $extension = $request->file('photo')->getClientOriginalExtension(); // getting image extension
                    //          $fileName = time() . '.' . $extension; // renameing image
                    //          $file_path = 'assets/images/blog/' . $fileName;
                    //          $request->file('photo')->move($destinationPath, $fileName); // uploading file to given path
                    //          $upload_ok = 1;

                    //       } else {
                    //          return response()->json([
                    //            'type' => 'error',
                    //            'message' => "<div class='alert alert-warning'>File is not valid</div>"
                    //          ]);
                    //       }
                    //    } else {
                    //       return response()->json([
                    //         'type' => 'error',
                    //         'message' => "<div class='alert alert-warning'>Error! File type is not valid</div>"
                    //       ]);
                    //    }
                    // } else {
                    //    $upload_ok = 1;
                    //    $file_path = $request->input('SelectedFileName');
                    // }

                    // if ($upload_ok == 0) {
                    //    return response()->json([
                    //      'type' => 'error',
                    //      'message' => "<div class='alert alert-warning'>Sorry Failed</div>"
                    //    ]);
                    // } else {

                    $subject = Subject::findOrFail($subject->id);
                    $subject->std_class_id = $request->input('std_class_id');
                    $subject->name = $request->input('name');
                    $subject->code = $request->input('code');
                    $subject->order = $request->input('order');
                    $subject->teacher_id = 0;
                    $subject->marks = $request->input('marks');
                    $subject->pass_marks = $request->input('pass_marks');
                    $subject->theory_marks = $request->input('theory_marks');
                    $subject->theory_pass_marks = $request->input('theory_pass_marks');
                    $subject->mcq_marks = $request->input('mcq_marks');
                    $subject->mcq_pass_marks = $request->input('mcq_pass_marks');
                    $subject->mcq_pass_marks = $request->input('mcq_pass_marks');
                    $subject->practical_marks = $request->input('practical_marks');
                    $subject->practical_marks = $request->input('practical_marks');
                    $subject->practical_pass_marks = $request->input('practical_pass_marks');
                    $subject->practical_pass_marks = $request->input('practical_pass_marks');
                    $subject->ct_marks = $request->input('ct_marks');
                    $subject->ct_marks = $request->input('ct_marks');
                    $subject->ct_pass_marks = $request->input('ct_pass_marks');
                    $subject->status = $request->input('status');
                    $subject->uploaded_by = auth()->user()->id;
                    $subject->save(); //

                    $section_ids = $request->input('section_id');

                    foreach ($section_ids as $section_id) {
                        $subject_assign = SubjectAssign::updateOrInsert(
                            [
                                'subject_id' => $subject->id,
                                'section_id' => $section_id
                            ],
                            [
                                'status' => 1,
                                'uploaded_by' => auth()->user()->id
                            ]
                        );
                    }

                    DB::commit();
                    return response()->json(['type' => 'success', 'message' => "Successfully Updated"]);
                } catch (\Exception $e) {
                    DB::rollback();
                    return response()->json(['type' => 'error', 'message' => "Please Fill With Correct data"]);
                }
               // }
            }
         } else {
            abort(403, 'Sorry, you are not authorized to access the page');
         }
      } else {
         return response()->json(['status' => 'false', 'message' => "Access only ajax request"]);
      }
   }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Subject $subject)
   {
      if ($request->ajax()) {
         $haspermision = auth()->user()->can('subject-delete');
         if ($haspermision) {
            $subject->delete();
            return response()->json(['type' => 'success', 'message' => 'Successfully Deleted']);
         } else {
            abort(403, 'Sorry, you are not authorized to access the page');
         }
      } else {
         return response()->json(['status' => 'false', 'message' => "Access only ajax request"]);
      }
   }

    public function getSubjects(Request $request, $class_id)
    {
        if ($request->ajax()) {

            $class = StdClass::findOrFail($class_id);
            $subjects = $class->subject;
            if ($subjects) {
                echo "<option value='' selected disabled> Select a subject</option>";
                foreach ($subjects as $subject) {
                    echo "<option  value='$subject->id'> $subject->name</option>";
                }
            }
        } else {
            return response()->json(['status' => 'false', 'message' => "Access only ajax request"]);
        }
    }

    public function getOptionalSubjects(Request $request, $class_id)
    {
        if ($request->ajax()) {
            $subjects = Subject::where('class_id', $class_id)->where('subject_type', 0)->get();
            if ($subjects) {
                echo "<option value=''> Select Optional Subject</option>";
                foreach ($subjects as $subject) {
                    echo "<option  value='$subject->id'> $subject->name</option>";
                }
            }
        } else {
            return response()->json(['status' => 'false', 'message' => "Access only ajax request"]);
        }
    }
}
