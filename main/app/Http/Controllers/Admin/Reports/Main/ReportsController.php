<?php

namespace App\Http\Controllers\Admin\Reports\Main;

use App\Exports\Reports\Main\ReportsExport;
use App\Http\Controllers\Controller;
use App\Repositories\MainReportRespirotory;
use Illuminate\Http\Request;

class ReportsController extends Controller
{
    //
    private $mainReportRespirotory;

    public function __construct(MainReportRespirotory $mainReportRespirotory)
    {
        $this->mainReportRespirotory = $mainReportRespirotory;
        $this->middleware(['auth:admin']);
    }

    public function index()
    {
        $page_title = trans('pages.reports.clinic');
        return view('admin.reports.main.index', [
            'page_title' => $page_title
        ]);
    }

    public function get_reports(Request $request)
    {
        if ($request->ajax()) {
            $data = $this->mainReportRespirotory->getReports($request);
            return datatables()->of($data)
                ->addIndexColumn()
                ->addColumn('clinic', function ($row) {
                    if ($row->clinic) {
                        return $row->clinic->clinic;
                    }
                })
                ->addColumn('full_name', function ($row) {
                    return $row->patient->first_name . ' ' . $row->patient->last_name;
                })
                ->addColumn('appointment_date', function ($row) {
                    return date('d-m-Y', strtotime($row->appointment_date));
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
                ->addColumn('scheme', function ($row) {
                    if ($row->payment_detail) {
                        if ($row->payment_detail->insurance) {
                            return $row->payment_detail->scheme;
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
                ->addColumn('consultation_fee', function ($row) {
                    return number_format($row->consultation_fee, 2, '.', ',');
                })
                ->addColumn('claimed_amount', function ($row) {
                    return number_format($row->claimed_amount, 2, '.', ',');
                })
                ->addColumn('agreed_amount', function ($row) {
                    return number_format($row->agreed_amount, 2, '.', ',');
                })
                ->addColumn('paid_amount', function ($row) {
                    return number_format($row->paid_amount, 2, '.', ',');
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
                    if ($row->order) {
                        $order = $row->order;
                        $workshop = $order->workshop;
                        if ($workshop) {
                            return $workshop->name;
                        }
                    }
                })
                ->rawColumns([
                    'full_name',
                    'appointment_date',
                    'type',
                    'scheduled_date',
                    'doctor_full_name',
                    'consultation_fee',
                    'claimed_amount',
                    'agreed_amount',
                    'order_date',
                    'order_status',
                    'workshop'
                ])
                ->make(true);
        }
    }

    public function export(Request $request)
    {
        # code...
        $from_date = $request->input('from_date') ? $request->input('from_date') : '';
        $to_date = $request->input('to_date')  ? $request->input('to_date') : '';
        $payment_status = $request->input('payment_status')  ? $request->input('payment_status') : '';
        $order_status = $request->input('order_status')  ? $request->input('order_status') : '';
        return (new ReportsExport($from_date, $to_date, $payment_status, $order_status))->download('reports' . time() . '.xlsx', \Maatwebsite\Excel\Excel::XLSX);
    }
}
