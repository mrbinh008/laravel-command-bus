<?php

namespace Domain\User\Actions;

use Domain\User\Models\User;

class CreateUserAction
{
    public function handle(array $payload): User
    {
        return User::query()->create($payload);
    }
}
