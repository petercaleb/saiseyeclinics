<?php

namespace App\Http\Controllers\Technicians\Assets;

use App\Http\Controllers\Controller;
use App\Models\Technician;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AssetsController extends Controller
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
        if ($request->ajax()) {
            $data = $workshop->workshop_asset->sortBy('created_at', SORT_DESC);
            return datatables()->of($data)
                ->addIndexColumn()
                ->addColumn('type', function($row){
                    $type = $row->asset_type->title;
                    return $type;
                })
                ->addColumn('condition', function($row){
                    $condition = $row->asset_condition->title;
                    return $condition;
                })
                ->make(true);
        }
        $page_title = "Assets";
        $num_assets = $workshop->workshop_asset->count();
        return view('technicians.assets.index', [
            'page_title' => $page_title,
            'num_assets' => $num_assets,
        ]);
    }
}
