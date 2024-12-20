<?php

namespace App\Http\Controllers\Admin\Cases;

use App\Models\CaseColor;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Settings\Cases\ColorsRequest;
use App\Http\Requests\Admin\Settings\Cases\UpdateColorsRequest;

class CasesColorsController extends Controller
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
            $data = CaseColor::latest()->get();
            return datatables()->of($data)
                ->addIndexColumn()
                ->addColumn('actions', function ($row) {
                    $btn = '<a href="javascript:void(0)" data-id="'. $row->id .'" class="btn btn-sm btn-outline-primary updateCaseColorBtn">';
                    $btn = $btn . '<i class="fa fa-edit"></i>';
                    $btn = $btn . '</a>';
                    $btn = $btn . '<a href="javascript:void(0)" data-id="'. $row->id .'" class="btn btn-sm btn-outline-danger deleteCaseColorBtn">';
                    $btn = $btn . '<i class="fa fa-trash"></i>';
                    $btn = $btn . '</a>';
                    return $btn;
                })
                ->rawColumns(['actions'])
                ->make(true);
        }
        $page_title = trans('pages.settings.page_title');
        return view('admin.cases.colors.index', [
            'page_title' => $page_title,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ColorsRequest $request)
    {
        //
        $data = $request->except("_token");

        $colors = new CaseColor;

        $colors->title = $data['title'];
        $colors->slug = Str::slug($data['title']);
        $colors->description = $data['description'];

        $colors->save();

        $response = [
            'status' => true,
            'message' => 'New Case Color successfully added'
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
        $colors = CaseColor::findOrFail($id);

        $response = [
            'status' => true,
            'data' => $colors
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
    public function update(UpdateColorsRequest $request, $id)
    {
        //
        $colors = CaseColor::findOrFail($id);

        $data = $request->except("_token");

        $colors->title = $data['title'];
        $colors->slug = Str::slug($data['title']);
        $colors->description = $data['description'];

        $colors->save();

        $response = [
            'status' => true,
            'message' => 'Case Color successfully updated'
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
        $colors = CaseColor::findOrFail($id);

        $colors->delete();

        $response = [
            'status' => true,
            'message' => 'Case Color successfully deleted'
        ];

        return response()->json($response, 200);
    }
}
