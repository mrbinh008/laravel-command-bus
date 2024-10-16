<?php

namespace App\Traits;

use Illuminate\Http\JsonResponse;
use Spatie\LaravelData\PaginatedDataCollection;
use Symfony\Component\HttpFoundation\Response;

trait ResponseApiTrait
{
    public function responseOk(mixed $data = null, int $code = Response::HTTP_OK): JsonResponse
    {
        $output = [
            'data' => $data,
        ];

        return response()->json($output, $code);
    }

    public function responsePaginate(PaginatedDataCollection $data, int $code = Response::HTTP_OK): JsonResponse
    {
        $output = [
            'data' => $data->all(),
            'meta' => [
                'total' => $data->items()->total(),
                'per_page' => $data->items()->perPage(),
                'current_page' => $data->items()->currentPage(),
            ],
        ];

        return response()->json($output, $code);
    }

    public function responseError(string|int $errorCode, mixed $message, int $code, mixed $data = null): JsonResponse
    {
        $output = [
            'data' => $data,
            'errors' => [
                'error_code' => $errorCode,
                'error_message' => $message,
            ],
        ];

        return response()->json($output, $code);
    }
}
