<?php

namespace App\Exports\Billing;

use App\Models\PaymentBill;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromView;

class ExportBilling implements FromView
{
    use Exportable;
    /**
    * @return \Illuminate\Support\View
    */
    public function view():View
    {
        //
        $data = PaymentBill::where('bill_status', 'CLOSED')->latest()->get();
        return view('admin.main.billing.export', [
            'data' => $data
        ]);
    }
}
