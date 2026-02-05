@extends('layout.app')

@section('content')
<div class="container py-4">
    <h2 class="mb-4">Edit Pengeluaran</h2>

    <div class="row">
        <div class="col-md-6">
            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <form action="{{ route('expenditures.update', $expenditure->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <div class="mb-3">
                            <label class="form-label font-weight-bold">Nama Pengeluaran</label>
                            <input type="text" name="nama_pengeluaran" class="form-control @error('nama_pengeluaran') is-invalid @enderror" 
                                   value="{{ old('nama_pengeluaran', $expenditure->nama_pengeluaran) }}" required>
                            @error('nama_pengeluaran') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label font-weight-bold">Keterangan (Opsional)</label>
                            <textarea name="keterangan" class="form-control @error('keterangan') is-invalid @enderror" rows="3">{{ old('keterangan', $expenditure->keterangan) }}</textarea>
                            @error('keterangan') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label font-weight-bold">Total Harga (Rp)</label>
                            <input type="number" name="price" class="form-control @error('price') is-invalid @enderror" 
                                   value="{{ old('price', $expenditure->price) }}" step="0.01" required>
                            @error('price') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label font-weight-bold">Tanggal</label>
                            <input type="date" name="date" class="form-control @error('date') is-invalid @enderror" 
                                   value="{{ old('date', $expenditure->date instanceof \DateTime ? $expenditure->date->format('Y-m-d') : $expenditure->date) }}" required>
                            @error('date') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary w-100 shadow-sm">Update Pengeluaran</button>
                            <a href="{{ route('expenditures.index') }}" class="btn btn-secondary w-100">Batal</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection