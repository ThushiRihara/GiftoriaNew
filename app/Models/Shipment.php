<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Shipment extends Model
{
    protected $fillable = [
        'order_id', 
        'address_line1', 
        'address_line2', 
        'state', 
        'country'
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
