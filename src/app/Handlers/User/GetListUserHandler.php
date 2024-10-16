<?php

namespace App\Handlers\User;

use App\Actions\User\GetListUserAction;
use App\Share\BaseGetListQuery;
use Illuminate\Pagination\LengthAwarePaginator;

readonly class GetListUserHandler
{
    public function __construct(
        private GetListUserAction $getListUserAction,
    )
    {
    }

    public function handle(BaseGetListQuery $query): LengthAwarePaginator
    {
        return $this->getListUserAction->handle($query->getFilter(), $query->getWith(), $query->getSort());
    }
}
