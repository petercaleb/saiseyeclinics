<?php

namespace App\Http\Controllers\Admin\Cases;

use App\Models\CaseShape;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Settings\Cases\ShapesRequest;

class CasesShapesController extends Controller
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
        if ($request->ajax()) {
            $data = CaseShape::latest()->get();
            return datatables()->of($data)
                ->addIndexColumn()
                ->addColumn('actions', function ($row) {
                    $btn = '<a href="javascript:void(0)" data-id="' . $row->id . '" class="btn btn-sm btn-outline-primary updateCaseShapeBtn">';
                    $btn = $btn . '<i class="fa fa-edit"></i>';
                    $btn = $btn . '</a>';
                    $btn = $btn . '<a href="javascript:void(0)" data-id="' . $row->id . '" class="btn btn-sm btn-outline-danger deleteCaseShapeBtn">';
                    $btn = $btn . '<i class="fa fa-trash"></i>';
                    $btn = $btn . '</a>';
                    return $btn;
                })
                ->rawColumns(['actions'])
                ->make(true);
        }
        $page_title = trans('pages.settings.page_title');
        return view('admin.cases.shapes.index', [
            'page_title' => $page_title
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ShapesRequest $request)
    {
        //
        $data = $request->except("_token");

        $sizes = new CaseShape;

        $sizes->create([
            'title' => $data['title'],
            'slug' => Str::slug($data['title']),
            'description' => $data['description']
        ]);

        $response = [
            'status' => true,
            'message' => 'Case Shape successfully added'
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
        $shape = CaseShape::findOrFail($id);

        $response = [
            'status' => true,
            'data' => $shape
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
    public function update(Request $request, $id)
    {
        //
        $shape = CaseShape::findOrFail($id);

        $data = $request->except("_token");

        $shape->update([
            'title' => $data['title'],
            'slug' => Str::slug($data['title']),
            'description' => $data['description']
        ]);

        $response = [
            'status' => true,
            'message' => 'Case shape successfully updated'
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
        $shape = CaseShape::findOrFail($id);

        $shape->delete();

        $response = [
            'status' => true,
            'message' => 'Case shape successfully removed'
        ];

        return response()->json($response, 200);
    }
}
