<?php

use App\Http\Controllers\ObatController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\TransactionController;
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
    // crud obat
    Route::resource('obat', ObatController::class);

    Route::get('/', function () {
        return view('admin.index');
    })->name('dashboard');

    // crud order
    Route::resource('order', OrderController::class);
    Route::post('/save', [OrderController::class, 'save'])->name('save');

    // transaction
    Route::get('/transaction', [TransactionController::class, 'index'])->name('transaction');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
