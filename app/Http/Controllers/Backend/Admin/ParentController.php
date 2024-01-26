<?php

namespace App\Http\Controllers\backend\admin;

use App\Http\Controllers\Controller;
use App\Models\StdParent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Yajra\DataTables\DataTables;
use View;
use DB;
use App\Imports\StdParentsImport;
use App\Models\ExcelImportRecord;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Hash;

class ParentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('backend.admin.std_parent.index');
    }

    public function getAll(Request $request)
    {
       if ($request->ajax()) {
         $can_view = $can_edit = $can_delete = '';
         if (!auth()->user()->can('std-parent-view')) {
            $can_view = "style='display:none;'";
         }
          if (!auth()->user()->can('std-parent-edit')) {
             $can_edit = "style='display:none;'";
          }
          if (!auth()->user()->can('std-parent-delete')) {
             $can_delete = "style='display:none;'";
          }

          $std_parent = StdParent::orderby('created_at', 'desc')->get();
          return Datatables::of($std_parent)

            // ->addColumn('project_name', function ($section) {
            //     return $project->client_id? $project->client->name.'-'.$project->name:'n/a';
            // })

            ->addColumn('status', function ($std_parent) {
                return $std_parent->status ? '<span class="badge badge-success">Active</span>' : '<span class="badge badge-danger">Inactive</span>';
             })

            ->addColumn('action', function ($std_parent) use ($can_view, $can_edit, $can_delete) {
               $html = '<div class="btn-group">';
               $html .= '<a data-toggle="tooltip" ' . $can_view . '  id="' . $std_parent->id . '" class="btn btn-xs btn-success mr-1 view" title="View"><i class="fa fa-eye"></i> </a>';
               $html .= '<a data-toggle="tooltip" ' . $can_edit . '  id="' . $std_parent->id . '" class="btn btn-xs btn-info mr-1 edit" title="Edit"><i class="fa fa-edit"></i> </a>';
               $html .= '<a data-toggle="tooltip" ' . $can_delete . ' id="' . $std_parent->id . '" class="btn btn-xs btn-danger delete" title="Delete"><i class="fa fa-trash"></i> </a>';
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

    public function import()
   {
      $haspermision = auth()->user()->can('std-parent-import');
      if ($haspermision) {

         return view('backend.admin.std_parent.import');
      } else {
         abort(403, 'Sorry, you are not authorized to access the page');
      }
   }

   public function importStore(Request $request)
   {

      if ($request->ajax()) {
         $haspermision = auth()->user()->can('std-parent-import');
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



                    $path = $request->file('excel_upload')->getRealPath();
                    $data = Excel::import(new StdParentsImport, $path);

                    if ($request->hasFile('excel_upload')) {
                        $extension = strtolower($request->file('excel_upload')->getClientOriginalExtension());
                        if ($extension == "xlsx" || $extension == "xls") {
                            if ($request->file('excel_upload')->isValid()) {
                                $destinationPath = public_path('assets/documents'); // upload path
                                $extension = $request->file('excel_upload')->getClientOriginalExtension(); // getting image extension
                                $fileName = date("Y.m.d").'-'.date("h-i-sa").'-'.'parents-import'.'-'.uniqid() . '.' . $extension; // renameing image
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
