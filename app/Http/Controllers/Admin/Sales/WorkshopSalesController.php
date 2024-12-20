<?php

namespace App\Http\Controllers\Admin\Sales;

use App\Http\Controllers\Controller;
use App\Models\Workshop;
use Illuminate\Http\Request;

class WorkshopSalesController extends Controller
{
    //

    public function __construct()
    {
        $this->middleware('auth:admin');
    }


    public function index(Request $request, $id)
    {

        $workshop = Workshop::findOrFail($id);
        if ($request->ajax()) {
            $data = $workshop->workshop_sale->sortBy('created_at', SORT_DESC);
            return datatables()->of($data)
                ->addIndexColumn()
                ->addColumn('lens_power', function ($row) {
                    return $row->lens->power;
                })
                ->addColumn('lens_code', function ($row) {
                    return $row->lens->code;
                })
                ->addColumn('lens_type', function ($row) {
                    return $row->lens->lens_type->type;
                })
                ->addColumn('lens_material', function ($row) {
                    return $row->lens->lens_material->title;
                })
                ->addColumn('lens_index', function ($row) {
                    return $row->lens->lens_index;
                })
                ->addColumn('eye', function ($row) {
                    return $row->lens->eye;
                })
                ->rawColumns(['lens_power', 'lens_code', 'lens_type', 'lens_material', 'lens_index', 'eye'])
                ->make(true);
        }

        $page_title = "Workshop Sales";
        return view('admin.sales.workshops.index', [
            'page_title' => $page_title,
            'workshop' => $workshop
        ]);
    }
}
