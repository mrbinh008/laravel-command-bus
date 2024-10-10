<?php

namespace App\Application\Actions;

use App\Infrastructure\Database\Models\User;
use Illuminate\Pagination\LengthAwarePaginator;

readonly class GetListUserAction
{
    public function __construct(
        private User $model
    )
    {
    }

    public function getList(array $filter = [], array $with = [], string $sort = 'desc'): LengthAwarePaginator
    {
        return $this->model->query()
            ->where($filter)
            ->with($with)
            ->orderBy('created_at', $sort)
            ->paginate();
    }
}
