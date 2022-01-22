<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::post('auth/register', [\App\Http\Controllers\Api\AuthController::class, 'register']);
Route::post('auth/login', [\App\Http\Controllers\Api\AuthController::class, 'login']);
Route::post('auth/logout', [\App\Http\Controllers\Api\AuthController::class, 'logout']);
Route::get('auth/user', [\App\Http\Controllers\Api\AuthController::class, 'userProfile']);

Route::post('control-devices', [\App\Http\Controllers\Api\ControlDeviceController::class, 'create']);
Route::get('control-devices', [\App\Http\Controllers\Api\ControlDeviceController::class, 'store']);
Route::patch('control-devices/{controlDeviceId}', [\App\Http\Controllers\Api\ControlDeviceController::class, 'update']);
Route::delete('control-devices/{controlDeviceId}', [\App\Http\Controllers\Api\ControlDeviceController::class, 'delete']);

Route::post('live-check', [\App\Http\Controllers\Api\LiveCheckController::class, 'check']);
