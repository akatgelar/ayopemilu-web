<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;

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
            if (app()->bound('sentry')) {
                app('sentry')->captureException($e);
            }
        });
    }

    public function render($request, Throwable $exception)
    {
        if ($request->segment(1) == 'api') {
            return $this->handleApiException($request, $exception);
        }
        else if ($request->wantsJson()) {
            return $this->handleApiException($request, $exception);
        }
        else {
            $retval = parent::render($request, $exception);
        }

        return $retval;
    }

    private function handleApiException($request, Throwable $exception)
    {
        $exception = $this->prepareException($exception);

        if ($exception instanceof \Illuminate\Http\Exception\HttpResponseException) {
            $exception = $exception->getResponse();
        }

        if ($exception instanceof \Illuminate\Auth\AuthenticationException) {
            $exception = $this->unauthenticated($request, $exception);
        }

        if ($exception instanceof \Illuminate\Validation\ValidationException) {
            $exception = $this->convertValidationExceptionToResponse($exception, $request);
        }

        return $this->customApiResponse($exception);
    }

    private function customApiResponse($exception)
    {
        if (method_exists($exception, 'getStatusCode')) {
            $statusCode = $exception->getStatusCode();
        } else {
            $statusCode = 500;
        }

        $response = [];
        $response['status'] = false;
        $response['status_code'] = $statusCode;
        $response['message'] = 'Unknown error';
        $response['data'] = [];
        $response['pagination'] = [];

        switch ($statusCode) {
            case 302:
                // Redirect
                $statusCode = 401;
                $response['message'] = 'Unauthorized';
                break;
            case 401:
                $response['message'] = 'Unauthorized';
                break;
            case 403:
                $response['message'] = 'Forbidden';
                break;
            case 404:
                $response['message'] = 'Not Found';
                break;
            case 405:
                $response['message'] = 'Method Not Allowed';
                break;
            case 422:
                $response['message'] = $exception->original['message'];
                $response['data'] = $exception->original['errors'];
                break;
            case 500:
                $response['message'] = 'Internal server error, ' . $exception->getMessage();
            default:
                break;
        }

        // if (config('app.debug')) {
        //     $response['data'] = $exception->getTrace();
        // }

        $response['status_code'] = $statusCode;

        return response()->json($response, $statusCode);
    }
}
