<?php

namespace App\Http\Controllers\Backend\Admin;

use App\Http\Controllers\Controller;
use App\Models\Teacher;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;
use App\Models\Test;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\DataTables;
use View;
use DB;

class TestController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('backend.admin.test.index');
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        if ($request->ajax()) {

            $view = View::make('backend.admin.test.create')->render();
            return response()->json(['html' => $view]);

        } else {
            return response()->json(['status' => 'false', 'message' => "Access only ajax request"]);
        }
    }


    public function getAll(Request $request)
    {
        if ($request->ajax()) {
            //  $can_view = $can_edit = $can_delete = '';
            //  if (!auth()->user()->can('test-view')) {
            //     $can_view = "style='display:none;'";
            //  }
            //   if (!auth()->user()->can('test-edit')) {
            //      $can_edit = "style='display:none;'";
            //   }
            //   if (!auth()->user()->can('test-delete')) {
            //      $can_delete = "style='display:none;'";
            //   }

            $test = Test::orderby('created_at', 'desc')->get();
            return Datatables::of($test)
                // ->addColumn('project_name', function ($section) {
                //     return $project->client_id? $project->client->name.'-'.$project->name:'n/a';
                // })

                ->addColumn('action', function ($test) {
                    $html = '<div class="btn-group">';
                    $html .= '<a data-toggle="tooltip"   id="' . $test->id . '" class="btn btn-xs btn-success mr-1 view" title="View"><i class="fa fa-eye"></i> </a>';
                    $html .= '<a data-toggle="tooltip"   id="' . $test->id . '" class="btn btn-xs btn-info mr-1 edit" title="Edit"><i class="fa fa-edit"></i> </a>';
                    $html .= '<a data-toggle="tooltip"   id="' . $test->id . '" class="btn btn-xs btn-danger delete" title="Delete"><i class="fa fa-trash"></i> </a>';
                    $html .= '</div>';
                    return $html;
                })
                ->rawColumns(['action'])
                ->addIndexColumn()
                ->make(true);
        } else {
            return response()->json(['status' => 'false', 'message' => "Access only ajax request"]);
        }
    }


    public function store(Request $request)
    {

        // return "test";
        if ($request->ajax()) {

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

                    $test = new Test;
                    $test->name = $request->input('name');
                    $test->email = $request->input('email');
                    $test->phone = $request->input('phone');
                    $test->save(); //
                    DB::commit();
                    return response()->json(['type' => 'success', 'message' => "Successfully Updated"]);
                } catch (\Exception $e) {
                    DB::rollback();
                    return response()->json(['type' => 'error', 'message' => "Please Fill With Correct data"]);
                }
            }
        } else {
            return response()->json(['status' => 'false', 'message' => "Access only ajax request"]);
        }
    }


    /**
     * Display the specified resource.
     *
     * @param  Test $test
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Test $test)
    {
        if ($request->ajax()) {
            $view = View::make('backend.admin.test.view', compact('test'))->render();
            return response()->json(['html' => $view]);
        } else {
            return response()->json(['status' => 'false', 'message' => "Access only ajax request"]);
        }
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  Request $request
     * @param  Test $test
     * @return \Illuminate\Http\Response
     */

    public function edit(Request $request, Test $test)
    {

        if ($request->ajax()) {
            $view = View::make('backend.admin.test.edit', compact('test'))->render();
            return response()->json(['html' => $view]);
        } else {
            return response()->json(['status' => 'false', 'message' => "Access only ajax request"]);
        }
    }


    public function update(Request $request, Test $test)
    {
        if ($request->ajax()) {


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
                    $test = Test::findOrFail($test->id);
                    $test->name = $request->input('name');
                    $test->email = $request->input('email');
                    $test->phone = $request->input('phone');
                    $test->save();
                    DB::commit();
                    return response()->json(['type' => 'success', 'message' => "Successfully Updated"]);
                } catch (\Exception $e) {
                    DB::rollback();
                    return response()->json(['type' => 'error', 'message' => "Please Fill With Correct data"]);
                }
            }
        } else {
            return response()->json(['status' => 'false', 'message' => "Access only ajax request"]);
        }
    }


    /**
     * Remove the specified resource from storage.
     * @params Request $request
     * @params Test $test
     *
     * @return \Illuminate\Http\Response
     * @throws \Exception
     */
    public function destroy(Request $request, Test $test)
    {
        if ($request->ajax()) {
            if (1) {
                $test->delete();
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
                $view = View::make('backend.admin.test.smsSend', compact('teachers'))->render();
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
                        $this->httpRequest($teacher->phone);
                    }
                } else {
                    foreach (\request('teachers_numbers') as $phone) {
                        $this->httpRequest($phone);
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
    private function httpRequest($phone)
    {
        Http::post(config('services.sms.url'), [
            'api_key' => config('services.sms.api_key'),
            'type' => config('services.sms.type'),
            'contacts' => $phone,
            'senderid' => config('services.sms.senderid'),
            'msg' => \request('message')

        ]);
    }

}
