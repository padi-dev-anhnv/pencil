<?php

namespace App\Policies;

use App\User;
use App\Guide;
use Illuminate\Auth\Access\HandlesAuthorization;

class GuidePolicy
{
    use HandlesAuthorization;
    
    public function create(User $user)
    {
        $array_allow =  ['admin','instruction_manager'];
        $user_role = $user->role->type;
        return in_array($user_role, $array_allow);
    }
}
