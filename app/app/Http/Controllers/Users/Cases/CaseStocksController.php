<?php

namespace App\Http\Controllers\Users\Cases;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\CaseStock;
use Illuminate\Support\Facades\Auth;

class CaseStocksController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');   
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //
        $user = User::findOrFail(Auth::user()->id);
        $clinic = $user->clinic;
        $organization = $clinic->organization;
        if($request->ajax())
        {
            $data = $clinic->case_stock()->latest()->get();
            return datatables()->of($data)
                ->addIndexColumn()
                ->addColumn('case_code', function($row){
                    return $row->hqStock->frame_case->code;
                })
                ->addColumn('color', function($row){
                    return $row->hqStock->frame_case->case_color->title;
                })
                ->addColumn('shape', function($row){
                    return $row->hqStock->frame_case->case_shape->title;
                })
                ->addColumn('size', function($row){
                    return $row->hqStock->frame_case->case_size->title;
                })
                ->rawColumns(['color', 'shape', 'case_code'])
                ->make(true);
        }
        $page_title = trans('users.page.inventory.sub_page.cases');
        return view('users.cases.index', [
            'clinic' => $clinic,
            'organization' => $organization,
            'page_title' => $page_title
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(CaseStock $caseStock)
    {
        //
        return response()->json([
            'status' => 'success',
            'data' => $caseStock
        ]);
    }
    
}
