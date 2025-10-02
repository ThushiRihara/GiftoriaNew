<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AddOn extends Model
{
    protected $fillable = [
        'name', 
        'price'
    ];

    // Gifts that can have this add-on (catalog rules)
    public function gifts()
    {
        return $this->belongsToMany(Gift::class, 'gift_add_ons')
                    ->withTimestamps();
    }


    // Order items where this add-on was chosen (actual purchase)
    public function orderItems()
    {
        return $this->belongsToMany(OrderItem::class, 'order_item_add_ons')
                    ->withPivot('quantity')
                    ->withTimestamps();
    }
}
