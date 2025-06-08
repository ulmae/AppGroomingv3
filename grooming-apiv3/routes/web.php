<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ReceptionistController;
use App\Http\Controllers\PetsController;
use App\Http\Controllers\CustomersController;
use App\Http\Controllers\LandingController;
use App\Http\Controllers\GroomerController;
//use App\Http\Controllers\


Route::get('/', [LandingController::class, 'index'])->name('landing');
Route::get('/test', function () {
    return view('test');
});


Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');


Route::middleware('auth')->group(function () {

    Route::get('/dashboard', [AuthController::class, 'dashboard'])->name('dashboard');
    
    Route::middleware('role:receptionist')->group(function () {
        Route::get('/receptionist', [ReceptionistController::class, 'index'])->name('receptionist.dashboard');
        Route::post('/receptionist/orders', [ReceptionistController::class, 'addOrder'])->name('receptionist.add-order');
        Route::post('/receptionist/orders/{id}/cancel', [ReceptionistController::class, 'cancelOrder'])->name('receptionist.cancel-order');
        Route::get('/receptionist/customers/{id}/pets', [ReceptionistController::class, 'getPetsByCustomer'])->name('receptionist.customer-pets');
        Route::get('/pets', [PetsController::class, 'index'])->name('pets.index');
        Route::post('/pets', [PetsController::class, 'store'])->name('pets.store');
        Route::get('/pets/{id}', [PetsController::class, 'show'])->name('pets.show');
        Route::put('/pets/{id}', [PetsController::class, 'update'])->name('pets.update');
        Route::delete('/pets/{id}', [PetsController::class, 'destroy'])->name('pets.destroy');
        Route::get('/customers', [CustomersController::class, 'index'])->name('customers.index');
        Route::post('/customers', [CustomersController::class, 'store'])->name('customers.store');
        Route::get('/customers/{id}/edit', [CustomersController::class, 'edit'])->name('customers.edit');
        Route::put('/customers/{id}', [CustomersController::class, 'update'])->name('customers.update');
        Route::delete('/customers/{id}', [CustomersController::class, 'destroy'])->name('customers.destroy');
        Route::get('/customers/{id}', [CustomersController::class, 'show'])->name('customers.show');
    });
    
    Route::middleware('role:groomer')->group(function () {
        Route::get('/groomer', [GroomerController::class, 'index'])->name('groomer.dashboard');
        Route::get('/groomer/orders/{id}', [GroomerController::class, 'show'])->name('groomer.show');
        Route::post('/groomer/orders/{id}/complete', [GroomerController::class, 'complete'])->name('groomer.complete');
        Route::post('/groomer/orders/{id}/notes', [GroomerController::class, 'addNotes'])->name('groomer.notes');
    });
    
    Route::middleware('role:admin')->group(function () {
        Route::get('/admin', function () {
            return view('dashboard.admin');
        })->name('admin.dashboard');
    });
});