<?php

namespace App\Exports\Reports\HQ;

use App\Models\HqFrameStock;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\Exportable;

class HqFramesReportExport implements FromView
{
    use Exportable;
    /**
    * @return \Illuminate\Support\Collection
    */
    public function view():View
    {
        //
        $data = HqFrameStock::latest()->get();
        return view('admin.reports.hq.frames.reports', [
            'data' => $data
        ]);
    }
}
