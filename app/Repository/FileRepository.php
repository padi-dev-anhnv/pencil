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
        $file = $this->file::with('user.office', 'guide')->findOrFail($id);
        // check permission view        
        $user = auth()->user();
        if (!$user->can('view', $file)) {
            return redirect('guide');
        }

        $file_user = $file->user->name;
        unset($file->user);
        if($file->guide){
            $file->number_guide = $file->guide->number;
        }
        $file->user = $file_user;
        $file->canEdit = false;
        if ($user->can('delete', $file)) {
            $file->canEdit = true;
        }
        return response()->json($file);
    }

    public function create($request)
    {
        if($request['id']){
            $file = $this->file::find($request['id']);
            if(auth()->user()->cannot('delete', $file))
                return ['success' => false];
        }   

        if(empty($request['id'])){
            $request['user_id'] = auth()->user()->id;  
            $request['office'] = auth()->user()->office ? auth()->user()->office->name : '' ;
        }
                      
        $file = $this->file::updateOrCreate(['id' =>$request['id']],$request);
        return $file;
    }

    public function delete($request)
    {
        
        $file = $this->file::find($request->id);
        if($request->user()->can('delete', $file)){
            $file->delete();
            return ['success' => true];
        }            
        return ['success' => false , 'message' => config('errors.can_not_delete_file')];
    }
}


?>