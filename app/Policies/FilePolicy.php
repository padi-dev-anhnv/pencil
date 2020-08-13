<?php

namespace App\Policies;

use App\User;
use App\File;
use Illuminate\Auth\Access\HandlesAuthorization;

class FilePolicy
{
    use HandlesAuthorization;
    
    public function list(User $user)
    {
        $array_allow =  ['admin', 'file_manager', 'instruction_manager'];
        $user_role = $user->role->type;
        return in_array($user_role, $array_allow);
    }

    public function delete(User $user, File $file)
    {
        if($user->id === $file->user_id || $user->role->type == 'admin')
            return true;
        return false;
    }
}
