<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Workshop extends Model
{
    use HasFactory;

    protected $fillable = [
        'organization_id',
        'name',
        'initials',
        'logo',
        'phone',
        'email',
        'address',
    ];

    public function organization()
    {
        # code...
        return $this->belongsTo(Organization::class, 'organization_id', 'id');
    }

    public function frame_prescription()
    {
        # code...
        return $this->hasMany(FramePrescription::class, 'power_id', 'id');
    }

    public function order()
    {
        # code...
        return $this->hasMany(Order::class, 'workshop_id', 'id');
    }

    public function treatment()
    {
        # code...
        return $this->hasOne(Treatment::class, 'workshop_id', 'id');
    }

    public function technician()
    {
        # code...
        return $this->hasMany(Technician::class, 'workshop_id', 'id');
    }

    public function workshop_asset()
    {
        # code...
        return $this->hasMany(WorkshopAsset::class, 'workshop_id', 'id');
    }

    public function lens()
    {
        # code...
        return $this->hasMany(Lens::class, 'workshop_id', 'id');
    }

    public function from_workshop_transfer_asset()
    {
        # code...
        return $this->hasMany(WorkshopTransferAsset::class, 'from_workshop_id', 'id');
    }

    public function to_workshop_transfer_asset()
    {
        # code...
        return $this->hasMany(WorkshopTransferAsset::class, 'to_workshop_id', 'id');
    }

    public function lens_purchase()
    {
        # code...
        return $this->hasMany(LensPurchase::class, 'workshop_id', 'id');
    }

    public function lens_transfer()
    {
        # code...
        return $this->hasMany(LensTransfer::class, 'workshop_id', 'id');
    }

    public function lens_transfer_to()
    {
        # code...
        return $this->hasMany(LensTransfer::class, 'to_workshop_id', 'id');
    }

    public function workshop_sale()
    {
        # code...
        return $this->hasMany(WorkshopSale::class, 'workshop_id', 'id');
    }

    public function request_lens()  
    {
        return $this->hasMany(RequestLens::class, 'workshop_id', 'id');    
    }

    public function lens_receive()  
    {
        return $this->hasMany(LensReceive::class, 'workshop_id');
    }

    public function hq_lens_transfer_to() 
    {
        return $this->hasMany(HqLensTransfer::class, 'to_workshop_id');
    }

    public function lens_request()  
    {
        return $this->hasMany(LensRequest::class, 'workshop_id');
    }

    public function workshop_case_stock()  
    {
        return $this->hasMany(WorkshopCaseStock::class, 'workshop_id', 'id');   
    }

    public function workshop_case_receive()
    {
        return $this->hasMany(WorkshopCaseReceive::class, 'workshop_id', 'id');
    }

    public function from_workshop_case_receive()
    {
        return $this->hasMany(WorkshopCaseReceive::class, 'from_workshop_id', 'id');
    }

    public function hq_case_transfer_to()
    {
        return $this->hasMany(HqCaseTransfer::class, 'to_workshop_id', 'id');
    }

    public function workshop_case_request()  
    {
        return $this->hasMany(WorkshopCaseRequest::class, 'workshop_id', 'id');    
    }
}
