<?php

namespace App\Domain\User\Actions;

use Domain\User\Models\User;
use Illuminate\Pagination\LengthAwarePaginator;

class GetListUserAction
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
