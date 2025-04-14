<?php

namespace App\Http\Controllers\Admin\Frames;

use App\Http\Controllers\Controller;
use App\Models\Clinic;
use App\Models\FrameRequest;
use Illuminate\Http\Request;

class FrameRequestsController extends Controller
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
        if ($request->ajax()) {
            $data = $clinic->frame_request()->latest()->get();
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
                    return $row->user->first_name . ' ' . $row->user->last_name;
                })
                ->addColumn('clinic', function ($row) {
                    return $row->clinic->clinic;
                })
                ->rawColumns(['request_date', 'requested_by', 'status', 'transfer_status', 'clinic'])
                ->make(true);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
    public function destroy(FrameRequest $frameRequest)
    {
        //
    }
}
