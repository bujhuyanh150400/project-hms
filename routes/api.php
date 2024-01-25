<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// API provinces
Route::prefix('provinces/v1')->group(function () {
    Route::get('/province', [\App\Http\Controllers\API\Provinces::class, 'getProvinces']);
    Route::get('/district', [\App\Http\Controllers\API\Provinces::class, 'getDistricts']);
    Route::get('/ward', [\App\Http\Controllers\API\Provinces::class, 'getWards']);
});
