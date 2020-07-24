<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class File extends Model
{
    public static $extAllow = ['jpg',  'png', 'jpeg','gif','ai', 'psd',  'pdf', 'xlsx','docx','pptx'] ;
    public static $extPic = ['jpg', 'gif', 'png', 'jpeg'];

    protected $fillable = ['user_id', 'name', 'link', 'description', 'tags', 'material', 'type'];    

    protected $appends = ['thumbnail'];
    
    protected $casts = [
        'created_at' => 'datetime:Y-m-d',
    ];

    public static function findThumbnail($link)
    {
        if(!$link)
            return '';
        $info = pathinfo($link);
        $ext = $info['extension'];
        $arrayExt = self::$extPic ;
        if(in_array($ext, $arrayExt))
            return 'storage/thumbnail/'. $info['filename'] . '-thumbnail.' . $ext;
        else
            return 'https://via.placeholder.com/1740x1445?text=' . $ext;
    }

    public function getThumbnailAttribute($key)
    {   
        return self::findThumbnail($this->link);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function scopeAuthor($query, $author_id)
    {
        return $query->where('user_id', $author_id);
    }

    public function scopeDateFrom($query, $date)
    {
        return $query->whereDate('created_at','>=', $date);
    }

    public function scopeDateTo($query, $date)
    {
        return $query->whereDate('created_at','<=', $date);
    }

    public function scopeKey($query, $author_id)
    {
        return $query->where('user_id', $author_id);
    }

    public function scopeMaterial($query, $material)
    {
        return $query->whereIn('material', explode(',' , $material));
    }

    public function scopeOffice($query, $office_id)
    {
        return $query->whereHas('user.office', function($queryb)  use ($office_id){
            $queryb->where('id', $office_id);
        });
    }

    public function scopeKeyword($query, $key)
    {
        // return $query->whereRaw('MATCH (description, tags, name, link) AGAINST (?)' , array($key));
        return $query->where('name','LIKE','%'.$key.'%')
        ->orWhere('link','LIKE','%'.$key.'%')
        ->orWhere('description','LIKE','%'.$key.'%')
        ->orWhere('tags','LIKE','%'.$key.'%')
        ->orWhereHas('user', function($query) use ($key) {
            $query->where('name','LIKE','%'.$key.'%');
        })
        ->orWhereHas('user.office', function($query) use ($key) {
            $query->where('name','LIKE','%'.$key.'%');
        })
        ;
    }

    public function getFileUrl($link)
    {
        $info = pathinfo($link);
        $ext = $info['extension'];
        $file_name = $info['filename'];
        $arrayExt = ['jpg', 'jpeg', 'gif', 'png'];
        $dir_file = '/public/files';
        $dir_thumbnail = '/public/thumbnail/';

        $array_url = [];
        $array_url['file'] = $link; 
        if(in_array($ext, $arrayExt)){
            return 'storage/thumbnail/'. $file_name . '-thumbnail.' . $ext;
        }            
        else{
            return 'https://via.placeholder.com/1740x1445?text=' . $ext;
        }
            
    }
}
