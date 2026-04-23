<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\LoanController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\CategoryController;

/*
|--------------------------------------------------------------------------
| AUTH
|--------------------------------------------------------------------------
*/
Route::get('/', [AuthController::class, 'loginForm']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout']);

/*
|--------------------------------------------------------------------------
| DASHBOARD
|--------------------------------------------------------------------------
*/
Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth'])
    ->name('dashboard');

/*
|--------------------------------------------------------------------------
| MASTER DATA
|--------------------------------------------------------------------------
*/
Route::resource('/users', UserController::class);
Route::resource('/books', BookController::class);

/*
|--------------------------------------------------------------------------
| USER ACTION
|--------------------------------------------------------------------------
*/
Route::post('/pinjam/{id}', [LoanController::class, 'store']);
Route::post('/return-request/{id}', [LoanController::class, 'requestReturn']);
Route::get('/my-loans', [LoanController::class, 'myLoans']);
Route::get('/history', [LoanController::class, 'history']);

/*
|--------------------------------------------------------------------------
| ADMIN ACTION
|--------------------------------------------------------------------------
*/
Route::get('/loans', [LoanController::class, 'index']);
Route::post('/loans/{id}/approve', [LoanController::class, 'approve']);
Route::post('/loans/{id}/reject', [LoanController::class, 'reject']);
Route::get('/loans/return', [LoanController::class, 'returnIndex']);
Route::post('/approve-return/{id}', [LoanController::class, 'approveReturn']);

/*
|--------------------------------------------------------------------------
| CATEGORIES
|--------------------------------------------------------------------------
*/
Route::get('/categories', [CategoryController::class, 'index']);
Route::post('/categories', [CategoryController::class, 'store']);
Route::put('/categories/{id}', [CategoryController::class, 'update']);
Route::delete('/categories/{id}', [CategoryController::class, 'destroy']);