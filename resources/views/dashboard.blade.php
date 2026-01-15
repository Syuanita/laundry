@extends('layout.app')

@section('content')
<div class="row mb-4">
    <div class="col-12">
        <div class="card bg-light border-0 shadow-sm p-4 text-center">
            <h2>Selamat Datang di Sistem Informasi Laundry</h2>
            <p class="text-muted">Kelola semua aktivitas laundry dengan mudah dan cepat.</p>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-4 mb-3">
        <div class="card text-white bg-primary h-100">
            <div class="card-body d-flex flex-column justify-content-center align-items-center">
                <h1 class="display-4 fw-bold">{{ $total_transaksi }}</h1>
                <h5 class="card-title">Transaksi</h5>
                <p class="card-text">Kelola pesanan masuk & status cucian.</p>
                <a href="{{ route('transaksi.index') }}" class="btn btn-light text-primary mt-auto">Buka Kasir</a>
            </div>
        </div>
    </div>

    <div class="col-md-4 mb-3">
        <div class="card text-white bg-success h-100">
            <div class="card-body d-flex flex-column justify-content-center align-items-center">
                <h1 class="display-4 fw-bold">{{ $total_kategori }}</h1>
                <h5 class="card-title">Layanan</h5>
                <p class="card-text">Atur jenis cucian & harga.</p>
                <a href="{{ route('kategori.index') }}" class="btn btn-light text-success mt-auto">Kelola Layanan</a>
            </div>
        </div>
    </div>

    <div class="col-md-4 mb-3">
        <div class="card text-white bg-info h-100">
            <div class="card-body d-flex flex-column justify-content-center align-items-center">
                <h1 class="display-4 fw-bold">{{ $total_karyawan }}</h1>
                <h5 class="card-title">Karyawan</h5>
                <p class="card-text">Data pegawai & penggajian.</p>
                <a href="{{ route('karyawan.index') }}" class="btn btn-light text-info mt-auto">Lihat Data</a>
            </div>
        </div>
    </div>
</div>

<div class="row mt-3">
    <div class="col-md-6">
        <div class="card shadow-sm">
            <div class="card-body">
                <h5>Inventaris Barang</h5>
                <p>Cek stok sabun, plastik, dan peralatan.</p>
                <a href="{{ route('inventaris.index') }}" class="btn btn-outline-dark">Cek Stok</a>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card shadow-sm">
            <div class="card-body">
                <h5>Hitung Gaji</h5>
                <p>Rekap gaji karyawan berdasarkan kinerja.</p>
                <a href="{{ route('penggajian.index') }}" class="btn btn-outline-dark">Buat Penggajian</a>
            </div>
        </div>
    </div>
</div>
@endsection