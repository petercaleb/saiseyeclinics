<?php

namespace App\Http\Controllers\Admin\Reports\Clinics;

use App\Models\Clinic;
use App\Models\Workshop;
use Illuminate\Http\Request;
use App\Exports\ClinicReports;
use App\Http\Controllers\Controller;

class ReportsController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, $id)
    {
        //
        $clinic = Clinic::findOrFail($id);
        if ($request->ajax()) {
            if (!empty($request->from_date) && !empty($request->to_date)) {
                $data = $clinic->report()
                    ->whereBetween('appointment_date', [$request->from_date, $request->to_date])
                    ->get();
            } elseif (!empty($request->payment_status)) {

                $data = $clinic->report()->where('bill_status', $request->payment_status)
                    ->latest()->get();
            } elseif (!empty($request->order_status)) {
                $data = $clinic->report()->where('order_status', $request->order_status)
                    ->latest()->get();
            } else {
                $data = $clinic->report()->latest()->get();
            }

            return datatables()->of($data)
                ->addIndexColumn()
                ->addColumn('date_in', function ($row) {
                    return date('d-m-Y', strtotime($row->patient->date_in));
                })
                ->addColumn('full_name', function ($row) {
                    return $row->patient->first_name . ' ' . $row->patient->last_name;
                })

                ->addColumn('card_number', function ($row) {
                    return $row->patient->card_number;
                })

                ->addColumn('type', function ($row) {
                    if ($row->payment_detail) {
                        return $row->payment_detail->client_type->type;
                    }
                })
                ->addColumn('insurance', function ($row) {
                    if ($row->payment_detail) {
                        if ($row->payment_detail->insurance) {
                            return $row->payment_detail->insurance->title;
                        }
                    }
                })
                ->addColumn('scheduled_date', function ($row) {
                    if ($row->doctor_schedule) {
                        return $row->doctor_schedule->date;
                    }
                })
                ->addColumn('doctor_full_name', function ($row) {
                    if ($row->doctor_schedule) {
                        return $row->doctor_schedule->user->first_name . ' ' . $row->doctor_schedule->user->last_name;
                    }
                })
                ->addColumn('scheme', function ($row) {
                    if ($row->payment_detail) {
                        if ($row->payment_detail->insurance) {
                            return $row->payment_detail->scheme;
                        }
                    }
                })

                ->addColumn('order_date', function ($row) {
                    if ($row->order) {
                        return date('d F Y', strtotime($row->order->order_date));
                    }
                })

                ->addColumn('order_status', function ($row) {
                    if ($row->order) {
                        return $row->order->status;
                    }
                })

                ->addColumn('workshop', function ($row) {
                    $order = $row->order;
                    if ($order) {
                        $workshop_id = $order->workshop_id;
                        $workshop = Workshop::findorfail($workshop_id)->first();
                        if ($workshop) {
                            return $workshop->name;
                        }
                    }
                })

                ->rawColumns([
                    'date_in',
                    'full_name',
                    'type',
                    'insurance',
                    'scheme',
                    'scheduled_date',
                    'doctor_full_name',
                    'order_date',
                    'order_status',
                ])
                ->make(true);
        }
        $page_title = trans('pages.reports.clinic-main');
        return view('admin.reports.clinic.main-report', [
            'clinic' => $clinic,
            'page_title' => $page_title
        ]);
    }

    /**
     * Export a newly report
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function export(Request $request, $id)
    {
        //
        $clinic = Clinic::findOrFail($id);
        $from_date = $request->input('from_date') ? $request->input('from_date') : '';
        $to_date = $request->input('to_date')  ? $request->input('to_date') : '';
        $payment_status = $request->input('payment_status') ? $request->input('payment_status') : '';
        $order_status = $request->input('order_status') ? $request->input('order_status') : '';
        return (new ClinicReports($clinic->id, $from_date, $to_date, $payment_status, $order_status))->download('reports' . time() . '.xlsx', \Maatwebsite\Excel\Excel::XLSX);
    }
}
