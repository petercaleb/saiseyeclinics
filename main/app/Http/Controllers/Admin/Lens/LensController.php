<?php

namespace App\Http\Controllers\Admin\Lens;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Lens\StoreLensStockRequest;
use App\Http\Requests\Admin\Workshop\Lens\UpdateLensRequest;
use App\Models\HqLens;
use App\Models\Lens;
use App\Models\Workshop;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class LensController extends Controller
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
        $organization = $workshop->organization;
        if ($request->ajax()) {
            $data = $workshop->lens->sortBy('created_at', SORT_DESC);
            return datatables()->of($data)
                ->addIndexColumn()
                ->addColumn('code', function ($row) {
                    if ($row->hq_lens) {
                        return $row->hq_lens->code;
                    }
                })
                ->addColumn('power', function ($row) {
                    if ($row->hq_lens) {
                        return $row->hq_lens->power;
                    }
                })
                ->addColumn('type', function ($row) {
                    if ($row->hq_lens) {
                        return $row->hq_lens->lens_type->type;
                    }
                })
                ->addColumn('material', function ($row) {
                    if ($row->hq_lens) {
                        return $row->hq_lens->lens_material->title;
                    }
                })
                ->addColumn('lens_index', function ($row) {
                    if ($row->hq_lens) {
                        return $row->hq_lens->lens_index;
                    }
                })
                ->addColumn('action', function ($row) {
                    $btn = '<a href="javascript:void(0)" data-toggle="tooltip"  data-id="' . $row->id . '" data-original-title="Update" class="update btn btn-tools btn-sm updateLensBtn"><i class="fa fa-edit"></i></a>';
                    $btn = $btn .= ' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="' . $row->id . '" data-original-title="Delete" class="delete btn btn-tools btn-sm deleteLensBtn"><i class="fa fa-trash"></i></a>';
                    return $btn;
                })
                ->rawColumns(['action', 'type', 'material', 'code'])
                ->make(true);
        }

        $page_title = "Lenses";
        return view('admin.lens.index', [
            'workshop' => $workshop,
            'page_title' => $page_title,
            'organization' => $organization
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreLensStockRequest $request, Workshop $workshop)
    {
        //
        $data = $request->except("_token");

        $organization = $workshop->organization;

        $hq_lens = $organization->hq_lens()->findOrFail($data['hq_lens_id']);

        $opening = $data['opening'];

        $received = 0;

        $transfered = 0;

        $total = ($opening + $received) - $transfered;

        $sold = 0;

        $closing = $total - $sold;

        $workshop->lens()->create([
            'organization_id' => $workshop->organization->id,
            'hq_lens_id' => $hq_lens->id,
            'power' => $hq_lens->power,
            'eye' => $hq_lens->eye,
            'opening' => $opening,
            'received' => $received,
            'transfered' => $transfered,
            'total' => $total,
            'sold' => $sold,
            'closing' => $closing,
        ]);

        $response['status'] = true;
        $response['message'] = "New Lens Has Been Added To Stocks";

        return response()->json($response);
    }


    /**
     * Import a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function import(Request $request)
    {
        $data = $request->except('_token');

        $validator = Validator::make($data, []);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Lens $lens)
    {
        //
        $response = [
            'status' => true,
            'data' => $lens
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
    public function update(UpdateLensRequest $request, Lens $lens)
    {
        //
        $data = $request->except("_token");

        $hq_lens = HqLens::findOrFail($data['hq_lens_id']);

        $opening = $data['opening'];

        $received = $lens->received;

        $transfered = $lens->transfered;

        $total = ($opening + $received) - $transfered;

        $sold = $lens->sold;

        $closing = $total - $sold;

        $lens->update([
            'hq_lens_id' => $hq_lens->id,
            'power' => $hq_lens->power,
            'eye' => $hq_lens->eye,
            'opening' => $opening,
            'received' => $received,
            'transfered' => $transfered,
            'total' => $total,
            'sold' => $sold,
            'closing' => $closing,
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
    public function destroy(Lens $lens)
    {
        //
        $lens->delete();
        $response['status'] = true;
        $response['message'] = "You have successfully deleted lens from stock";
        return response()->json($response);
    }
}
