<?php

namespace App\Exports\Reports\Main;

use App\Models\Report;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\Exportable;

class ReportsExport implements FromView
{

    use Exportable;
    public $from_date;
    public $to_date;
    public $payment_status;
    public $order_status;

    public function __construct($from_date, $to_date, $payment_status, $order_status)
    {
        $this->from_date = $from_date;
        $this->to_date = $to_date;
        $this->payment_status = $payment_status;
        $this->order_status = $order_status;
    }

    /**
    * @return \Illuminate\Support\View
    */
    public function view(): View
    {
        //
        if (!empty($this->from_date) && !empty($this->to_date)) {
            $data = Report::whereBetween('appointment_date', [request()->input('from_date'), request()->input('to_date')])
                ->get();
        } elseif (!empty($this->payment_status)) {
            $data = Report::where('bill_status', $this->payment_status)
                ->get();
        } elseif (!empty($this->order_status)) {
            $data = Report::where('order_status', $this->order_status)
                ->get();
        } else {
            $data = Report::latest()->get();
        }
        return view('admin.reports.main.export_reports', [
            'reports' => $data
        ]);
    }
}
