<?php

namespace App\Handlers\User;

use App\Actions\User\DeleteUserAction;
use App\Models\User;

readonly class DeleteUserHandler
{
    public function __construct(
        private DeleteUserAction $deleteUserAction,
    )
    {
    }

    public function handle(User $user): int
    {
        return $this->deleteUserAction->handle($user);
    }
}
