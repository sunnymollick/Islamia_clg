<?php

namespace App\Http\Controllers\Backend\Admin;

use App\Http\Controllers\Controller;
use App\Models\ExpensesHead;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Validator;
use View;

class ExpensesHeadController extends Controller
{
    /**
     * Display a listing of the resource.
     *@param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $expensesHeads = ExpensesHead:: all();

            return Datatables::of($expensesHeads)
                ->addIndexColumn()
                ->addColumn('action', function($expensesHead){
                    $html = '<div class="btn-group">';
                    $html .= '<a data-toggle="tooltip"   id="' . $expensesHead->id . '" class="btn btn-xs btn-warning margin-r-5 edit" title="Edit"><i class="fa fa-edit fa-fw"></i> </a>';
                    $html .= '<a data-toggle="tooltip"   id="' . $expensesHead->id . '" class="btn btn-xs btn-danger margin-r-5 delete" title="Delete"><i class="fa fa-trash fa-fw"></i> </a>';
                    $html .= '</div>';
                    return $html;
                })
                ->rawColumns(['action'])
                ->make(true);
        } else {
            return view('backend.admin.finance.expenses_heads.index');
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
            $haspermision = auth()->user()->can('expenses-head-create');
    
            if ($haspermision) {
                $view = View::make('backend.admin.finance.expenses_heads.create')->render();
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
            $haspermision = auth()->user()->can('expenses-head-create');

            if ($haspermision) {
                $rules = [
                    'name' => 'required|unique:expenses_heads'
                ];
                
                $validator = Validator::make($request->all(), $rules);

                if ($validator->fails()) {
                    return response()->json([
                        'type' => 'error',
                        'errors' => $validator->getMessageBag()->toArray(),
                    ]);
                } else {
                    ExpensesHead::create([
                        'name' => $request->name
                    ]);

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
     * @param  \App\Models\ExpensesHead  $expensesHead
     * @return \Illuminate\Http\Response
     */
    public function show(ExpensesHead $expensesHead)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ExpensesHead  $expensesHead
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, ExpensesHead $expensesHead)
    {
        if ($request->ajax()) {
            $haspermision = auth()->user()->can('expenses-head-create');
            if ($haspermision) {
                $view = View::make('backend.admin.finance.expenses_heads.edit', compact('expensesHead'))->render();
                return response()->json(['html' => $view]);
            }
        } else {
            return response()->json(['status' => 'false', 'message' => "Access only ajax request"]);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ExpensesHead  $expensesHead
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ExpensesHead $expensesHead)
    {
        if ($request->ajax()) {
            $haspermision = auth()->user()->can('expenses-head-create');

            if ($haspermision) {
                $rules = [
                    'name' => 'required|unique:expenses_heads'
                ];
                
                $validator = Validator::make($request->all(), $rules);

                if ($validator->fails()) {
                    return response()->json([
                        'type' => 'error',
                        'errors' => $validator->getMessageBag()->toArray(),
                    ]);
                } else {
                    
                    $expensesHead->update([
                        'name' => $request->name
                    ]);

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
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ExpensesHead  $expensesHead
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, ExpensesHead $expensesHead)
    {
        if ($request->ajax()) {
            $haspermision = auth()->user()->can('income-head-create');
            if ($haspermision) {
                $expensesHead->delete();
                return response()->json(['type' => 'success', 'message' => 'Successfully Deleted']);
            } else {
                abort(403, 'Sorry, you are not authorized to access the page');
            }
        } else {
            return response()->json(['status' => 'false', 'message' => "Access only ajax request"]);
        }
    }
}
