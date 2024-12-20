<?php

namespace App\Http\Controllers\Admin\Lens;

use App\Models\Workshop;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class LensRequestController extends Controller
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
            $data = $workshop->lens_request()->latest()->get();
            return datatables()->of($data)
                ->addIndexColumn()
                ->addColumn('requested_date', function ($row) {
                    return  date('d-m-Y', strtotime($row->request_date));
                })
                ->addColumn('power', function ($row) {
                    return $row->hq_lens->power;
                })
                ->addColumn('lens_index', function ($row) {
                    return $row->hq_lens->lens_index;
                })
                ->addColumn('eye', function ($row) {
                    return $row->hq_lens->eye;
                })
                ->addColumn('request_status', function ($row) {
                    if ($row->status) {
                        return '<span class="badge badge-success">Requested</span>';
                    } else {
                        return '<span class="badge badge-danger">Not Requested</span>';
                    }
                })
                ->addColumn('transfer_status', function ($row) {
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

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
