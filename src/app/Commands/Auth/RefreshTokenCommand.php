<?php

namespace App\Commands\Auth;

use Spatie\LaravelData\Attributes\MapInputName;
use Spatie\LaravelData\Attributes\Validation\StringType;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Mappers\SnakeCaseMapper;

#[MapInputName(SnakeCaseMapper::class)]
class RefreshTokenCommand extends Data
{
    public function __construct(
        #[StringType]
        public string $refreshToken,
    ) {}
}
