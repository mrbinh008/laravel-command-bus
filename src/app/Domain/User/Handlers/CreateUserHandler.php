<?php

namespace App\Domain\User\Handlers;


use Domain\User\Actions\CreateUserAction;
use Domain\User\Data\CreateUserData;
use Domain\User\Models\User;

class CreateUserHandler
{
    private CreateUserAction $createUserAction;

    public function __construct(CreateUserAction $createUserAction)
    {
        $this->createUserAction = $createUserAction;
    }

    public function handle(CreateUserData $data): User
    {
        return $this->createUserAction->handle($data->toArray());
    }
}
