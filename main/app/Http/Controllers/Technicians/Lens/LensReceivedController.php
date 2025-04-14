<?php

namespace App\Http\Controllers\Technicians\Lens;

use App\Http\Controllers\Controller;
use App\Http\Requests\Technicians\Lens\StoreLensReceivedRequest;
use App\Models\LensReceive;
use App\Models\Technician;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LensReceivedController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:technician');
    }

    /**
     * 
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //
        $technician = Technician::findOrFail(Auth::guard('technician')->user()->id);
        $workshop = $technician->workshop;
        if ($request->ajax()) {
            $data = $workshop->lens_receive()->where('is_hq', 1)->latest()->get();
            return datatables()->of($data)
                ->addIndexColumn()
                ->addColumn('received_status', function($row){
                    if ($row->received_status) {
                        return '<span class="badge badge-success">Received</span>';
                    } else {
                        return '<span class="badge badge-warning">Pending</span>';
                    }
                })
                ->addColumn('received_by', function($row){
                    return $row->technician->first_name. ' ' . $row->technician->last_name;
                })
                ->addColumn('received_date', function ($row) {
                    return  date('d-m-Y', strtotime($row->received_date));
                })
                ->rawColumns(['received_date', 'received_status', 'received_by'])
                ->make(true);
        }
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function get_lens_received_from_workshops(Request $request)
    {
        $technician = Technician::findOrFail(Auth::guard('technician')->user()->id);
        $workshop = $technician->workshop;
        if ($request->ajax()) {
            $data = $workshop->lens_receive()->where('is_hq', 0)->latest()->get();
            return datatables()->of($data)
                ->addIndexColumn()
                ->addColumn('received_date', function ($row) {
                    return  date('d-m-Y', strtotime($row->received_date));
                })
                ->rawColumns(['received_date'])
                ->make(true);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreLensReceivedRequest $request)
    {
        //
        $data = $request->except(['_token']);

        $technician = Technician::findOrFail(Auth::guard('technician')->user()->id);

        $workshop = $technician->workshop;

        $organization = $workshop->organization;

        $hq_lens_transfer = $organization->hq_lens_transfer()->findOrFail($data['hq_lens_transfer_id']);

        $hq_lens = $hq_lens_transfer->hq_lens;

        $lenses = $workshop->lens()->where('hq_lens_id', $hq_lens->id)->first();

        if($lenses)
        {
            $opening = $lenses->opening;
            $received = $lenses->received + $hq_lens_transfer->quantity;
            $transfered = $lenses->transfered;
            $total = ($opening + $received) - $transfered;
            $sold = $lenses->sold;
            $closing = $total - $sold;

            $lenses->update([
                'opening' => $opening,
                'received' => $received,
                'transfered' => $transfered,
                'total' => $total,
                'sold' => $sold,
                'closing' => $closing,
            ]);

        }else
        {
            $opening = 0;
            $received = $hq_lens_transfer->quantity;
            $transfered = 0;
            $total = ($opening + $received) - $transfered;
            $sold = 0;
            $closing = $total - $sold;

            // create lense
            $lenses = $workshop->lens()->create([
                'organization_id' => $organization->id,
                'hq_lens_id' => $hq_lens->id,
                'eye' => $hq_lens->eye,
                'opening' => $opening,
                'received' => $received,
                'transfered' => $transfered,
                'total' => $total,
                'sold' => $sold,
                'closing' => $closing
            ]);
        }

        // receive lense
        $is_hq = $data['is_hq'];
        $workshop->lens_receive()->create([
            'organization_id' => $organization->id,
            'hq_lens_id' => $hq_lens->id,
            'technician_id' => $technician->id,
            'lens_code' => $hq_lens->code,
            'received_date' => $data['received_date'],
            'quantity' => $hq_lens_transfer->quantity,
            'is_hq' => $is_hq,
            'condition' => $data['condition'],
            'remarks' => $data['remarks'],
        ]);

        // Update hq_lens_transfer
        $hq_lens_transfer->update([
            'received_status' => 1,
        ]);

        $response['status'] = true;
        $response['message'] = 'Lens Received Successfully';
        return response()->json($response);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(LensReceive $lensReceive)
    {
        //
        return response()->json([
            'status' => true,
            'data' => $lensReceive
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(LensReceive $lensReceive)
    {
        //
    }
}
