<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ReceptionistController;
use App\Http\Controllers\PetsController;


Route::get('/', function () {
    return redirect()->route('login');
});
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
    
    });
    
    Route::middleware('role:groomer')->group(function () {
        Route::get('/groomer', function () {
            return view('dashboard.groomer');
        })->name('groomer.dashboard');
    });
    
    Route::middleware('role:admin')->group(function () {
        Route::get('/admin', function () {
            return view('dashboard.admin');
        })->name('admin.dashboard');
    });
});