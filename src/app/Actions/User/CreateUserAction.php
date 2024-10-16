<?php

namespace App\Actions\User;

use App\Models\User;

class CreateUserAction
{
    /**
     * @param array $payload
     * @return User
     */
    public function handle(array $payload): User
    {
        return User::query()->create($payload);
    }
}
