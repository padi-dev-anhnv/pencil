<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Delivery extends Model
{
    protected $guarded = [];

    protected $casts = ['shipping_date' => 'date:Y/m/d', 'received_date' => 'date:Y/m/d'];
}
