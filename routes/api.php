<?php

use App\Http\Controllers\API\PongController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CartController;
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

Route::post('/auth/register', [AuthController::class, 'register']);
Route::post('/auth/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
  Route::post('/auth/logout', [AuthController::class, 'logout']);
});

Route::resource('pongs', PongController::class);

Route::get('products', ProductController::class);

Route::middleware('auth:sanctum')->prefix('/cart')->group(function () {
  Route::get('get-cart', [CartController::class, 'getCart']);
  Route::post('add-item', [CartController::class, 'addItem']);
  Route::post('remove-item', [CartController::class, 'removeItem']);
  Route::post('update-quantity', [CartController::class, 'updateQuantity']);
});
