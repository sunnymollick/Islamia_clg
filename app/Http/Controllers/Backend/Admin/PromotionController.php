<?php

namespace App\Http\Controllers\backend\admin;

use App\Http\Controllers\Controller;
use App\Imports\EnrollImport;
use App\Models\Enroll;
use App\Models\ExcelImportRecord;
use App\Models\StdClass;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Yajra\DataTables\DataTables;
use View;
use DB;

class PromotionController extends Controller
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

    public function import()
   {
      $haspermision = auth()->user()->can('promotion-import');
      if ($haspermision) {
         $std_classes = StdClass::orderBy('id', 'asc')->get();
         return view('backend.admin.promotion.import',compact('std_classes'));
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
                    $path = $request->file('excel_upload')->getRealPath();
                    $data = Excel::import(new EnrollImport($request->section_id), $path);


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