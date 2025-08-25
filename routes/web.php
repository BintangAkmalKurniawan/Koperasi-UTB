<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AnggotaController;
use App\Http\Controllers\SHUController;
use App\Http\Controllers\Dashboard;
use App\Http\Controllers\SimpananController;
use App\Http\Controllers\DashboardAnggotaController;
use App\Http\Controllers\ForgotPasswordController;
use App\Http\Controllers\JualBeliAnggotaController;
use App\Http\Controllers\ProdukAnggotaController;
use App\Http\Controllers\ProductImageController;
use App\Http\Controllers\ProfilAnggotaController;
use App\Http\Controllers\ShuAnggotaController;
use App\Http\Controllers\SimpananAnggotaController;
use App\Http\Controllers\TabunganController;
use App\Http\Controllers\TabunganAnggotaController;
use App\Http\Controllers\TransaksiController;

// Auth
Route::redirect('/', '/login');
Route::get('/login', [AuthController::class, 'index'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('loginCheck');


Route::middleware('auth')->group(function () {
    Route::get('/profil', [AuthController::class, 'profil'])->name('profil');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});

    //View Admin
    Route::middleware(['auth', 'admin'])->group(function () {
        //Dashboard
        Route::get('/dashboard', [Dashboard::class, 'index'])->name('dashboard');
        Route::get('/profil', [AuthController::class, 'Profil'])->name('profil');
        Route::get('/simpanan/info/{id_user}', [SimpananController::class, 'getInfo'])->name('simpanan.info');
        Route::post('/update-password', [ForgotPasswordController::class, 'updatePassword'])->name('password.update');
        //Anggota
        Route::controller(AnggotaController::class)->group(function () {
            Route::get('/daftar-anggota', 'index')->name('daftar-anggota')->middleware('no-cache');
            Route::get('/tambah-anggota', 'create')->name('anggota.create');
            Route::post('/anggota', 'store')->name('anggota.store');
            Route::get('/anggota/{id}', 'show')->name('anggota.show');
            Route::put('/anggota/{id}', 'update')->name('anggota.update');
            Route::delete('/anggota/{id}', 'destroy')->name('anggota.destroy');
        });

        // Manajemen Simpanan / Tabungan
        Route::get('/simpanan', [SimpananController::class, 'index'])->name('simpanan');
        Route::post('/simpanan', [SimpananController::class, 'store'])->name('simpanan.store');
        Route::post('/simpanan/alokasi', [SimpananController::class, 'setNextAllocation'])->name('simpanan.alokasi');
        Route::post('/simpanan/target', [SimpananController::class, 'setTargetAndPeriode'])->name('simpanan.target');
        

        // Manajemen SHU
        Route::get('/shu', [SHUController::class, 'index'])->name('shu.index');
        Route::post('/shu', [SHUController::class, 'store'])->name('shu.store');
        Route::get('/shu/{period}', [SHUController::class, 'show'])->name('shu.show');
        Route::get('/shu/{id}/cetak', [ShuController::class, 'cetak'])->name('shu.cetak');


        // Tabungan
        Route::get('/tabungan',[TabunganController::class, 'index'])->name('tabungan.index');
        Route::post('/tabungan',[TabunganController::class, 'store'])->name('tabungan.store');
        Route::get('/tabungan/{id_user}/cetak-rekap', [TabunganController::class, 'cetakRekap'])->name('tabungan.cetakRekap');

    
        // TRANSAKSI
        Route::resource('transaksi', TransaksiController::class);
        Route::get('/transaksi/{transaksi}/struk', [TransaksiController::class, 'cetakStruk'])->name('transaksi.struk');

        // ROUTE GAMBAR PRODUK
        Route::delete('products/{product}/images/{image}', [ProductImageController::class, 'destroy'])
            ->name('products.images.destroy');
        Route::post('products/{product}/images/{image}/thumbnail', [ProductImageController::class, 'setThumbnail'])
            ->name('products.images.thumbnail');

        // ROUTE TRASH & RESTORE PRODUK
        Route::get('/products/trash', [ProdukAnggotaController::class, 'trash'])->name('products.trash');
        Route::post('/products/{id_product}/restore', [ProdukAnggotaController::class, 'restore'])->name('products.restore');
        Route::delete('/products/{id_product}/force-delete', [ProdukAnggotaController::class, 'forceDelete'])->name('products.forceDelete');

        // RESOURCE PRODUK
        Route::resource('products', ProdukAnggotaController::class);

        // API PENCARIAN ANGGOTA
        Route::get('/anggota/search/{nik}', [AnggotaController::class, 'search']);

});

     // View Anggota
        Route::middleware(['auth', 'anggota'])->group(function() {
        
        // Dashboard
            Route::get('/dashboard-anggota', [DashboardAnggotaController::class, 'index'])->name('dashboardAnggota');

            // Jual Beli
            Route::get('/jualbeli-anggota', [JualBeliAnggotaController::class, 'index'])->name('jualbeliAnggota');

            // Produk
            Route::get('/produk-anggota', [ProdukAnggotaController::class, 'indexAnggota'])->name('anggota.produk.index');
            Route::get('/anggota/produk/pribadi', [ProdukAnggotaController::class, 'indexAnggotaPribadi'])->name('anggota.produk.pribadi');
            Route::get('/produk-anggota/{id}', [ProdukAnggotaController::class, 'showAnggota'])->name('anggota.produk.show');

            
            // Profil
            Route::get('/profil-anggota', [ProfilAnggotaController::class, 'index'])->name('profilAnggota');

            // Shu
            Route::get('/shu-anggota', [ShuAnggotaController::class, 'index'])->name('shuAnggota');

            //Simpanan
            Route::get('/simpanan-anggota', [SimpananAnggotaController::class, 'index'])->name('anggota.simpanan.index');

            // Tabungan
            Route::get('/tabungan-anggota', [TabunganAnggotaController::class, 'index'])->name('tabunganAnggota');

    });