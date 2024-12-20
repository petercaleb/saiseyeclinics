<?php

namespace App\Http\Controllers\Technicians\Cases;

use App\Models\Technician;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\Users\Frames\FrameRequestMail;
use App\Http\Requests\Technicians\Cases\StoreCaseRequest;
use App\Models\WorkshopCaseRequest;

class CaseRequestsController extends Controller
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
        $data = $workshop->workshop_case_request()->latest()->get();
        return datatables()->of($data)
            ->addIndexColumn()
            ->addColumn('request_date', function ($row) {
                return date('F d, Y', strtotime($row->request_date));
            })
            ->addColumn('status', function ($row) {
                if ($row->status) {
                    return '<span class="badge badge-success">Requested</span>';
                } else {
                    return '<span class="badge badge-danger">Not Requested</span>';
                }
            })

            ->addColumn('transfer_status', function ($row) {
                if ($row->transfer_status) {
                    return '<span class="badge badge-success">Transferred</span>';
                } else {
                    return '<span class="badge badge-danger">Not Transferred</span>';
                }
            })
            ->addColumn('requested_by', function ($row) {
                return $row->technician->first_name . ' ' . $row->technician->last_name;
            })
            ->addColumn('workshop', function ($row) {
                return $row->workshop->name;
            })
            ->rawColumns(['request_date', 'requested_by', 'status', 'transfer_status', 'workshop'])
            ->make(true);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreCaseRequest $request)
    {
        //
        $data = $request->except("_token");

        $technician = Technician::findOrFail(auth()->guard('technician')->user()->id);

        $workshop = $technician->workshop;

        $organization = $workshop->organization;

        $hq_case_stock = $organization->hq_case_stock()->findOrFail($data['hq_case_stock_id']);

        $frame_case = $hq_case_stock->frame_case;

        $workshop->workshop_case_request()->create([
            'organization_id' => $organization->id,
            'technician_id' => $technician->id,
            'hq_case_stock_id' => $hq_case_stock->id,
            'case_id' => $frame_case->id,
            'case_code' => $frame_case->code,
            'request_date' => $data['request_date'],
            'quantity' => $data['quantity'],
            'status' => 1,
            'transfer_status' => 0,
            'remarks' => $data['remarks'],
        ]);

        $details = [
            'title' => 'Case Request',
            'body' => 'You have a new case request from ' . $workshop->name . '.' . ' Please check your dashboard.'
        ];

        Mail::to($organization->email)->send(new FrameRequestMail($details));
        

        return response()->json([
            'status' => true,
            'message' => 'Case request has been created successfully'
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(WorkshopCaseRequest $workshopCaseRequest)
    {
        //
        return response()->json([
            'status' => true,
            'data' => $workshopCaseRequest
        ]);
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
