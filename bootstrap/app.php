<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        // Register your custom middleware
        $middleware->alias([
            'superadmin' => App\Http\Middleware\SuperAdminMiddleware::class,
            'admin'      => App\Http\Middleware\AdminMiddleware::class,
            'manager'    => App\Http\Middleware\ManagerMiddleware::class,
            'staff'      => App\Http\Middleware\StaffMiddleware::class,
            'guest'      => App\Http\Middleware\RedirectIfAuthenticated::class,
        ]);
        
        // You can also add global middleware here if needed
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();