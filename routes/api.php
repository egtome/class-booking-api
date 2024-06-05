<?php

use App\Http\Controllers\Api\BookingController;
use App\Http\Controllers\Api\UserController;
use Illuminate\Support\Facades\Route;

Route::post('user/register', [UserController::class, 'register']);
Route::post('user/login', [UserController::class, 'login']);
Route::get('books/available', [BookingController::class, 'getAvailableBooks']);

Route::group(['middleware' => ['auth:sanctum', 'checktokenactivity', 'loguseractivity']], function() {
    Route::post('user/logout', [UserController::class, 'logout']);
    Route::post('book', [BookingController::class, 'bookClass']);
    Route::delete('book/{id}', [BookingController::class, 'remove']);
});
