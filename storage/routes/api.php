<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ApiLoginController;
use App\Http\Controllers\AbsenController;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware(['auth:api'])->group(function () {
    Route::get('users/data-rahasia', function () {
        return "ini rahasia";
    });

    Route::get('/user', [ApiLoginController::class, 'user']);
    Route::get('/date', [ApiLoginController::class, 'dateNow']);
    Route::post('/store', [AbsenController::class, 'store']);
    Route::put('/update/{id}', [AbsenController::class, 'update']);
    Route::get('/index/{id}', [AbsenController::class, 'index']);
    Route::put('/update-absen/{id}', [AbsenController::class, 'updateAbsen']);
    Route::post('/store-leave', [AbsenController::class, 'storeLeave']);
    Route::post('/update-jam', [ApiLoginController::class, 'update_jam']);
});

Route::post('login', [ApiLoginController::class, 'login']);
Route::post('login-public', [ApiLoginController::class, 'login_public']);
