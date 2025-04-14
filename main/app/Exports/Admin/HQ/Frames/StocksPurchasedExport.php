<?php

namespace App\Exports\Admin\HQ\Frames;

use App\Models\Admin;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\Exportable;

class StocksPurchasedExport implements FromView
{
    use Exportable;
    /**
    * @return \Illuminate\Support\Collection
    */
    public function view(): View
    {
        $admin = Admin::findOrFail(Auth::guard('admin')->user()->id);
        $organization = $admin->organization;
        $data = $organization->hq_frame_purchase()->latest()->get();
        return view('admin.HQ.Frames.purchase-exports', [
            'data' => $data
        ]);
    }
}
