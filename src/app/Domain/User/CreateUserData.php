<?php

namespace App\Domain\User;

use Spatie\LaravelData\Attributes\MapInputName;
use Spatie\LaravelData\Attributes\Validation\Email;
use Spatie\LaravelData\Attributes\Validation\StringType;
use Spatie\LaravelData\Attributes\Validation\Unique;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Mappers\SnakeCaseMapper;

#[MapInputName(SnakeCaseMapper::class)]
class CreateUserData extends Data
{
    #[StringType]
    public string $name;
    #[Email, StringType,Unique('users', 'email')]
    public string $email;
    #[StringType]
    public string $password;
}
