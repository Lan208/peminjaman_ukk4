<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\LoanController;
use App\Http\Controllers\DashboardController;

/*
|--------------------------------------------------------------------------
| AUTH
|--------------------------------------------------------------------------
*/
Route::get('/', [AuthController::class, 'loginForm']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout']);
Route::get('/dashboard', [AuthController::class, 'dashboard']);

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

// pinjam buku
Route::post('/pinjam/{id}', [LoanController::class, 'store']);

// request pengembalian
Route::post('/return-request/{id}', [LoanController::class, 'requestReturn']);

// lihat pinjaman sendiri
Route::get('/my-loans', [LoanController::class, 'myLoans']);

// history user
Route::get('/history', [LoanController::class, 'history']);


/*
|--------------------------------------------------------------------------
| ADMIN ACTION
|--------------------------------------------------------------------------
*/

// lihat semua peminjaman
Route::get('/loans', [LoanController::class, 'index']);

// approve / reject peminjaman
Route::post('/loans/{id}/approve', [LoanController::class, 'approve']);
Route::post('/loans/{id}/reject', [LoanController::class, 'reject']);

// halaman approval pengembalian
Route::get('/loans/return', [LoanController::class, 'returnIndex']);

// approve pengembalian
Route::post('/approve-return/{id}', [LoanController::class, 'approveReturn']);

// dashboard
Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth'])
    ->name('dashboard');