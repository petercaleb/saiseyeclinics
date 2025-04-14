<?php

namespace App\Http\Controllers\Admin\Cases;

use App\Http\Controllers\Controller;
use App\Models\CaseReceive;
use App\Models\Clinic;
use Illuminate\Http\Request;

class CaseReceivedController extends Controller
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
            $data = $clinic->case_receive()->where('is_hq', 1)->latest()->get();
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
                    return $row->user->first_name . ' ' . $row->user->last_name;
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
    public function get_received_from_clinic(Request $request, Clinic $clinic)
    {
        if ($request->ajax()) {
            $data = $clinic->case_receive()->where('is_hq', 0)->latest()->get();
            return datatables()->of($data)
                ->addIndexColumn()
                ->addColumn('from_clinic', function($row){

                })
                ->addColumn('status', function ($row) {
                    if ($row->received_status) {
                        return '<span class="badge badge-success">Received</span>';
                    } else {
                        return '<span class="badge badge-warning">Pending</span>';
                    }
                })
                ->addColumn('received_by', function ($row) {
                    return $row->user->first_name . ' ' . $row->user->last_name;
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
    public function show(CaseReceive $caseReceive)
    {
        //
        return response()->json([
            'status' => true,
            'data' => $caseReceive
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
