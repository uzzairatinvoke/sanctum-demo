<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\DocumentsController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// public route
Route::post('login', [AuthController::class, 'login']);

// protected route
Route::get('/me', [AuthController::class, 'me'])->middleware('auth:sanctum');

// protected route untuk Document
// selain daripada buat logic authorization di controller, kita juga boleh guna middleware
// contoh: ->middleware(['auth:sanctum','can:create-documents'])
// kita tambah can:create-documents di middleware
Route::post('documents', [DocumentsController::class, 'store'])->middleware(['auth:sanctum', 'can:create-documents']);


// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');
