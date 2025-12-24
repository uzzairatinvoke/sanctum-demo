<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\DocumentsController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// public route
Route::post('login',[AuthController::class,'login']);

// protected route
Route::get('/me',[AuthController::class,'me'])->middleware('auth:sanctum');

Route::apiResource('documents',DocumentsController::class)->middleware(['auth:sanctum']);
