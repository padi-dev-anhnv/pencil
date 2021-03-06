<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class File extends Model
{
    public static $extAllow = ['jpg',  'png', 'jpeg','gif','ai', 'psd',  'pdf', 'xlsx','docx','pptx', 'xls', 'doc', 'ppt'] ;
    public static $extPic = ['jpg', 'gif', 'png', 'jpeg'];
    public static $fileDir = '/public/files/';
    public static $fileThumbnail = '/public/thumbnail/';

    protected $fillable = ['user_id', 'name', 'link', 'description', 'tags', 'material', 'type', 'guide_id', 'office'];    

    protected $appends = ['thumbnail', 'creator'];
    
    protected $casts = [
        'created_at' => 'datetime:Y-m-d',
    ];

    public function getCreatorAttribute($val)
    {

        if($this->guide && $this->guide->old_creator)
            return  $this->guide->old_creator;
        else 
            return $this->user;
        
    }

    public static function hasThumbnail($link)
    {
        if(!$link)
            return false;
        $info = pathinfo($link);
        $ext = isset($info['extension']) ? $info['extension'] : '';
        $arrayExt = self::$extPic ;
        $thumbnail = []; 
        if(in_array($ext, $arrayExt))
            $thumbnail['thumbnail']  = $info['filename'] . '-thumbnail.' . $ext;
        else
            $thumbnail['ext'] = $ext;
        return $thumbnail;
    }


    public static function findThumbnail($link)
    {
        $file = self::hasThumbnail($link) ;
        if($file == false)
            return '';
        if(isset($file['thumbnail']))
            return  asset('storage/thumbnail/'. $file['thumbnail']);
        else
            return 'https://via.placeholder.com/1740x1445?text=' . $file['ext'];
    }

    public function getThumbnailAttribute($key)
    {   
        return self::findThumbnail($this->link);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function guide()
    {
       return $this->belongsTo(Guide::class)->select('id', 'number', 'supplier_id', 'old_creator');
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
            $queryb->where('office', $office_id);
        });
    }

    public function scopeKeyword($query, $key)
    {
        return $query->where('name','LIKE','%'.$key.'%')
        ->orWhere('link','LIKE','%'.$key.'%')
        ->orWhere('description','LIKE','%'.$key.'%')
        ->orWhere('tags','LIKE','%'.$key.'%')
        ->orWhereHas('user', function($query) use ($key) {
            $query->where('name','LIKE','%'.$key.'%');
        })
        ->orWhereHas('guide', function($query) use ($key) {
            $query->where('number',$key);
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

    public static function boot ()
    {
        parent::boot();
        self::deleting(function ($file) {
            Storage::disk('public')->delete('files/'.$file->link); 
            $thumbnail = self::hasThumbnail($file->link);
            if(isset($thumbnail['thumbnail']))
                Storage::disk('public')->delete('thumbnail/'.$thumbnail['thumbnail']); 
        });
    }
}
