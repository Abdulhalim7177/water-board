<?php

use App\Http\Controllers\CustomerController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\Auth\AdminLoginController;
use Illuminate\Support\Facades\Route;

Route::post('/register', [CustomerController::class, 'apiRegister']);
Route::post('/login', [CustomerController::class, 'apiLogin']);
Route::post('/admin/login', [AdminLoginController::class, 'apiLogin']);
Route::post('/admin/logout', [AdminLoginController::class, 'apiLogout'])->middleware('auth:sanctum');

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/customer', [CustomerController::class, 'getCustomer']);
    Route::get('/tariffs', [CustomerController::class, 'getTariffs']);
});

Route::prefix('admin')->middleware(['auth:sanctum', 'role.admin'])->group(function () {
    Route::get('/customers', [AdminController::class, 'apiCustomers']);
    Route::post('/customers/import', [AdminController::class, 'apiImportCustomers']);
});
?>