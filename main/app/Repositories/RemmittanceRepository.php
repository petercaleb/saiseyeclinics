<?php

namespace App\Repositories;

use Carbon\Carbon;
use App\Models\Remmittance;
use App\Enums\RemmittanceStatus;

class RemmittanceRepository
{
    public function getAll($status = RemmittanceStatus::RECEIVED)
    {
        return Remmittance::with(['paymentBill'])->where('status', '!=', $status)->latest()->get();
    }

    public function getAllRemmittanceForClinicAndInsurance(array $attributes, $status = RemmittanceStatus::RECEIVED)
    {
        $clinicId = data_get($attributes, 'clinic_id');
        $insuranceId = data_get($attributes, 'insurance_id');
        return Remmittance::whereHas('paymentBill.payment_detail', function ($query) use ($clinicId, $insuranceId) {
            $query->where('clinic_id', $clinicId)
                ->where('insurance_id', $insuranceId); // This acts as an AND condition
        })->where('status', '!=', $status)->get();
    }

    public function getAllRemmittanceForClinic(array $attributes, $status = RemmittanceStatus::RECEIVED)
    {
        $clinicId = data_get($attributes, 'clinic_id');
        return Remmittance::whereHas('paymentBill', function ($query) use ($clinicId) {
            $query->where('clinic_id', $clinicId);
        })->where('status', '!=', $status)->get();
    }

    public function getAllRemmittanceForInsurance(array $attributes, $status = RemmittanceStatus::RECEIVED)
    {
        $insuranceId = data_get($attributes, 'insurance_id');
        return Remmittance::whereHas('paymentBill.payment_detail', function ($query) use ($insuranceId) {
            $query->where('insurance_id', $insuranceId);
        })->where('status', '!=', $status)->get();
    }

    public function getSubmiited($status = RemmittanceStatus::SUBMITTED)
    {
        return Remmittance::with(['paymentBill'])->where('status', $status)->latest()->get();
    }

    public function getSumSubmittedRemmittance($status = RemmittanceStatus::SUBMITTED)  
    {
        return Remmittance::where('status', $status)
        ->with('paymentBill')
        ->get()
        ->sum(function($remmittance){
            return $remmittance->paymentBill->total_amount;
        });
    }

    public function getSubmiitedByDate($date, $status = RemmittanceStatus::SUBMITTED)
    {
        return Remmittance::with(['paymentBill'])->where('date', $date)->where('status', $status)->latest()->get();
    }

    public function getSubmittedForClinicAndInsurance(array $attributes, $status = RemmittanceStatus::SUBMITTED)
    {
        $clinicId = data_get($attributes, 'clinic_id');
        $insuranceId = data_get($attributes, 'insurance_id');
        return Remmittance::whereHas('paymentBill.payment_detail', function ($query) use ($clinicId, $insuranceId) {
            $query->where('clinic_id', $clinicId)
                ->where('insurance_id', $insuranceId); // This acts as an AND condition
        })->where('status', $status)->get(); 
    }

    public function getSubmittedRemmittanceForClinic(array $attributes, $status = RemmittanceStatus::SUBMITTED)
    {
        $clinicId = data_get($attributes, 'clinic_id');
        return Remmittance::whereHas('paymentBill', function ($query) use ($clinicId) {
            $query->where('clinic_id', $clinicId);
        })->where('status', $status)->get();
    }

    public function getSubmittedRemmittanceForInsurance(array $attributes, $status = RemmittanceStatus::SUBMITTED)
    {
        $insuranceId = data_get($attributes, 'insurance_id');
        return Remmittance::whereHas('paymentBill.payment_detail', function ($query) use ($insuranceId) {
            $query->where('insurance_id', $insuranceId);
        })->where('status', $status)->get();
    }

    public function getPending($status = RemmittanceStatus::PENDING)
    {
        return Remmittance::with(['paymentBill'])->where('status', $status)->latest()->get();
    }

    public function getPendingForClinicAndInsurance(array $attributes, $status = RemmittanceStatus::PENDING)
    {
        $clinicId = data_get($attributes, 'clinic_id');
        $insuranceId = data_get($attributes, 'insurance_id');
        return Remmittance::whereHas('paymentBill.payment_detail', function ($query) use ($clinicId, $insuranceId) {
            $query->where('clinic_id', $clinicId)
                ->where('insurance_id', $insuranceId); // This acts as an AND condition
        })->where('status', $status)->get(); 
    }

    public function getPendingRemmittanceForClinic(array $attributes, $status = RemmittanceStatus::PENDING)
    {
        $clinicId = data_get($attributes, 'clinic_id');
        return Remmittance::whereHas('paymentBill', function ($query) use ($clinicId) {
            $query->where('clinic_id', $clinicId);
        })->where('status', $status)->get();
    }

    public function getPendingRemmittanceForInsurance(array $attributes, $status = RemmittanceStatus::PENDING)
    {
        $insuranceId = data_get($attributes, 'insurance_id');
        return Remmittance::whereHas('paymentBill.payment_detail', function ($query) use ($insuranceId) {
            $query->where('insurance_id', $insuranceId);
        })->where('status', $status)->get();
    }

    public function getReceived($status = RemmittanceStatus::RECEIVED)
    {
        return Remmittance::with(['paymentBill'])->where('status', $status)->latest()->get();
    }

    public function showRemmittance($id)
    {
        return Remmittance::with(['paymentBill'])->findOrFail($id);
    }

    public function updateMultipleRemmittance(array $attributes)
    {
        $remmittance_id = data_get($attributes, 'remmittance_id');
        $status = RemmittanceStatus::SUBMITTED;
        foreach ($remmittance_id as $remmittanceId) {
            $remmittance = Remmittance::findOrFail($remmittanceId);
            $remmittance->update([
                'date' => Carbon::now()->format('Y-m-d'),
                'status' => $status
            ]);
            $paymentBill = $remmittance->paymentBill;
            $paymentBill->update([
                'remmittance_status' => $status
            ]);
        }
        return true;
    }
}
