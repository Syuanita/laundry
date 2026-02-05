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


Route::get('/', function () {
    $total_transaksi = Transaksi::count();
    $total_kategori = Kategori::count();
    $total_karyawan = Karyawan::count();

    return view('dashboard', compact('total_transaksi', 'total_kategori', 'total_karyawan'));
});

Route::resource('kategori', KategoriController::class);
Route::resource('karyawan', KaryawanController::class);
Route::resource('inventaris', InventarisController::class);
Route::resource('transaksi', TransaksiController::class);
Route::resource('penggajian', PenggajianController::class);
Route::get('/laporan', [LaporanController::class, 'index'])->name('laporan.index');
Route::resource('inventaris', InventarisController::class);

Route::resource('expenditures', ExpenditureController::class);

Route::get('/laporan', [LaporanController::class, 'index'])->name('laporan.index');


