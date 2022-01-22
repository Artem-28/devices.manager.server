<?php
namespace App\Traits;


use App\Models\Role;

trait Permission
{
    protected function checkPermissionAdmin($user): bool
    {
        if (!empty($user)) {
            return $user->tokenCan(Role::ADMIN);
        }
        return false;
    }

    protected function checkPermissionOperator($user): bool
    {
        if (!empty($user)) {
            return $user->tokenCan(Role::OPERATOR);
        }
        return false;
    }

    protected function checkPermission($user)
    {
        if (!empty($user)) {
            return $user->tokenCan($user->permissions);
        }
        return false;
    }
}
