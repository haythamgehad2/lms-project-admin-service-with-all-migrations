<?php

namespace App\Mapper;

use App\Models\User;

class UserMapper
{
    public function map(User $user): array
    {
        return [
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
            'images' => $user->getFirstMediaUrl('users_pp', 'thumb')
        ];
    }
}
