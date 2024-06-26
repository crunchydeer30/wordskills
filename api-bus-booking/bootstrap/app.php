<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

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
        $exceptions->render(function (ValidationException $e, Request $requets) {
            return response()->json([
                'error' => [
                    'code' => 422,
                    'message' => $e->getMessage() ?? 'Validation error',
                    'errors' => $e->errors(),
                ]
            ], 422);
        });

        $exceptions->render(function (NotFoundHttpException $e, Request $requets) {
            return response()->json([
                'error' => [
                    'code' => 404,
                    'message' => 'Not Found',
                ]
            ], 404);
        });

        $exceptions->render(function (AccessDeniedHttpException $e, Request $requets) {
            return response()->json([
                'error' => [
                    'code' => 403,
                    'message' => 'Forbidden',
                ]
            ]);
        });
    })->create();
