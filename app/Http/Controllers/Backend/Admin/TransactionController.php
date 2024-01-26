<?php

namespace App\Http\Controllers\Backend\Admin;

use App\Models\Bill;
use App\Models\Transaction;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Student;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\DataTables;
use View;
use PDF;


class TransactionController extends Controller
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
            $view = View::make('backend.admin.finance.transactions.index', compact('student_id'))->render();
            return response()->json(['html' => $view]);
        } else {
            return response()->json(['type' => 'error', 'message' => 'Allowed ajax request only!']);
        }
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function allTransactions(Request $request)
    {
        if ($request->ajax()) {
            $student = Student::find($request->student_id);
            $bills = $student->bills()->orderBy('created_at', 'DESC')->get();
            return Datatables::of($bills)
            ->addIndexColumn()
            ->addColumn('bill_no', function($bill){
                if (!empty($bill)) {
                    return $bill->id ?? '';
                }
            })
            ->addColumn('paid', function($bill){
                if (!empty($bill)) {
                    return $bill->transaction->paid ?? '';
                }
            })
            ->addColumn('due', function($bill){
                if (!empty($bill->transaction)) {
                    return $bill->transaction->due ?? '';
                }
            })
            ->addColumn('created_at', function($bill){
                if (!empty($bill->transaction)) {
                    return $bill->transaction->created_at ?? '';
                }
            })
            ->addColumn('updated_at', function($bill){
                if (!empty($bill->transaction)) {
                    return $bill->transaction->updated_at ?? '';
                }
            })
            ->addColumn('action', function($bill){
                if (!empty($bill->transaction)) {
                    $html = '<div class="btn-group">';
                    $html .= '<a data-toggle="tooltip"   id="' . $bill->transaction->id . '" class="btn btn-xs btn-info margin-r-5 make-invoice" title="Bill Dtails"><i class="fas fa-receipt"></i></a>';
                    $html .= '</div>';
                    return $html;
                } else {
                    return '<p class="text-warning">No trasaction.</p>';
                }
            })
            ->rawColumns(['action'])
            ->make(true);
        } else {
            return response()->json(['type' => 'error', 'message' => 'Allowed ajax request only!']);
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
            $rules = [
                'total_payable' => 'required|numeric',
                'total_due' => 'required|numeric',
            ];

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                return response()->json(['type' => 'error', 'message' => $validator->getMessageBag()->toArray()]);
            }

            $bill = Bill::find($request->bill_id);
            $transaction = Transaction::firstOrCreate(
                [
                    'bill_id' => $bill->id
                ],
                [
                    'paid' => $request->total_payable,
                    'due' => $request->total_due,
                    'comment' => $request->comment,            
                ]
            );

            $transaction_id = $transaction->id;
            
            return response()->json(['type' => 'success', 'message' => 'Payment successfully done!', 'id' => $transaction_id, 'is_pdf' => $request->is_pdf]);
        } else {
            return response()->json(['type' => 'error', 'message' => 'Allowed ajax request only!']);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Transaction  $transaction
     * @return \Illuminate\Http\Response
     */
    public function show(Transaction $transaction)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Transaction  $transaction
     * @return \Illuminate\Http\Response
     */
    public function edit(Transaction $transaction)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Transaction  $transaction
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Transaction $transaction)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Transaction  $transaction
     * @return \Illuminate\Http\Response
     */
    public function destroy(Transaction $transaction)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Transaction  $transaction
     * @return \Illuminate\Http\Response
     */
    public function makeInvoice(Transaction $transaction)
    {
        $bill = $transaction->bill;
        $pdf = PDF::loadView('backend.admin.finance.transactions.invoice', compact('bill'));
        return $pdf->stream('invoice.pdf');
    }
}
