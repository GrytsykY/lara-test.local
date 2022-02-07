<?php

use App\Http\Controllers\AlertController;
use App\Http\Controllers\BasketController;
use App\Http\Controllers\PingController;
use App\Http\Controllers\TestController;
use App\Http\Controllers\UrlController;

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
    return redirect()->route('login');
});

Route::get('/test', [TestController::class, 'index']);

Route::resource('/url', UrlController::class)->middleware(['auth']);
Route::resource('/alert', AlertController::class);
Route::post('/url/ajax-check-url', [UrlController::class, 'ajaxCheckUrl'])->name('ajaxCheckUrl');
Route::get('/url/ajax-url-form/{id}', [UrlController::class, 'ajaxUrlProdForm'])->name('url.ajax-url-form');
Route::get('/basket', [BasketController::class, 'basket'])->name('basket')->middleware('auth');
Route::get('/restore/{id}', [BasketController::class, 'restore'])->name('basket.restore')->middleware('auth');
Route::get('/delete-trash/{id}', [BasketController::class, 'deleteTrash'])->name('basket.delete-trash')->middleware('auth');
Route::get('ping1', [PingController::class, 'ping1'])->name('ping1');//->middleware(['auth']);
Route::get('ping2', [PingController::class, 'ping2'])->name('ping2')->middleware(['auth']);
Route::get('ping3', [PingController::class, 'ping3'])->name('ping3')->middleware(['auth']);


Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');


require __DIR__.'/auth.php';

// 5087265422 my 534407566
