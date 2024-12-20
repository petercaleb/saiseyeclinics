<?php

namespace App\Http\Controllers\Users\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        # code...
        $user = User::findOrFail(auth()->user()->id);
        $num_my_schedules = $user->doctor_schedule->count();
        $schedules = $user->doctor_schedule()->latest()->paginate(10);
        $clinic = $user->clinic;
        $num_all_schedules = $clinic->doctor_schedule()->count();
        $patients = $clinic->patient->count();
        $orders = $clinic->order->count();
        $page_title = trans('users.page.dashboard.title');
        return view('users.dashboard.index',[
            'page_title' => $page_title,
            'clinic' => $clinic,
            'num_my_schedules' => $num_my_schedules,
            'schedules' => $schedules,
            'num_all_schedules' => $num_all_schedules,
            'patients' => $patients,
            'orders' => $orders
        ]);
    }
}
