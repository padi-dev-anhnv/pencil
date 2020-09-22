<?php
namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon; 
use App\Traits\GuideScope;

class Guide extends Model
{
    use GuideScope;
    protected $guarded = ['id', 'clone_id', 'creator'];
    protected $hidden = ['key_code'];
    protected $casts = [
        'created_at'  => 'date:Y/m/d',
        'shipping_at'  => 'date:Y/m/d',
        'received_at'  => 'date:Y/m/d',
        'price'         => 'array',
        'products'         => 'array',
        // 'old_creator'   => 'array'
    ];

    protected $appends = ['first_product','creator'];

    protected $keywordSearch;
    
    public function __construct()
    {
        $this->keywordSearch = config('guidesearch.fields');
    }

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
        // return $this->creator()->select('name')->first();
        if($this->old_creator)
            $creator = ['id' => 9999, 'name' => $this->old_creator];
        else
            $creator = $this->creator()->select('name', 'id')->first()->toArray();
        return $creator;
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
    /*
    public function products()
    {
        return $this->hasMany(Product::class);
    }
    */
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
