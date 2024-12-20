<?php

namespace App\Http\Controllers\Technicians\Lens;

use Carbon\Carbon;
use App\Models\Workshop;
use App\Models\Technician;
use App\Models\RequestLens;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\Technicians\RequestLensMail;
use App\Http\Requests\Technicians\Lens\StoreLensRequest;

class LensRequestController extends Controller
{
    //
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
        $technician = Technician::findOrFail(Auth::guard('technician')->user()->id);
        $workshop = $technician->workshop;
        if ($request->ajax()) {
            $data = $workshop->lens_request()->latest()->get();
            return datatables()->of($data)
                ->addIndexColumn()
                ->addColumn('requested_date', function($row){
                    return  date('d-m-Y', strtotime($row->request_date));
                })
                ->addColumn('power', function($row){
                    return $row->hq_lens->power;
                })
                ->addColumn('lens_index', function($row){
                    return $row->hq_lens->lens_index;
                })
                ->addColumn('eye', function($row){
                    return $row->hq_lens->eye;
                })
                ->addColumn('request_status', function($row){
                    if ($row->status) {
                        return '<span class="badge badge-success">Requested</span>';
                    } else {
                        return '<span class="badge badge-danger">Not Requested</span>';
                    }
                })
                ->addColumn('transfer_status', function($row){
                    if ($row->transfer_status) {
                        return '<span class="badge badge-success">Transfered</span>';
                    } else {
                        return '<span class="badge badge-danger">Not Transfered</span>';
                    }
                })
                ->addColumn('requested_by', function ($row) {
                    return $row->technician->first_name . ' ' . $row->technician->last_name;
                })
                ->rawColumns(['requested_by', 'request_status', 'transfer_status', 'power', 'requested_date', 'lens_index', 'eye'])
                ->make(true);
        }
    }

    /***
     * 
     * Send Lens Request
     * 
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreLensRequest $request)
    {
        $data = $request->except("_token");

        $technician = Technician::findOrFail(Auth::guard('technician')->user()->id);
        
        $workshop = $technician->workshop;

        $organization = $workshop->organization;

        $hq_lens = $organization->hq_lens()->findOrFail($data['hq_lens_id']);

        $workshop->lens_request()->create([
            'organization_id' => $organization->id,
            'technician_id' => $technician->id,
            'hq_lens_id' => $hq_lens->id,
            'lens_code' => $hq_lens->code,
            'request_date' => $data['request_date'],
            'quantity' => $data['quantity'],
            'status' => 1,
            'transfer_status' => 0,
            'remarks' => $data['remarks']
        ]);

        $details = [
            'title' => 'Lens Request',
            'body' => 'You have a new case request from ' . $workshop->name . '.' . ' Please check your dashboard.',
            'workshop' => $workshop->name
        ];

        Mail::to($workshop->email)->send(new RequestLensMail($details));

        $response = [
            'status' => true,
            'message' => 'You have successfully send request'
        ];

        return response()->json($response, 200);
    }
}
