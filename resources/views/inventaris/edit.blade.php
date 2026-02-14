@extends('layout.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 offset-md-2">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="mb-0">Edit Barang: {{ $item->nama_barang }}</h4>
                    <a href="{{ route('inventaris.index') }}" class="btn btn-secondary btn-sm">Kembali</a>
                </div>
                <div class="card-body">
                    
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('inventaris.update', $item->id) }}" method="POST">
                        @csrf
                        @method('PUT') 

                        <div class="mb-3">
                            <label for="nama_barang" class="form-label">Nama Barang</label>
                            <input type="text" name="nama_barang" class="form-control" id="nama_barang" 
                                   value="{{ old('nama_barang', $item->nama_barang) }}" required>
                        </div>

                        <div class="mb-3">
                            <label for="harga" class="form-label">Harga Beli (Rp)</label>
                            <input type="number" name="harga" class="form-control" id="harga" 
                                   value="{{ old('harga', $item->harga) }}" required>
                        </div>

                        <div class="mb-3">
                            <label for="stok" class="form-label">Jumlah Stok</label>
                            <input type="number" name="stok" class="form-control" id="stok" 
                                   value="{{ old('stok', $item->stok) }}" required>
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection