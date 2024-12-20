<?php

namespace App\Http\Controllers\Users\Frames;

use App\Http\Controllers\Controller;
use App\Models\FrameStock;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FrameStocksController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //
        $user = User::findOrFail(Auth::user()->id);
        $clinic = $user->clinic;
        if ($request->ajax()) {
            $data = $clinic->frame_stock()->latest()->get();
            return datatables()->of($data)
                ->addIndexColumn()
                ->addColumn('frame_code', function ($row) {
                    $frame_code = $row->code;
                    return $frame_code;
                })
                ->addColumn('gender', function($row){
                    return $row->hq_stock->gender;
                })
                ->addColumn('color', function($row){
                    $frame_color = $row->hq_stock->frame_color->color;
                    return $frame_color;
                })
                ->addColumn('shape', function($row){
                    $frame_shape = $row->hq_stock->frame_shape->shape;
                    return $frame_shape;
                })
                ->rawColumns(['frame_code', 'color', 'shape'])
                ->make(true);
        }
        $page_title = "Frame Stocks";
        return view('users.frames.index', [
            'page_title' => $page_title,
            'clinic' => $clinic,
            'organization' => $clinic->organization,
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(FrameStock $frameStock)
    {
        //
        return response()->json([
            'status' => true,
            'data' => $frameStock
        ]);
    }
}
