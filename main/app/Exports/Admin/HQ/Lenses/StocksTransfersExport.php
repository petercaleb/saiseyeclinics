<?php

namespace App\Exports\Admin\HQ\Lenses;

use App\Models\Admin;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromView;

class StocksTransfersExport implements FromView
{
    use Exportable;
    /**
    * @return \Illuminate\Support\View
    */
    public function view(): View
    {
        $admin = Admin::findOrFail(Auth::guard('admin')->user()->id);
        $organization = $admin->organization;
        $data = $organization->hq_lens_transfer()->latest()->get();
        return view('admin.HQ.lenses.transfer-export', [
            'data' => $data
        ]);
    }
}
