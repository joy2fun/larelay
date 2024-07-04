<?php

namespace App\Exceptions;

use Dcat\Admin\Admin;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * The list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     */
    public function register(): void
    {
        $this->reportable(function (Throwable $e) {
            if ($e instanceof BadRequestException) {
                return false;
            }
        });

        $this->renderable(function (Throwable $e) {
            if (app('admin.omni')->isApiRequest()) {
                return Admin::json()->withException($e)->send();
            }
        });
    }
}
