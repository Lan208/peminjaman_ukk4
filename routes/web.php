<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\LoanController;


Route::get('/', [AuthController::class, 'loginForm']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout']);
Route::get('/dashboard', [AuthController::class, 'dashboard']);
Route::resource('/users', UserController::class);
Route::resource('/books', BookController::class);
// USER PINJAM
Route::post('/pinjam/{id}', [LoanController::class, 'store']);

// ADMIN
Route::get('/loans', [LoanController::class, 'index']);
Route::post('/loans/{id}/approve', [LoanController::class, 'approve']);
Route::post('/loans/{id}/reject', [LoanController::class, 'reject']);
Route::get('/history', [LoanController::class, 'history']);
Route::post('/loans/{id}/return', [LoanController::class, 'return']);

Route::post('/return-request/{id}', [LoanController::class, 'requestReturn']);
Route::post('/approve-return/{id}', [LoanController::class, 'approveReturn']);
Route::get('/loans/return', [LoanController::class, 'returnRequests']);
Route::get('/my-loans', [LoanController::class, 'myLoans']);
Route::post('/return/{id}', [LoanController::class, 'returnBook']); 
