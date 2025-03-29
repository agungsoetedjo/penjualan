<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\KeranjangController;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\TransaksiController;
use App\Http\Middleware\AdminMiddleware;
use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('layouts.app');
// });

Route::middleware(AdminMiddleware::class)->group(function () {
    Route::get('/kategori', [KategoriController::class, 'index']);
    Route::post('/kategori/store', [KategoriController::class, 'store']);
    Route::delete('/kategori/{id}', [KategoriController::class, 'destroy']);
    Route::put('/kategori/{id}', [KategoriController::class, 'update']);

    Route::get('/produk', [ProdukController::class, 'index']);
    Route::post('/produk', [ProdukController::class, 'store']);
    Route::put('/produk/{produk}', [ProdukController::class, 'update']);
    Route::delete('/produk/{produk}', [ProdukController::class, 'destroy'])->name('produk.destroy');
});

Route::post('/keranjang/store', [KeranjangController::class, 'store']);
Route::get('/checkout', [KeranjangController::class, 'checkout']);
Route::get('/keranjang', [KeranjangController::class, 'index'])->name('keranjang.index');
Route::post('/keranjang/tambahKeranjang/{id}', [KeranjangController::class, 'tambahKeKeranjang'])->name('keranjang.tambahKeKeranjang');
Route::post('/keranjang/update', [KeranjangController::class, 'updateKeranjang'])->name('keranjang.update');
// Route::post('/keranjang/tambah/{id}', [KeranjangController::class, 'tambah'])->name('keranjang.tambah');
// Route::post('/keranjang/kurangi/{id}', [KeranjangController::class, 'kurangi'])->name('keranjang.kurangi');
Route::delete('/keranjang/hapus/{id}', [KeranjangController::class, 'hapus'])->name('keranjang.hapus');

Route::get('/checkout', [TransaksiController::class, 'checkout'])->name('katalog.checkout');
Route::post('/checkout', [TransaksiController::class, 'prosesCheckout']);
Route::get('/katalog/{transaksi}', [TransaksiController::class, 'show'])->name('katalog.show');
Route::get('/katalog', [TransaksiController::class, 'index']);

Route::get('/transaksi', [TransaksiController::class, 'riwayatTransaksi'])->name('transaksi.riwayat');
Route::post('/transaksi/update-status/{id}', [TransaksiController::class, 'updateStatus'])->name('transaksi.update-status');

Route::get('/dashboard/login', [DashboardController::class, 'showLogin'])->name('admin.login');
Route::post('/dashboard/login', [DashboardController::class, 'login'])->name('admin.login.submit');
Route::post('/dashboard/logout', [DashboardController::class, 'logout'])->name('admin.logout');

Route::get('/', [DashboardController::class, 'index'])
    ->name('admin.dashboard')
    ->middleware(AdminMiddleware::class);