@extends('layout.app')

@section('content')

<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Input Transaksi Baru</h6>
    </div>
    <div class="card-body">
        <form action="{{ route('transaksi.store') }}" method="POST">
            @csrf
            
            <div class="row">
                <div class="col-md-4 mb-3">
                    <label>Tanggal Transaksi</label>
                    <input type="date" name="tgl_transaksi" class="form-control" value="{{ date('Y-m-d') }}" required>
                    @error('tgl_transaksi')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <div class="col-md-4 mb-3">
                    <label>Nama Pelanggan</label>
                    <input type="text" name="nama_customer" class="form-control" placeholder="Masukkan nama pelanggan" value="{{ old('nama_customer') }}" required>
                    @error('nama_customer')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <div class="col-md-4 mb-3">
                    <label>No. Telpon (WhatsApp)</label>
                    <input type="number" name="nomer_telepon" class="form-control" placeholder="081234567890" value="{{ old('nomer_telepon') }}" required>
                    <small class="text-muted">Nomor ini akan menerima struk digital.</small>
                    @error('nomer_telepon')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label>Pilih Layanan</label>
                    <select name="kategori_id" class="form-control" required>
                        <option value="">-- Pilih Jenis Laundry --</option>
                        @foreach($kategori as $k)
                            <option value="{{ $k->id }}" {{ old('kategori_id') == $k->id ? 'selected' : '' }}>
                                {{ $k->nama_jenis }} - {{ $k->durasi_layanan }} (Rp {{ number_format($k->harga_per_jenis) }})
                            </option>
                        @endforeach
                    </select>
                    @error('kategori_id')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label>Karyawan yang Mengerjakan</label>
                    <select name="karyawan_id" class="form-control" required>
                        <option value="">-- Pilih Karyawan --</option>
                        @foreach($karyawan as $kry)
                            <option value="{{ $kry->id }}" {{ old('karyawan_id') == $kry->id ? 'selected' : '' }}>
                                {{ $kry->nama_karyawan }}
                            </option>
                        @endforeach
                    </select>
                    @error('karyawan_id')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
            </div>
            
            <div class="mb-3">
                <label>Berat (Kg) / Jumlah (Satuan)</label>
                <input type="number" step="0.01" name="berat" class="form-control" placeholder="Contoh: 2.5" value="{{ old('berat') }}" required>
                @error('berat')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label>Status Pembayaran</label>
                    <select name="status_bayar" class="form-control" required>
                        <option value="belum_lunas">Belum Lunas</option>
                        <option value="lunas">Lunas</option>
                    </select>
                </div>
                <div class="col-md-6 mb-3">
                    <label>Status Cucian</label>
                    <select name="status_proses" class="form-control" required>
                        <option value="proses">Sedang Diproses</option>
                        <option value="selesai">Selesai</option>
                        <option value="diambil">Sudah Diambil</option>
                    </select>
                </div>
            </div>

            <div class="form-group mb-4">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="kirim_wa" value="1" id="kirimWaCheck" checked>
                    <label class="form-check-label font-weight-bold text-success" for="kirimWaCheck">
                        <i class="fab fa-whatsapp"></i> Kirim Struk Digital ke WhatsApp Pelanggan Otomatis
                    </label>
                </div>
            </div>
            
            <div class="alert alert-info">
                <i class="fas fa-info-circle"></i> Data berat akan otomatis terakumulasi ke menu Penggajian hari ini.
            </div>

            <button type="submit" class="btn btn-primary btn-lg btn-block">
                <i class="fas fa-save"></i> Simpan Transaksi
            </button>
        </form>
    </div>
</div>

@endsection