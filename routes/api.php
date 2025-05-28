<?php

use App\Http\Controllers\CustomerController;
use Illuminate\Support\Facades\Route;

Route::post('/login', [CustomerController::class, 'apiLogin']);
Route::post('/register', [CustomerController::class, 'apiRegister']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/customer', [CustomerController::class, 'getCustomer']);
    Route::get('/tariffs', [CustomerController::class, 'getTariffs']);
});

?>