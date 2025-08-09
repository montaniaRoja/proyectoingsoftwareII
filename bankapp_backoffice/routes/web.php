<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;

use Illuminate\Support\Facades\Broadcast;
use Illuminate\Support\Facades\Route;

Route::view('/', 'login')->name('login');
Route::view('/create', 'create')->name('create');
Route::view('/password', 'password')->name('password');


Broadcast::routes();

Route::post('/user/login', [AuthController::class, 'loginUser'])->name('user.login');
Route::post('/user/create', [UserController::class, 'userCreate'])->name('user.create');
Route::post('/user/password', [UserController::class, 'resetPassword'])->name('user.password');


Route::get('/user/logout', [AuthController::class, 'logOut'])->name('user.logout');

Route::middleware(['auth'])->group(function () {
    Route::view('/index', 'appviews.index')->name('index');
    Route::view('/customers', 'appviews.customers')->name('customers');
    Route::view('/accounts/{customerId}', 'appviews.accounts')->name('accounts');
    Route::view('/companies', 'appviews.companies')->name('companies')->middleware('can:crear clientes');
    Route::view('/users', 'appviews.users')->name('users')->middleware('can:autorizar usuarios');
    Route::view('/roles', 'appviews.roles')->name('roles')->middleware('can:create roles');
    Route::view('/deposits', 'appviews.depositos-report')->name('deposits')->middleware('can:see deposits');


});
