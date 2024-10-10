<?php

namespace App\Application\Actions;

use App\Infrastructure\Database\Models\User;

class CreateUserAction
{
    public function handle(array $payload): User
    {
        return User::query()->create($payload);
    }
}
