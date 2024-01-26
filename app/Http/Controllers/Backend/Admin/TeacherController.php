<?php

namespace App\Http\Controllers\Backend\Admin;

use App\Http\Controllers\Controller;
use App\Models\Teacher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Yajra\DataTables\DataTables;
use View;
use DB;
use App\Imports\TeachersImport;
use App\Models\StdClass;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Hash;


class TeacherController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('backend.admin.teacher.index');
    }

    public function getAll(Request $request)
    {
        if ($request->ajax()) {
            $can_view = $can_edit = $can_delete = '';
            if (!auth()->user()->can('teacher-view')) {
                $can_view = "style='display:none;'";
            }
            if (!auth()->user()->can('teacher-edit')) {
                $can_edit = "style='display:none;'";
            }
            if (!auth()->user()->can('teacher-delete')) {
                $can_delete = "style='display:none;'";
            }

            $teacher = Teacher::orderby('order', 'asc')->get();
            return Datatables::of($teacher)
                // ->addColumn('project_name', function ($section) {
                //     return $project->client_id? $project->client->name.'-'.$project->name:'n/a';
                // })

                ->addColumn('status', function ($teacher) {
                    return $teacher->status ? '<span class="badge badge-success">Active</span>' : '<span class="badge badge-danger">Inactive</span>';
                })
                ->addColumn('action', function ($teacher) use ($can_view, $can_edit, $can_delete) {
                    $html = '<div class="btn-group">';
                    $html .= '<a data-toggle="tooltip" ' . $can_view . '  id="' . $teacher->id . '" class="btn btn-xs btn-success mr-1 view" title="View"><i class="fa fa-eye"></i> </a>';
                    $html .= '<a data-toggle="tooltip" ' . $can_edit . '  id="' . $teacher->id . '" class="btn btn-xs btn-info mr-1 edit" title="Edit"><i class="fa fa-edit"></i> </a>';
                    $html .= '<a data-toggle="tooltip" ' . $can_delete . ' id="' . $teacher->id . '" class="btn btn-xs btn-danger delete" title="Delete"><i class="fa fa-trash"></i> </a>';
                    $html .= '</div>';
                    return $html;
                })
                ->rawColumns(['status', 'action'])
                ->addIndexColumn()
                ->make(true);
        } else {
            return response()->json(['status' => 'false', 'message' => "Access only ajax request"]);
        }
    }

    public function import()
    {
        $haspermision = auth()->user()->can('teacher-import');
        if ($haspermision) {

            return view('backend.admin.teacher.import');
        } else {
            abort(403, 'Sorry, you are not authorized to access the page');
        }
    }

    public function importStore(Request $request)
    {

        if ($request->ajax()) {
            $haspermision = auth()->user()->can('teacher-import');
            if ($haspermision) {

                $rules = [
                    //   'excel_upload' => 'required',

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


                        // $bank = new Bank;
                        // $bank->name = $request->input('name');
                        // $bank->address = $request->input('address');
                        // $bank->uploaded_by = auth()->user()->id;
                        // $bank->save(); //


                        // $uploaded_by=auth()->user()->id;

                        $path = $request->file('excel_upload')->getRealPath();
                        $data = Excel::import(new TeachersImport, $path);

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
            $haspermision = auth()->user()->can('teacher-create');
            if ($haspermision) {
                $view = View::make('backend.admin.teacher.create')->render();
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
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        // return $request;
        if ($request->ajax()) {
            $haspermision = auth()->user()->can('teacher-create');
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
                                    $destinationPath = public_path('assets/images/teacher'); // upload path
                                    $extension = $request->file('photo')->getClientOriginalExtension(); // getting image extension
                                    $fileName = time() . uniqid() . '.' . $extension; // renameing image
                                    $file_path = 'assets/images/teacher/' . $fileName;
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
                            $teacher = new Teacher;
                            $teacher->name = $request->input('name');
                            $teacher->code = $request->input('code');
                            $teacher->qualification = $request->input('qualification');
                            $teacher->marital_status = $request->input('marital_status');
                            $teacher->dob = $request->input('dob');
                            $teacher->doj = $request->input('doj');
                            $teacher->gender = $request->input('gender');
                            $teacher->religion = $request->input('religion');
                            $teacher->blood_group = $request->input('blood_group');
                            $teacher->address = $request->input('address');
                            $teacher->phone = $request->input('phone');
                            $teacher->email = $request->input('email');
                            $teacher->password = Hash::make("123456");
                            $teacher->designation = $request->input('designation');
                            $teacher->order = $request->input('order');
                            $teacher->file_path = $file_path;

                            $teacher->uploaded_by = auth()->user()->id;
                            $teacher->save(); //

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
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Teacher $teacher)
    {
        if ($request->ajax()) {
            $haspermision = auth()->user()->can('teacher-view');
            if ($haspermision) {
                $view = View::make('backend.admin.teacher.view', compact('teacher'))->render();
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
    public function edit(Request $request, Teacher $teacher)
    {

        if ($request->ajax()) {
            $haspermision = auth()->user()->can('teacher-edit');
            if ($haspermision) {
                $view = View::make('backend.admin.teacher.edit', compact('teacher'))->render();
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
    public function update(Request $request, Teacher $teacher)
    {
        if ($request->ajax()) {
            $haspermision = auth()->user()->can('teacher-edit');
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
                                    $destinationPath = public_path('assets/images/teacher'); // upload path
                                    $extension = $request->file('photo')->getClientOriginalExtension(); // getting image extension
                                    $fileName = time() . uniqid() . '.' . $extension; // renameing image
                                    $file_path = 'assets/images/teacher/' . $fileName;
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
                            $teacher = Teacher::findOrFail($teacher->id);
                            $teacher->name = $request->input('name');
                            $teacher->code = $request->input('code');
                            $teacher->qualification = $request->input('qualification');
                            $teacher->marital_status = $request->input('marital_status');
                            $teacher->dob = $request->input('dob');
                            $teacher->doj = $request->input('doj');
                            $teacher->gender = $request->input('gender');
                            $teacher->religion = $request->input('religion');
                            $teacher->blood_group = $request->input('blood_group');
                            $teacher->address = $request->input('address');
                            $teacher->phone = $request->input('phone');
                            $teacher->email = $request->input('email');
                            $teacher->password = Hash::make("123456");
                            $teacher->designation = $request->input('designation');
                            $teacher->order = $request->input('order');

                            $teacher->file_path = $file_path;

                            $teacher->status = $request->input('status');
                            $teacher->uploaded_by = auth()->user()->id;
                            $teacher->save(); //

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
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Teacher $teacher)
    {
        if ($request->ajax()) {
            $haspermision = auth()->user()->can('teacher-delete');
            if ($haspermision) {
                $teacher->delete();
                return response()->json(['type' => 'success', 'message' => 'Successfully Deleted']);
            } else {
                abort(403, 'Sorry, you are not authorized to access the page');
            }
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
            $teachers = Teacher::all();

            $haspermision = auth()->user()->can('sms-send');
            if ($haspermision) {
                $view = View::make('backend.admin.teacher.smsSend', compact('teachers'))->render();
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
            'teachers_numbers' => 'required',
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
                if (\request('teachers_numbers')[0] == 'all') {
                    $teachers = Teacher::all();
                    foreach ($teachers as $teacher) {
                        $this->httpRequest($teacher->phone, $request->message);
                    }
                } else {
                    foreach (\request('teachers_numbers') as $phone) {
                        $this->httpRequest($phone, $request->message);
                    }
                }
                return response()->json(['type' => 'success', 'message' => 'Message send successfully']);
            }
        } else {
            return response()->json(['type' => 'error', 'message' => 'Access only ajax request']);
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
