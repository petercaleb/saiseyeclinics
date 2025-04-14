<?php

namespace App\Repositories;

use Carbon\Carbon;
use App\Models\PaymentBill;
use App\Models\Remmittance;
use App\Enums\DocumentStatus;
use App\Enums\RemmittanceStatus;

class BillingRepository
{
    public function closed_bills()
    {
        return PaymentBill::with(['clinic', 'appontment', 'appontment.patient', 'appontment.lens_power', 'appontment.lens_power.frame_prescription', 'payment_detail', 'payment_detail.insurance'])
            ->where('bill_status', 'CLOSED')
            ->where('remmittance_status', '=', null)
            ->latest()->get();
    }

    public function closed_bills_for_clinic(array $attributes)
    {
        return PaymentBill::with(['clinic', 'appontment', 'appontment.patient', 'appontment.lens_power', 'appontment.lens_power.frame_prescription', 'payment_detail', 'payment_detail.insurance'])
            ->where('clinic_id', data_get($attributes, 'clinic_id'))
            ->where('bill_status', 'CLOSED')
            ->where('remmittance_status', '=', null)
            ->latest()->get();
    }

    public function closed_bills_for_insurance(array $attributes)
    {
        $insuranceId = data_get($attributes, 'insurance_id');
        return PaymentBill::whereHas('payment_detail', function($query) use ($insuranceId){
            $query->where('insurance_id', $insuranceId);
        })->with(['clinic', 'appontment', 'appontment.patient', 'appontment.lens_power', 'appontment.lens_power.frame_prescription', 'payment_detail', 'payment_detail.insurance'])
            ->where('bill_status', 'CLOSED')
            ->where('remmittance_status', '=', null)
            ->latest()->get();
    }

    public function closed_bills_for_clinic_and_insurance(array $attributes)
    {
        $clinicId = data_get($attributes, 'clinic_id');
        $insuranceId = data_get($attributes, 'insurance_id');
        return PaymentBill::whereHas('payment_detail', function($query) use ($insuranceId){
            $query->where('insurance_id', $insuranceId);
        })->with(['clinic', 'appontment', 'appontment.patient', 'appontment.lens_power', 'appontment.lens_power.frame_prescription', 'payment_detail', 'payment_detail.insurance'])
            ->where('bill_status', 'CLOSED')
            ->where('clinic_id', $clinicId)
            ->where('remmittance_status', '=', null)
            ->latest()->get();
    }

    public function sentToHq($status = DocumentStatus::PHYSICAL_DOCUMENT)
    {
        return PaymentBill::with(['clinic', 'appontment', 'appontment.patient', 'appontment.lens_power', 'appontment.lens_power.frame_prescription', 'payment_detail', 'payment_detail.insurance'])
            ->where('bill_status', 'CLOSED')
            ->where('document_status', $status)
            ->where('remmittance_status', '=', null)
            ->latest()->get();
    }

    public function sentToHqForClinic(array $attributes, $status = DocumentStatus::PHYSICAL_DOCUMENT)
    {
        return PaymentBill::with(['clinic', 'appontment', 'appontment.patient', 'appontment.lens_power', 'appontment.lens_power.frame_prescription', 'payment_detail', 'payment_detail.insurance'])
            ->where('bill_status', 'CLOSED')
            ->where('clinic_id', data_get($attributes, 'clinic_id'))
            ->where('document_status', $status)
            ->where('remmittance_status', '=', null)
            ->latest()->get();
    }

    public function sentToHqForInsurance(array $attributes, $status = DocumentStatus::PHYSICAL_DOCUMENT)
    {
        $insuranceId = data_get($attributes, 'insurance_id');
        return PaymentBill::whereHas('payment_detail', function($query) use ($insuranceId){
            $query->where('insurance_id', $insuranceId);
        })->with(['clinic', 'appontment', 'appontment.patient', 'appontment.lens_power', 'appontment.lens_power.frame_prescription', 'payment_detail', 'payment_detail.insurance'])
            ->where('bill_status', 'CLOSED')
            ->where('document_status', $status)
            ->where('remmittance_status', '=', null)
            ->latest()->get();
    }

    public function sentToHqForClinicAndInsurance(array $attributes, $status = DocumentStatus::PHYSICAL_DOCUMENT)
    {
        $insuranceId = data_get($attributes, 'insurance_id');
        return PaymentBill::whereHas('payment_detail', function($query) use ($insuranceId){
            $query->where('insurance_id', $insuranceId);
        })->with(['clinic', 'appontment', 'appontment.patient', 'appontment.lens_power', 'appontment.lens_power.frame_prescription', 'payment_detail', 'payment_detail.insurance'])
            ->where('clinic_id', data_get($attributes, 'clinic_id'))
            ->where('bill_status', 'CLOSED')
            ->where('document_status', $status)
            ->where('remmittance_status', '=', null)
            ->latest()->get();
    }

