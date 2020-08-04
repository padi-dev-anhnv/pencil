<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Guide extends Model
{
    protected $guarded = ['id'];

    protected $casts = [
        'created_at'  => 'date:Y/m/d'
    ];

    protected $appends = ['first_product','creator'];

    public function getFirstProductAttribute($val)
    {
        return $this->products()->select('name')->first();
    }

    public function getCreatorAttribute($val)
    {
        return $this->creator()->select('name')->first();
    }

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
    public function supplier()
    {
        return $this->belongsTo(User::class, 'supplier_id');
    }
    public function creator()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function scopeOffice($query, $office_id)
    {
        return $query->whereHas('creator.office', function($queryb)  use ($office_id){
            $queryb->where('id', $office_id);
        });
    }

    public function scopeWorker($query, $worker_id)
    {
        return $query->where('supplier_id',$worker_id);
    }

    public function scopeCreator($query, $keyword)
    {
        return $query->whereHas('creator', function($queryb)  use ($keyword){
            $queryb->where('name', 'LIKE','%'.$keyword.'%');
        });
    }

    public function scopeOrderDateFrom($query, $date)
    {
        return $query->whereDate('created_at','>=', $date);
    }

    public function scopeOrderDateTo($query, $date)
    {
        return $query->whereDate('created_at','<=', $date);
    }

    public function scopeShippingDateFrom($query, $date)
    {
        return $query->whereHas('delivery', function($queryb)  use ($date){
            return $queryb->whereDate('shipping_date','>=', $date);
        });
    }

    public function scopeShippingDateTo($query, $date)
    {
        return $query->whereHas('delivery', function($queryb)  use ($date){
            return $queryb->whereDate('shipping_date','<=', $date);
        });
    }

    public function scopeReceivedDateFrom($query, $date)
    {
        return $query->whereHas('delivery', function($queryb)  use ($date){
            return $queryb->whereDate('received_date','>=', $date);
        });
    }

    public function scopeReceivedDateTo($query, $date)
    {
        return $query->whereHas('delivery', function($queryb)  use ($date){
            return $queryb->whereDate('received_date','<=', $date);
        });
    }

    public function scopeSortArray($query , $array)
    {
        $query->orderBy('id', $array['orderDate'])
        ->orderBy(Delivery::select('name')
            ->whereColumn('deliveries.shipping_date', 'guides.id')
        )     ;
        /*
        ->whereHas('delivery', function($queryb)  use ($array){
            return $queryb->orderBy('shipping_date', $array['shippingDate']);
        });
*/

        /*
        ->whereHas('delivery', function($queryb)  use ($array){
            return $queryb->orderBy('received_date', $array['receivedDate']);
        });
        */
    }
}
