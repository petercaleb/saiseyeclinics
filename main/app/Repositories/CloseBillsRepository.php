<?php

namespace App\Repositories;

use App\Enums\DocumentStatus;
use App\Models\PaymentBill;
use App\Models\User;
use Carbon\Carbon;

class CloseBillsRepository
{

    public function getScheduledClosedBills(User $user)  
    {
        return $user->payment_bill()->where('bill_status', 'CLOSED')->latest()->get();
    }

    public function getScheduledClosedBillsWhereDocumentHasNotBeenSendToHQ(User $user, $documentStatus = DocumentStatus::PHYSICAL_DOCUMENT_NOT_SENT)  
    {
        return $user->payment_bill()->where('bill_status', 'CLOSED')->where('document_status', $documentStatus)->latest()->get();   
    }

    public function getScheduledClosedBillsWhereDocumentHasBeenSendToHQ(User $user, $documentStatus = DocumentStatus::PHYSICAL_DOCUMENT)  
    {
        return $user->payment_bill()->where('bill_status', 'CLOSED')->where('document_status', $documentStatus)->latest()->get();  
    }

    public function sendPhysicalDoc(PaymentBill $paymentBill, $status = DocumentStatus::PHYSICAL_DOCUMENT)  
    {
        $date = Carbon::now()->format('Y-m-d');
        $paymentBill->update([
            'document_status' => $status,
            'send_date' => $date
        ]);
        return $paymentBill;
    }

    public function sendMultiplePhysicalDoc(array $attributes, $status = DocumentStatus::PHYSICAL_DOCUMENT)  
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

}