@extends('layout.app')
@section('content')
<div class="d-flex justify-content-between mb-3">
    <h3>Stok Barang</h3>
    <a href="{{ route('inventaris.create') }}" class="btn btn-primary">Tambah Barang</a>
</div>
<table class="table table-bordered">
    <thead>
        <tr>
            <th>Nama Barang</th>
            <th>Harga Beli</th>
            <th>Stok</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        @foreach($inventaris as $inv)
        <tr>
            <td>{{ $inv->nama_barang }}</td>
            <td>Rp {{ number_format($inv->harga) }}</td>
            <td>{{ $inv->stok }}</td>
            <td>
                <form action="{{ route('inventaris.destroy', $inv->id) }}" method="POST" onsubmit="return confirm('Hapus?')">
                    @csrf @method('DELETE')
                    <button class="btn btn-sm btn-danger">Hapus</button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
@endsection