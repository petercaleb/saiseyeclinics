<?php

namespace App\Http\Controllers\Users\Frames;

use App\Models\User;
use App\Models\FrameRequest;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\Users\Frames\FrameRequestMail;
use App\Http\Requests\Users\Frames\StoreFrameRequest;

class FrameRequestsController extends Controller
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
        $user  = User::findOrFail(Auth::user()->id);
        $clinic = $user->clinic;
        if ($request->ajax()) {
            $data = $clinic->frame_request()->latest()->get();
            return datatables()->of($data)
                ->addIndexColumn()
                ->addColumn('request_date', function($row){
                    return date('F d, Y', strtotime($row->request_date));
                })
                ->addColumn('status', function($row){
                    if($row->status){
                        return '<span class="badge badge-success">Requested</span>';
                    }else{
                        return '<span class="badge badge-danger">Not Requested</span>';
                    }
                })
                ->addColumn('transfer_status', function($row){
                    if($row->transfer_status){
                        return '<span class="badge badge-success">Transferred</span>';
                    }else{
                        return '<span class="badge badge-danger">Not Transferred</span>';
                    }
                })
                ->addColumn('requested_by', function ($row) {
                    return $row->user->first_name . ' ' . $row->user->last_name;
                })
                ->addColumn('actions', function ($row) {
                })
                ->rawColumns(['actions', 'status', 'transfer_status'])
                ->make(true);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreFrameRequest $request)
    {
        //

        $data = $request->except("_token");

        $user  = User::findOrFail(Auth::user()->id);

        $clinic = $user->clinic;

        $organization = $clinic->organization;

        $hq_frame_stock = $organization->hq_frame_stock()->findOrFail($data['hq_stock_id']);

        $frame = $hq_frame_stock->frame;

        $clinic->frame_request()->create([
            'organization_id' => $organization->id,
            'user_id' => $user->id,
            'hq_stock_id' => $hq_frame_stock->id, // 'hq_stock_id' is the id of the frame in the headquarter's stock
            'frame_id' => $frame->id,
            'request_date' => $data['request_date'],
            'frame_code' => $frame->code,
            'quantity' => $data['quantity'],
            'remarks' => $data['remarks'],
            'status' => 1,
            'transfer_status' => 0
        ]);

        $details = [
            'title' => 'Frame Request',
            'body' => 'You have a new frame request from ' . $clinic->clinic . '.' . ' Please check your dashboard.'
        ];

        Mail::to($organization->email)->send(new FrameRequestMail($details));

        return response()->json([
            'status' => true,
            'message' => 'Frame request has been sent successfully.'
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(FrameRequest $frameRequest)
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
