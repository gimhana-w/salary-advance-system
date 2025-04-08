<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\SalaryAdvanceRequestController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Authentication Routes
Route::middleware('guest')->group(function () {
Route::get('/', function () {
        return redirect()->route('login');
    });

    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);
});

Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Employee Routes
Route::middleware(['auth', \App\Http\Middleware\EmployeeMiddleware::class])->group(function () {
    // Profile
    Route::get('/profile', [EmployeeController::class, 'profile'])->name('employee.profile');
    Route::put('/profile', [EmployeeController::class, 'updateProfile'])->name('employee.profile.update');
    Route::put('/profile/password', [EmployeeController::class, 'updatePassword'])->name('employee.profile.password');
    
    // Dashboard
    Route::get('/employee/dashboard', [EmployeeController::class, 'dashboard'])->name('employee.dashboard');
    
    // Request History
    Route::get('/employee/request-history', [EmployeeController::class, 'requestHistory'])->name('employee.request-history');
    
    // Salary Advance Request Routes
    Route::prefix('salary-advance')->name('salary-advance.')->group(function () {
        Route::get('/create', [SalaryAdvanceRequestController::class, 'create'])->name('create');
        Route::post('/', [SalaryAdvanceRequestController::class, 'store'])->name('store');
        Route::get('/{request}', [SalaryAdvanceRequestController::class, 'show'])->name('show');
    });
});

// Admin Routes
Route::middleware(['auth', \App\Http\Middleware\AdminMiddleware::class])->prefix('admin')->name('admin.')->group(function () {
    // Dashboard
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    
    // Employee Management
    Route::get('/employees', [AdminController::class, 'employees'])->name('employees.index');
    Route::get('/employees/create', [AdminController::class, 'createEmployee'])->name('employees.create');
    Route::post('/employees', [AdminController::class, 'storeEmployee'])->name('employees.store');
    Route::get('/employees/{employee}/edit', [AdminController::class, 'editEmployee'])->name('employees.edit');
    Route::put('/employees/{employee}', [AdminController::class, 'updateEmployee'])->name('employees.update');
    Route::delete('/employees/{employee}', [AdminController::class, 'deleteEmployee'])->name('employees.delete');
    
    // Request Management
    Route::get('/requests', [AdminController::class, 'requests'])->name('requests');

    Route::put('/requests/{request}/approve', [AdminController::class, 'approveRequest'])->name('requests.approve');
    Route::put('/requests/{request}/reject', [AdminController::class, 'rejectRequest'])->name('requests.reject');

    // Admin Users Management
    Route::get('/users', [AdminController::class, 'users'])->name('users.index');
    Route::get('/users/create', [AdminController::class, 'createUser'])->name('users.create');
    Route::post('/users', [AdminController::class, 'storeUser'])->name('users.store');
    Route::get('/users/{user}/edit', [AdminController::class, 'editUser'])->name('users.edit');
    Route::put('/users/{user}', [AdminController::class, 'updateUser'])->name('users.update');
    Route::delete('/users/{user}', [AdminController::class, 'deleteUser'])->name('users.delete');
    
    // Reports
    Route::get('/reports', [AdminController::class, 'reports'])->name('reports');
});
