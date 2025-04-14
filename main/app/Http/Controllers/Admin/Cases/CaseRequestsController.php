<?php

namespace App\Http\Controllers\Admin\Cases;

use App\Models\Clinic;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CaseRequestsController extends Controller
{
    //
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
            $data = $clinic->case_request()->latest()->get();
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
}

