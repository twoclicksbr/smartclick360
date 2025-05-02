<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Illuminate\Validation\ValidationException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\QueryException;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        api: __DIR__ . '/../routes/api.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        //
    })
    ->withExceptions(function (Exceptions $exceptions) {
        $exceptions->renderable(function (NotFoundHttpException $e, $request) {
            if ($e->getPrevious() instanceof ModelNotFoundException) {
                return response()->json(['error' => 'Registro não encontrado.'], 404);
            }

            return response()->json(['error' => 'Rota não encontrada.'], 404);
        });

        $exceptions->renderable(function (ValidationException $e, $request) {
            return response()->json([
                'error' => 'Erro de validação.',
                'fields' => $e->errors(),
            ], 422);
        });

        $exceptions->renderable(function (AuthenticationException $e, $request) {
            return response()->json(['error' => 'Não autenticado.'], 401);
        });

        $exceptions->renderable(function (AuthorizationException $e, $request) {
            return response()->json(['error' => 'Acesso não autorizado.'], 403);
        });

        $exceptions->renderable(function (QueryException $e, $request) {
            return response()->json([
                'error' => 'Erro de banco de dados.',
                'message' => $e->getMessage(),
            ], 500);
        });

        $exceptions->renderable(function (\Symfony\Component\HttpKernel\Exception\HttpException $e, $request) {
            if ($e->getStatusCode() === 403) {
                return response()->json(['error' => 'Acesso negado.'], 403);
            }
        });
    })->create();
