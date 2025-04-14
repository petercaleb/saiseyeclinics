<?php

namespace App\Exports;

use App\Models\Clinic;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromView;

class ClinicOrdersReport implements FromView
{
    /**
     * @return \Illuminate\Support\Collection
     */
    use Exportable;

    private $clinic_id;
    public $from_date;
    public $to_date;
    public $order_id;
    public $order_status;

    public function __construct($clinic_id, $from_date, $to_date, $order_id, $order_status)
    {
        $this->clinic_id = $clinic_id;
        $this->from_date = $from_date;
        $this->to_date = $to_date;
        $this->order_id = $order_id;
        $this->order_status = $order_status;
    }

    public function view(): View
    {
        $clinic = Clinic::findOrFail($this->clinic_id);
        if (!empty($this->from_date) && !empty($this->to_date)) {

            $data = $clinic->order()->join('order_tracks', 'orders.id', '=', 'order_tracks.order_id')
                ->select('orders.*', 'order_tracks.track_status', 'order_tracks.track_date', 'order_tracks.tat')
                ->whereBetween('order_tracks.track_date', [$this->from_date, $this->to_date])
                ->orderBy('orders.created_at', 'desc')
                ->get();
        } elseif (!empty($this->order_id)) {


            $data = $clinic->order()->join('order_tracks', 'orders.id', '=', 'order_tracks.order_id')
                ->select('orders.*', 'order_tracks.track_status', 'order_tracks.track_date')
                ->where('orders.id', $this->order_id)
                ->orderBy('orders.created_at', 'desc')
                ->get();
        } elseif (!empty($this->order_status)) {

            $data = $clinic->order()->join('order_tracks', 'orders.id', '=', 'order_tracks.order_id')
                ->select('orders.*', 'order_tracks.track_status', 'order_tracks.track_date', 'order_tracks.tat')
                ->where('order_tracks.track_status', $this->order_status)
                ->orderBy('orders.created_at', 'desc')
                ->get();
        } else {
            $data = $clinic->order()->join('order_tracks', 'orders.id', '=', 'order_tracks.order_id')
                ->select('orders.*', 'order_tracks.track_status', 'order_tracks.track_date', 'order_tracks.tat')
                ->orderBy('orders.created_at', 'desc')
                ->get();
        }

        return view('admin.reports.orders.reports', [
            'reports' => $data
        ]);
    }
}
