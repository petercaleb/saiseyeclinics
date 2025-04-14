<?php

namespace App\Exports\Remmittance;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\Exportable;
use App\Repositories\RemmittanceRepository;

class SubmittedRemmittanceExport implements FromView
{
    use Exportable;
    /**
    * @return \Illuminate\Support\FromView
    */
    public function view(): View
    {
        $remmittanceRepository = new RemmittanceRepository();
        $data = $remmittanceRepository->getSubmiited();
        return view('admin.main.remmittance.export-submitted', [
            'data' => $data
        ]);
    }
}
