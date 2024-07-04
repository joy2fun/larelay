<?php

use App\Http\Controllers\EndpointController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('admin.auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('endpoint/{slug}', [EndpointController::class, 'relay']);
