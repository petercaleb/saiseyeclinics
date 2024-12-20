<?php

namespace App\Http\Controllers\Admin\Cases;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Clinic\Cases\CasesStockRequest;
use App\Models\Clinic;
use App\Models\ClinicFrameCaseStock;
use App\Models\FrameCase;
use Illuminate\Http\Request;

class ClinicCasesStockController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, $id)
    {
        //
        $clinic = Clinic::findOrFail($id);
        if ($request->ajax()) {
            $data = $clinic->clinic_frame_case_stock()->latest()->get();
            return datatables()->of($data)  
                ->addIndexColumn()
                ->addColumn('actions', function($row){
                    $btn = '<a href="javascript:void(0)" data-id="'. $row->id .'" class="btn btn-sm btn-outline-danger deleteCaseColorBtn">';
                    $btn = $btn . '<i class="fa fa-trash"></i>';
                    $btn = $btn . '</a>';
                    return $btn;
                })
                ->rawColumns(['actions'])
                ->make(true);
        }
        $page_title = "inventory";
        $sub_page = "cases";
        $cases = FrameCase::latest()->get();
        $num_stocks = ClinicFrameCaseStock::latest()->count();
        return view('admin.cases.clinic_stocks.index', [
            'page_title' => $page_title,
            'sub_page' =>  $sub_page,
            'clinic' => $clinic,
            'cases' => $cases,
            'num_stocks' => $num_stocks
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CasesStockRequest $request)
    {
        //
        $data = $request->except("_token");

        $clinic = Clinic::findOrFail($data['clinic_id']);

        $case = FrameCase::findOrFail($data['case_id']);

        $clinic->clinic_frame_case_stock()->create([
            'organization_id' => $clinic->organization_id,
            'frame_case_id' => $case->id,
            'code' => $case->code,
            'stock' => $data['stock'],
            'remarks' => $data['remarks']
        ]);

        $response = [
            'status' => true,
            'message' => 'You have added a new stock'
        ];

        return response()->json($response, 200);
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
