<?php
namespace App\Repository;

use App\File;
use Illuminate\Database\Eloquent\Builder;

class FileRepository
{
    protected $file;

    public function __construct(File $file)
    {
        $this->file = $file;
    }

    public function search($request)
    {
        $query = File::query();

        $arrayFilter = ['author', 'dateFrom', 'dateTo', 'material', 'office', 'keyword'];
        foreach($arrayFilter as $filter)
        {
            if(isset($request[$filter]))
                call_user_func_array(array($query, $filter), array($request[$filter]));
        }        

        $files = $query->select('id', 'type', 'created_at', 'link', 'name')->orderBy('created_at', 'desc')->paginate($request['ppp']);
        return $files;
    }

    public function show($id)
    {
        $file = $this->file::with('user.office', 'product.guide:number,id')->findOrFail($id);
        $file->office = $file->user->office->name;
        $file_user = $file->user->name;
        unset($file->user);
        if($file->product){
            $file->number_guide = $file->product->guide->number;
            unset($file->product);
        }
            
        $file->user = $file_user;
        return response()->json($file);
    }

    public function create($request)
    {
        $request['user_id'] = auth()->user()->id;
        $file = $this->file::updateOrCreate(['id' =>$request['id']],$request);
        return $file;
    }
}


?>