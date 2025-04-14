<?php

namespace App\Exports\Banking;

use App\Repositories\BankingRepository;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromView;

class PaymentExport implements FromView
{
    use Exportable;

    private $banking_id;

    public function __construct($banking_id)
    {
        $this->banking_id = $banking_id;
    }
    /**
    * @return \Illuminate\Support\View
    */
    public function view(): View
    {
        $bankingRepository = new BankingRepository();
        $data = $bankingRepository->show($this->banking_id);
        return view('admin.main.banking.payment-export', [
            'data' => $data
        ]);
    }
}
