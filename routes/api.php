<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TemperatureController;

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

Route::group(['prefix'=>'temperature'], function () {
    Route::get('/', [TemperatureController::class, 'index']);
    Route::get('/{id}', [TemperatureController::class, 'show']);
    Route::post('/', [TemperatureController::class, 'store']);
    Route::put('/{id}', [TemperatureController::class, 'update']);
    Route::delete('/{id}', [TemperatureController::class, 'destroy']);
});

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
