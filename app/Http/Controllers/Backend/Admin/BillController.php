<?php

namespace App\Http\Controllers\Backend\Admin;

use App\Http\Controllers\Controller;
use App\Models\Bill;
use App\Models\BillDetail;
use App\Models\EducationalFee;
use App\Models\StdClass;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\DataTables;
use DB;
use View;

class BillController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $student_id = $request->student_id;
            $std_class_id = $request->std_class_id;
            $view = View::make('backend.admin.finance.bills.index', compact('student_id', 'std_class_id'))->render();

            return response()->json(['html' => $view]);
        }
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function allBills(Request $request)
    {
        if ($request->ajax()) {
            $student_id = $request->student_id;
            $student = Student::find($student_id);
            $bills = $student->bills()->orderBy('created_at', 'DESC')->get();

            return Datatables::of($bills)
            ->addIndexColumn()
            ->addColumn('bill_no', function($bill){
                return $bill->id;
            })
            ->addColumn('action', function($bill){
                $html = '<div class="btn-group">';
                $html .= '<a data-toggle="tooltip"   id="' . $bill->id . '" class="btn btn-xs btn-info margin-r-5 billDetails" title="Bill Dtails"><i class="fas fa-receipt"></i></a>';
                $html .= '<a data-toggle="tooltip"   id="' . $bill->id . '" class="btn btn-xs btn-warning margin-r-5 edit" title="Edit Details"><i class="fa fa-edit fa-fw"></i></a>';
                $html .= '<a data-toggle="tooltip"   id="' . $bill->id . '" class="btn btn-xs btn-danger margin-r-5 delete" title="Delete"><i class="fa fa-trash fa-fw"></i> </a>';
                $html .= '</div>';
                return $html;
            })
            ->rawColumns(['action'])
            ->make(true);
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
            $student_id = $request->student_id;
            $std_class_id = $request->std_class_id;
            $educationalFees = EducationalFee::where('std_class_id', $std_class_id)->get();
            $view = View::make('backend.admin.finance.bills.create', compact('educationalFees', 'std_class_id', 'student_id'))->render();

            return response()->json(['html' => $view]);

        } else {
            return response()->json(['status' => false, 'message' => 'Ajax request only!']);
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
        try {
            DB::beginTransaction(); 

            $bill = Bill::create([
                'student_id' => $request->student_id
            ]);

            $income_heads = explode(',', $request->income_head_ids);
            $key = 'income_head_';
            foreach($income_heads as $income_head) {
                if($income_head == $request->$key . $income_head) {
    
                    $rules = [
                        'amount_' . $income_head => 'required|numeric',
                        'discount_' . $income_head => 'nullable|numeric'
                    ];

                    $validator = Validator::make($request->all(), $rules);
    
                    if ($validator->fails()) {
                        return response()->json([
                            'type' => 'error',
                            'errors' => $validator->getMessageBag()->toArray()
                        ]);
                    } else {
                        
                        $amount =  'amount_' . $income_head;
                        $discount =  'discount_' . $income_head;
                        $payable = $request->$amount - $request->$discount;
                        
                        BillDetail::create([
                            'bill_id' => $bill->id,
                            'income_head_id' => $income_head,
                            'payable' => $payable,
                            'discount' => $request->$discount
                        ]);
    
                    }                
                }
            }
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['type' => 'fail','message' =>  'Something went wrong']);
        }
    
        return response()->json(['type'=> 'success', 'message' => 'Successfully saved!']);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Bill  $bill
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Bill $bill)
    {
        if ($request->ajax()) {
            $previousBills = Bill::where('student_id', $bill->student_id)->orderBy('created_at', 'DESC')->get();
            $previousBill = isset($previousBills[1]) ? $previousBills[1] : null;

            $view = View::make('backend.admin.finance.bills.view', compact('bill', 'previousBill'))->render();
            return response()->json(['type' => 'success', 'html' => $view]);
        } else {
            return response()->json(['type' => 'error', 'message' => 'Allowed ajax request only!']);
        }
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Bill  $bill
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, Bill $bill)
    {  
        if ($request->ajax()) {

        $student_id = $request->student_id;
        $std_class_id = $request->std_class_id;
        $educationalFees = EducationalFee::where('std_class_id', $std_class_id)->get();

        $selected_items_id = [];
        $selected_items = [];
        foreach($bill->billDetails as $billDetail) {
            $selected_items_id[] = $billDetail->income_head_id;
            $selected_items[] = ['id' => $billDetail->incomeHead->id, 'name' => $billDetail->incomeHead->name, 'amount' => $billDetail->payable, 'discount' => $billDetail->discount];
        }

        $view = View::make('backend.admin.finance.bills.edit', compact('educationalFees', 'std_class_id', 'student_id', 'bill', 'selected_items', 'selected_items_id'))->render();

        return response()->json(['html' => $view]);

        } else {
            return response()->json(['status' => false, 'message' => 'Ajax request only!']);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Bill  $bill
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Bill $bill)
    {
        try {
            DB::beginTransaction(); 
            $income_heads = explode(',', $request->income_head_ids);
            $key = 'income_head_';
            foreach($income_heads as $income_head) {
                if($income_head == $request->$key . $income_head) {
    
                    $rules = [
                        'amount_' . $income_head => 'required|numeric',
                        'discount_' . $income_head => 'nullable|numeric'
                    ];

                    $validator = Validator::make($request->all(), $rules);
    
                    if ($validator->fails()) {
                        return response()->json([
                            'type' => 'error',
                            'errors' => $validator->getMessageBag()->toArray()
                        ]);
                    } else {

                        $amount =  'amount_' . $income_head;
                        $discount =  'discount_' . $income_head;
                        $payable = $request->$amount - $request->$discount;
                        
                        $bill->billDetails()->updateOrCreate(
                            [
                            'income_head_id' => $income_head
                            ],

                            ['payable' => $payable,
                            'discount' => $request->$discount
                            ]
                        );
    
                    }                
                }
            }
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['type' => 'fail','message' =>  'Something went wrong']);
        }
    
        return response()->json(['type'=> 'success', 'message' => 'Successfully updated!']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Bill  $bill
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Bill $bill)
    {   
        if ($request->ajax())
        {
            $bill->delete();
            return response()->json(['type' => 'success', 'message' => 'Successfully bill deleted!']);
        } else {
            return response()->json(['type' => 'error', 'message' => 'Allowed ajax request only!']);
        }
    } 


    /**
     * Remove the specified resource from storage.
     *
     * @param   \Illuminate\Http\Request  $request

     * @return \Illuminate\Http\Response
     */
    public function bilDetailsDestroy(Request $request)
    {
        if ($request->ajax()) {
            $billDetail = BillDetail::where('bill_id', $request->bill_id)->where('income_head_id', $request->income_head_id)->first();
            if (!empty($billDetail)) {
                $billDetail->delete();
                return response()->json(['type' => 'success', 'message' => 'Deleted successfully']);
            } else {
                return response()->json(['type' => 'danger', 'message' => 'Data not inserted yet!']);
            }
        } else {
            return response()->json(['type' => 'error', 'message' => 'Allowed ajax request only!']);
        }
    }


    /**
     * Update the specified resource(is_paid slug in bill_details table)  in storage
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */

    public function updateBillDetails(Request $request, BillDetail $billDetail)
    {
        if ($request->ajax()) {
            $rules = [
                'is_paid' => 'required|boolean',
                'total_payable' => 'required|numeric',
                'total_due' => 'required|numeric'
            ];
            $validator = validator::make($request->all(), $rules);

            if ($validator->fails()) {
                return response()->json([
                    'type' => 'error',
                    'message' => $validator->getMessageBag()->toArray()
                ]);
            }

            $billDetail->update(['is_paid' => $request->is_paid]);

            if ($request->is_paid == 1) {
                $total_payable = $request->total_payable + $billDetail->payable;
                $total_due = $request->total_due - $billDetail->payable;
            }else if($request->is_paid == 0) {
                $total_payable = $request->total_payable - $billDetail->payable;
                $total_due = $request->total_due + $billDetail->payable;
            }

            $amount = ['total_payable' => $total_payable, 'total_due' => $total_due];

            return response()->json([
                'type' => 'success', 
                'amount' => $amount,
                'message' => 'Successfully updated!'
            ]);
        }
    }


    public function massBillCreate()
    {
       
    }
}
