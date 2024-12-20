<?php

namespace App\Http\Controllers\Admin\Cases;

use App\Models\CaseSize;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Settings\Cases\SizesRequest;
use App\Http\Requests\Admin\Settings\Cases\UpdateSizesRequest;

class CaseSizesController extends Controller
{

    function __construct()
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
        if ($request->ajax()) {
            $data = CaseSize::latest()->get();
            return datatables()->of($data)
                ->addIndexColumn()
                ->addColumn('actions', function ($row) {
                    $btn = '<a href="javascript:void(0)" data-id="'. $row->id .'" class="btn btn-sm btn-outline-primary updateCaseSizeBtn">';
                    $btn = $btn . '<i class="fa fa-edit"></i>';
                    $btn = $btn . '</a>';
                    $btn = $btn . '<a href="javascript:void(0)" data-id="'. $row->id .'" class="btn btn-sm btn-outline-danger deleteCaseSizeBtn">';
                    $btn = $btn . '<i class="fa fa-trash"></i>';
                    $btn = $btn . '</a>';
                    return $btn;
                })
                ->rawColumns(['actions'])
                ->make(true);
        }
        $page_title = trans('pages.settings.page_title');
        return view('admin.cases.sizes.index', [
            'page_title' => $page_title
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(SizesRequest $request)
    {
        //
        $data = $request->except("_token");

        $sizes = new CaseSize;

        $sizes->create([
            'title' => $data['title'],
            'slug' => Str::slug($data['title']),
            'description' => $data['description']
        ]);

        $response = [
            'status' => true,
            'message' => 'Case Size successfully added'
        ];

        return response()->json($response, 200);
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
        $size = CaseSize::findOrFail($id);

        $response = [
            'status' => true,
            'data' => $size
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
    public function update(UpdateSizesRequest $request, $id)
    {
        //
        $size = CaseSize::findOrFail($id);

        $data = $request->except("_token");

        $size->update([
            'title' => $data['title'],
            'slug' => Str::slug($data['title']),
            'description' => $data['description']
        ]);

        $response = [
            'status' => true,
            'message' => 'Case Size successfully updated'
        ];

        return response()->json($response, 200);
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
        $size = CaseSize::findOrFail($id);

        $size->delete();

        $response = [
            'status' => true,
            'message' => 'Case Size successfully removed'
        ];

        return response()->json($response, 200);
    }
}
