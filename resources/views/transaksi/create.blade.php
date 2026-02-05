@extends('layout.app')
@section('content')
<h3>Input Transaksi Baru</h3>
<form action="{{ route('transaksi.store') }}" method="POST" class="mt-3">
    @csrf
    
    <div class="row">
        <div class="col-md-6 mb-3">
            <label>Nama Pelanggan</label>
            <input type="text" name="nama_customer" class="form-control" placeholder="Masukkan nama pelanggan" required>
            @error('nama_customer')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
        <div class="col-md-6 mb-3">
            <label>No. Telpon</label>
            <input type="text" name="nomer_telepon" class="form-control" placeholder="Contoh: 081234567890" required>
            @error('nomer_telepon')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
    </div>

    <div class="mb-3">
        <label>Pilih Layanan</label>
        <select name="kategori_id" class="form-control" required>
            <option value="">-- Pilih Jenis Laundry --</option>
            @foreach($kategori as $k)
                <option value="{{ $k->id }}">
                    {{ $k->nama_jenis }} - {{ $k->durasi_layanan }} (Rp {{ number_format($k->harga_per_jenis) }})
                </option>
            @endforeach
        </select>
        @error('kategori_id')
            <span class="text-danger">{{ $message }}</span>
        @enderror
    </div>
    
    <div class="mb-3">
        <label>Berat (Kg) / Jumlah (Satuan)</label>
        <input type="number" step="0.01" name="berat" class="form-control" placeholder="Contoh: 2.5" required>
        @error('berat')
            <span class="text-danger">{{ $message }}</span>
        @enderror
    </div>

    <div class="row">
        <div class="col-md-6 mb-3">
            <label>Status Pembayaran</label>
            <select name="status_bayar" class="form-control" required>
                <option value="belum_lunas">Belum Lunas</option>
                <option value="lunas">Lunas</option>
            </select>
            @error('status_bayar')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
        <div class="col-md-6 mb-3">
            <label>Status Cucian</label>
            <select name="status_proses" class="form-control" required>
                <option value="proses">Sedang Diproses</option>
                <option value="selesai">Selesai</option>
                <option value="diambil">Sudah Diambil</option>
            </select>
            @error('status_proses')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
    </div>
    
    <div class="alert alert-info">
        Total harga akan dihitung otomatis oleh sistem setelah Simpan.
    </div>

    <button type="submit" class="btn btn-primary btn-lg">Simpan Transaksi</button>
</form>
@endsection