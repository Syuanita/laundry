<?php

use Illuminate\Support\Facades\Route;
use App\Models\Transaksi;
use App\Models\Kategori;
use App\Models\Karyawan;
use App\Models\Inventaris;
use App\Models\Penggajian;
use App\Models\Expenditure;

use App\Http\Controllers\LaporanController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\KaryawanController;
use App\Http\Controllers\InventarisController;
use App\Http\Controllers\TransaksiController;
use App\Http\Controllers\PenggajianController;
use App\Http\Controllers\ExpenditureController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\GoogleController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return redirect()->route('login');
});

// Google Auth Routes
Route::controller(GoogleController::class)->group(function(){
    Route::get('auth/google', 'redirectToGoogle')->name('google.login');
    Route::get('auth/google/callback', 'handleGoogleCallback')->name('google.callback');
});

// Guest Routes (Login & Register)
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    
    Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

// Authenticated Routes (Harus Login Dulu)
Route::middleware(['auth'])->group(function () {
    
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // --- DASHBOARD (BISA DIAKSES SEMUA ROLE) ---
    Route::get('/dashboard', function () {
        $total_transaksi = Transaksi::count();
        $total_kategori = Kategori::count();
        $total_karyawan = Karyawan::count();
        $total_inventaris = Inventaris::count();
        $total_penggajian = Penggajian::count();
        $total_expenditure = Expenditure::count();
        
        return view('dashboard', compact(
            'total_transaksi', 
            'total_kategori', 
            'total_karyawan',
            'total_inventaris',
            'total_penggajian',
            'total_expenditure'
        ));
    })->name('dashboard');


    // --- GROUP 1: AKSES ADMIN DAN KARYAWAN (Hanya Lihat & Tambah) ---
    Route::middleware(['role:admin,karyawan'])->group(function () {
        // PERUBAHAN DISINI: Menggunakan ->only() untuk membatasi akses
        // Karyawan hanya boleh: Lihat Data, Form Tambah, Simpan Data, Lihat Detail
        Route::resource('transaksi', TransaksiController::class)
            ->only(['index', 'create', 'store', 'show']);
    });


    // --- GROUP 2: KHUSUS ADMIN SAJA (Full Akses + Edit/Hapus) ---
    Route::middleware(['role:admin'])->group(function () {
        
        // PERUBAHAN DISINI: Sisa fungsi Transaksi (Edit, Update, Hapus) hanya untuk Admin
        Route::resource('transaksi', TransaksiController::class)
            ->only(['edit', 'update', 'destroy']);
        
        // Data Master
        Route::resource('kategori', KategoriController::class);
        Route::resource('karyawan', KaryawanController::class);
        Route::resource('inventaris', InventarisController::class);
        
        // Keuangan & Penggajian
        Route::get('/penggajian/get-total-kg/{karyawan_id}', [PenggajianController::class, 'getTotalKg']);
        Route::resource('penggajian', PenggajianController::class);
        Route::resource('expenditures', ExpenditureController::class);

        // Laporan
        Route::get('/laporan', [LaporanController::class, 'index'])->name('laporan.index');
        Route::get('/laporan/export-pdf', [LaporanController::class, 'exportPdf'])->name('laporan.export_pdf');
    });

});