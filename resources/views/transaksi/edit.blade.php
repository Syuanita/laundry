@extends('layout.app')

@section('content')

<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Edit Transaksi #{{ $transaksi->id }}</h6>
    </div>
    <div class="card-body">
        <form action="{{ route('transaksi.update', $transaksi->id) }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="row">
                <div class="col-md-4 mb-3">
                    <label>Tanggal Transaksi</label>
                    <input type="date" name="tgl_transaksi" class="form-control" 
                           value="{{ old('tgl_transaksi', date('Y-m-d', strtotime($transaksi->tgl_transaksi))) }}" 
                           required>
                    @error('tgl_transaksi')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <div class="col-md-4 mb-3">
                    <label>Nama Pelanggan</label>
                    <input type="text" name="nama_customer" class="form-control" 
                           value="{{ old('nama_customer', $transaksi->nama_customer) }}" required>
                    @error('nama_customer')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <div class="col-md-4 mb-3">
                    <label>No. Telpon (WhatsApp)</label>
                    <input type="text" name="nomer_telepon" class="form-control" 
                           value="{{ old('nomer_telepon', $transaksi->nomer_telepon) }}" required>
                    @error('nomer_telepon')
                        <small class="text-danger">{{ $message }}</small>
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
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>
            
            <div class="mb-3">
                <label>Berat (Kg) / Jumlah (Satuan)</label>
                <input type="number" step="0.01" name="berat" class="form-control" 
                       value="{{ old('berat', $transaksi->berat) }}" required>
                @error('berat')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label>Status Pembayaran</label>
                    <select name="status_bayar" class="form-control" required>
                        <option value="belum_lunas" {{ old('status_bayar', $transaksi->status_bayar) == 'belum_lunas' ? 'selected' : '' }}>Belum Lunas</option>
                        <option value="lunas" {{ old('status_bayar', $transaksi->status_bayar) == 'lunas' ? 'selected' : '' }}>Lunas</option>
                    </select>
                </div>
                <div class="col-md-6 mb-3">
                    <label>Status Cucian</label>
                    <select name="status_proses" class="form-control" required>
                        <option value="proses" {{ old('status_proses', $transaksi->status_proses) == 'proses' ? 'selected' : '' }}>Sedang Diproses</option>
                        <option value="selesai" {{ old('status_proses', $transaksi->status_proses) == 'selesai' ? 'selected' : '' }}>Selesai</option>
                        <option value="diambil" {{ old('status_proses', $transaksi->status_proses) == 'diambil' ? 'selected' : '' }}>Sudah Diambil</option>
                    </select>
                </div>
            </div>

            {{-- ALERT INFO HARGA --}}
            <div class="alert alert-info">
                <strong><i class="fas fa-calculator"></i> Info:</strong> 
                Total harga saat ini adalah <b>Rp {{ number_format($transaksi->total_harga) }}</b>. 
                Sistem akan menghitung ulang otomatis jika Anda mengubah layanan atau berat.
            </div>


            <div class="card bg-light mb-3">
                <div class="card-body py-2">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="kirim_wa" value="1" id="kirimWaEdit">
                        <label class="form-check-label font-weight-bold text-success" for="kirimWaEdit">
                            <i class="fab fa-whatsapp"></i> Kirim Struk REVISI ke WhatsApp Customer?
                        </label>
                        <br>
                        <small class="text-muted ml-4">Centang ini jika Anda ingin mengirim notifikasi perubahan data ke pelanggan.</small>
                    </div>
                </div>
            </div>

            <div class="d-flex justify-content-between">
                <a href="{{ route('transaksi.index') }}" class="btn btn-secondary">Batal</a>
                <button type="submit" class="btn btn-primary btn-lg"><i class="fas fa-save"></i> Update Perubahan</button>
            </div>
        </form>
    </div>
</div>
@endsection