<?php

namespace App\Policies;

use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;
    
    public function list(User $user)
    {
        $array_allow = ['admin'];
        $user_role = $user->role->type;
        return in_array($user_role, $array_allow);
    }
}
