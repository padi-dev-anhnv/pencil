<?php
namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon; 

class Guide extends Model
{
    protected $guarded = ['id', 'clone_id', 'creator'];

    protected $casts = [
        'created_at'  => 'date:Y/m/d',
        'shipping_at'  => 'date:Y/m/d',
        'received_at'  => 'date:Y/m/d',
        'price'         => 'array',
        'products'         => 'array',
    ];

    protected $appends = ['first_product','creator'];

    protected $keywordSearch = [
        'title', 'number', 'store_code', 'last_numb', 'customer_name', 'curator',
        // ''
    ];

    // Accessor


    public function setCreatedAtAttribute($val)
    {
        $this->attributes['created_at'] = empty($val) ? now() :  $val ;  
            
    }

    public function getCreatedAtAttribute($val)
    {
        return Carbon::parse($val)->format('Y-m-d');
    }

    public function getFirstProductAttribute($val)
    {
        return $this->products;
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
    public function office()
    {
        return $this->belongsTo(Office::class);
    }

    public function dupplicate()
    {
        return $this->belongsTo(Guide::class, 'clone_id');
    }

    public function files()
    {
        return $this->hasMany(File::class);
    }


    // Scope

    public function scopeOffice($query, $office_id)
    {
        return $query->where('office_id', $office_id);
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
        if(!$array['orderDate'] && !$array['shippingDate'] && !$array['receivedDate'])
            $query->orderBy('id', 'desc');
        if(!empty($array['orderDate']))
            $query->orderBy('created_at', $array['orderDate']);
        if(!empty($array['shippingDate']))
            $query->orderBy('created_at', $array['shippingDate']);
        if(!empty($array['receivedDate']))
            $query->orderBy('created_at', $array['receivedDate']);
    }

    public function scopeKeyword($query, $keyword)
    {
        $keyword = array_filter($keyword);
        if(empty($keyword)) return false ;
        $query->whereLike($this->keywordSearch, $keyword);
    }

    public static function boot ()
    {
        parent::boot();
        self::deleting(function ($guide) {
           $guide->delivery()->delete();
           $guide->packaging()->delete();
           $guide->procedure()->delete();
           $guide->files()->delete();
        });
    }
}
