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
        Route::get('view/{id}',[\App\Http\Controllers\Admin\UsersController::class,'view'])->name('users.view')->whereNumber('id');
        Route::get('view_edit/{id}',[\App\Http\Controllers\Admin\UsersController::class,'view_edit'])->name('users.view_edit')->whereNumber('id');
        Route::put('edit/{id}',[\App\Http\Controllers\Admin\UsersController::class,'edit'])->name('users.edit')->whereNumber('id');
        Route::delete('deleted/{id}',[\App\Http\Controllers\Admin\UsersController::class,'deleted'])->name('users.deleted')->whereNumber('id');
    });
    Route::prefix('clinic')->group(function () {
        Route::get('list',[\App\Http\Controllers\Admin\ClinicController::class,'list'])->name('clinic.list');
        Route::get('view_add',[\App\Http\Controllers\Admin\ClinicController::class,'view_add'])->name('clinic.view_add');
        Route::post('add', [\App\Http\Controllers\Admin\ClinicController::class, 'add'])->name('clinic.add');
        Route::get('view/{id}',[\App\Http\Controllers\Admin\ClinicController::class,'view'])->name('clinic.view')->whereNumber('id');
        Route::get('view_edit/{id}',[\App\Http\Controllers\Admin\ClinicController::class,'view_edit'])->name('clinic.view_edit')->whereNumber('id');
        Route::put('edit/{id}',[\App\Http\Controllers\Admin\ClinicController::class,'edit'])->name('clinic.edit')->whereNumber('id');
        Route::delete('deleted/{id}',[\App\Http\Controllers\Admin\ClinicController::class,'deleted'])->name('clinic.deleted')->whereNumber('id');
    });
});

