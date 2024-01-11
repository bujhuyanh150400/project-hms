<?php

use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return view('welcome');
});

Route::middleware('authentication:admin')->prefix('admin')->group(function () {
    Route::get('/', [\App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('admin.dashboard');
    Route::get('/login', [\App\Http\Controllers\Admin\LoginController::class, 'index'])->name('admin.login');
    Route::post('/login-submit', [\App\Http\Controllers\Admin\LoginController::class, 'login'])->name('admin.login-submit');
    Route::get('/file/{filepath}', [\App\Http\Controllers\Admin\FileController::class, 'showFile'])->name('file.show');
    Route::prefix('users')->group(function (){
        Route::get('list', [\App\Http\Controllers\Admin\UsersController::class, 'list'])->name('users.list');
        Route::get('view_add', [\App\Http\Controllers\Admin\UsersController::class, 'view_add'])->name('users.view_add');
        Route::post('add', [\App\Http\Controllers\Admin\UsersController::class, 'add'])->name('users.add');
        Route::get('view_edit/{id}',[\App\Http\Controllers\Admin\UsersController::class,'view_edit'])->name('users.view_edit')->whereNumber('id');
        Route::put('edit/{id}',[\App\Http\Controllers\Admin\UsersController::class,'edit'])->name('users.edit')->whereNumber('id');
    });
});

