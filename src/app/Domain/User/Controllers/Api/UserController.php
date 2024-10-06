<?php

namespace App\Domain\User\Controllers\Api;

use App\Domain\Shared\Queries\BaseGetListQuery;
use App\Domain\User\Handlers\CreateUserHandler;
use App\Domain\User\Handlers\GetListUserHandler;
use Domain\User\Data\CreateUserData;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Bus;
use Spatie\RouteAttributes\Attributes\Prefix;
use Spatie\RouteAttributes\Attributes\Route;

#[prefix('users')]
class UserController
{
    /**
     * @throws BindingResolutionException
     */
    #[Route('GET', '/')]
    public function index(Request $request): JsonResponse
    {
        $filter = [];
        $sort = $request->input('sort', 'asc');

        $getUserListQuery = new BaseGetListQuery($filter, [], $sort);
        $getUserListHandler = app()->make(GetListUserHandler::class);
        $users = Bus::dispatchNow($getUserListQuery, $getUserListHandler);

        return response()->json($users);
    }

    /**
     * @throws BindingResolutionException
     */
    #[Route('POST', '/')]
    public function store(Request $request): JsonResponse
    {
        $updateUserCommand = CreateUserData::from([
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password,
        ]);
        $updateUserHandler = app()->make(CreateUserHandler::class);
        $result = Bus::dispatchNow($updateUserCommand, $updateUserHandler);

        return response()->json($result);
    }
}
