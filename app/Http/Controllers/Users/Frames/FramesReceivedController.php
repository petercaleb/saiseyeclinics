<?php

namespace App\Http\Controllers\Users\Frames;

use App\Models\User;
use App\Models\Clinic;
use Illuminate\Http\Request;
use App\Models\FrameReceived;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\Users\Frames\StoreFrameReceivedRequest;

class FramesReceivedController extends Controller
{

    public function __construct()
    {
        $this->middleware(['auth']);
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
        if ($request->ajax()) {
            $data = $clinic->frame_received()->where('is_hq', 1)->latest()->get();
            return datatables()->of($data)
                ->addIndexColumn()
                ->addColumn('frame_code', function ($row) {
                    return $row->frame_code;
                })
                ->addColumn('status', function ($row) {
                    if ($row->received_status) {
                        return '<span class="badge badge-success">Received</span>';
                    } else {
                        return '<span class="badge badge-warning">Pending</span>';
                    }
                })
                ->addColumn('received_by', function ($row) {
                    return $row->user->first_name . ' ' . $row->user->last_name;
                })
                ->rawColumns(['frame_code', 'status', 'received_by'])
                ->make(true);
        }
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getReceivedFromClinic(Request $request)
    {
        //
        $user = User::findOrFail(Auth::user()->id);
        $clinic = $user->clinic;
        if ($request->ajax()) {
            $data = $clinic->frame_received()->where('is_hq', 0)->latest()->get();
            return datatables()->of($data)
                ->addIndexColumn()
                ->addColumn('frame_code', function ($row) {
                    return $row->frame_code;
                })
                ->addColumn('from_clinic', function ($row) {
                    return $row->fromClinic->clinic;
                })
                ->addColumn('status', function ($row) {
                    if ($row->received_status) {
                        return '<span class="badge badge-success">Received</span>';
                    } else {
                        return '<span class="badge badge-warning">Pending</span>';
                    }
                })
                ->addColumn('received_by', function ($row) {
                    return $row->user->first_name . ' ' . $row->user->last_name;
                })
                ->rawColumns(['frame_code', 'from_clinic', 'status', 'received_by'])
                ->make(true);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreFrameReceivedRequest $request, Clinic $clinic)
    {
        //
        $data = $request->except(['_token']);

        $organization = $clinic->organization;

        $hq_frame_transfer = $organization->hq_frame_transfer()->findOrFail($data['hq_frame_transfer_id']);

        $hq_frame_stock = $hq_frame_transfer->hq_frame_stock;

        $frame_stock = $clinic->frame_stock()->where('hq_stock_id', $hq_frame_stock->id)->first();

        // check this stock does not exist in this clinic
        // update frame_stocks
        if ($frame_stock) {
            $opening = $frame_stock->opening;
            $received = $frame_stock->received + $hq_frame_transfer->quantity;
            $transfered = $frame_stock->transfered;
            $total = ($opening + $received) - $transfered;
            $sold = $frame_stock->sold;
            $closing = $total - $sold;
            $frame_stock->update([
                'opening' => $opening,
                'received' => $received,
                'transfered' => $transfered,
                'total' => $total,
                'sold' => $sold,
                'closing' => $closing,
            ]);
        } else {
            $opening = 0;
            $received = $hq_frame_transfer->quantity;
            $transfered = 0;
            $total = ($opening + $received) - $transfered;
            $sold = 0;
            $closing = $total - $sold;
            // create frame_stock
            $frame_stock = $clinic->frame_stock()->create([
                'organization_id' => $organization->id,
                'hq_stock_id' => $hq_frame_stock->id,
                'frame_id' => $hq_frame_stock->frame->id,
                'code' => $hq_frame_stock->frame->code,
                'opening' => $opening,
                'received' => $received,
                'transfered' => $transfered,
                'total' => $total,
                'sold' => $sold,
                'closing' => $closing,
                'price' => $hq_frame_stock->price,
            ]);
        }

        // Receive Frames 
        $is_hq = $data['is_hq'];
        $clinic->frame_received()->create([
            'organization_id' => $organization->id,
            'hq_frame_stock_id' => $hq_frame_stock->id,
            'user_id' => Auth::user()->id,
            'frame_id' => $hq_frame_stock->frame->id,
            'frame_code' => $hq_frame_stock->frame->code,
            'received_date' => $data['received_date'],
            'quantity' => $hq_frame_transfer->quantity,
            'received_status' => $data['received_status'],
            'is_hq' => $is_hq,
            'condition' => $data['condition'],
            'remarks' => $data['remarks'],
        ]);

        // Update hq_frame_transfer
        $hq_frame_transfer->update([
            'received_status' => 1,
        ]);

        $response['status'] = true;
        $response['message'] = 'Frame Received Successfully';
        return response()->json($response);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(FrameReceived $frameReceived)
    {
        //
        return response()->json([
            'status' => true,
            'data' => $frameReceived,
        ], 200);
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
