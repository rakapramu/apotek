<?php

use App\Http\Controllers\ObatController;
use App\Http\Controllers\OrderController;
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
    return view('auth.login');
});



Route::prefix('admin')->middleware(['auth', 'isLogin'])->group(function () {
    Route::resource('obat', ObatController::class);
    Route::get('/', function () {
        return view('admin.index');
    });
    Route::resource('order', OrderController::class);
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
