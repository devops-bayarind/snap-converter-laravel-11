<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Support\Facades\Log;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->trimStrings(
            ['*']
        );
        $middleware->alias([
            'snap.authentication' => \App\Http\Middleware\SnapAuthentication::class,
            'request.logger' => \App\Http\Middleware\RequestLogger::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        $exceptions->renderable(function (Throwable $e) {
            //
            Log::info("Internal Error",[
                "error" => $e->getMessage(),
                "code" => $e->getCode(),
//                "trace" => $e->getTrace(),
            ]);
            return response()->json([
                "responseCode"=>  "5000001",
                "responseMessage" => "Internal Server Error"
            ], 200, ['X-TIMESTAMP' => date('c')]);
        });
    })->create();
