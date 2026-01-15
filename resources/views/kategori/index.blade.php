@extends('layout.app')
@section('content')
<div class="d-flex justify-content-between mb-3">
    <h3>Data Kategori & Layanan</h3>
    <a href="{{ route('kategori.create') }}" class="btn btn-primary">Tambah Layanan</a>
</div>

<table class="table table-bordered table-striped">
    <thead>
        <tr>
            <th>Nama Layanan</th>
            <th>Tipe</th>
            <th>Harga Dasar</th>
            <th>Durasi</th>
            <th>Biaya Layanan</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        @foreach($kategori as $item)
        <tr>
            <td>{{ $item->nama_jenis }}</td>
            <td>{{ ucfirst($item->tipe) }}</td>
            <td>Rp {{ number_format($item->harga_per_jenis) }}</td>
            <td>{{ $item->durasi_layanan }}</td>
            <td>Rp {{ number_format($item->biaya_layanan) }}</td>
            <td>
                <form action="{{ route('kategori.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Yakin hapus?')">
                    @csrf @method('DELETE')
                    <button type="submit" class="btn btn-sm btn-danger">Hapus</button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
@endsection