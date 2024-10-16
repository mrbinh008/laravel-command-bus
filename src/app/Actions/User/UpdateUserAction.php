<?php

namespace App\Actions\User;

use App\Models\User;

class UpdateUserAction
{
    /**
     * @param User $user
     * @param array $payload
     * @return int
     */
    public function handle(User $user, array $payload): int
    {
        return $user->update($payload);
    }
}
