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

    // Является ли авторизованная сущность устройством
    protected function checkPermissionControlDevice($controlDevice)
    {
        if(!empty($controlDevice)) {
            return $controlDevice->tokenCan(Role::CONTROL_DEVICE);
        }
        return false;
    }

    // Является ли авторизованная сущность пользователем
    protected function checkPermissionUser($user)
    {
        if (!empty($user)) {
            return $user->tokenCan(Role::USER);
        }
        return false;
    }
}
