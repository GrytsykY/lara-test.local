<?php

use App\Http\Controllers\TestController;
use App\Http\Controllers\UrlController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Notification;

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

Route::get('/test', [TestController::class, 'index']);

Route::resource('/url', UrlController::class)->middleware(['auth']);
Route::resource('/alert', \App\Http\Controllers\AlertController::class);
Route::post('/url/ajax-check-url', [UrlController::class, 'ajaxCheckUrl'])->name('ajaxCheckUrl');
Route::get('url-ping/ping1', [UrlController::class, 'ping1'])->name('ping1');
Route::get('url-ping/ping2', [UrlController::class, 'ping2'])->name('ping2');
Route::get('url-ping/ping3', [UrlController::class, 'ping3'])->name('ping3');


Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

//Notification::route('telegram', '5087265422')
//    ->notify(new \App\Notifications\Telegram);

require __DIR__.'/auth.php';

// 5087265422 my 534407566
