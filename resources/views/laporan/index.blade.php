@extends('layout.app')

@section('content')
<div class="row mb-4">
    <div class="col-12">
        <h3>Laporan & Grafik Keuangan</h3>
    </div>
</div>

<div class="card shadow-sm mb-4">
    <div class="card-body">
        <form action="{{ route('laporan.index') }}" method="GET" class="row g-3 align-items-end">
            <div class="col-md-4">
                <label>Dari Tanggal</label>
                <input type="date" name="start_date" class="form-control" value="{{ $startDate }}">
            </div>
            <div class="col-md-4">
                <label>Sampai Tanggal</label>
                <input type="date" name="end_date" class="form-control" value="{{ $endDate }}">
            </div>
            <div class="col-md-4">
                <button type="submit" class="btn btn-primary w-100">Tampilkan Laporan</button>
            </div>
        </form>
        <small class="text-muted mt-2 d-block">*Gunakan filter tanggal untuk melihat laporan Harian, Mingguan, atau Bulanan.</small>
    </div>
</div>

<div class="row mb-4">
    <div class="col-md-4">
        <div class="card bg-success text-white">
            <div class="card-body text-center">
                <h5>Total Pemasukan</h5>
                <h2>Rp {{ number_format($totalPemasukan) }}</h2>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card bg-danger text-white">
            <div class="card-body text-center">
                <h5>Total Gaji Karyawan</h5>
                <h2>Rp {{ number_format($totalGaji) }}</h2>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card bg-warning text-dark">
            <div class="card-body text-center">
                <h5>Belanja Inventaris</h5>
                <h2>Rp {{ number_format($totalBelanjaInventaris) }}</h2>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-6 mb-4">
        <div class="card h-100">
            <div class="card-header bg-white fw-bold">Status Cucian</div>
            <div class="card-body">
                <canvas id="chartProses"></canvas>
            </div>
        </div>
    </div>

    <div class="col-md-6 mb-4">
        <div class="card h-100">
            <div class="card-header bg-white fw-bold">Status Pembayaran</div>
            <div class="card-body">
                <canvas id="chartBayar"></canvas>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    // 1. Konfigurasi Grafik Status PROSES
    const ctxProses = document.getElementById('chartProses');
    new Chart(ctxProses, {
        type: 'doughnut', // Grafik Donat
        data: {
            labels: ['Dalam Proses', 'Selesai', 'Sudah Diambil'],
            datasets: [{
                label: 'Jumlah Transaksi',
                data: [
                    {{ $statusProses['proses'] }}, 
                    {{ $statusProses['selesai'] }}, 
                    {{ $statusProses['diambil'] }}
                ],
                backgroundColor: [
                    '#ffc107', // Kuning (Proses)
                    '#198754', // Hijau (Selesai)
                    '#0d6efd'  // Biru (Diambil)
                ],
                hoverOffset: 4
            }]
        }
    });

    // 2. Konfigurasi Grafik Status BAYAR
    const ctxBayar = document.getElementById('chartBayar');
    new Chart(ctxBayar, {
        type: 'pie', // Grafik Kue
        data: {
            labels: ['Lunas', 'Belum Lunas'],
            datasets: [{
                label: 'Jumlah Transaksi',
                data: [
                    {{ $statusBayar['lunas'] }}, 
                    {{ $statusBayar['belum_lunas'] }}
                ],
                backgroundColor: [
                    '#198754', // Hijau (Lunas)
                    '#dc3545'  // Merah (Belum)
                ],
                hoverOffset: 4
            }]
        }
    });
</script>
@endsection