@extends('layout.app')
@section('content')
<h3>Tambah Layanan Baru</h3>
<form action="{{ route('kategori.store') }}" method="POST" class="mt-3">
    @csrf
    <div class="mb-3">
        <label>Nama Jenis (Contoh: Cuci Kering)</label>
        <input type="text" name="nama_jenis" class="form-control" required>
    </div>
    <div class="mb-3">
        <label>Tipe</label>
        <select name="tipe" class="form-control">
            <option value="kiloan">Kiloan</option>
            <option value="satuan">Satuan</option>
        </select>
    </div>
    <div class="mb-3">
        <label>Harga Dasar (Per Kg/Pcs)</label>
        <input type="number" name="harga_per_jenis" class="form-control" required>
    </div>
    <div class="row">
        <div class="col-md-6 mb-3">
            <label>Durasi (Contoh: 1 Hari / 6 Jam)</label>
            <input type="text" name="durasi_layanan" class="form-control" required>
        </div>
        <div class="col-md-6 mb-3">
            <label>Biaya Layanan Tambahan (Rp)</label>
            <input type="number" name="biaya_layanan" class="form-control" value="0" required>
        </div>
    </div>
    <button type="submit" class="btn btn-success">Simpan</button>
</form>
@endsection