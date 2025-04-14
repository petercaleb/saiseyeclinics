<?php

namespace App\Http\Controllers\Admin\HQ\Lens;

use Carbon\Carbon;
use App\Models\Admin;
use App\Models\HqLens;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Exports\Admin\HQ\Lenses\StocksExport;
use App\Http\Requests\Admin\HQ\Lenses\StoreLensRequest;
use App\Http\Requests\Admin\HQ\Lenses\UpdateLensRequest;

class HQLensesController extends Controller
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
    public function index(Request $request)
    {
        //
        $admin = Admin::findOrFail(Auth::guard('admin')->user()->id);
        $organization = $admin->organization;
        if ($request->ajax()) {
            $data = $organization->hq_lens()->latest()->get();
            return datatables()->of($data)
                ->addIndexColumn()
                ->addColumn('type', function ($row) {
                    $type = $row->lens_type->type;
                    return $type;
                })
                ->addColumn('material', function ($row) {
                    $material = $row->lens_material->title;
                    return $material;
                })
                ->addColumn('actions', function ($row) {
                    $btn = '<a href="javascript:void(0)"  data-id="' . $row->id . '" class="btn btn-tools btn-sm updateLensBtn">';
                    $btn = $btn . '<i class="fa fa-edit"></i></a>';
                    $btn = $btn . ' <a href="javascript:void(0)" data-id="' . $row->id . '" class="delete btn btn-tools btn-sm deleteLensBtn">';
                    $btn = $btn . '<i class="fa fa-trash"></i></a>';
                    return $btn;
                })
                ->rawColumns(['actions', 'type', 'material'])
                ->make(true);
        }

        $page_title = trans('admin.page.lenses.sub_page.lense_stock');
        $lenses = $organization->hq_lens()->latest()->get();
        return view('admin.HQ.lenses.index', [
            'page_title' => $page_title,
            'organization' => $organization,
            'lenses' => $lenses
        ]);
    }

    public function export()
    {
        return (new StocksExport())->download('lens-stocks-' . time() . '.xlsx', \Maatwebsite\Excel\Excel::XLSX);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreLensRequest $request)
    {
        //
        $data = $request->except("_token");

        $admin = Admin::findOrFail(Auth::guard('admin')->user()->id);

        $organization = $admin->organization;

        $opening = $data['opening'];

        $purchased = 0;

        $transfered = 0;

        $total = ($opening + $purchased) - $transfered;

        $code = Str::upper(Str::random(5));

        $organization->hq_lens()->create([
            'admin_id' => $admin->id,
            'power' => $data['power'],
            'code' => $code,
            'lens_type_id' => $data['lens_type_id'],
            'lens_material_id' => $data['lens_material_id'],
            'lens_index' => $data['lens_index'],
            'date_added' => Carbon::now()->format('Y-m-d'),
            'eye' => $data['eye'],
            'opening' => $opening,
            'purchased' => $purchased,
            'transfered' => $transfered,
            'total' => $total
        ]);

        $response['status'] = true;
        $response['message'] = "New Lens Has Been Added To Stocks";

        return response()->json($response);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(HqLens $hqLens)
    {
        //
        $response = [
            'status' => true,
            'data' => $hqLens
        ];

        return response()->json($response, 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateLensRequest $request, HqLens $hqLens)
    {
        //
        $data = $request->except("_token");

        $hqLens->update([
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

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(HqLens $hqLens)
    {
        //
        $hqLens->delete();
        $response['status'] = true;
        $response['message'] = "You have successfully deleted lens from stock";
        return response()->json($response);
    }
}
