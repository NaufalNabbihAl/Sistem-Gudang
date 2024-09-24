<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\MutasiController;
use App\Http\Controllers\KategoriController;


Route::controller(AuthController::class)->group(function () {
    Route::post('/register', 'register')->name('register');
    Route::post('/login', 'login')->name('login');
});

Route::middleware('auth:sanctum')->group(function () {
    Route::apiResource('barang', BarangController::class);
    Route::apiResource('kategori', KategoriController::class);
    Route::apiResource('mutasi', MutasiController::class);
    Route::get('/mutasi/barang/{barang}', [MutasiController::class, 'barangHistory']);
    Route::get('/mutasi/user/{user}', [MutasiController::class, 'userHistory']);
    Route::apiResource('user', UserController::class);
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});
