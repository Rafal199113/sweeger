<?php

namespace App\Exceptions;

use GuzzleHttp\Exception\ClientException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Throwable;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;

class Handler extends ExceptionHandler
{
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
        $this->reportable(function (Throwable $e) {
            //
        });
    }

    /**
     * Render the exception into an HTTP response.
     */
    public function render($request, Throwable $exception)
    {
        $url = $request->fullUrl();

        if ($exception instanceof ClientException) {
            if ($exception->getCode() === 404) {
                return response()->view('errors.404', ['url' => $url], 404);
            }
        }

        return parent::render($request, $exception);
    }
}
