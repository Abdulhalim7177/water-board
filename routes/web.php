<?php

use App\Http\Controllers\CustomerController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// Authentication Routes (Laravel UI)
Auth::routes(['register' => true, 'login' => true]);

// Customer Dashboard (Protected)
Route::middleware(['auth:customer'])->group(function () {
    Route::get('/customer/dashboard', [CustomerController::class, 'dashboard'])->name('customer.dashboard');
});

?>