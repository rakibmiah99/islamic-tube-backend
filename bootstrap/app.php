<?php
use App\Utils\Helper;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Support\Facades\Route;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        //
    })
    ->withExceptions(function (Exceptions $exceptions) {
        $exceptions->render(function (ValidationException $e) {
            return Helper::ApiResponse($e->getMessage(), $e->errors(), 422, false);
        });

        $exceptions->render(function (ModelNotFoundException $e) {
            return Helper::ApiResponse('data not found', null, 404, false);
        });

        $exceptions->render(function (NotFoundHttpException $e) {
            return Helper::ApiResponse($e->getMessage(), null, 404, false);
        });
    })->create();
