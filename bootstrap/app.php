<?php

use App\Traits\ApiResponsable;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->statefulApi();
    })
    ->withExceptions(function (Exceptions $exceptions) {
        $exceptions->renderable(function (AuthenticationException $e, $request) {
            return (new class {
                use ApiResponsable;
            })->respondUnAuthenticated($e->getMessage());
        });

        // if api not found 
        $exceptions->renderable(function (MethodNotAllowedHttpException $e, $request) {
            return (new class {
                use ApiResponsable;
            })->respondNotFound($e);
        });
    })->create();
