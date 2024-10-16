<?php

namespace App\Handlers\User;

use App\Actions\User\CreateUserAction;
use App\Commands\User\CreateUserCommand;
use App\Models\User;

readonly class CreateUserHandler
{
    public function __construct(
        private CreateUserAction $createUserAction,
    )
    {
    }

    public function handle(CreateUserCommand $command): User
    {
        return $this->createUserAction->handle($command->toArray());
    }
}
