@extends('layout.app')
@section('content')
<div class="d-flex justify-content-between mb-3">
    <h3>Riwayat Penggajian</h3>
    <a href="{{ route('penggajian.create') }}" class="btn btn-success">Input Gaji</a>
</div>
<table class="table table-bordered">
    <thead>
        <tr>
            <th>Karyawan</th>
            <th>Total Kg Dikerjakan</th>
            <th>Total Gaji Diterima</th>
            <th>Tanggal Input</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        @foreach($penggajian as $p)
        <tr>
            <td>{{ $p->karyawan->nama_karyawan }}</td>
            <td>{{ $p->total_kg_dikerjakan }} Kg</td>
            <td class="fw-bold text-success">Rp {{ number_format($p->total_gaji) }}</td>
            <td>{{ $p->created_at->format('d M Y') }}</td>
            <td>
                <form action="{{ route('penggajian.destroy', $p->id) }}" method="POST" onsubmit="return confirm('Hapus?')">
                    @csrf @method('DELETE')
                    <button class="btn btn-sm btn-danger">Hapus</button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
@endsection