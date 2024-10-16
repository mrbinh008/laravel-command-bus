<?php

namespace App\Exceptions;

use App\Traits\ResponseApiTrait;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Throwable;

class Handler extends ExceptionHandler
{
    use ResponseApiTrait;

    /**
     * A list of exception types with their corresponding custom log levels.
     *
     * @var array<class-string<Throwable>, \Psr\Log\LogLevel::*>
     */
    protected $levels = [
        ModelNotFoundException::class => 'warning',
        ValidationException::class => 'warning',
        MethodNotAllowedHttpException::class => 'warning',
        QueryException::class => 'error',
        \Exception::class => 'error',
    ];

    /**
     * A list of the exception types that are not reported.
     *
     * @var array<int, class-string<Throwable>>
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     */
    public function register(): void
    {
        $this->reportable(function (Throwable $e) {
            foreach ($this->levels as $class => $level) {
                if ($e instanceof $class) {
                    Log::log($level, $e->getMessage());
                }
            }
        });
    }

    public function render($request, Throwable $e): Response|JsonResponse
    {
        if ($request->expectsJson()) {
            return $this->handleApiException($e);
        }

        return parent::render($request, $e);
    }

    protected function handleApiException(Throwable $e): JsonResponse
    {
        if ($e instanceof NotFoundHttpException) {
            return $this->responseError(
                Response::HTTP_NOT_FOUND,
                'Not found',
                Response::HTTP_NOT_FOUND,
            );
        }

        if ($e instanceof ModelNotFoundException) {
            return $this->responseError(
                Response::HTTP_NOT_FOUND,
                'Model not found',
                Response::HTTP_NOT_FOUND,
            );
        }

        if ($e instanceof QueryException) {
            Log::error($e->getMessage());

            return $this->responseError(
                Response::HTTP_INTERNAL_SERVER_ERROR,
                'Query error',
                Response::HTTP_INTERNAL_SERVER_ERROR,
            );
        }
        if ($e instanceof ValidationException) {
            return $this->responseError(
                Response::HTTP_UNPROCESSABLE_ENTITY,
                $e->validator->errors(),
                Response::HTTP_UNPROCESSABLE_ENTITY,
            );
        }
        if ($e instanceof MethodNotAllowedHttpException) {
            return $this->responseError(
                Response::HTTP_METHOD_NOT_ALLOWED,
                'Method not allowed',
                Response::HTTP_METHOD_NOT_ALLOWED,
            );
        }
        if ($e instanceof AuthenticationException) {
            return $this->responseError(
                Response::HTTP_UNAUTHORIZED,
                'Unauthenticated',
                Response::HTTP_UNAUTHORIZED,
            );
        }

        if ($e instanceof AuthorizationException) {
            return $this->responseError(
                Response::HTTP_FORBIDDEN,
                'FORBIDDEN',
                Response::HTTP_FORBIDDEN,
            );
        }

        return $this->responseError(
            Response::HTTP_INTERNAL_SERVER_ERROR,
            $e->getMessage(),
            Response::HTTP_INTERNAL_SERVER_ERROR,
        );
    }
}
