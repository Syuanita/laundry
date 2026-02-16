@extends('layout.app')
@section('content')

@if(session('whatsapp_url'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <strong><i class="fas fa-check-circle"></i> Transaksi Berhasil Disimpan!</strong><br>
        Silakan klik tombol di bawah untuk mengirim struk digital:
        <br><br>
        
        <a href="{{ session('whatsapp_url') }}" target="_blank" class="btn btn-success btn-lg">
            <i class="fab fa-whatsapp"></i> Kirim Struk ke WhatsApp Pelanggan
        </a>

        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@elseif(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

<div class="d-flex justify-content-between mb-3">
    <h3>Data Transaksi</h3>
    <a href="{{ route('transaksi.create') }}" class="btn btn-warning fw-bold">Transaksi Baru</a>
</div>

<div class="table-responsive">
    <table class="table table-hover">
        <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>Nama Pelanggan</th>
                <th>Layanan</th>
                <th>Karyawan</th> <th>Berat/Jml</th>
                <th>Total Bayar</th>
                <th>Status Bayar</th>
                <th>Status Proses</th>
                <th>Tanggal</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($transaksi as $t)
            <tr>
                <td>#{{ $t->id }}</td>
                <td>
                    {{ $t->nama_customer }}<br>
                    <small class="text-muted">{{ $t->nomer_telepon }}</small>
                </td>
                <td>
                    {{ $t->kategori->nama_jenis }} 
                    <small class="text-muted d-block">({{ $t->kategori->durasi_layanan }})</small>
                </td>
                <td>
                    <span class="badge badge-light border text-dark">
                        <i class="fas fa-user-tag mr-1"></i> {{ $t->karyawan->nama_karyawan ?? 'N/A' }}
                    </span>
                </td>
                <td>{{ $t->berat }} Kg</td>
                <td class="fw-bold text-primary">Rp {{ number_format($t->total_harga) }}</td>
                <td>
                    <span class="badge bg-{{ $t->status_bayar == 'lunas' ? 'success' : 'danger' }}">
                        {{ ucfirst($t->status_bayar) }}
                    </span>
                </td>
                <td>
                    @php
                        $badgeColor = [
                            'proses' => 'info',
                            'selesai' => 'warning',
                            'diambil' => 'success'
                        ];
                    @endphp
                    <span class="badge bg-{{ $badgeColor[$t->status_proses] ?? 'secondary' }}">
                        {{ ucfirst($t->status_proses) }}
                    </span>
                </td>
                
                <td>{{ date('d M Y', strtotime($t->tgl_transaksi)) }}</td>

                <td>
                    <div class="btn-group">
                        <a href="{{ route('transaksi.edit', $t->id) }}" class="btn btn-sm btn-info text-white">
                            <i class="fas fa-edit"></i>
                        </a>
                        
                        <form action="{{ route('transaksi.destroy', $t->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus transaksi ini?')">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-danger">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                    </div>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection