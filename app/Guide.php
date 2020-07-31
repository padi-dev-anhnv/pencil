<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Guide extends Model
{
    protected $guarded = ['id'];

    protected $casts = [
        'created_at'  => 'date:Y-m-d'
    ];

    public function delivery()
    {
        return $this->hasOne(Delivery::class);
    }
    public function packaging()
    {
        return $this->hasOne(Packaging::class);
    }
    public function procedure()
    {
        return $this->hasOne(Procedure::class);
    }
    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
