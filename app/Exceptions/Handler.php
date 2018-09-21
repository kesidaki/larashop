<?php

namespace App\Exceptions;

use Exception;
use App\Traits\ApiResponser;
use Illuminate\Database\QueryException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Validation\ValidationException;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Session\TokenMismatchException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;

class Handler extends ExceptionHandler
{
    use ApiResponser;

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
        'password',
        'password_confirmation',
    ];

    /**
     * Report or log an exception.
     *
     * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
     *
     * @param  \Exception  $exception
     * @return void
     */
    public function report(Exception $exception)
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $exception
     * @return \Illuminate\Http\Response
     */
    /*public function render($request, Exception $exception) {
        if ($exception instanceof ValidationException) {
            return $this->convertValidationExceptionToResponse($exception, $request);
        }

        // Exception for when model is not found
        // Store name of model and return the error saying it does not exist
        if ($exception instanceof ModelNotFoundException) {
            $modelName = strtolower(class_basename($exception->getModel()));
            return $this->errorResponse('Specified identificator does not exist: '.$modelName, 404);
        }

        // What to return if user is not authenticated
        if ($exception instanceof AuthenticationException) {
            return $this->notAuthenticated($exception, $request);
        }

        // What to return if user is not authorized
        if ($exception instanceof AuthorizationException) {
            return $this->errorResponse($exception->getMessage(), 403);
        }

        // What to return if url is not found
        if ($exception instanceof NotFoundHttpException) {
            return $this->errorResponse('The specified URL cannot be found', 404);
        }

        // What to return if method is not found
        if ($exception instanceof MethodNotAllowedHttpException) {
            return $this->errorResponse('The specified method for the request is invalid', 405);
        }

        // Any other Http Exception
        if ($exception instanceof HttpException) {
            return $this->errorResponse($exception->getMessage(), $exception->getStatusCode());
        }

        // Query Exceptions
        if ($exception instanceof QueryException) {
            $errorCode = $exception->errorInfo[1];

            if ($errorCode == 1451) {
                return $this->errorResponse('Cannot remove this resource permanently. It is related with other resource', 409);
            }
        }

        // CSRF Exception
        if ($exception instanceof TokenMismatchException) {
            return redirect()->back()->withInput($request->input());
        }

        // If Application is on debug mode, then return detailed message
        // env file -> APP_DEBUG = true
        if (config('app.debug')) {
            return parent::render($request, $exception);
        }

        // Return error 500 for any other exception
        return $this->errorResponse('An unexpected error occured. Try again later', 500);
    }*/

    public function notAuthenticated($request, AuthenticationException $exception) {
        return $this->errorResponse('Not authenticated', 401);
    }

    public function convertValidationExceptionToResponse(ValidationException $e, $request) {
        $errors = $e->validator->errors()->getMessages();

        if ($this->isFrontEnd($request)) {
            return $request->ajax() ? response()->json($error, 422) : redirect()->back()->withInput($request->input())->withErrors($errors);
        }

        return $this->errorResponse($errors, 422);
    }

    public function unauthenticated($request, AuthenticationException $exception) {
        if (!$this->isFrontEnd($request)) {
            return redirect()->guest('login');
        }

        return $this->errorResponse('Unauthenticated', 401);
    }

    private function isFrontEnd($request) {
        return $request->acceptsHtml() && collect($request->route()->middleware())->contains('web');
    }

}
