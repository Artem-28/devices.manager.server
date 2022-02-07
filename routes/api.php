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

Route::post('playlists', [\App\Http\Controllers\Api\PlayListController::class, 'create']);
Route::get('playlists', [\App\Http\Controllers\Api\PlayListController::class, 'store']);
Route::patch('playlists/{playListId}', [\App\Http\Controllers\Api\PlayListController::class, 'update']);
Route::delete('playlists/{playListId}', [\App\Http\Controllers\Api\PlayListController::class, 'delete']);

Route::post('playlists/{playListId}/contents', [\App\Http\Controllers\Api\ContentController::class, 'create']);
Route::get('playlists/{playListId}/contents', [\App\Http\Controllers\Api\ContentController::class, 'store']);
Route::patch('playlists/{playListId}/contents/{contentId}', [\App\Http\Controllers\Api\ContentController::class, 'update']);
Route::delete('playlists/{playListId}/contents/{contentId}', [\App\Http\Controllers\Api\ContentController::class, 'delete']);

Route::get('content-types', [\App\Http\Controllers\Api\ContentTypeController::class, 'store']);

Route::post('content-file', [\App\Http\Controllers\Api\ContentFileController::class, 'create']);
