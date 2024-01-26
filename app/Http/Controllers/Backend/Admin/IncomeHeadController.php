<?php

namespace App\Http\Controllers\Backend\Admin;

use App\Http\Controllers\Controller;
use App\Models\IncomeHead;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\DataTables;
use View;

class IncomeHeadController extends Controller
{
    
    /**
     * showing all income heads
     * 
     */

    public function index(Request $request)
    {
        
        if ($request->ajax()) {
            
            $incomeheads = IncomeHead::all();
            return Datatables::of($incomeheads)
                ->addIndexColumn()
                ->addColumn('action', function($incomeHead){
                    $html = '<div class="btn-group">';
                    $html .= '<a data-toggle="tooltip"   id="' . $incomeHead->id . '" class="btn btn-xs btn-warning margin-r-5 edit" title="Edit"><i class="fa fa-edit fa-fw"></i> </a>';
                    $html .= '<a data-toggle="tooltip"   id="' . $incomeHead->id . '" class="btn btn-xs btn-danger margin-r-5 delete" title="Delete"><i class="fa fa-trash fa-fw"></i> </a>';
                    $html .= '</div>';
                    return $html;
                })
                ->rawColumns(['action'])
                ->make(true);
        } else {
            return view('backend.admin.finance.income_heads.index');    
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
        $haspermision = auth()->user()->can('income-head-create');

        if ($haspermision) {
            $view = View::make('backend.admin.finance.income_heads.create')->render();
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
        if ($request->ajax()) {
            $haspermision = auth()->user()->can('income-head-create');

            if ($haspermision) {
                $rules = [
                    'name' => 'required|unique:income_heads'
                ];
                
                $validator = Validator::make($request->all(), $rules);

                if ($validator->fails()) {
                    return response()->json([
                        'type' => 'error',
                        'errors' => $validator->getMessageBag()->toArray(),
                    ]);
                } else {
                    IncomeHead::create([
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
    * Show the form for editing the specified resource.
    *
    * @param  \App\Models\IncomeHead $financeIncomeHead
    * @return \Illuminate\Http\Response
    */
   public function edit(Request $request,  IncomeHead $incomeHead)
   {
        if ($request->ajax()) {
            $haspermision = auth()->user()->can('income-head-create');
            if ($haspermision) {
                $view = View::make('backend.admin.finance.income_heads.edit', compact('incomeHead'))->render();
                return response()->json(['html' => $view]);
            }
        } else {
            return response()->json(['status' => 'false', 'message' => "Access only ajax request"]);
        }
   }

   /**
    * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\Models\IncomeHead $financeIncomeHead
     * @return \Illuminate\Http\Response
     */
   public function update(Request $request, IncomeHead $incomeHead) 
   {
        if ($request->ajax()) {
            $haspermision = auth()->user()->can('income-head-create');

            if ($haspermision) {
                $rules = [
                    'name' => 'required|unique:income_heads'
                ];
                
                $validator = Validator::make($request->all(), $rules);

                if ($validator->fails()) {
                    return response()->json([
                        'type' => 'error',
                        'errors' => $validator->getMessageBag()->toArray(),
                    ]);
                } else {
                    
                    $incomeHead->update([
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
     * @param  \App\Models\Page $page
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, IncomeHead $incomeHead)
    {
        if ($request->ajax()) {
            $haspermision = auth()->user()->can('income-head-create');
            if ($haspermision) {
                $incomeHead->delete();
                return response()->json(['type' => 'success', 'message' => 'Successfully Deleted']);
            } else {
                abort(403, 'Sorry, you are not authorized to access the page');
            }
        } else {
            return response()->json(['status' => 'false', 'message' => "Access only ajax request"]);
        }
    }
}
