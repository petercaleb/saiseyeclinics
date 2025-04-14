<?php

namespace App\Http\Controllers\Admin\HQ\Frames;

use App\Exports\Admin\HQ\Frames\StocksExport;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\HQ\Frames\StoreFramesRequest;
use App\Http\Requests\Admin\HQ\Frames\UpdateFramesRequest;
use App\Models\Admin;
use App\Models\HqFrameStock;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;

class HQFrameStocksController extends Controller
{

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
            $data = $organization->hq_frame_stock()->latest()->get();
            return datatables()->of($data)
                ->addIndexColumn()
                ->addColumn('frame_code', function ($row) {
                    return $row->frame->code;
                })
                ->addColumn('color', function ($row) {
                    return $row->frame_color->color;
                })
                ->addColumn('shape', function ($row) {
                    return $row->frame_shape->shape;
                })
                ->addColumn('actions', function ($row) {
                    $btn = '<a href="javascript:void(0)"  data-id="' . $row->id . '" class="btn btn-tools btn-sm updateFrameStock">';
                    $btn = $btn . '<i class="fas fa-edit"></i></a>';
                    $btn = $btn . '<a href="javascript:void(0)"  data-id="' . $row->id . '" class="btn btn-tools btn-sm deleteFrameStock">';
                    $btn = $btn . '<i class="fas fa-trash-alt"></i></a>';
                    return $btn;
                })
                ->rawColumns(['frame_code', 'color', 'shape', 'actions'])
                ->make(true);
        }
        $frame_stocks = $organization->hq_frame_stock()->latest()->get();
        $page_title = trans('admin.page.frames.sub_page.frame_stocks');
        return view('admin.HQ.Frames.index', [
            'organization' => $organization,
            'page_title' => $page_title,
            'stocks' => $frame_stocks
        ]);
    }

    /**
     * Export a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function export()
    {
        return (new StocksExport())->download('frame-stocks-' . time() . '.xlsx', \Maatwebsite\Excel\Excel::XLSX);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreFramesRequest $request)
    {
        //
        $data = $request->except("_token");

        $admin = Admin::findOrFail(Auth::guard('admin')->user()->id);

        $organization = $admin->organization;

        $frame = $organization->frame()->findOrFail($data['frame_id']);

        $frame_color = $organization->frame_color()->findOrFail($data['color_id']);

        $frame_shape = $organization->frame_shape()->findOrFail($data['shape_id']);

        $organization->hq_frame_stock()->create([
            'admin_id' => $admin->id,
            'frame_id' => $frame->id,
            'code' => $frame->code,
            'gender' => $data['gender'],
            'color_id' => $frame_color->id,
            'shape_id' => $frame_shape->id,
            'opening' => $data['opening_stock'],
            'total' => $data['opening_stock'],
            'supplier_price' => $data['supplier_price'],
            'price' => $data['price']
        ]);

        $response['status'] = true;
        $response['message'] = 'Frame Stock Added Successfully';
        return response()->json($response, 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(HqFrameStock $hqFrameStock)
    {
        //
        $response  = [
            'status' => true,
            'data' => $hqFrameStock
        ];

        return response()->json($response, 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateFramesRequest $request, HqFrameStock $hqFrameStock)
    {
        //
        $data = $request->except("_token");

        $admin = Admin::findOrFail(Auth::guard('admin')->user()->id);

        $organization = $admin->organization;

        $frame = $organization->frame()->findOrFail($data['frame_id']);

        $frame_color = $organization->frame_color()->findOrFail($data['color_id']);

        $frame_shape = $organization->frame_shape()->findOrFail($data['shape_id']);

        $opening = $data['opening_stock'];

        $purchased = $hqFrameStock->purchased;

        $transfered = $hqFrameStock->transfered;

        $total = ($opening + $purchased) - $transfered;


        $hqFrameStock->update([
            'admin_id' => $admin->id,
            'frame_id' => $frame->id,
            'code' => $frame->code,
            'gender' => $data['gender'],
            'color_id' => $frame_color->id,
            'shape_id' => $frame_shape->id,
            'opening' => $opening,
            'purchased' => $purchased,
            'transfered' => $transfered,
            'total' => $total,
            'supplier_price' => $data['supplier_price'],
            'price' => $data['price']
        ]);

        $response['status'] = true;
        $response['message'] = 'Frame Stock Updated Successfully';
        return response()->json($response, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(HqFrameStock $hqFrameStock)
    {
        //
        try {
            $hqFrameStock->delete();
            $response['status'] = true;
            $response['message'] = 'Frame Stock Deleted Successfully';
            $code = 200;

        } catch (Exception $e) {
            $response['status'] = false;
            $response['message'] = 'Frame Stock could not be deleted';
            $code = 401;
        }

        return response()->json($response, $code);
    }
}
