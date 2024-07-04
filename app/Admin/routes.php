<?php

use App\Admin\Controllers\EndpointController;
use App\Admin\Controllers\EndpointTargetController;
use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Route;
use Dcat\Admin\Admin;

Admin::routes();

Route::group([
    'prefix'     => config('admin.route.prefix'),
    'namespace'  => config('admin.route.namespace'),
    'middleware' => config('admin.route.middleware'),
], function (Router $router) {

    $router->get('/', fn () => admin_redirect('endpoints'));
    $router->resource('endpoints', EndpointController::class);
    $router->resource('endpoint-targets', EndpointTargetController::class);

});
