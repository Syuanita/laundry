@extends('layout.app')
@section('content')
<h3>Edit Transaksi</h3>

<form action="{{ route('transaksi.update', $transaksi->id) }}" method="POST" class="mt-3">
    @csrf
    @method('PUT')
    
    <div class="row">
        <div class="col-md-4 mb-3">
            <label>Tanggal Transaksi</label>
            <input type="date" name="tgl_transaksi" class="form-control" 
                   value="{{ old('tgl_transaksi', date('Y-m-d', strtotime($transaksi->tgl_transaksi))) }}" 
                   required>
            @error('tgl_transaksi')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>

        <div class="col-md-4 mb-3">
            <label>Nama Pelanggan</label>
            <input type="text" name="nama_customer" class="form-control" 
                   value="{{ old('nama_customer', $transaksi->nama_customer) }}" required>
            @error('nama_customer')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>

        <div class="col-md-4 mb-3">
            <label>No. Telpon</label>
            <input type="text" name="nomer_telepon" class="form-control" 
                   value="{{ old('nomer_telepon', $transaksi->nomer_telepon) }}" required>
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
                <option value="{{ $k->id }}" 
                    {{ old('kategori_id', $transaksi->kategori_id) == $k->id ? 'selected' : '' }}>
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
        <input type="number" step="0.01" name="berat" class="form-control" 
               value="{{ old('berat', $transaksi->berat) }}" required>
        @error('berat')
            <span class="text-danger">{{ $message }}</span>
        @enderror
    </div>

    <div class="row">
        <div class="col-md-6 mb-3">
            <label>Status Pembayaran</label>
            <select name="status_bayar" class="form-control" required>
                <option value="belum_lunas" 
                    {{ old('status_bayar', $transaksi->status_bayar) == 'belum_lunas' ? 'selected' : '' }}>
                    Belum Lunas
                </option>
                <option value="lunas" 
                    {{ old('status_bayar', $transaksi->status_bayar) == 'lunas' ? 'selected' : '' }}>
                    Lunas
                </option>
            </select>
            @error('status_bayar')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
        <div class="col-md-6 mb-3">
            <label>Status Cucian</label>
            <select name="status_proses" class="form-control" required>
                <option value="proses" 
                    {{ old('status_proses', $transaksi->status_proses) == 'proses' ? 'selected' : '' }}>
                    Sedang Diproses
                </option>
                <option value="selesai" 
                    {{ old('status_proses', $transaksi->status_proses) == 'selesai' ? 'selected' : '' }}>
                    Selesai
                </option>
                <option value="diambil" 
                    {{ old('status_proses', $transaksi->status_proses) == 'diambil' ? 'selected' : '' }}>
                    Sudah Diambil
                </option>
            </select>
            @error('status_proses')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
    </div>
    
    <div class="alert alert-info">
        <strong>Total Harga Saat Ini:</strong> Rp {{ number_format($transaksi->total_harga) }}
        <br>
        <small>Total harga akan dihitung ulang otomatis saat disimpan.</small>
    </div>

    <div class="mb-3">
        <button type="submit" class="btn btn-primary btn-lg">Update Transaksi</button>
        <a href="{{ route('transaksi.index') }}" class="btn btn-secondary btn-lg">Batal</a>
    </div>
</form>
@endsection