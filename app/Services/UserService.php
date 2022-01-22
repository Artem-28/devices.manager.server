<?php

namespace App\Services;

use App\Models\Account;
use App\Models\User;

class UserService
{
    // Создание нового пользователя
    public function createUser(Account $account, $data): User
    {
        $user = new User([
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
        ]);
        $account->users()->save($user);
        return  $user;
    }

    public function getUserByLogin($login)
    {
       return User::where('email', $login)->first();
    }

    public function getUserPermissions($user)
    {
        $permissions = $user->roles();
        dd($permissions);
    }
}
