<?php

namespace App\Http\Controllers\Admin\Reports\Frames;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Clinic;
use Illuminate\Support\Facades\Auth;
use App\Repositories\FramesReportRepository;

class FramesReportController extends Controller
{
    //
    private $framesReportRepository;

    public function __construct(FramesReportRepository $framesReportRepository)
    {
        $this->middleware('auth:admin');
        $this->framesReportRepository = $framesReportRepository;
    }

    public function index(Request $request, Clinic $clinic)
    {
        if ($request->ajax()) {
            $admin_id = Auth::guard('admin')->user()->id;
            $data = $this->framesReportRepository->getAllFrames($request, $admin_id);
            return datatables()->of($data)
                ->addIndexColumn()
                ->addColumn('brand', function ($row) {
                    $brand = $row->frame_brand->title;
                    return $brand;
                })
                ->addColumn('size', function ($row) {
                    $size = $row->frame_size->size;
                    return $size;
                })
                ->addColumn('type', function ($row) {
                    $type = $row->frame_type->title;
                    return $type;
                })
                ->addColumn('material', function ($row) {
                    $material = $row->frame_material->title;
                    return $material;
                })
                ->addColumn('photo', function ($row) {
                    $img = '<img src="' . asset('storage/frames/' . $row->photo) . '" alt="' . $row->title . '" class="img-circle img-size-32 mr-2" width="100px">';
                    return $img;
                })
                ->addColumn('status', function ($row) {
                    if ($row->status == 1) {
                        return '<span class="badge badge-success">Active</span>';
                    } else {
                        return '<span class="badge badge-danger">Inactive</span>';
                    }
                })
                ->addColumn('action', function ($row) {
                    $btn = '<div class="btn-group">';
                    $btn = $btn . '<button type="button" class="btn btn-default">Action</button>';
                    $btn = $btn . '<button type="button" class="btn btn-default dropdown-toggle dropdown-icon" data-toggle="dropdown">';
                    $btn = $btn . '<span class="sr-only">Toggle Dropdown</span>';
                    $btn = $btn . '</button>';
                    $btn = $btn . '<div class="dropdown-menu" role="menu">';
                    $btn = $btn . '<a class="dropdown-item editFrame" data-id="' . $row->id . '" href="javascript:void(0)">Edit</a>';
                    $btn = $btn . '<a class="dropdown-item deleteFrame" data-id="' . $row->id . '" href="javascript:void(0)">Delete</a>';
                    $btn = $btn . '</div></div>';
                    return $btn;
                })
                ->rawColumns(['brand', 'size', 'material', 'photo', 'status', 'action'])
                ->make(true);
        }
        $page_title = trans('menus.admins.sidebar.reports.frames');
        return view('admin.reports.frames.index', [
            'clinic' => $clinic,
            'page_title' => $page_title
        ]);
    }

    public function export()  
    {
        
    }
}
