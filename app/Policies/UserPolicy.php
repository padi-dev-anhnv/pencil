<?php

namespace App\Policies;

use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function list(User $user)
    {
        $array_allow = ['admin'];
        $user_role = $user->role->name;
        return in_array($user_role, $array_allow);
    }
}
