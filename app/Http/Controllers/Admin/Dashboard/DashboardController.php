<?php

namespace App\Http\Controllers\Admin\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Clinic;
use App\Models\PaymentBill;
use App\Models\Workshop;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    // clinic dashboard
    public function index(Clinic $clinic)
    {
        # code...
        $appointments = $clinic->appointment()
            ->join('patients', 'appointments.patient_id', '=', 'patients.id')
            ->join('payment_details', 'appointments.id', '=', 'payment_details.appointment_id')
            ->join('client_types', 'payment_details.client_type_id', '=', 'client_types.id')
            ->select('appointments.*', 'patients.first_name', 'patients.last_name', 'client_types.type')
            ->orderBy('appointments.created_at', 'desc')
            ->limit(10)
            ->get();
        $payments = $clinic->payment_bill()->sum('paid_amount');
        $remittances = $clinic->remittance()->sum('amount');
        $page_title = trans('pages.dashboard');
        $sub_page = 'dashboard';
        $patients = $clinic->patient->count();

        // $payments_report = PaymentBill::select('');

        return view('admin.dashboard.clinics.index', compact('clinic', 'page_title', 'sub_page', 'patients', 'appointments', 'payments', 'remittances'));
    }

    // Workshop Dashboard
    public function workshop($id)
    {
        # code...
        $workshop = Workshop::findOrFail($id);
        $orders = $workshop->order->sortBy('created_at', SORT_DESC);
        $sum_lenses = $workshop->lens->sum('closing');
        $num_orders = $workshop->order->count();
        $num_technicians = $workshop->technician->count();
        $num_sales = $workshop->workshop_sale->sum('quantity');
        return view('admin.dashboard.workshops.index', compact('workshop', 'sum_lenses', 'orders', 'num_orders', 'num_technicians', 'num_sales'));
    }
}
