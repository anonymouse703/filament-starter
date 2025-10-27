<?php

use App\Services\Responser\Responser;
use Illuminate\Foundation\Application;
use App\Services\FileUploader\FileUploader;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        //
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })
    ->withBindings([
        'responser' => fn () => new Responser,
        'file_uploader' => fn () => new FileUploader,
    ])
    ->create();
