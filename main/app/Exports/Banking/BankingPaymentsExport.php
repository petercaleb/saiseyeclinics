<?php

namespace App\Exports\Banking;

use App\Repositories\BankingRepository;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromView;

class BankingPaymentsExport implements FromView
{
    use Exportable;
    
    /**
    * @return \Illuminate\Support\View
    */
    public function view(): View
    {
        $bankingRepository = new BankingRepository();
        $data = $bankingRepository->getAllBanking();
        return view('admin.main.banking.exports', [
            'data' => $data
        ]);   
    }
}
