<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\TransaksiController;
use App\Http\Controllers\KasirController;

Route::get('/', fn() => redirect()->route('login'));
Route::get('/login',  [AuthController::class, 'showLogin'])->name('login')->middleware('guest');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::post('/logout',[AuthController::class, 'logout'])->name('logout')->middleware('auth');

Route::middleware(['auth','role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard',                  [AdminController::class,    'dashboard']     )->name('dashboard');

    Route::resource('products', ProdukController::class)
        ->parameters(['products' => 'produk'])
        ->except(['show']);

    Route::get('/categories',                 [KategoriController::class, 'index']         )->name('categories.index');
    Route::post('/categories',                [KategoriController::class, 'store']         )->name('categories.store');
    Route::put('/categories/{kategori}',      [KategoriController::class, 'update']        )->name('categories.update');
    Route::delete('/categories/{kategori}',   [KategoriController::class, 'destroy']       )->name('categories.destroy');

    Route::get('/transactions',               [TransaksiController::class,'index']         )->name('transactions.index');
    Route::get('/transactions/{transaksi}',   [TransaksiController::class,'show']          )->name('transactions.show');
    Route::delete('/transactions/{transaksi}',[TransaksiController::class,'destroy']       )->name('transactions.destroy');

    Route::get('/users',                      [AdminController::class,    'users']         )->name('users.index');
    Route::post('/users',                     [AdminController::class,    'storeUser']     )->name('users.store');
    Route::delete('/users/{user}',            [AdminController::class,    'destroyUser']   )->name('users.destroy');
});

Route::middleware(['auth','role:kasir'])->prefix('kasir')->name('kasir.')->group(function () {
    Route::get('/',                           [KasirController::class,    'index']         )->name('index');
    Route::get('/produks',                    [KasirController::class,    'getProduks']    )->name('produks');
    Route::post('/transaksi',                 [KasirController::class,    'simpanTransaksi'])->name('transaksi');
    Route::get('/nota/{transaksi}',           [KasirController::class,    'cetakNota']     )->name('nota');
});
