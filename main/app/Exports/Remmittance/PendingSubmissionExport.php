<?php

namespace App\Exports\Remmittance;

use App\Repositories\RemmittanceRepository;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\Exportable;

class PendingSubmissionExport implements FromView
{

    use Exportable;
    /**
    * @return \Illuminate\Support\FromView
    */
    public function view(): View
    {
        $remmittanceRepository = new RemmittanceRepository();
        $data = $remmittanceRepository->getPending();
        return view('admin.main.remmittance.export-pending', [
            'data' => $data
        ]);
    }
}
