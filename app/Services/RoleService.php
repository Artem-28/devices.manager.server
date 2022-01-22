<?php

namespace App\Services;

use App\Models\Role;
use App\Models\User;

class RoleService
{
    public function assignRoles(User $user, $roles)
    {
        $user->roles()->sync($roles);
    }
}
