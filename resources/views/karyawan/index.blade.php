@extends('layout.app')
@section('content')
<div class="d-flex justify-content-between mb-3">
    <h3>Data Karyawan</h3>
    <a href="{{ route('karyawan.create') }}" class="btn btn-primary">Tambah Karyawan</a>
</div>
<table class="table table-bordered">
    <tr>
        <th>ID</th>
        <th>Nama Karyawan</th>
        <th>Aksi</th>
    </tr>
    @foreach($karyawan as $k)
    <tr>
        <td>{{ $k->id }}</td>
        <td>{{ $k->nama_karyawan }}</td>
        <td>
             <form action="{{ route('karyawan.destroy', $k->id) }}" method="POST" onsubmit="return confirm('Hapus?')">
                @csrf @method('DELETE')
                <button class="btn btn-sm btn-danger">Hapus</button>
            </form>
        </td>
    </tr>
    @endforeach
</table>
@endsection