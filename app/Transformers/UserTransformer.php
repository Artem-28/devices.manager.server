<?php

namespace App\Transformers;

use App\Models\User;
use League\Fractal;

class UserTransformer extends Fractal\TransformerAbstract
{
    public function transform(User $user): array
    {
        return [
            'id' => $user->id,
            'email' => $user->email,
            'name' => $user->name,
            'surname' => $user->surname,
            'patronymic' => $user->patronymic,
            'birthday' => $user->birthday,
            'phone' => $user->phone,
            'avatar' => $user->avatar,
            'permissions' => $user->permissions,
        ];
    }
}
