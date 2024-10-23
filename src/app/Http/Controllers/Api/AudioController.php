<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\services\AudioService;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Spatie\RouteAttributes\Attributes\Post;
use Spatie\RouteAttributes\Attributes\Prefix;

#[Prefix('audio')]
class AudioController extends Controller
{
    public function __construct(
        private readonly AudioService $audioService
    )
    {
    }

    /**
     * @throws ConnectionException
     */
    #[Post('/', name: 'audio')]
    public function __invoke(Request $request): JsonResponse
    {
        $file = $request->file('audio');
        $result = $this->audioService->handle($file);

        return $this->responseOk($result);
    }
}
