<?php

namespace App\Exports\Admin\Reports;

use App\Models\Clinic;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;

class ClinicPendingClaimsReport implements FromView
{
    /**
     * @return \Illuminate\Support\Collection
     */

    use Exportable;

    private $clinic_id;
    public $from_date;
    public $to_date;

    public function __construct($clinic_id, $from_date, $to_date)
    {
        $this->clinic_id = $clinic_id;
        $this->from_date = $from_date;
        $this->to_date = $to_date;
    }


    public function view(): View
    {
        $clinic = Clinic::findOrFail($this->clinic_id);
        if (!empty($this->from_date) && !empty($this->to_date)) {

            $data = $clinic->payment_bill()
                ->whereBetween('open_date', [$this->from_date, $this->to_date])
                ->where('approval_status', 'PENDING')
                ->latest()->get();

        } else {
            $data = $clinic->payment_bill()
                    ->where('approval_status', 'PENDING')
                    ->latest()->get();
        }

        return view('admin.reports.claims.pending.reports', [
            'reports' => $data
        ]);
    }
}
