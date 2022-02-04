<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\MeController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
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

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::group([
    'middleware' => [
        'auth:api',
    ],
], function () {
    Route::get('/me', [MeController::class, 'index']);

    // Product
    Route::prefix('/products')->group(function () {
        Route::get('', [ProductController::class, 'getAll']);
        Route::post('', [ProductController::class, 'store']);
        Route::get('{product}', [ProductController::class, 'get']);
        Route::put('{product}', [ProductController::class, 'update']);
        Route::delete('{product}', [ProductController::class, 'destroy']);
    });

    // Order
    Route::post('/orders', [OrderController::class, 'save']);
});
