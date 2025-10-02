<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    protected $fillable = [
        'order_id', 
        'gift_id', 
        'quantity',
        'price'
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function gift()
    {
        return $this->belongsTo(Gift::class);
    }

    public function addOns()
    {
        return $this->belongsToMany(AddOn::class, 'order_item_add_ons')
                    ->withPivot('quantity')
                    ->withTimestamps();
    }
}
