<?php

namespace App\Domain\User\Handlers;

use App\Domain\Shared\Queries\BaseGetListQuery;
use App\Domain\User\Actions\GetListUserAction;
use Illuminate\Pagination\LengthAwarePaginator;

readonly class GetListUserHandler
{
    public function __construct(
        private GetListUserAction $getListUserAction
    )
    {
    }

    public function handle(BaseGetListQuery $query): LengthAwarePaginator
    {
        return $this->getListUserAction->getList($query->getFilter(), $query->getWith(), $query->getSort());
    }
}
