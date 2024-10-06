<?php

namespace App\Domain\Shared\Queries;

readonly class BaseGetListQuery
{
    public function __construct(
        private array  $filter = [],
        private array  $with = [],
        private string $sort = 'desc'
    ) {}

    public function getFilter(): array
    {
        return $this->filter;
    }

    public function getWith(): array
    {
        return $this->with;
    }

    public function getSort(): string
    {
        return $this->sort;
    }
}
