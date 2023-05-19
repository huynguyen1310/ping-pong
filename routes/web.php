<?php

use App\Http\Controllers\PongController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\SiteController;
use App\http\Controllers\PostController;
use App\Jobs\SendingMail;
use App\Models\User;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
  return view('welcome');
});

Route::get('/posts/{post}', [PostController::class, 'show'])->middleware('trackTimeSpent');

Route::middleware([
  'auth:sanctum',
  config('jetstream.auth_session'),
  'verified',
])->group(function () {
  Route::get('/dashboard', function () {
    return view('dashboard');
  })->name('dashboard');
});

Route::middleware('auth')->group(function () {
  Route::resource('sites', SiteController::class);
});

Route::get('pongs', [PongController::class, 'index']);

Route::get('search', SearchController::class);

Route::get('/jobs', function () {
  SendingMail::dispatch(User::first());

  return 'welcome email Jobs dispatched!';
});
