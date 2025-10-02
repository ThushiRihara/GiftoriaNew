<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $fillable = [
        'order_id', 
        'payment_method', 
        'total_amount', 
        'payment_date', 
        'card_number', 
        'cvv', 
        'expiry_date'
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
