<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController as ApiAuthController;
use App\Http\Controllers\Api\ProdukController as ApiProdukController;
use App\Http\Controllers\Api\KategoriController as ApiKategoriController;
use App\Http\Controllers\Api\TransaksiController as ApiTransaksiController;
use App\Http\Controllers\Api\DashboardController as ApiDashboardController;

Route::post('/login', [ApiAuthController::class, 'login']);
Route::post('/logout', [ApiAuthController::class, 'logout'])->middleware('auth:sanctum');

Route::get('/produk', [ApiProdukController::class, 'index']);
Route::get('/produk/{id}', [ApiProdukController::class, 'show']);

Route::get('/kategori', [ApiKategoriController::class, 'index']);

Route::get('/transaksi', [ApiTransaksiController::class, 'index'])->middleware('auth:sanctum');
Route::get('/transaksi/{id}', [ApiTransaksiController::class, 'show'])->middleware('auth:sanctum');
Route::post('/transaksi', [ApiTransaksiController::class, 'store'])->middleware('auth:sanctum');

Route::get('/dashboard/stats', [ApiDashboardController::class, 'stats'])->middleware('auth:sanctum');


