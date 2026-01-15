@extends('layout.app')
@section('content')
<h3>Input Transaksi Baru</h3>
<form action="{{ route('transaksi.store') }}" method="POST" class="mt-3">
    @csrf
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
    </div>
    
    <div class="mb-3">
        <label>Berat (Kg) / Jumlah (Satuan)</label>
        <input type="number" step="0.01" name="berat" class="form-control" placeholder="Contoh: 2.5" required>
    </div>

    <div class="row">
        <div class="col-md-6 mb-3">
            <label>Status Pembayaran</label>
            <select name="status_bayar" class="form-control">
                <option value="belum_lunas">Belum Lunas</option>
                <option value="lunas">Lunas</option>
            </select>
        </div>
        <div class="col-md-6 mb-3">
            <label>Status Cucian</label>
            <select name="status_proses" class="form-control">
                <option value="proses">Sedang Diproses</option>
                <option value="selesai">Selesai</option>
                <option value="diambil">Sudah Diambil</option>
            </select>
        </div>
    </div>
    
    <div class="alert alert-info">
        Total harga akan dihitung otomatis oleh sistem setelah Simpan.
    </div>

    <button type="submit" class="btn btn-primary btn-lg">Simpan Transaksi</button>
</form>
@endsection