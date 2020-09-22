<?php

namespace App\Policies;

use App\User;
use App\Guide;
use Illuminate\Auth\Access\HandlesAuthorization;

class GuidePolicy
{
    use HandlesAuthorization;

    public function hasPer($user)
    {
        $array_allow =  ['admin','instruction_manager', 'worker'];
        $user_role = $user->role->type;
        return in_array($user_role, $array_allow);
    }
    
    public function view(User $user, Guide $guide)
    {
        if(!$this->hasPer($user))
            return false;
        if($user->role->type == "worker" && $guide->supplier_id != $user->id )
            return false;
        return true;
    }

    public function update(User $user, Guide $guide)
    {
        $canUpdate = false;
        if($user->role->type == "admin")
            $canUpdate = true;
        if($user->id == $guide->user_id)
            $canUpdate= true;
        return $canUpdate;
    }

    public function create(User $user)
    {
        $array_allow =  ['admin','instruction_manager'];
        $user_role = $user->role->type;
        return in_array($user_role, $array_allow);
    }

    public function list(User $user)
    {
        return $this->hasPer($user);
        /*
        $array_allow =  ['admin','instruction_manager', 'worker'];
        $user_role = $user->role->type;
        return in_array($user_role, $array_allow);
        */
    }
    
}
