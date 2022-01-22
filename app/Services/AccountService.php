<?php

namespace App\Services;

use App\Models\Account;

class AccountService
{
    // Создание нового аккаунта
    public function createAccount($title): Account
    {
        $account = new Account([
            'title' => $title
        ]);
        $account->save();
        return $account;
    }
}
