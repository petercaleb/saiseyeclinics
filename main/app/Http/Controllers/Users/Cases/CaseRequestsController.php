<?php

namespace App\Http\Controllers\Users\Cases;

use App\Models\User;
use App\Models\CaseRequest;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use App\Mail\Users\Frames\FrameRequestMail;
use App\Http\Requests\Users\Cases\StoreCaseRequest;

class CaseRequestsController extends Controller
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
        $user = User::findOrFail(auth()->user()->id);
        $clinic = $user->clinic;
        if ($request->ajax()) {
            $data = $clinic->case_request()->latest()->get();
            return datatables()->of($data)
                ->addIndexColumn()
                ->addColumn('request_date', function ($row) {
                    return date('d-m-Y', strtotime($row->request_date));
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
                    return $row->user->first_name . ' ' . $row->user->last_name;
                })
                ->rawColumns(['status', 'transfer_status'])
                ->make(true);
        }
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

        $user = User::findOrFail(auth()->user()->id);

        $clinic = $user->clinic;

        $organization = $clinic->organization;

        $hq_case_stock = $organization->hq_case_stock()->findOrFail($data['hq_case_stock_id']);

        $frame_case = $hq_case_stock->frame_case;

        $clinic->case_request()->create([
            'organization_id' => $organization->id,
            'user_id' => auth()->user()->id,
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
            'body' => 'You have a new case request from ' . $clinic->clinic . '.' . ' Please check your dashboard.'
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
    public function show(CaseRequest $caseRequest)
    {
        //
        return response()->json([
            'status' => true,
            'data' => $caseRequest
        ]);
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
