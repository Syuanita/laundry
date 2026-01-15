@extends('layout.app')
@section('content')
<h3>Tambah Stok Barang</h3>
<form action="{{ route('inventaris.store') }}" method="POST">
    @csrf
    <div class="mb-3">
        <label>Nama Barang</label>
        <input type="text" name="nama_barang" class="form-control" required>
    </div>
    <div class="row">
        <div class="col-md-6 mb-3">
            <label>Harga Satuan (Rp)</label>
            <input type="number" name="harga" class="form-control" required>
        </div>
        <div class="col-md-6 mb-3">
            <label>Jumlah Stok</label>
            <input type="number" name="stok" class="form-control" required>
        </div>
    </div>
    <button type="submit" class="btn btn-primary">Simpan</button>
</form>
@endsection