    public function receivedFromClinic($status = DocumentStatus::RECEIVED_DOCUMENT)
    {
        return PaymentBill::with(['clinic', 'appontment', 'appontment.patient', 'appontment.lens_power', 'appontment.lens_power.frame_prescription', 'payment_detail', 'payment_detail.insurance'])
            ->where('bill_status', 'CLOSED')
            ->where('document_status', $status)
            ->where('remmittance_status', '=', null)
            ->latest()->get();
    }


    public function receivedFromClinicForClinic(array $attributes, $status = DocumentStatus::RECEIVED_DOCUMENT)
    {
        return PaymentBill::with(['clinic', 'appontment', 'appontment.patient', 'appontment.lens_power', 'appontment.lens_power.frame_prescription', 'payment_detail', 'payment_detail.insurance'])
            ->where('clinic_id', data_get($attributes, 'clinic_id'))
            ->where('bill_status', 'CLOSED')
            ->where('document_status', $status)
            ->where('remmittance_status', '=', null)
            ->latest()->get();
    }

    public function receivedFromClinicForInsurance(array $attributes, $status = DocumentStatus::RECEIVED_DOCUMENT)
    {
        $insuranceId = data_get($attributes, 'insurance_id');
        return PaymentBill::whereHas('payment_detail', function($query) use($insuranceId){
            $query->where('insurance_id', $insuranceId);
        })->with(['clinic', 'appontment', 'appontment.patient', 'appontment.lens_power', 'appontment.lens_power.frame_prescription', 'payment_detail', 'payment_detail.insurance'])
            ->where('bill_status', 'CLOSED')
            ->where('document_status', $status)
            ->where('remmittance_status', '=', null)
            ->latest()->get();
    }

    public function receivedFromClinicForClinicAndInsurance(array $attributes, $status = DocumentStatus::RECEIVED_DOCUMENT)
    {

        $insuranceId = data_get($attributes, 'insurance_id');
        return PaymentBill::whereHas('payment_detail', function($query) use($insuranceId){
            $query->where('insurance_id', $insuranceId);
        })->with(['clinic', 'appontment', 'appontment.patient', 'appontment.lens_power', 'appontment.lens_power.frame_prescription', 'payment_detail', 'payment_detail.insurance'])
            ->where('clinic_id', data_get($attributes, 'clinic_id'))
            ->where('bill_status', 'CLOSED')
            ->where('document_status', $status)
            ->where('remmittance_status', '=', null)
            ->latest()->get();
    }

    public function receiveDocument(PaymentBill $paymentBill, $status = DocumentStatus::RECEIVED_DOCUMENT)
    {
        $date = Carbon::now()->format('Y-m-d');
        $paymentBill->update([
            'document_status' => $status,
            'received_date' => $date
        ]);
        return $paymentBill;
    }
    public function receiveMultipleDocuments(array $attributes, $status = DocumentStatus::RECEIVED_DOCUMENT)
    {
        $payment_bill_id = data_get($attributes, 'payment_bill_id');
        $date = Carbon::now()->format('Y-m-d');
        foreach($payment_bill_id as $payBillId)
        {
            $paymentBill = PaymentBill::findOrFail($payBillId);
            $paymentBill->update([
                'document_status' => $status,
                'send_date' => $date
            ]);
        }
        return true;
    }
    public function storeRemmittance(array $attributes)
    {
        $payment_bill_id = data_get($attributes, 'payment_bill_id');
        $status = RemmittanceStatus::PENDING;
        foreach ($payment_bill_id as $billId) {
            $paymentBill = PaymentBill::findOrFail($billId);
            $paymentDetail = $paymentBill->payment_detail;
            $client_type = $paymentDetail->client_type;

            // Check if remittance already exists
            $checkRemmittanceForPayments = Remmittance::where('payment_bill_id',  $paymentBill->id)->first();

            // If remittance exists, skip to the next iteration
            if($checkRemmittanceForPayments)
            {
                continue; // Skip this iteration
            }
            if ($client_type->type == 'Insurance') {

                if ($paymentBill->document_status == DocumentStatus::RECEIVED_DOCUMENT) {
                    Remmittance::create([
                        'payment_bill_id' => $billId,
                        'date' => Carbon::now()->format('Y-m-d'),
                        'status' => $status
                    ]);
                    $paymentBill->update([
                        'remmittance_status' => $status
                    ]);
                }
            }
        }
        return true;
    }
}
