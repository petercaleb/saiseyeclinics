<?php

namespace App\Http\Controllers\Admin\Frames;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Clinic\Frames\StoreFrameStock;
use App\Http\Requests\Admin\Clinic\Frames\UpdateFrameStockRequest;
use App\Models\Clinic;
use App\Models\Frame;
use App\Models\FrameColor;
use App\Models\FrameShape;
use App\Models\FrameStock;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

use function GuzzleHttp\Promise\all;

class FramesStocksController extends Controller
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
    public function index(Request $request, Clinic $clinic)
    {
        //
        $organization = $clinic->organization;
        if ($request->ajax()) {
            $data = $clinic->frame_stock()->latest()->get();
            return datatables()->of($data)
                ->addIndexColumn()
                ->addColumn('gender', function ($row) {
                    if ($row->hq_stock) {
                        return $row->hq_stock->gender;
                    }
                })
                ->addColumn('color', function ($row) {
                    if ($row->hq_stock) {
                        return $row->hq_stock->frame_color->color;
                    }
                })
                ->addColumn('shape', function ($row) {
                    if ($row->hq_stock) {
                        return $row->hq_stock->frame_shape->shape;
                    }
                })
                ->addColumn('remarks', function ($row) {
                    return Str::limit($row->remarks, 20, '...');
                })
                ->addColumn('actions', function ($row) {
                    $btn = '<a href="javascript:void(0)" data-id="' . $row->id . '" class="btn btn-tools btn-sm updateFrameStock">';
                    $btn = $btn . '<i class="fa fa-edit"></i></a> ';
                    $btn = $btn . '<a href="javascript:void(0)" data-id="' . $row->id . '" class="btn btn-tools btn-sm deleteFrameStock">';
                    $btn = $btn . '<i class="fa fa-trash"></i></a>';
                    return $btn;
                })
                ->rawColumns(['actions', 'color', 'shape', 'remarks'])
                ->make(true);
        }
        $page_title = trans('menus.admins.sidebar.inventory.frames.title');
        return view('admin.clinic.frames.index', [
            'page_title' => $page_title,
            'clinic' => $clinic,
            'organization' => $organization,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreFrameStock $request, Clinic $clinic)
    {
        //
        $data = $request->except("_token");

        $organization = $clinic->organization;

        $hq_frame_stock = $organization->hq_frame_stock()->findOrFail($data['hq_stock_id']);

        // check this stock does not exist in this clinic
        $clinic_frame_stock = $clinic->frame_stock()->where('hq_stock_id', $hq_frame_stock->id)->first();
        if ($clinic_frame_stock) {
            $response['status'] = false;
            $response['message'] = 'Frame Stock Already Exists';
            return response()->json($response, 200);
        }

        $opening = $data['opening'];

        $received = 0;

        $transfered = 0;

        $total = ($opening + $received) - $transfered;

        $sold = 0;

        $closing = $total - $sold;

        $clinic->frame_stock()->create([
            'organization_id' => $organization->id,
            'hq_stock_id' => $hq_frame_stock->id,
            'frame_id' =>  $hq_frame_stock->frame->id,
            'code' => $hq_frame_stock->frame->code,
            'opening' => $opening,
            'received' => $received,
            'transfered' => $transfered,
            'total' => $total,
            'sold' => $sold,
            'closing' => $closing,
            'price' => $hq_frame_stock->price,
            'remarks' => $data['remarks'],
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
    public function show(FrameStock $frameStock)
    {
        //
        $response['status'] = true;
        $response['data'] = $frameStock;
        return response()->json($response, 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateFrameStockRequest $request, FrameStock $frameStock)
    {
        //
        $data = $request->except("_token");

        $clinic = $frameStock->clinic;

        $organization = $clinic->organization;

        $hq_frame_stock = $organization->hq_frame_stock()->findOrFail($data['hq_stock_id']);

        // check this stock does not exist in this clinic
        $clinic_frame_stock = $clinic->frame_stock()->where('hq_stock_id', $hq_frame_stock->id)->first();
        if ($clinic_frame_stock) {
            $response['status'] = false;
            $response['message'] = 'Frame Stock Already Exists';
            return response()->json($response, 200);
        }

        $opening = $data['opening'];

        $received = $frameStock->received;

        $transfered = $frameStock->transfered;

        $total = ($opening + $received) - $transfered;

        $sold = $frameStock->sold;

        $closing = $total - $sold;

        $frameStock->update([
            'organization_id' => $organization->id,
            'hq_stock_id' => $hq_frame_stock->id,
            'frame_id' =>  $hq_frame_stock->frame->id,
            'code' => $hq_frame_stock->frame->code,
            'opening' => $opening,
            'received' => $received,
            'transfered' => $transfered,
            'total' => $total,
            'sold' => $sold,
            'closing' => $closing,
            'price' => $hq_frame_stock->price,
            'remarks' => $data['remarks'],
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
    public function destroy(FrameStock $frameStock)
    {
        //
        $frameStock->delete();
        $response['status'] = true;
        $response['message'] = 'Frame Stock Deleted Successfully';
        return response()->json($response, 200);
    }
}
