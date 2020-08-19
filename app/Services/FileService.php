<?php
namespace App\Services;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use App\File;
use Image;

class FileService
{

    public function uploadFile($file)
    {
        $file_upload = $file;
        $suffix = Str::random(7);
        $full_name = $file_upload->getClientOriginalName();
        $file_name = pathinfo($full_name, PATHINFO_FILENAME);
        $extension = pathinfo($full_name, PATHINFO_EXTENSION);
        $new_name = $file_name . '-' . $suffix . '.' . $extension;
        $thumbnail_name = $file_name . '-' . $suffix.'-thumbnail.'.$extension;
        $dir = File::$fileDir;
        $dir_thumbnail = File::$fileThumbnail;
        $path = Storage::putFileAs($dir,$file_upload, $new_name);

        $file_thumbnail = File::findThumbnail($new_name);
        $arrayExt = File::$extPic ;
        if(in_array($extension, $arrayExt)){
            $thumbnail = Image::make($file_upload)->resize(800, null, function ($constraint) {
                $constraint->aspectRatio();
            })->stream($extension, 80);
            Storage::put($dir_thumbnail . $thumbnail_name, $thumbnail);
        }     

        return ['link' => $new_name, 'type' => $extension, 'file_thumbnail' => $file_thumbnail];
    }

    public function dupplicateFile($dir,  $link)
    {
        $suffix = Str::random(4);
        $full_name = $link;
        $file_name = pathinfo($full_name, PATHINFO_FILENAME);
        $extension = pathinfo($full_name, PATHINFO_EXTENSION);
        $new_name = $file_name . '-' . $suffix . '.' . $extension;
        Storage::copy($dir.$link, $dir.$new_name);
    }

    public function download($file_id)
    {
        $file = File::findOrFail($file_id);
        return Storage::download('public/files/' .$file->link);
    }
}