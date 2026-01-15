@extends('layout.app')
@section('content')
<h3>Tambah Karyawan</h3>
<form action="{{ route('karyawan.store') }}" method="POST">
    @csrf
    <div class="mb-3">
        <label>Nama Lengkap</label>
        <input type="text" name="nama_karyawan" class="form-control" required>
    </div>
    <button type="submit" class="btn btn-primary">Simpan</button>
</form>
@endsection