<?php

namespace App\Models;

use Jenssegers\Mongodb\Eloquent\Model as Eloquent;


class Offer extends Eloquent
{
    // use the mongodb connection
    protected $connection = 'mongodb';

    // If you want a custom collection name:
    protected $collection = 'offers';

    protected $fillable = [
        'title',
        'description',
        'admin_id', // optional (we will set to 1)
    ];
}
