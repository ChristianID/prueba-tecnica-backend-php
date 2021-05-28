<?php

namespace App\Exceptions;

use Throwable;
use Illuminate\Database\QueryException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Session\TokenMismatchException;
use Illuminate\Validation\ValidationException;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;

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
        'password',
        'password_confirmation',
    ];

    /**
     * Report or log an exception.
     *
     * @param  \Throwable  $exception
     * @return void
     *
     * @throws \Throwable
     */
    public function report(Throwable $exception)
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Throwable  $exception
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @throws \Throwable
     */
    public function render($request, Throwable $exception)
    {
        if( $request->wantsJson() && !config('app.debug') ) {

            $statusCode = 400;
            $response = [
                'message' => 'Sorry, something went wrong.'
            ];

            if ($exception instanceof ValidationException) {
                $statusCode = 422;
                $response['message'] = 'Bad request';
                $response['errors'] = $exception->validator->errors()->getMessages();
            }

            else if ($exception instanceof ModelNotFoundException) {
                $statusCode = 404;
                $modelName = strtolower(class_basename($exception->getModel()));
                $response['message'] = "Does not exists any {$modelName} with the specified identificator";
            }

            else if ($exception instanceof AuthenticationException) {
                $statusCode = 401;
                $response['message'] = 'Unauthenticated';
            }

            else if ($exception instanceof AuthorizationException) {
                $statusCode = 403;
                $response['message'] = $exception->getMessage();
            }

            else if ($exception instanceof MethodNotAllowedHttpException) {
                $statusCode = 405;
                $response['message'] = 'The specified method for the request is invalid';
            }

            else if ($exception instanceof NotFoundHttpException) {
                $statusCode = 404;
                $response['message'] = 'The specified URL cannot be found';
            }

            else if ($exception instanceof HttpException) {
                $statusCode = $exception->getStatusCode();
                $response['message'] = $exception->getMessage();
            }

            else if ($exception instanceof QueryException) {
                $statusCode = 500;
                $response['message'] = 'Internal error';
            }

            else if ($exception instanceof TokenMismatchException) {
                return redirect()->back()->withInput($request->input());
            }


            return response()->json($response, $statusCode);
        }

        return parent::render($request, $exception);
    }
}
