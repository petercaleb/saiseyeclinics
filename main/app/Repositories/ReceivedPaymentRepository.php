<?php 

namespace App\Repositories;

use App\Models\ReceivedPayment;

class ReceivedPaymentRepository
{
    public function getAllReceivedPayments()  
    {
        
    }

    public function updatePaidAmountReceivedPayments(array $attributes, ReceivedPayment $receivedPayment)  
    {
        $amount = $receivedPayment->amount;
        $paid_amount = data_get($attributes, 'paid');
        $balance = $amount - $paid_amount;
        if($balance < 0)
        {
            $changeToReturn = abs($balance);
            $balance = 0;
        }else{
            $changeToReturn = 0;
        }
        $receivedPayment->update([
            'amount' => $amount,
            'paid' => $paid_amount,
            'balance' => $balance,
            'change' => $changeToReturn
        ]);

        return $receivedPayment;
    }
}