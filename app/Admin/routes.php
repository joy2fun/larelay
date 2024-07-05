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

    $router->get('/', 'HomeController@index');
    $router->resource('endpoints', EndpointController::class);
    $router->resource('endpoints-targets', EndpointTargetController::class);

});
