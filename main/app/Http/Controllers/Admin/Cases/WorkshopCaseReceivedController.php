<?php

namespace App\Http\Controllers\Admin\Cases;

use App\Models\Workshop;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\WorkshopCaseReceive;

class WorkshopCaseReceivedController extends Controller
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
    public function get_received_from_workshop(Request $request, Workshop $workshop)
    {
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
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(WorkshopCaseReceive $workshopCaseReceive)
    {
        //
        return response()->json([
            'status' => true,
            'data' => $workshopCaseReceive
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(WorkshopCaseReceive $workshopCaseReceive)
    {
        //
    }
}
