<?php

namespace App\Exports;

use App\Models\Patient;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;

class PatientsReport implements FromView
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
     * @return \Illuminate\Support\view
     */
    public function view(): View
    {
        if (!empty($this->from_date) && !empty($this->to_date)) {
            $data = Patient::join('appointments', 'appointments.patient_id', '=', 'patients.id')
                ->join('users', 'users.id', '=', 'patients.user_id')
                ->select('patients.*', 'users.first_name as user_first', 'users.last_name as user_last', 'appointments.date as added_date')
                ->where('patients.clinic_id', $this->clinic_id)
                ->whereBetween('appointments.date', [request()->input('from_date'), request()->input('to_date')])
                ->get();
        } else {
            $data = Patient::where('clinic_id', $this->clinic_id)->get();
        }
        return view('admin.patients.reports', [
            'patients' => $data
        ]);
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return Patient::all();
    }
}
