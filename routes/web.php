<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\KeranjangController;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\TransaksiController;
use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('layouts.app');
// });

Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

Route::get('/kategori', [KategoriController::class, 'index']);
Route::post('/kategori/store', [KategoriController::class, 'store']);
Route::delete('/kategori/{id}', [KategoriController::class, 'destroy']);

Route::get('/produk', [ProdukController::class, 'index']);
Route::post('/produk', [ProdukController::class, 'store']);
Route::put('/produk/{produk}', [ProdukController::class, 'update']);
Route::delete('/produk/{produk}', [ProdukController::class, 'destroy'])->name('produk.destroy');

Route::put('/kategori/{id}', [KategoriController::class, 'update']);

Route::post('/keranjang/store', [KeranjangController::class, 'store']);
Route::get('/checkout', [KeranjangController::class, 'checkout']);
Route::get('/keranjang', [KeranjangController::class, 'index'])->name('keranjang.index');
Route::post('/keranjang/tambahKeranjang/{id}', [KeranjangController::class, 'tambahKeKeranjang'])->name('keranjang.tambahKeKeranjang');
Route::post('/keranjang/tambah/{id}', [KeranjangController::class, 'tambah'])->name('keranjang.tambah');
Route::post('/keranjang/kurangi/{id}', [KeranjangController::class, 'kurangi'])->name('keranjang.kurangi');
Route::delete('/keranjang/hapus/{id}', [KeranjangController::class, 'hapus'])->name('keranjang.hapus');

Route::get('/checkout', [TransaksiController::class, 'checkout'])->name('katalog.checkout');
Route::post('/checkout', [TransaksiController::class, 'prosesCheckout']);
Route::get('/katalog/{transaksi}', [TransaksiController::class, 'show'])->name('katalog.show');
Route::get('/katalog', [TransaksiController::class, 'index']);

