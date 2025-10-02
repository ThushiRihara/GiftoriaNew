<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GiftAddOn extends Model
{
    protected $fillable = [
        'gift_id', 
        'add_on_id'
    ];

    public function gift()
    {
        return $this->belongsTo(Gift::class);
    }

    public function addOn()
    {
        return $this->belongsTo(AddOn::class);
    }
}
