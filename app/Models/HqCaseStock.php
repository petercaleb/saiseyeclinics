<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HqCaseStock extends Model
{
    use HasFactory;

    protected $fillable = [
        'organization_id',
        'admin_id',
        'case_id',
        'opening',
        'purchased',
        'transfered',
        'total',
        'supplier_price',
        'price',
    ];

    public function organization()  
    {
        return $this->belongsTo(Organization::class, 'organization_id', 'id');    
    }

    public function admin()  
    {
        return $this->belongsTo(Admin::class, 'admin_id', 'id');
    }


    public function frame_case()  
    {
        return $this->belongsTo(FrameCase::class, 'case_id', 'id');
    }


}
