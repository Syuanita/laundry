@extends('layout.app')
@section('content')
<h3>Input Penggajian Mingguan/Bulanan</h3>
<form action="{{ route('penggajian.store') }}" method="POST">
    @csrf
    <div class="mb-3">
        <label>Pilih Karyawan</label>
        <select name="karyawan_id" class="form-control" required>
            @foreach($karyawan as $k)
                <option value="{{ $k->id }}">{{ $k->nama_karyawan }}</option>
            @endforeach
        </select>
    </div>
    
    <div class="row">
        <div class="col-md-6 mb-3">
            <label>Total Berat Dikerjakan (Kg)</label>
            <input type="number" step="0.01" name="total_kg_dikerjakan" class="form-control" required>
        </div>
        <div class="col-md-6 mb-3">
            <label>Upah Per Kg (Rp)</label>
            <input type="number" name="tarif_per_kg" class="form-control" placeholder="Contoh: 1000" required>
            <small class="text-muted">Gaji akan dihitung: Berat x Upah</small>
        </div>
    </div>

    <button type="submit" class="btn btn-success">Hitung & Simpan Gaji</button>
</form>
@endsection