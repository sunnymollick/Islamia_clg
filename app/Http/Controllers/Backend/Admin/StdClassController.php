<?php

namespace App\Http\Controllers\Backend\Admin;

use App\Http\Controllers\Controller;
use App\Models\Session;
use App\Models\StdClass;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Yajra\DataTables\DataTables;
use View;
use DB;
use Auth;

class StdClassController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('backend.admin.std_class.index');
    }

    public function getAll(Request $request)
    {
       if ($request->ajax()) {
         $can_view = $can_edit = $can_delete = '';
         if (!auth()->user()->can('std-class-view')) {
            $can_view = "style='display:none;'";
         }
          if (!auth()->user()->can('std-class-edit')) {
             $can_edit = "style='display:none;'";
          }
          if (!auth()->user()->can('std-class-delete')) {
             $can_delete = "style='display:none;'";
          }

          $std_class = StdClass::orderby('created_at', 'desc')->get();
          return Datatables::of($std_class)

            ->addColumn('section', function ($std_class) {
                $section='';
                foreach($std_class->section as $sec){
                    $section=$section.'<span class="badge badge-success ml-2">' . $sec->name . '</span>';
                }
                return $section;
            })

            ->addColumn('status', function ($std_class) {
                return $std_class->status ? '<span class="badge badge-success">Active</span>' : '<span class="badge badge-danger">Inactive</span>';
             })

            ->addColumn('action', function ($std_class) use ($can_view, $can_edit, $can_delete) {
               $html = '<div class="btn-group">';
               $html .= '<a data-toggle="tooltip" ' . $can_view . '  id="' . $std_class->id . '" class="btn btn-xs btn-success mr-1 view" title="View"><i class="fa fa-eye"></i> </a>';
               $html .= '<a data-toggle="tooltip" ' . $can_edit . '  id="' . $std_class->id . '" class="btn btn-xs btn-info mr-1 edit" title="Edit"><i class="fa fa-edit"></i> </a>';

                if (Auth::user()->id == 1) {
                    $html .= '<a data-toggle="tooltip" ' . $can_delete . ' id="' . $std_class->id . '" class="btn btn-xs btn-danger delete" title="Delete"><i class="fa fa-trash"></i> </a>';
                }
                $html .= '</div>';
               return $html;
            })
            ->rawColumns(['section','status','action'])
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
         $haspermision = auth()->user()->can('std-class-create');
         if ($haspermision) {
            $view = View::make('backend.admin.std_class.create')->render();
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


       if ($request->ajax()) {
          $haspermision = auth()->user()->can('std-class-create');
          if ($haspermision) {

             $rules = [
                'name' => 'required',
                'in_digit' => 'required',
                'has_optional' => 'required',

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

                    $session=Session::where('status',1)->first();

                    $std_class = new StdClass;
                    $std_class->session_id = $session->id;
                    $std_class->name = $request->input('name');
                    $std_class->in_digit = $request->input('in_digit');
                    $std_class->has_optional = $request->input('has_optional');
                    $std_class->uploaded_by = auth()->user()->id;
                    $std_class->save(); //
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
    public function show(Request $request, StdClass $std_class)
   {
      if ($request->ajax()) {
         $haspermision = auth()->user()->can('std-class-view');
         if ($haspermision) {
            $view = View::make('backend.admin.std_class.view', compact('std_class'))->render();
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
    public function edit(Request $request, StdClass $std_class)
   {

      if ($request->ajax()) {
         $haspermision = auth()->user()->can('std-class-edit');
         if ($haspermision) {

            $view = View::make('backend.admin.std_class.edit', compact('std_class'))->render();
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
    public function update(Request $request, StdClass $std_class)
   {
      if ($request->ajax()) {
         $haspermision = auth()->user()->can('std-class-edit');
         if ($haspermision) {

            $rules = [
                // 'client_id' => 'required',
                // 'name' => 'required',
                // 'address' => 'required',

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

                    $std_class = StdClass::findOrFail($std_class->id);
                    $std_class->name = $request->input('name');
                    $std_class->in_digit = $request->input('in_digit');
                    $std_class->has_optional = $request->input('has_optional');
                    $std_class->status = $request->input('status');
                    $std_class->uploaded_by = auth()->user()->id;
                    $std_class->save(); //
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
    public function destroy(Request $request, StdClass $std_class)
   {
      if ($request->ajax()) {
         $haspermision = auth()->user()->can('std-class-delete');
         if ($haspermision) {
            $std_class->delete();
            return response()->json(['type' => 'success', 'message' => 'Successfully Deleted']);
         } else {
            abort(403, 'Sorry, you are not authorized to access the page');
         }
      } else {
         return response()->json(['status' => 'false', 'message' => "Access only ajax request"]);
      }
   }
}
