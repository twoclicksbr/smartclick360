<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Throwable;

class Handler extends ExceptionHandler
{
    public function render($request, Throwable $exception)
    {
        if ($exception instanceof NotFoundHttpException) {
            if ($request->expectsJson()) {
                // força a exibição da view mesmo se o Accept for application/json
                return response()->view('errors.404', [], 404);
            }

            return response()->view('errors.404', [], 404);
        }

        return parent::render($request, $exception);
    }
}
