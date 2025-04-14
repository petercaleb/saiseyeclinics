<?php

namespace App\Exports\Remmittance;

use App\Models\Remmittance;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\Exportable;

class ExportRemmittance implements FromView
{
    use Exportable;
    /**
    * @return \Illuminate\Support\Collection
    */
    public function view(): View
    {
        $data = Remmittance::with(['paymentBill'])->latest()->get();
        return view('admin.main.remmittance.export', [
            'data' => $data
        ]);
    }
}
