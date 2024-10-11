<?php

namespace App\Domain\User;

use App\Infrastructure\Database\Models\User;
use Spatie\LaravelData\Attributes\MapInputName;
use Spatie\LaravelData\Attributes\Validation\Email;
use Spatie\LaravelData\Attributes\Validation\StringType;
use Spatie\LaravelData\Attributes\Validation\Unique;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Mappers\SnakeCaseMapper;
use Spatie\LaravelData\Support\Validation\References\RouteParameterReference;

#[MapInputName(SnakeCaseMapper::class)]
class UpdateUserData extends Data
{
    public User $user;
    #[StringType]
    public string $name;
    #[Email, StringType, Unique('users', 'email', ignore: new RouteParameterReference('user', 'id'))]
    public string $email;
}
