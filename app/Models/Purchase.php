<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Purchase extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'item_id',
        'price',
        'payment_status',
        'toyyibpay_bill_code',
    ];

    //$purchase->real_price
    public function getRealPriceAttribute()
    {
        return 'RM'.$this->price/100;
    }

    //$purchase->payment_link
    public function getPaymentLinkAttribute()
    {
        return 'https://dev.toyyibpay.com/'.$this->toyyibpay_bill_code;
    }
}
