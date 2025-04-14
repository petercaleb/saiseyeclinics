<?php

namespace App\Repositories;

use App\Models\Insurance;
use App\Models\Remmittance;

class InsurancesRepository {

    public function getAllInsurance()  
    {
        return Insurance::latest()->get();
    }

    public function getRemmittanceForInsurance($id)    
    {
        $insurance = Insurance::findOrFail($id);
        $insuranceId  = $insurance->id;
        $remmittances = Remmittance::whereHas('paymentBill.payment_detail.insurance', function($query) use ($insuranceId){
            $query->where('id', $insuranceId);
        })->with(['paymentBill.patient'])->get();

        return $remmittances;
        
    }

}
