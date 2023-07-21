<?php

use App\Http\Controllers\API\PongController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\PrivateChatController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\TweetController;
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

Route::middleware('auth:api')->group(function () {
    Route::post('/auth/logout', [AuthController::class, 'logout']);
});

Route::resource('pongs', PongController::class);
Route::resource('tweets', TweetController::class);

Route::get('products', [ProductController::class, 'index']);

Route::middleware('auth:api')->prefix('/cart')->group(function () {
    Route::get('get-cart', [CartController::class, 'getCart']);
    Route::post('add-item', [CartController::class, 'addItem']);
    Route::post('remove-item', [CartController::class, 'removeItem']);
    Route::post('update-quantity', [CartController::class, 'updateQuantity']);
});

Route::middleware('auth:api')->group(function () {
    Route::get('/users', [AuthController::class, 'listUsers']);

    // Get all chats for the authenticated user
    // Route::get('/chats', 'ChatController@index');

    // Get all messages in a chat
    // Route::get('/chats/{chat_id}/messages', 'MessageController@index');

    // Send a message in a chat
    // Route::post('/chats/{chat_id}/messages', 'MessageController@store');

    // Create a new chat
    // Route::post('/chats', 'ChatController@store');

    // Add a user to a chat
    // Route::post('/chats/{chat_id}/users', 'ChatUserController@store');

    // Remove a user from a chat
    // Route::delete('/chats/{chat_id}/users/{user_id}', 'ChatUserController@destroy');

    // Get all private chats for the authenticated user
    Route::get('/private-chats', [PrivateChatController::class, 'index']);

    // Get all messages in a private chat between two users
    Route::get('/private-chats/{user_id}/messages', [PrivateChatController::class, 'getMessageBetweenTwoUsers']);

    // Send a message in a private chat between two users
    Route::post('/private-chats/{user_id}/messages', [PrivateChatController::class, 'sendMessageBetweenTwoUsers']);
});

Route::middleware('auth:api')->post('/broadcasting/auth', function () {
    return true;
});
