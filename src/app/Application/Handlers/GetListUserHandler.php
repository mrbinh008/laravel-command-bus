<?php

namespace App\Application\Handlers;

use App\Application\Actions\GetListUserAction;
use App\Domain\Shared\Queries\BaseGetListQuery;
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
