<?php

namespace App\Commands\User;

use Spatie\LaravelData\Attributes\MapInputName;
use Spatie\LaravelData\Attributes\Validation\Email;
use Spatie\LaravelData\Attributes\Validation\Max;
use Spatie\LaravelData\Attributes\Validation\Min;
use Spatie\LaravelData\Attributes\Validation\StringType;
use Spatie\LaravelData\Attributes\Validation\Unique;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Mappers\SnakeCaseMapper;

#[MapInputName(SnakeCaseMapper::class)]
class CreateUserCommand extends Data
{
    #[StringType]
    public string $name;
    #[StringType, Email, Unique('users', 'email')]
    public string $email;
    #[StringType, Min(8), Max(255)]
    public string $password;
}
