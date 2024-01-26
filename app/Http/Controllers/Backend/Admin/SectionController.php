<?php

namespace App\Http\Controllers\Backend\Admin;

use App\Http\Controllers\Controller;
use App\Models\Section;
use App\Models\Session;
use App\Models\StdClass;
use App\Models\SubjectAssign;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Yajra\DataTables\DataTables;
use View;
use DB;
use Auth;

class SectionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('backend.admin.section.index');
    }

    public function getAll(Request $request)
    {
        if ($request->ajax()) {
            $can_view = $can_edit = $can_delete = '';
            if (!auth()->user()->can('section-view')) {
                $can_view = "style='display:none;'";
            }
            if (!auth()->user()->can('section-edit')) {
                $can_edit = "style='display:none;'";
            }
            if (!auth()->user()->can('section-delete')) {
                $can_delete = "style='display:none;'";
            }

            $section = Section::orderby('created_at', 'desc')->get();
            return Datatables::of($section)

                // ->addColumn('project_name', function ($section) {
                //     return $project->client_id? $project->client->name.'-'.$project->name:'n/a';
                // })

                ->addColumn('status', function ($section) {
                    return $section->status ? '<span class="badge badge-success">Active</span>' : '<span class="badge badge-danger">Inactive</span>';
                })

                ->addColumn('class', function ($section) {
                    return $section->stdClass->name;
                })

                ->addColumn('action', function ($section) use ($can_view, $can_edit, $can_delete) {
                    $html = '<div class="btn-group">';
                    $html .= '<a data-toggle="tooltip" ' . $can_view . '  id="' . $section->id . '" class="btn btn-xs btn-success mr-1 view" title="View"><i class="fa fa-eye"></i> </a>';
                    $html .= '<a data-toggle="tooltip" ' . $can_edit . '  id="' . $section->id . '" class="btn btn-xs btn-info mr-1 edit" title="Edit"><i class="fa fa-edit"></i> </a>';
                    if (Auth::user()->id == 1) {
                        $html .= '<a data-toggle="tooltip" ' . $can_delete . ' id="' . $section->id . '" class="btn btn-xs btn-danger delete" title="Delete"><i class="fa fa-trash"></i> </a>';
                    }
                    $html .= '</div>';
                    return $html;
                })
                ->rawColumns(['class','status', 'action'])
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
            $haspermision = auth()->user()->can('section-create');
            if ($haspermision) {
                $std_classes = StdClass::where('status', 1)->orderBy('id', 'asc')->get();
                $view = View::make('backend.admin.section.create', compact('std_classes'))->render();
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

        // return $request;
        if ($request->ajax()) {
            $haspermision = auth()->user()->can('section-create');
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
                        $section = new Section;
                        $section->std_class_id = $request->input('std_class_id');
                        $section->name = $request->input('name');
                        $section->identification_number = $request->input('identification_number');
                        $section->uploaded_by = auth()->user()->id;
                        $section->save(); //
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
    public function show(Request $request, Section $section)
    {
        if ($request->ajax()) {
            $haspermision = auth()->user()->can('section-view');
            if ($haspermision) {
                $std_classes = StdClass::where('status', 1)->orderBy('id', 'asc')->get();
                $view = View::make('backend.admin.section.view', compact('section', 'std_classes'))->render();
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
    public function edit(Request $request, Section $section)
    {

        if ($request->ajax()) {
            $haspermision = auth()->user()->can('section-edit');
            if ($haspermision) {
                $std_classes = StdClass::orderBy('id', 'asc')->get();
                $view = View::make('backend.admin.section.edit', compact('section', 'std_classes'))->render();
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
    public function update(Request $request, Section $section)
    {

        if ($request->ajax()) {
            $haspermision = auth()->user()->can('section-edit');
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
                        $section = Section::findOrFail($section->id);
                        $section->std_class_id = $request->input('std_class_id');
                        $section->name = $request->input('name');
                        $section->identification_number = $request->input('identification_number');
                        $section->status = $request->input('status');
                        $section->uploaded_by = auth()->user()->id;
                        $section->save(); //
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
    public function destroy(Request $request, Section $section)
    {
        if ($request->ajax()) {
            $haspermision = auth()->user()->can('section-delete');
            if ($haspermision) {
                $section->delete();
                return response()->json(['type' => 'success', 'message' => 'Successfully Deleted']);
            } else {
                abort(403, 'Sorry, you are not authorized to access the page');
            }
        } else {
            return response()->json(['status' => 'false', 'message' => "Access only ajax request"]);
        }
    }

    /**
     * @param Request $request
     * @param StdClass $class
     */


    public function getSections(Request $request, $class_id)
    {
        if ($request->ajax()) {

            $class = StdClass::findOrFail($class_id);
            $sections = $class->section;
            // $sections = Section::where('std_class_id', $class_id)->get();
            if ($sections) {
                echo "<option value='' selected disabled> Select a section</option>";
                foreach ($sections as $section) {
                    echo "<option  value='$section->id'>$section->name</option>";
                }
            }
        } else {
            return response()->json(['status' => 'false', 'message' => "Access only ajax request"]);
        }
    }

    public function deleteSections(Request $request, $section_arr,$subject_id){

        if ($section_arr != null) {
            $subject_assign = SubjectAssign::where('subject_id', $subject_id)
                ->where('section_id', $section_arr)
                ->first();
            $subject_assign->delete();

            return response()->json([
                'status' => 'true', 'message' => 'successfully deleted'
            ]);
        }else{
            return response()->json([
                'status' => 'false', 'message' => 'Not deleted'
            ]);
        }
    }

    public function getSectionsForSms(Request $request, StdClass $class)
    {
        if ($request->ajax()) {
            $haspermission = auth()->user()->can('section-get-sections');
            if ($haspermission) {
                $sections = $class->section;
                return response()->json(['data' => $sections, 'message' => 'Successfully fetched!']);
            } else {
                abort(403, 'Sorry, you are not authorized to access to change');
            }
        } else {
            return response()->json(['status' => 'false', 'message' => 'Access only ajax request']);
        }
    }

}
