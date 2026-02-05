@extends('layout.app')

@section('content')
<div class="container py-4">
    <h2 class="mb-4">Catat Pengeluaran</h2>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    
    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="row">
        <div class="col-md-4">
            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <form action="{{ route('expenditures.store') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label font-weight-bold">Nama Pengeluaran</label>
                            <input type="text" name="nama_pengeluaran" class="form-control @error('nama_pengeluaran') is-invalid @enderror" 
                                   value="{{ old('nama_pengeluaran') }}" placeholder="Contoh: Beli Detergen, Listrik, dll" required>
                            @error('nama_pengeluaran') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label font-weight-bold">Keterangan (Opsional)</label>
                            <textarea name="keterangan" class="form-control @error('keterangan') is-invalid @enderror" 
                                      placeholder="Masukkan keterangan tambahan" rows="3">{{ old('keterangan') }}</textarea>
                            @error('keterangan') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label font-weight-bold">Total Harga (Rp)</label>
                            <input type="number" name="price" class="form-control @error('price') is-invalid @enderror" 
                                   value="{{ old('price') }}" placeholder="Masukkan jumlah pengeluaran" step="0.01" required>
                            @error('price') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label font-weight-bold">Tanggal</label>
                            <input type="date" name="date" class="form-control @error('date') is-invalid @enderror" 
                                   value="{{ old('date', date('Y-m-d')) }}" required>
                            @error('date') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <button type="submit" class="btn btn-primary w-100 shadow-sm">Simpan Pengeluaran</button>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-md-8">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white border-bottom"><strong>Riwayat Pengeluaran</strong></div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover table-striped">
                            <thead class="table-light">
                                <tr>
                                    <th>Tanggal</th>
                                    <th>Nama Pengeluaran</th>
                                    <th>Keterangan</th>
                                    <th>Harga</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($expenditures as $exp)
                                <tr>
                                    <td>{{ \Carbon\Carbon::parse($exp->date)->format('d/m/Y') }}</td>
                                    <td><strong>{{ $exp->nama_pengeluaran }}</strong></td>
                                    <td>{{ $exp->keterangan ?? '-' }}</td>
                                    <td class="fw-bold">Rp {{ number_format($exp->price, 0, ',', '.') }}</td>
                                    <td>
                                        <a href="{{ route('expenditures.edit', $exp->id) }}" class="btn btn-sm btn-info text-white">Edit</a>
                                        <form action="{{ route('expenditures.destroy', $exp->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus?')">
                                            @csrf @method('DELETE')
                                            <button class="btn btn-sm btn-danger">Hapus</button>
                                        </form>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="text-center text-muted py-4">Belum ada data pengeluaran.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection