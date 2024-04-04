<?php

use Illuminate\Support\Facades\Route;

Route::middleware('authentication:admin')->group(function () {
    Route::get('/', [\App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('admin.dashboard');
    Route::get('/login', [\App\Http\Controllers\Admin\LoginController::class, 'index'])->name('admin.login');
    Route::post('/logout', [\App\Http\Controllers\Admin\LoginController::class, 'logout'])->name('admin.logout');
    Route::post('/login-submit', [\App\Http\Controllers\Admin\LoginController::class, 'login'])->name('admin.login-submit');
    Route::get('/file/{filepath}', [\App\Http\Controllers\Admin\FileController::class, 'showFile'])->name('file.show');
    // Điều hành
    Route::prefix('users')->group(function () {
        Route::middleware('permission:adminOnly')->group(function () {
            Route::get('list', [\App\Http\Controllers\Admin\UsersController::class, 'list'])->name('users.list');
            Route::get('view_add', [\App\Http\Controllers\Admin\UsersController::class, 'view_add'])->name('users.view_add');
            Route::post('add', [\App\Http\Controllers\Admin\UsersController::class, 'add'])->name('users.add');
            Route::delete('deleted/{id}', [\App\Http\Controllers\Admin\UsersController::class, 'deleted'])->name('users.deleted')->whereNumber('id');
        });
        Route::middleware('permission:userEditSelf')->group(function () {
            Route::get('view/{id}', [\App\Http\Controllers\Admin\UsersController::class, 'view'])->name('users.view')->whereNumber('id');
            Route::get('view_edit/{id}', [\App\Http\Controllers\Admin\UsersController::class, 'view_edit'])->name('users.view_edit')->whereNumber('id');
            Route::put('edit/{id}', [\App\Http\Controllers\Admin\UsersController::class, 'edit'])->name('users.edit')->whereNumber('id');
        });
    });
    Route::prefix('clinic')->group(function () {
        Route::middleware('permission:adminOnly')->group(function () {
            Route::get('list', [\App\Http\Controllers\Admin\ClinicController::class, 'list'])->name('clinic.list');
            Route::get('view_add', [\App\Http\Controllers\Admin\ClinicController::class, 'view_add'])->name('clinic.view_add');
            Route::post('add', [\App\Http\Controllers\Admin\ClinicController::class, 'add'])->name('clinic.add');
            Route::get('view_edit/{id}', [\App\Http\Controllers\Admin\ClinicController::class, 'view_edit'])->name('clinic.view_edit')->whereNumber('id');
            Route::put('edit/{id}', [\App\Http\Controllers\Admin\ClinicController::class, 'edit'])->name('clinic.edit')->whereNumber('id');
            Route::delete('deleted/{id}', [\App\Http\Controllers\Admin\ClinicController::class, 'deleted'])->name('clinic.deleted')->whereNumber('id');
        });
        Route::get('view/{id}', [\App\Http\Controllers\Admin\ClinicController::class, 'view'])->name('clinic.view')->whereNumber('id');
    });
    Route::prefix('specialties')->group(function () {
        Route::get('list', [\App\Http\Controllers\Admin\SpecialtiesController::class, 'list'])->name('specialties.list');
        Route::middleware('permission:adminOnly')->group(function () {
            Route::get('view_add', [\App\Http\Controllers\Admin\SpecialtiesController::class, 'view_add'])->name('specialties.view_add');
            Route::post('add', [\App\Http\Controllers\Admin\SpecialtiesController::class, 'add'])->name('specialties.add');
            Route::get('view_edit/{id}', [\App\Http\Controllers\Admin\SpecialtiesController::class, 'view_edit'])->name('specialties.view_edit')->whereNumber('id');
            Route::put('edit/{id}', [\App\Http\Controllers\Admin\SpecialtiesController::class, 'edit'])->name('specialties.edit')->whereNumber('id');
            Route::delete('deleted/{id}', [\App\Http\Controllers\Admin\SpecialtiesController::class, 'deleted'])->name('specialties.deleted')->whereNumber('id');
        });
    });
    Route::middleware('permission:adminOnly')->prefix('type_material')->group(function () {
        Route::get('list', [\App\Http\Controllers\Admin\MaterialController::class, 'type_material_list'])
            ->name('type_material.list');
        Route::get('view_add', [\App\Http\Controllers\Admin\MaterialController::class, 'type_material_view_add'])
            ->name('type_material.view_add');
        Route::post('add', [\App\Http\Controllers\Admin\MaterialController::class, 'type_material_add'])
            ->name('type_material.add');
        Route::get('view_edit/{id}', [\App\Http\Controllers\Admin\MaterialController::class, 'type_material_view_edit'])
            ->name('type_material.view_edit');
        Route::put('edit/{id}', [\App\Http\Controllers\Admin\MaterialController::class, 'type_material_edit'])
            ->name('type_material.edit');
        Route::put('deleted/{id}', [\App\Http\Controllers\Admin\MaterialController::class, 'type_material_deleted'])
            ->name('type_material.deleted');
    });
    Route::middleware('permission:checkUserAccess')->prefix('warehouse')->group(function () {
        Route::get('list', [\App\Http\Controllers\Admin\MaterialController::class, 'warehouse_list'])
            ->name('warehouse.list');
        Route::get('view_add', [\App\Http\Controllers\Admin\MaterialController::class, 'warehouse_view_add'])
            ->name('warehouse.view_add');
        Route::post('add', [\App\Http\Controllers\Admin\MaterialController::class, 'warehouse_add'])
            ->name('warehouse.add');
        Route::get('view_edit/{id}', [\App\Http\Controllers\Admin\MaterialController::class, 'warehouse_view_edit'])
            ->name('warehouse.view_edit')
            ->whereNumber('id');
        Route::put('edit/{id}', [\App\Http\Controllers\Admin\MaterialController::class, 'warehouse_edit'])
            ->name('warehouse.edit')
            ->whereNumber('id');
        Route::get('log/{id}', [\App\Http\Controllers\Admin\MaterialController::class, 'warehouse_log'])
            ->name('warehouse.log')
            ->whereNumber('id');
        Route::get('view_edit_total/{id}', [\App\Http\Controllers\Admin\MaterialController::class, 'warehouse_view_edit_total'])
            ->name('warehouse.view_edit_total')
            ->whereNumber('id');
        Route::put('edit_total/{id}', [\App\Http\Controllers\Admin\MaterialController::class, 'warehouse_edit_total'])
            ->name('warehouse.edit_total')
            ->whereNumber('id');;
    });
    // Về khách hàng
    Route::prefix('customer')->group(function () {
        Route::get('list', [\App\Http\Controllers\Admin\CustomerController::class, 'list'])
            ->name('customer.list');
        Route::get('view_add', [\App\Http\Controllers\Admin\CustomerController::class, 'view_add'])
            ->name('customer.view_add');
        Route::post('add', [\App\Http\Controllers\Admin\CustomerController::class, 'add'])
            ->name('customer.add');
        Route::get('view_edit/{id}', [\App\Http\Controllers\Admin\CustomerController::class, 'view_edit'])
            ->name('customer.view_edit')
            ->whereNumber('id');
        Route::put('edit/{id}', [\App\Http\Controllers\Admin\CustomerController::class, 'edit'])
            ->name('customer.edit')
            ->whereNumber('id');
        Route::middleware('check.regist.animal')->group(function () {
            Route::get('view/{customer_id}', [\App\Http\Controllers\Admin\CustomerController::class, 'view'])
                ->name('customer.view')
                ->whereNumber('id');
            Route::match(['get', 'post'], 'find_schedules/{customer_id}', [\App\Http\Controllers\Admin\SchedulesController::class, 'find_schedules'])
                ->name('customer.find_schedules')
                ->whereNumber('customer_id');
            Route::middleware(\App\Http\Middleware\checkSchedule::class)->group(function () {
                Route::get('view_add_schedules/{customer_id}', [\App\Http\Controllers\Admin\SchedulesController::class, 'view_add_schedules'])
                    ->name('customer.view_add_schedules')
                    ->whereNumber(['customer_id']);
                Route::post('add_schedules/{customer_id}', [\App\Http\Controllers\Admin\SchedulesController::class, 'add_schedules'])
                    ->name('customer.add_schedules')
                    ->whereNumber('customer_id');
            });
        });
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
    // Về lịch khám
    Route::middleware('permission:checkUserAccess')->prefix('bookings')->group(function () {
        Route::get('find_list', [\App\Http\Controllers\Admin\BookingController::class, 'find_list'])
            ->name('bookings.find_list');
        Route::get('list/{user_id}', [\App\Http\Controllers\Admin\BookingController::class, 'list'])
            ->name('bookings.list')
            ->whereNumber('user_id');
        Route::get('view_add/{user_id}', [\App\Http\Controllers\Admin\BookingController::class, 'view_add'])
            ->name('bookings.view_add')
            ->whereNumber('user_id');
        Route::post('add/{user_id}', [\App\Http\Controllers\Admin\BookingController::class, 'add'])
            ->name('bookings.add')
            ->whereNumber('user_id');
        Route::get('view_edit/{id}', [\App\Http\Controllers\Admin\BookingController::class, 'view_edit'])
            ->name('bookings.view_edit')
            ->whereNumber('id');
        Route::put('edit/{id}', [\App\Http\Controllers\Admin\BookingController::class, 'edit'])
            ->name('bookings.edit')
            ->whereNumber('id');
        Route::get('all_bookings', [\App\Http\Controllers\Admin\BookingController::class, 'all_bookings'])
            ->name('bookings.all_bookings');
    });
    Route::middleware('permission:checkUserAccess')->prefix('schedules')->group(function () {
        Route::controller(\App\Http\Controllers\Admin\SchedulesController::class)->group(function () {
            Route::get('find_list', 'find_list')
                ->name('schedules.find_list');
            Route::get('list/{user_id}', 'list')
                ->name('schedules.list')
                ->whereNumber('user_id');
            Route::get( 'view/{schedule_id}', 'view')
                ->name('schedules.view')
                ->whereNumber('schedule_id');
            Route::post( 'submit_history/{schedule_id}', 'submit_history')
                ->name('schedules.submit_history')
                ->whereNumber('schedule_id');
            Route::post('change_status', 'change_status')
                ->name('schedules.change_status');
            Route::get('all_schedules', 'all_schedules')
                ->name('schedules.all_schedules');
        });
    });
});
