<?php

namespace App\Exports;

use App\Models\Clinic;
use App\Models\PaymentBill;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;

class ClinicPaymentsReport implements FromView
{
    use Exportable;

    private $clinic_id;
    public $from_date;
    public $to_date;
    public $bill_status;

    public function __construct($clinic_id, $from_date, $to_date, $bill_status)
    {
        $this->clinic_id = $clinic_id;
        $this->from_date = $from_date;
        $this->to_date = $to_date;
        $this->bill_status = $bill_status;
    }

    public function view(): View
    {
        $clinic = Clinic::findOrFail($this->clinic_id);
        if (!empty($this->from_date) && !empty($this->to_date)) {
            $data = $clinic->payment_bill()->join('billings', 'payment_bills.id', '=', 'billings.payment_bill_id')
                ->select('payment_bills.*', 'billings.item', 'billings.amount', 'billings.receipt_number')
                ->whereBetween('payment_bills.open_date', [$this->from_date, $this->to_date])
                ->orderBy('payment_bills.created_at', 'desc')
                ->with('billing')
                ->get();
        } elseif (!empty($this->bill_status)) {
            $data = $clinic->payment_bill()
                ->where('bill_status', $this->bill_status)
                ->with('billing')
                ->latest()->get();
        } else {
            $data = $clinic->payment_bill()->with('billing')->latest()->get();
        }
        return view('admin.reports.payments.reports', [
            'reports' => $data
        ]);
    }
}
