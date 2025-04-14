<?php

namespace App\Http\Controllers\Admin\HQ\Cases;

use Exception;
use App\Models\Admin;
use App\Models\HqCaseStock;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Exports\Admin\HQ\Cases\StocksExport;
use App\Http\Requests\Admin\HQ\Cases\StoreCaseStockRequest;
use App\Http\Requests\Admin\HQ\Cases\UpdateCaseStockRequest;

class HqCaseStocksController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //
        $admin = Admin::findOrFail(Auth::guard('admin')->user()->id);
        $organization = $admin->organization;
        if ($request->ajax()) {
            $data = $organization->hq_case_stock()->latest()->get();
            return datatables()->of($data)
                ->addIndexColumn()
                ->addColumn('case_code', function($row){
                    return $row->frame_case->code;
                })
                ->addColumn('color', function($row){
                    return $row->frame_case->case_color->title;
                })
                ->addColumn('shape', function($row){
                    return $row->frame_case->case_shape->title;
                })
                ->addColumn('size', function($row){
                    return $row->frame_case->case_size->title;
                })
                ->addColumn('actions', function ($row) {
                    $btn = '<a href="javascript:void(0)"  data-id="' . $row->id . '" class="btn btn-tools btn-sm updateCaseStock">';
                    $btn = $btn . '<i class="fas fa-edit"></i></a>';
                    $btn = $btn . '<a href="javascript:void(0)"  data-id="' . $row->id . '" class="btn btn-tools btn-sm deleteCaseStock">';
                    $btn = $btn . '<i class="fas fa-trash-alt"></i></a>';
                    return $btn;
                })
                ->rawColumns(['actions', 'case_code', 'color', 'shape', 'size'])
                ->make(true);
        }
        $cases = $organization->hq_case_stock()->latest()->get();
        $page_title = trans('admin.page.cases.sub_page.case_stocks');
        return view('admin.HQ.cases.index', [
            'page_title' => $page_title,
            'organization' => $organization,
            'cases' => $cases
        ]);
    }

    public function export()
    {
        return (new StocksExport())->download('case-stocks-' . time() . '.xlsx', \Maatwebsite\Excel\Excel::XLSX);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreCaseStockRequest $request)
    {
        //
        $data = $request->except("_token");

        $admin = Admin::findOrFail(Auth::guard('admin')->user()->id);

        $organization = $admin->organization;

        $organization->hq_case_stock()->create([
            'admin_id' => $admin->id,
            'case_id' => $data['case_id'],
            'opening' => $data['opening'],
            'total' => $data['opening'],
            'supplier_price' => $data['supplier_price'],
            'price' => $data['price']
        ]);

        $response['status'] = true;
        $response['message'] = 'Case Stock Added Successfully';
        return response()->json($response, 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(HqCaseStock $hqCaseStock)
    {
        //
        return response()->json([
            'status' => true,
            'data' => $hqCaseStock
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateCaseStockRequest $request, HqCaseStock $hqCaseStock)
    {
        //
        $data = $request->except("_token");

        $admin = Admin::findOrFail(Auth::guard('admin')->user()->id);

        $organization = $admin->organization;

        $frame_case = $organization->frame_case()->findOrFail($data['case_id']);

        $opening = $data['opening'];

        $purchased = $hqCaseStock->purchased;

        $transfered = $hqCaseStock->transfered;

        $total = ($opening + $purchased) - $transfered;

        $hqCaseStock->update([
            'case_id' => $frame_case->id,
            'opening' => $opening,
            'purchased' => $purchased,
            'transfered' => $transfered,
            'total' => $total,
            'supplier_price' => $data['supplier_price'],
            'price' => $data['price']
        ]);

        $response['status'] = true;
        $response['message'] = 'Case Stock Updated Successfully';
        return response()->json($response, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(HqCaseStock $hqCaseStock)
    {
        //
        try {
            $hqCaseStock->delete();
            $response['status'] = true;
            $response['message'] = 'Case Stock Deleted Successfully';
            $code = 200;

        } catch (Exception $e) {
            $response['status'] = false;
            $response['message'] = 'Frame Stock could not be deleted';
            $code = 401;
        }

        return response()->json($response, $code);
    }
}
