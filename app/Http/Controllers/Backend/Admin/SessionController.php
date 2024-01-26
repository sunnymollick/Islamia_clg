<?php

namespace App\Http\Controllers\Backend\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Yajra\DataTables\DataTables;
use App\Models\Session;
use View;
use DB;
use Auth;
class SessionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('backend.admin.session.index');
    }

    public function getAll(Request $request)
    {
       if ($request->ajax()) {
         $can_view = $can_edit = $can_delete = '';
         if (!auth()->user()->can('session-view')) {
            $can_view = "style='display:none;'";
         }
          if (!auth()->user()->can('session-edit')) {
             $can_edit = "style='display:none;'";
          }
          if (!auth()->user()->can('session-delete')) {
             $can_delete = "style='display:none;'";
          }

          $session = Session::orderby('created_at', 'desc')->get();
          return Datatables::of($session)


            ->addColumn('status', function ($session) {
                return $session->status ? '<span class="badge badge-success">Active</span>' : '<span class="badge badge-danger">Inactive</span>';
             })

            ->addColumn('action', function ($session) use ($can_view, $can_edit, $can_delete) {
               $html = '<div class="btn-group">';
               $html .= '<a data-toggle="tooltip" ' . $can_view . '  id="' . $session->id . '" class="btn btn-xs btn-success mr-1 view" title="View"><i class="fa fa-eye"></i> </a>';
               $html .= '<a data-toggle="tooltip" ' . $can_edit . '  id="' . $session->id . '" class="btn btn-xs btn-info mr-1 edit" title="Edit"><i class="fa fa-edit"></i> </a>';
                if (Auth::user()->id == 1) {
               $html .= '<a data-toggle="tooltip" ' . $can_delete . ' id="' . $session->id . '" class="btn btn-xs btn-danger delete" title="Delete"><i class="fa fa-trash"></i> </a>';
                }
               $html .= '</div>';
               return $html;
            })
            ->rawColumns(['status','action'])
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
         $haspermision = auth()->user()->can('session-create');
         if ($haspermision) {
            $view = View::make('backend.admin.session.create')->render();
            // var_dump($view);
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

        // return "test";
       if ($request->ajax()) {
          $haspermision = auth()->user()->can('session-create');
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

                    DB::table('sessions')->where('status',1)->update([
                            'status' => 0,
                    ]);

                    $session = new Session;
                    $session->name = $request->input('name');
                    $session->uploaded_by = auth()->user()->id;
                    $session->save(); //
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
    public function show(Request $request, Session $session)
   {
      if ($request->ajax()) {
         $haspermision = auth()->user()->can('session-view');
         if ($haspermision) {
            $view = View::make('backend.admin.session.view', compact('session'))->render();
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
    public function edit(Request $request, Session $session)
   {

      if ($request->ajax()) {
         $haspermision = auth()->user()->can('session-edit');
         if ($haspermision) {

            $view = View::make('backend.admin.session.edit', compact('session'))->render();
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
    public function update(Request $request, Session $session)
   {
      if ($request->ajax()) {
         $haspermision = auth()->user()->can('session-edit');
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
                    $session = Session::findOrFail($session->id);
                    $session->name = $request->input('name');
                    $session->status = $request->input('status');
                    $session->uploaded_by = auth()->user()->id;
                    $session->save(); //
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
    public function destroy(Request $request, Session $session)
   {
      if ($request->ajax()) {
         $haspermision = auth()->user()->can('session-delete');
         if ($haspermision) {
            $session->delete();
            return response()->json(['type' => 'success', 'message' => 'Successfully Deleted']);
         } else {
            abort(403, 'Sorry, you are not authorized to access the page');
         }
      } else {
         return response()->json(['status' => 'false', 'message' => "Access only ajax request"]);
      }
   }
}
