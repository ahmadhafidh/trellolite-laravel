<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Auth\Access\AuthorizationException;
use Symfony\Component\HttpFoundation\Response;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        //
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        $exceptions->render(function (
            AuthorizationException $e,
            $request
        ) {
            if ($request->expectsJson()) {
                return response()->json([
                    'status'  => Response::HTTP_FORBIDDEN,
                    'message' => 'User not allowed',
                ], Response::HTTP_FORBIDDEN);
            }
        });
    })
    ->create();
