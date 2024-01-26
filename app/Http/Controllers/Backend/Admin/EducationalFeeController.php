<?php

namespace App\Http\Controllers\Backend\Admin;

use App\Http\Controllers\Controller;
use App\Models\EducationalFee;
use App\Models\IncomeHead;
use App\Models\StdClass;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Auth ;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use View;

class EducationalFeeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if (Auth::user()->hasRole('superadmin')) {
            if ($request->ajax()) {
                $educationalFees = EducationalFee::all();
    
                return DataTables::of($educationalFees) 
                   ->addIndexColumn()
                   ->addColumn('class_name', function($educationalFee) {
                       return  $educationalFee->stdClass->name;
                    })
                    ->addColumn('name', function($educationalFee)  {
                     return $educationalFee->incomeHead->name;
                    })
                    ->addColumn('amount', function($educationalFee) {
                     return  $educationalFee->amount;
                    })
                    ->addColumn('session', function($educationalFee) {
                     return  $educationalFee->stdClass->session->name;
                    })
                    ->addColumn('action', function($educationalFee) {
                    $html = '<div class="btn-group">';
                    $html .= '<a data-toggle="tooltip"   id="' . $educationalFee->id . '" class="btn btn-xs btn-warning margin-r-5 edit" title="Edit"><i class="fa fa-edit fa-fw"></i> </a>';
                    $html .= '<a data-toggle="tooltip"   id="' . $educationalFee->id . '" class="btn btn-xs btn-danger margin-r-5 delete" title="Delete"><i class="fa fa-trash fa-fw"></i> </a>';
                    $html .= '</div>';
                    return $html;
                   })
                   ->rawColumns(['action'])
                   ->make(true);
            } else {
                return view('backend.admin.finance.educational_fees.index');
            }
        } else {
            return '<div style="text-align:center; font-size:50px;">401</div>';
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
            $haspermision = auth()->user()->can('assign-fees-create');
    
            if ($haspermision) {
                $incomeHeads = IncomeHead::all();
                $stdClasses = StdClass::runningClasses();
            
                $view = View::make('backend.admin.finance.educational_fees.create', compact('incomeHeads', 'stdClasses'))->render();
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
            $haspermision = auth()->user()->can('assign-fees-store');

            if ($haspermision) {
                $rules = [
                    'income_head_id' => 'required',
                    'std_class_id' => 'required',
                    'amount' => 'required|numeric',
                ];
                
                $validator = Validator::make($request->all(), $rules);

                if ($validator->fails()) {
                    return response()->json([
                        'type' => 'error',
                        'errors' => $validator->getMessageBag()->toArray(),
                    ]);
                } else {
                    DB::beginTransaction();
                    try {
                        if($request->std_class_id == 'all') {
                            $stdClasses = StdClass::all();
                            foreach($stdClasses as $stdClass) {
                                EducationalFee::firstOrCreate(
                                    [
                                        'income_head_id' => $request->income_head_id,
                                        'std_class_id' => $stdClass->id,
                                    ],
                                    [
                                        'amount' => $request->amount
                                    ]
                                );
                            }
                        } else {
                            // dd('test');
                            EducationalFee::firstOrCreate(  
                                [
                                    'income_head_id' => $request->income_head_id,
                                    'std_class_id' => $request->std_class_id,
                                ],
                                [
                                    'amount' => $request->amount
                                ]
                            );
                        }

                        DB::commit();
                    } catch(\Exception $e) {
                        DB::rollBack();
                    }
                    return response()->json(['type' => 'success', 'message' => "Successfully Created"]);
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
     * @param  \App\Models\EducationalFee  $educationalFee
     * @return \Illuminate\Http\Response
     */
    public function show(EducationalFee $educationalFee)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\EducationalFee  $educationalFee
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, EducationalFee $educationalFee)
    {
        if ($request->ajax()) {
            $haspermision = auth()->user()->can('assign-fees-edit');
            if ($haspermision) {
                $incomeHeads = IncomeHead::all();

                $stdClasses = StdClass::where('session_id', $educationalFee->stdClass->session_id)->get();

                $view = View::make('backend.admin.finance.educational_fees.edit', compact('educationalFee', 'incomeHeads', 'stdClasses'))->render();
                return response()->json([
                    'html' => $view
                ]);
            }
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\EducationalFee  $educationalFee
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, EducationalFee $educationalFee)
    {
        if ($request->ajax()) {
            $haspermision = auth()->user()->can('assign-fees-store');

            if ($haspermision) {
                $rules = [
                    'income_head_id' => 'required',
                    'std_class_id' => 'required',
                    'amount' => 'required|numeric',
                ];
                
                $validator = Validator::make($request->all(), $rules);

                if ($validator->fails()) {
                    return response()->json([
                        'type' => 'error',
                        'errors' => $validator->getMessageBag()->toArray(),
                    ]);
                } else {

                    $educationalFee->update([
                        'income_head_id' => $request->income_head_id,
                        'std_class_id' => $request->std_class_id,
                        'amount' => $request->amount
                    ]);

                    return response()->json(['type' => 'success', 'message' => "Successfully updated!"]);
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
     * @param  \App\Models\EducationalFee  $educationalFee
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, EducationalFee $educationalFee)
    {
        if ($request->ajax()) {
            $educationalFee->delete();
            return response()->json(['type' => 'success', 'Message' => 'Successfully deleted!']);
        } else {
            return response()->json(['status' => 'false', 'message' => 'Access only ajax request.']);
        }
    }
}
