<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon; 

class Guide extends Model
{
    protected $guarded = ['id', 'clone_id'];

    protected $casts = [
        'created_at'  => 'date:Y/m/d',
        'shipping_at'  => 'date:Y/m/d',
        'received_at'  => 'date:Y/m/d',
        'price'         => 'array'
    ];

    // protected $appends = ['first_product','creator'];

    // Accessor

    public function getCreatedAtAttribute($val)
    {
        return Carbon::parse($val)->format('Y-m-d');
    }

    public function getFirstProductAttribute($val)
    {
        return $this->products()->select('name')->first();
    }

    public function getCreatorAttribute($val)
    {
        return $this->creator()->select('name')->first();
    }

    // Relationship

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

    public function dupplicate()
    {
        return $this->belongsTo(Guide::class, 'clone_id');
    }

    // Scope

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

    public function scopeHasPer($query)
    {
        $type = auth()->user()->role->type;
        $arrayAllow = ['admin', 'instruction_manager'];
        if(in_array($type, $arrayAllow))
            return false ; 
        $current_id = auth()->user()->id;
        return $query->where('user_id', $current_id)
                    ->orWhere('supplier_id', $current_id);
    }

    public function scopeIsWorker($query)
    {
        return $query->orWhere('supplier_id', auth()->user()->id);
    }

    public function scopeSortArray($query , $array)
    {
        $query->orderBy('created_at', $array['orderDate'])
        ->orderBy('shipping_date', $array['shippingDate'])
        ->orderBy('received_date', $array['receivedDate']);
    }

    public function scopeKeyword($query, $keyword)
    {
        $keyword = array_filter($keyword);
        if(empty($keyword)) return false ; 
        return $query->where(function($q) use ($keyword) {
            foreach ($keyword as $key) {
                $q->Where('title', 'LIKE', '%' . $key . '%');
            }
         });
    }
}
