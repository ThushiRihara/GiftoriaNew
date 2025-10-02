<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderItemAddOn extends Model
{
    protected $fillable = [
        'order_item_id', 
        'add_on_id',
        'quantity'
    ];

    public function orderItem()
    {
        return $this->belongsTo(OrderItem::class);
    }

    public function addOn()
    {
        return $this->belongsTo(AddOn::class);
    }
}
