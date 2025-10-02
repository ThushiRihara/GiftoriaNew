<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Gift extends Model
{
    protected $fillable = [
        'name', 
        'price', 
        'stock_quantity', 
        'category_id', 
        'admin_id',
        'image',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function admin()
    {
        return $this->belongsTo(Admin::class, 'admin_id');
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function giftAddOns()
    {
        return $this->hasMany(GiftAddOn::class);
    }

    // Direct relation: all add-ons available for this gift
    public function addOns()
    {
        return $this->belongsToMany(AddOn::class, 'gift_add_ons')
                    ->withTimestamps();
    }
}
