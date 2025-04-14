<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vendor extends Model
{
    use HasFactory;

    protected $fillable = [
        'organization_id',
        'first_name',
        'last_name',
        'company',
        'phone',
        'email',
        'type',
        'location',
    ];

    public function organization()
    {
        # code...
        return $this->belongsTo(Organization::class, 'organization_id', 'id');
    }

    public function lens_purchase()
    {
        # code...
        return $this->hasMany(LensPurchase::class, 'vendor_id', 'id');
    }
}
