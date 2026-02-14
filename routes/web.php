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




Route::get('/', function () {
    return redirect()->route('login');
});

Route::controller(GoogleController::class)->group(function(){
    Route::get('auth/google', 'redirectToGoogle')->name('google.login');
    Route::get('auth/google/callback', 'handleGoogleCallback')->name('google.callback');
});



Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    
    Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});


Route::middleware(['auth'])->group(function () {
    
   
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // Dashboard
    Route::get('/dashboard', function () {
        $total_transaksi = Transaksi::count();
        $total_kategori = Kategori::count();
        $total_karyawan = Karyawan::count();
        
        
        return view('dashboard', compact('total_transaksi', 'total_kategori', 'total_karyawan'));
    })->name('dashboard');

    // Resource Routes
    Route::resource('kategori', KategoriController::class);
    Route::resource('karyawan', KaryawanController::class);
    Route::resource('inventaris', InventarisController::class);
    Route::resource('transaksi', TransaksiController::class);
    Route::resource('penggajian', PenggajianController::class);
    Route::resource('expenditures', ExpenditureController::class);
    
    Route::get('/laporan', [LaporanController::class, 'index'])->name('laporan.index');

    Route::get('/laporan/export-pdf', [LaporanController::class, 'exportPdf'])->name('laporan.export_pdf');
});