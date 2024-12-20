<?php

namespace App\Exports;

use App\Models\Appointment;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;

class AppointmentsExport implements FromView
{

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


    /**
     * @return \Illuminate\Support\View
     */
    public function view(): View
    {
        if (!empty($this->from_date) && !empty($this->to_date)) {
            $data = Appointment::where('clinic_id', $this->clinic_id)
                ->whereBetween('date', [request()->input('from_date'), request()->input('to_date')])
                ->get();
        } else {
            $data = Appointment::where('clinic_id', $this->clinic_id)->get();
        }
        return view('admin.appointments.reports', [
            'appointments' => $data
        ]);
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        //
    }
}
