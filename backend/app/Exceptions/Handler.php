<?php

namespace App\Exceptions;

use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Throwable;
use Illuminate\Validation\ValidationException;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     *
     * @return void
     */
    public function register()
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }

    public function render($request, Throwable $e)
    {
        // This will replace our 404 response with
        // a JSON response.
        if ($e instanceof ModelNotFoundException &&
            $request->wantsJson())
        {
            return response()->json([
                'data' => 'Resource not found'
            ], 404);
        }

        return parent::render($request, $e);
    }

    /**
     * Create a response object from the given validation exception.
     *
     * @param ValidationException $e
     * @param  Request  $request
     * @return Response
     */
    protected function convertValidationExceptionToResponse(ValidationException $e, $request): Response
    {
        if ($e->response) {
            return $e->response;
        }

        return response()->json($e->validator->errors()->getMessages(), 422);
    }
}
