<?php

namespace App\Application\Actions;

use App\Infrastructure\Database\Models\User;

class UpdateUserAction
{
    public function handle(User $user,array $payload): int
    {
        return $user->update($payload);
    }
}
