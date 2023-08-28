<?php
namespace App\Repositories;

use App\Models\User;
use App\Models\UserCredit;

class UserCreditRepository extends Repository
{
    public function model(): string
    {
        return UserCredit::class;
    }

    public function createByUser(User $user) : UserCredit {
        if (!$user->userCredit) $user->userCredit()->create();
        return $user->userCredit()->first();
    }
}
