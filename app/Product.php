<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    // protected $fillable = ['name'];
    protected $guarded = ['font_size_enable', 'files'];

    protected $casts = ['pattern_text' => 'array', 'printing_color' => 'array'];

    protected $appends = ['file_array'];

    public function getFileArrayAttribute($value)
    {
        return $this->files()->get();
    }

    public function files()
    {
        return $this->hasMany(File::class);
    }

    public function guide()
    {
        return $this->belongsTo(Guide::class);
    }
}
