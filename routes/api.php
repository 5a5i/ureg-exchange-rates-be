<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\RateController;
use App\Http\Controllers\Api\CurrencyController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\DeveloperController;
use App\Http\Controllers\Api\AuthController;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');

Route::get('/rates', [RateController::class, 'index']);
Route::post('/rates', [RateController::class, 'store']);
Route::put('/rates', [RateController::class, 'update']);
Route::get('/external/{date}', [RateController::class, 'show']);

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
Route::group(['middleware' => ['web']], function () {
Route::any('login', [UserController::class, 'login']);
Route::any('register', [UserController::class, 'register']);
Route::any('logout', [UserController::class, 'logout']);
});

Route::group(['prefix' => 'developer', 'middleware' => ['web']], function () {
    Route::get('/', [DeveloperController::class, 'index']);
    Route::post('add', [DeveloperController::class, 'store']);
    Route::get('view/{id}', [DeveloperController::class, 'show']);
    Route::get('edit/{id}', [DeveloperController::class, 'show']);
    Route::post('update/{id}', [DeveloperController::class, 'update']);
    Route::delete('delete/{id}', [DeveloperController::class, 'destroy']);
    Route::post('multiple/delete', [DeveloperController::class, 'multipleDelete']);
    Route::post('list', [DeveloperController::class, 'developerList']);
});

Route::post('reset-password', [AuthController::class, 'sendPasswordResetLink']);
Route::post('reset/password', [AuthController::class, 'callResetPassword']);
Route::post('direct/reset/password', [AuthController::class, 'directResetPassword']);
Route::get('/currencies', [CurrencyController::class, 'index']);
