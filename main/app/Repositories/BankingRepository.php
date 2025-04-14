<?php

namespace App\Repositories;

use App\Models\Banking;
use App\Models\Remmittance;
use App\Models\ReceivedPayment;
use App\Enums\RemmittanceStatus;

class BankingRepository
{
    public function getAllBanking()
    {
        return Banking::with(['insurance'])->latest()->get();
    }

    public function getSumAllPaidBanking()
    {
        return Banking::sum('paid');
    }

    public function getSumAllBanlancesBanking()
    {
        return Banking::sum('balance');
    }

    public function storeBanking(array $attributes)
    {
        $notes = data_get($attributes, "notes") ?? "Fully Paid";
        $paid_amount = data_get($attributes, 'paid');
        $total_amount = Remmittance::whereIn('id', data_get($attributes, "remmittance_id"))
            ->with('paymentBill')->get()->sum(function ($remmittance) {
                return $remmittance->paymentBill->agreed_amount;
            });

        $total_balance = $total_amount - $paid_amount;

        if($total_balance < 0)
        {
            $changeToReturn = abs($total_balance);
            $total_balance = 0;
        }
        else
        {
            $changeToReturn = 0;
        }

        $banking = Banking::create([
            "date_received" => data_get($attributes, "date_received"),
            "transaction_code" => data_get($attributes, "transaction_code"),
            "transaction_mode" => data_get($attributes, "transaction_mode"),
            "insurance_id" => data_get($attributes, "insurance_id"),
            "amount" => $total_amount,
            "paid" => $paid_amount,
            "balance" => $total_balance,
            "change" => $changeToReturn,
            "status" => data_get($attributes, "status"),
            "notes" => $notes
        ]);

        // Attach the remmittances to the banking record
        foreach (data_get($attributes, "remmittance_id") as $remmittanceId) {
            $remmittance = Remmittance::with('paymentBill')->findOrFail($remmittanceId);

            ReceivedPayment::create([
                "banking_id" => $banking->id,
                "remmittance_id" => $remmittance->id,
                "paybill_id" => $remmittance->payment_bill_id,
                "amount" => $remmittance->paymentBill->agreed_amount,
                "paid" => $remmittance->paymentBill->agreed_amount,
                "balance" => 0
            ]);

            $remmittance->update([
                'status' => RemmittanceStatus::RECEIVED
            ]);
        }

        return $banking;
    }

    public function show($id)
    {
        return Banking::with(['insurance', 'receivedPayment'])->findOrFail($id);
    }
}
