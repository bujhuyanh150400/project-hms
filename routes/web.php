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
    // Điều hành
    Route::prefix('users')->group(function () {
        Route::get('list', [\App\Http\Controllers\Admin\UsersController::class, 'list'])->name('users.list');
        Route::get('view_add', [\App\Http\Controllers\Admin\UsersController::class, 'view_add'])->name('users.view_add');
        Route::post('add', [\App\Http\Controllers\Admin\UsersController::class, 'add'])->name('users.add');
        Route::get('view/{id}', [\App\Http\Controllers\Admin\UsersController::class, 'view'])->name('users.view')->whereNumber('id');
        Route::get('view_edit/{id}', [\App\Http\Controllers\Admin\UsersController::class, 'view_edit'])->name('users.view_edit')->whereNumber('id');
        Route::put('edit/{id}', [\App\Http\Controllers\Admin\UsersController::class, 'edit'])->name('users.edit')->whereNumber('id');
        Route::delete('deleted/{id}', [\App\Http\Controllers\Admin\UsersController::class, 'deleted'])->name('users.deleted')->whereNumber('id');
    });
    Route::prefix('clinic')->group(function () {
        Route::get('list', [\App\Http\Controllers\Admin\ClinicController::class, 'list'])->name('clinic.list');
        Route::get('view_add', [\App\Http\Controllers\Admin\ClinicController::class, 'view_add'])->name('clinic.view_add');
        Route::post('add', [\App\Http\Controllers\Admin\ClinicController::class, 'add'])->name('clinic.add');
        Route::get('view_edit/{id}', [\App\Http\Controllers\Admin\ClinicController::class, 'view_edit'])->name('clinic.view_edit')->whereNumber('id');
        Route::put('edit/{id}', [\App\Http\Controllers\Admin\ClinicController::class, 'edit'])->name('clinic.edit')->whereNumber('id');
        Route::delete('deleted/{id}', [\App\Http\Controllers\Admin\ClinicController::class, 'deleted'])->name('clinic.deleted')->whereNumber('id');
    });
    Route::prefix('specialties')->group(function () {
        Route::get('list', [\App\Http\Controllers\Admin\SpecialtiesController::class, 'list'])->name('specialties.list');
        Route::get('view_add', [\App\Http\Controllers\Admin\SpecialtiesController::class, 'view_add'])->name('specialties.view_add');
        Route::post('add', [\App\Http\Controllers\Admin\SpecialtiesController::class, 'add'])->name('specialties.add');
        Route::get('view_edit/{id}', [\App\Http\Controllers\Admin\SpecialtiesController::class, 'view_edit'])->name('specialties.view_edit')->whereNumber('id');
        Route::put('edit/{id}', [\App\Http\Controllers\Admin\SpecialtiesController::class, 'edit'])->name('specialties.edit')->whereNumber('id');
        Route::delete('deleted/{id}', [\App\Http\Controllers\Admin\SpecialtiesController::class, 'deleted'])->name('specialties.deleted')->whereNumber('id');
    });
    // Về khách hàng
    Route::prefix('customer')->group(function () {
        Route::get('list', [\App\Http\Controllers\Admin\CustomerController::class, 'list'])
            ->name('customer.list');
        Route::get('view_add', [\App\Http\Controllers\Admin\CustomerController::class, 'view_add'])
            ->name('customer.view_add');
        Route::post('add', [\App\Http\Controllers\Admin\CustomerController::class, 'add'])
            ->name('customer.add');
        Route::get('view/{id}', [\App\Http\Controllers\Admin\CustomerController::class, 'view'])
            ->name('customer.view')
            ->whereNumber('id')
            ->middleware('check.regist.animal');
        Route::get('view_edit/{id}', [\App\Http\Controllers\Admin\CustomerController::class, 'view_edit'])
            ->name('customer.view_edit')
            ->whereNumber('id');
        Route::put('edit/{id}', [\App\Http\Controllers\Admin\CustomerController::class, 'edit'])
            ->name('customer.edit')
            ->whereNumber('id');
        // Route::delete('deleted/{id}', [\App\Http\Controllers\Admin\SpecialtiesController::class, 'deleted'])->name('specialties.deleted')->whereNumber('id');
    });
    Route::prefix('animal')->group(function () {
        Route::get('list', [\App\Http\Controllers\Admin\AnimalController::class, 'list'])
            ->name('animal.list');
        Route::get('find_cust', [\App\Http\Controllers\Admin\AnimalController::class, 'find_cust'])
            ->name('animal.find_cust');
        Route::get('view_add/{cust_id}', [\App\Http\Controllers\Admin\AnimalController::class, 'view_add'])
            ->name('animal.view_add')
            ->whereNumber('cust_id');
        Route::post('add/{cust_id}', [\App\Http\Controllers\Admin\AnimalController::class, 'add'])
            ->name('animal.add')
            ->whereNumber('cust_id');
        Route::get('view/{id}', [\App\Http\Controllers\Admin\AnimalController::class, 'view'])
            ->name('animal.view')
            ->whereNumber('id');
        Route::get('view_edit/{id}', [\App\Http\Controllers\Admin\AnimalController::class, 'view_edit'])
            ->name('animal.view_edit')
            ->whereNumber('id');
        Route::put('edit/{id}', [\App\Http\Controllers\Admin\AnimalController::class, 'edit'])
            ->name('animal.edit')
            ->whereNumber('id');
    });
});
