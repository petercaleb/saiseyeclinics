<?php

namespace App\Http\Controllers\Technicians\Lens;

use App\Http\Controllers\Controller;
use App\Models\Lens;
use App\Models\Technician;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class LensController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth:technician');
    }

    public function index(Request $request)
    {
        # code...
        $technician = Technician::findOrFail(Auth::guard('technician')->user()->id);
        $workshop = $technician->workshop;
        $organization = $workshop->organization;
        if ($request->ajax()) {
            $data = $workshop->lens->sortBy('created_at', SORT_DESC);
            return datatables()->of($data)
                ->addIndexColumn()
                ->addColumn('lens_code', function($row){
                    return $row->hq_lens->code;
                })
                ->addColumn('power', function($row){
                    return $row->hq_lens->power;
                })
                ->addColumn('type', function ($row) {
                    $type = $row->hq_lens->lens_type->type;
                    return $type;
                })
                ->addColumn('material', function ($row) {
                    $material = $row->hq_lens->lens_material->title;
                    return $material;
                })
                ->addColumn('lens_index', function($row){
                    return $row->hq_lens->lens_index;
                })
                ->rawColumns(['type', 'material', 'lens_code', 'power', 'lens_index'])
                ->make(true);
        }
        $page_title = trans('pages.technicians.inventory.title');
        return view('technicians.lens.index', [
            'page_title' => $page_title,
            'workshop' => $workshop,
            'organization' => $organization
        ]);
    }

    public function show($id)
    {
        # code...
        $lens = Lens::findOrFail($id);
        $response['status'] = true;
        $response['data'] = $lens;
        return response()->json($response);
    }

    public function update(Request $request, $id)
    {
        # code...
        $data = $request->except("_token");

        $validator = Validator::make($data, [
            'power' => 'required',
            'lens_type_id' => 'required|integer|exists:lens_types,id',
            'lens_material_id' => 'required|integer|exists:lens_materials,id',
            'lens_index' => 'required',
            'eye' => 'required|string'
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors();
            $response['status'] = false;
            $response['errors'] = $errors;
            return response()->json($response, 401);
        }

        $lens = Lens::findOrFail($id);

        $lens->update([
            'power' => $data['power'],
            'lens_type_id' => $data['lens_type_id'],
            'lens_material_id' => $data['lens_material_id'],
            'lens_index' => $data['lens_index'],
            'eye' => $data['eye'],
        ]);

        $response['status'] = true;
        $response['message'] = "You have successfully updated lens details";

        return response()->json($response);
    }
}
