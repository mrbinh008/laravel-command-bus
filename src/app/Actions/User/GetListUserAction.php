<?php

namespace App\Actions\User;

use App\Models\User;
use Illuminate\Pagination\LengthAwarePaginator;

readonly class GetListUserAction
{
    public function __construct(
        private User $model
    )
    {
    }

    public function handle(array $filter = [], array $with = [], string $sort = 'desc'): LengthAwarePaginator
    {
        return $this->model->query()
            ->where($filter)
            ->with($with)
            ->orderBy('created_at', $sort)
            ->paginate();
    }
}
