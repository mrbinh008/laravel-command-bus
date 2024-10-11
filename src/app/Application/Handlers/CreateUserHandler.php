<?php

namespace App\Application\Handlers;


use App\Application\Actions\CreateUserAction;
use App\Domain\User\CreateUserData;
use App\Infrastructure\Database\Models\User;

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
