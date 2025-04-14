<?php

namespace App\Exports\Banking;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\Exportable;
use App\Repositories\RemmittanceRepository;

class ReceivedPaymentsExport implements FromView
{

    use Exportable;

    /**
    * @return \Illuminate\Support\View
    */
    public function view(): View
    {
        $remmittanceRepository = new RemmittanceRepository();
        $receivedRemmittanceData = $remmittanceRepository->getReceived();
        return view('admin.main.receivedPayments.export', [
            'data' => $receivedRemmittanceData
        ]);   
    }
}
