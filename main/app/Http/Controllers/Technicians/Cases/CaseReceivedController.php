<?php

namespace App\Http\Controllers\Technicians\Cases;

use App\Models\Technician;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Technicians\Cases\StoreCaseReceivedRequest;
use Illuminate\Support\Facades\Auth;

class CaseReceivedController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:technician');
    }

    /**
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
            $data = $workshop->workshop_case_receive()->where('is_hq', 1)->latest()->get();
            return datatables()->of($data)
                ->addIndexColumn()
                ->addColumn('status', function ($row) {
                    if ($row->received_status) {
                        return '<span class="badge badge-success">Received</span>';
                    } else {
                        return '<span class="badge badge-warning">Pending</span>';
                    }
                })
                ->addColumn('received_by', function ($row) {
                    return $row->technician->first_name . ' ' . $row->technician->last_name;
                })
                ->rawColumns(['received_by', 'status'])
                ->make(true);
        }
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function get_received_from_workshop(Request $request)
    {
        $technician = Technician::findOrFail(Auth::guard('technician')->user()->id);
        $workshop = $technician->workshop;
        if ($request->ajax()) {
            $data = $workshop->workshop_case_receive()->where('is_hq', 0)->latest()->get();
            return datatables()->of($data)
                ->addIndexColumn()
                ->addColumn('from_workshop', function ($row) {
                })
                ->addColumn('status', function ($row) {
                    if ($row->received_status) {
                        return '<span class="badge badge-success">Received</span>';
                    } else {
                        return '<span class="badge badge-warning">Pending</span>';
                    }
                })
                ->addColumn('received_by', function ($row) {
                    return $row->technician->first_name . ' ' . $row->technician->last_name;
                })
                ->rawColumns(['received_by', 'status'])
                ->make(true);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreCaseReceivedRequest $request)
    {
        //
        $data = $request->except(['_token']);

        $technician = Technician::findOrFail(auth()->guard('technician')->user()->id);

        $workshop = $technician->workshop;

        $organization = $workshop->organization;

        $hq_case_transfer = $organization->hq_case_transfer()->findOrFail($data['hq_case_transfer_id']);

        $hq_case_stock = $hq_case_transfer->hq_stock;

        $case_stock = $workshop->workshop_case_stock()->where('case_id', $hq_case_stock->case_id)->first();

        // check this stock does not exist in this clinic
        // update case_stocks
        if ($case_stock) {
            $opening = $case_stock->opening;
            $received = $case_stock->received + $hq_case_transfer->quantity;
            $transfered = $case_stock->transfered;
            $total = ($opening + $received) - $transfered;
            $sold = $case_stock->sold;
            $closing = $total - $sold;
            $case_stock->update([
                'opening' => $opening,
                'received' => $received,
                'transfered' => $transfered,
                'total' => $total,
                'sold' => $sold,
                'closing' => $closing,
            ]);
        } else {
            $opening = 0;
            $received = $hq_case_transfer->quantity;
            $transfered = 0;
            $total = ($opening + $received) - $transfered;
            $sold = 0;
            $closing = $total - $sold;
            // create case_stock
            $case_stock = $workshop->workshop_case_stock()->create([
                'organization_id' => $organization->id,
                'hq_stock_id' => $hq_case_stock->id,
                'case_id' => $hq_case_stock->frame_case->id,
                'code' => $hq_case_stock->frame_case->code,
                'opening' => $opening,
                'received' => $received,
                'transfered' => $transfered,
                'total' => $total,
                'sold' => $sold,
                'closing' => $closing,
                'price' => $hq_case_stock->price,
            ]);
        }

        // Receive Cases
        $is_hq = $data['is_hq'];
        $workshop->workshop_case_receive()->create([
            'organization_id' => $organization->id,
            'hq_case_stock_id' => $hq_case_stock->id,
            'technician_id' => Auth::guard('technician')->user()->id,
            'case_id' => $hq_case_stock->frame_case->id,
            'case_code' => $hq_case_stock->frame_case->code,
            'receive_date' => $data['receive_date'],
            'quantity' => $hq_case_transfer->quantity,
            'received_status' => $data['received_status'],
            'is_hq' => $is_hq,
            'condition' => $data['condition'],
            'remarks' => $data['remarks'],
        ]);

        // Update hq_frame_transfer
        $hq_case_transfer->update([
            'received_status' => 1,
        ]);

        $response['status'] = true;
        $response['message'] = 'Case Received Successfully';
        return response()->json($response);
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
