<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Broadcast;
use Illuminate\Support\Facades\Route;

Route::view('/', 'login')->name('login');

Route::post('/user/login', [AuthController::class, 'loginUser'])->name('user.login');

Broadcast::routes();

Route::get('/user/logout', [AuthController::class, 'logOut'])->name('user.logout');

Route::middleware(['auth'])->group(function () {
    Route::view('/index', 'appviews.index')->name('index');

    Route::view('/customers', 'appviews.customers')->name('customers');
    Route::view('/accounts/{customerId}', 'appviews.accounts')->name('accounts');

    Route::view('/companies', 'appviews.companies')->name('companies');


});
