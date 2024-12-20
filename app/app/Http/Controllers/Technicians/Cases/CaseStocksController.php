<?php

namespace App\Http\Controllers\Technicians\Cases;

use App\Http\Controllers\Controller;
use App\Models\Technician;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CaseStocksController extends Controller
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

        if ($request->ajax()) {
            $data = $workshop->workshop_case_stock()->latest()->get();
            return datatables()->of($data)
                ->addIndexColumn()
                ->addColumn('case_code', function ($row) {
                    return $row->hqStock->frame_case->code;
                })
                ->addColumn('color', function ($row) {
                    return $row->hqStock->frame_case->case_color->title;
                })
                ->addColumn('shape', function ($row) {
                    return $row->hqStock->frame_case->case_shape->title;
                })
                ->addColumn('size', function ($row) {
                    return $row->hqStock->frame_case->case_size->title;
                })
                ->rawColumns(['status'])
                ->make(true);
        }

        $page_title = trans('menus.technicians.sidebar.inventory.cases.title');
        $organization = $workshop->organization;
        return view('technicians.cases.index', [
            'page_title' => $page_title,
            'organization' => $organization,
            'workshop' => $workshop,
        ]);
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
