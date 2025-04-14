<?php

namespace App\Http\Controllers\Admin\Cases;

use App\Http\Controllers\Controller;
use App\Models\Workshop;
use App\Models\WorkshopCaseRequest;
use Illuminate\Http\Request;

class WorkshopCaseRequestsController extends Controller
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
    public function index(Request $request, Workshop $workshop)
    {
        //
        if ($request->ajax()) {
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
