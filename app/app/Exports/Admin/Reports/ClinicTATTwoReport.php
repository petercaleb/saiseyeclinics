<?php

namespace App\Exports\Admin\Reports;

use App\Models\Clinic;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;

class ClinicTATTwoReport implements FromView
{
    /**
     * @return \Illuminate\Support\Collection
     */
    use Exportable;

    private $clinic_id;
    public $from_date;
    public $to_date;
    public $status;

    public function __construct($clinic_id, $from_date, $to_date, $status)
    {
        $this->clinic_id = $clinic_id;
        $this->from_date = $from_date;
        $this->to_date = $to_date;
        $this->status = $status;
    }

    public function view(): View
    {
        $clinic = Clinic::findOrFail($this->clinic_id);
        if (!empty($this->from_date) && !empty($this->to_date)) {

            $data = $clinic->order()
                ->whereBetween('order_date', [$this->from_date, $this->to_date])
                ->where('tat_two', '>', 0)->latest()->get();
        } elseif (!empty($this->status)) {
            $data = $clinic->order()
                ->where('status', $this->status)
                ->where('tat_two', '>', 0)->latest()->get();
        } else {
            $data = $clinic->order()
                ->where('tat_two', '>', 0)
                ->latest()->get();
        }

        return view('admin.reports.tat.test_two_reports', [
            'reports' => $data
        ]);
    }
}
