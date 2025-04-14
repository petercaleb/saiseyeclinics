<?php

namespace App\Repositories;

use App\Models\Report;

class MainReportRespirotory
{
    public function getReports($request)
    {
        if (!empty($request->from_date) && !empty($request->to_date)) {

            $data = Report::whereBetween('appointment_date', [
                $request->from_date, $request->to_date
            ])->with([
                'clinic',
                'patient',
                'appointment',
                'payment_detail',
                'doctor_schedule',
                'diagnosis',
                'treatment',
                'lens_power',
                'lens_prescription',
                'frame_prescription',
                'payment_bill',
                'order.right_eye_lens',
                'order.left_eye_lens'
            ])->get();
        } elseif (!empty($request->payment_status)) {
            $data = Report::where('bill_status', $request->payment_status)
                ->with([
                    'clinic',
                    'patient',
                    'appointment',
                    'payment_detail',
                    'doctor_schedule',
                    'diagnosis',
                    'treatment',
                    'lens_power',
                    'lens_prescription',
                    'frame_prescription',
                    'payment_bill',
                    'order.right_eye_lens',
                    'order.left_eye_lens'
                ])
                ->latest()->get();
        } elseif (!empty($request->order_status)) {
            $data = Report::where('order_status', $request->order_status)
                ->with([
                    'clinic',
                    'patient',
                    'appointment',
                    'payment_detail',
                    'doctor_schedule',
                    'diagnosis',
                    'treatment',
                    'lens_power',
                    'lens_prescription',
                    'frame_prescription',
                    'payment_bill',
                    'order.right_eye_lens',
                    'order.left_eye_lens'
                ])
                ->latest()->get();
        } else {
            $data = Report::with([
                'clinic',
                'patient',
                'appointment',
                'payment_detail',
                'doctor_schedule',
                'diagnosis',
                'treatment',
                'lens_power',
                'lens_prescription',
                'frame_prescription',
                'payment_bill',
                'order'
            ])->latest()->get();
        }

        return $data;
    }
}
