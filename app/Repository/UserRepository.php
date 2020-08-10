<?php
namespace App\Repository;

use App\User;
use App\Office;
use Illuminate\Database\Eloquent\Builder;

class UserRepository
{
    protected $user;
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function create($payload)
    {
        if(!empty($payload['office'])){
            $office = Office::firstOrCreate(['name' => $payload['office']]);
            $payload['office_id'] = $office->id;
        }        
       
        User::updateOrCreate(['id' => $payload['id']],$payload);
    }

    public function list($request)
    {
        $users = User::notBanned()->orderBy('id', 'desc')->with('role','office')->paginate(10);
        return $users;
    }

    public function delete($id)
    {
        $user = User::find($id);
        $user->status = false ; 
        $user->save();
    }

    public function show($id)
    {
        $user = User::with('office')->find($id);
        return $user;
    }

    public function listUserPerFile()
    {
        $users = User::whereHas('role', function(Builder $query){
            $query->whereIn('type', ['admin', 'file_manager', 'instruction_manager']);
        })->get();
        return $users;

    }
}


?>