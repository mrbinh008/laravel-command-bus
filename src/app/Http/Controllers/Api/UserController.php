<?php

namespace App\Http\Controllers\Api;

use App\Commands\User\CreateUserCommand;
use App\Commands\User\UpdateUserCommand;
use App\Commands\User\UserData;
use App\Handlers\User\CreateUserHandler;
use App\Handlers\User\DeleteUserHandler;
use App\Handlers\User\GetListUserHandler;
use App\Handlers\User\UpdateUserHandler;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Share\BaseGetListQuery;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Bus;
use Spatie\LaravelData\PaginatedDataCollection;
use Spatie\RouteAttributes\Attributes\Delete;
use Spatie\RouteAttributes\Attributes\Get;
use Spatie\RouteAttributes\Attributes\Post;
use Spatie\RouteAttributes\Attributes\Prefix;
use Spatie\RouteAttributes\Attributes\Put;
use Spatie\RouteAttributes\Attributes\Where;
use Spatie\RouteAttributes\Attributes\WhereNumber;

#[Prefix('users')]
class UserController extends Controller
{
    public function __construct(
        private readonly CreateUserHandler  $createUserHandler,
        private readonly GetListUserHandler $getListUserHandler,
        private readonly UpdateUserHandler  $updateUserHandler,
        private readonly DeleteUserHandler  $deleteUserHandler,
    )
    {
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    #[Get('/', name: 'user.index')]
    public function index(Request $request): JsonResponse
    {
        $filter = [];
        $sort = $request->get('sort', 'desc');
        $query = new BaseGetListQuery($filter, [], $sort);

        $result = Bus::dispatchNow($query, $this->getListUserHandler);

        return $this->responsePaginate(UserData::collect($result, PaginatedDataCollection::class));
    }

    /**
     * @param User $user
     * @return JsonResponse
     */
    #[Get('/{user}', name: 'user.show')]
    #[Where('user', '[0-9]+')]
    public function show(User $user): JsonResponse
    {
        return $this->responseOk(UserData::from($user));
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    #[Post('/', name: 'user.store')]
    public function store(Request $request): JsonResponse
    {
        $command = CreateUserCommand::from([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => $request->input('password'),
        ]);
        $result = Bus::dispatchNow($command, $this->createUserHandler);

        return $this->responseOk(UserData::from($result));
    }

    /**
     * @param Request $request
     * @param User $user
     * @return JsonResponse
     */
    #[Put('/{user}', name: 'user.update')]
    #[WhereNumber('user')]
    public function update(Request $request, User $user): JsonResponse
    {
        $command = UpdateUserCommand::from([
            'user' => $user,
            'name' => $request->input('name'),
            'email' => $request->input('email'),
        ]);
        $result = Bus::dispatchNow($command, $this->updateUserHandler);

        return $this->responseOk($result);
    }

    /**
     * @param User $user
     * @return JsonResponse
     */
    #[Delete('/{user}', name: 'user.destroy')]
    #[WhereNumber('user')]
    public function destroy(User $user): JsonResponse
    {
        $result = Bus::dispatchNow($user, $this->deleteUserHandler);

        return $this->responseOk($result);
    }
}
