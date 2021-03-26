<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\PersonsController;
use App\Http\Controllers\API\LoadDBController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::resource('persons', PersonsController::class);
Route::get('/create-report/{id}', [PersonsController::class, 'createReport']);
Route::get('/create-reportAll', [PersonsController::class, 'createReportAll']);
Route::get('/load', [LoadDBController::class, 'load']);

