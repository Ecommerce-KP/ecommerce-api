<?php

namespace App\Exceptions;

use App\Traits\ApiResponse;
use Throwable;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class Handler extends ExceptionHandler
{
    use ApiResponse;

    /**
     * The list of the inputs that are never flashed to the session on validation exceptions.
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
        $this->reportable(function (Throwable $e, Request $request) {
            if ($request->is('api/*')) {
                Log::error('Request error: ' . $e->getMessage());
                return match (true) {
                    $e instanceof AuthenticationException => $this->sendError(__('common.unauthorized'), null, Response::HTTP_UNAUTHORIZED),
                    $e instanceof NotFoundHttpException => $this->sendError(__('common.not_found'), null, Response::HTTP_NOT_FOUND),
                    $e instanceof MethodNotAllowedHttpException => $this->sendError(__('common.method_not_allowed'), null, Response::HTTP_METHOD_NOT_ALLOWED),
                    $e instanceof AccessDeniedHttpException => $this->sendError(__('common.forbidden'), null, Response::HTTP_FORBIDDEN),
                    $e instanceof HttpException => $this->sendError($e->getMessage(), null, $e->getStatusCode()),
                    default => $this->sendError(__('common.server_error')),
                };
            }
        });
    }
}
