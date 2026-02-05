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
                <label class="fw-bold">Dari Tanggal</label>
                <input type="date" name="start_date" class="form-control" value="{{ $startDate }}">
            </div>
            <div class="col-md-4">
                <label class="fw-bold">Sampai Tanggal</label>
                <input type="date" name="end_date" class="form-control" value="{{ $endDate }}">
            </div>
            <div class="col-md-4">
                <button type="submit" class="btn btn-primary w-100">Tampilkan Laporan</button>
            </div>
        </form>
    </div>
</div>

<div class="row mb-4">
    <div class="col-md-3">
        <div class="card bg-success text-white shadow-sm">
            <div class="card-body text-center">
                <h6>Total Pemasukan</h6>
                <h3>Rp {{ number_format($totalPemasukan) }}</h3>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card bg-danger text-white shadow-sm">
            <div class="card-body text-center">
                <h6>Gaji Karyawan</h6>
                <h3>Rp {{ number_format($totalGaji) }}</h3>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card bg-warning text-dark shadow-sm">
            <div class="card-body text-center">
                <h6>Belanja Inventaris</h6>
                <h3>Rp {{ number_format($totalBelanjaInventaris) }}</h3>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card bg-info text-white shadow-sm">
            <div class="card-body text-center">
                <h6>Laba Bersih</h6>
                <h3>Rp {{ number_format($totalPemasukan - ($totalGaji + $totalBelanjaInventaris)) }}</h3>
            </div>
        </div>
    </div>
</div>

<div class="row mb-4">
    <div class="col-md-4 mb-4">
        <div class="card h-100 shadow-sm">
            <div class="card-header bg-dark text-white fw-bold">
                <i class="bi bi-star-fill text-warning"></i> Customer Terloyal
            </div>
            <div class="card-body p-0">
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Nama</th>
                            <th>No. Telp</th>
                            <th class="text-center">Order</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($topCustomers as $customer)
                        <tr>
                            <td>{{ $customer->nama_customer }}</td>
                            <td>{{ $customer->nomer_telepon }}</td>
                            <td class="text-center"><span class="badge bg-primary">{{ $customer->total_transaksi }}x</span></td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="3" class="text-center text-muted p-3">Belum ada data</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="col-md-4 mb-4">
        <div class="card h-100 shadow-sm">
            <div class="card-header bg-white fw-bold">Status Cucian</div>
            <div class="card-body">
                <canvas id="chartProses"></canvas>
            </div>
        </div>
    </div>

    <div class="col-md-4 mb-4">
        <div class="card h-100 shadow-sm">
            <div class="card-header bg-white fw-bold">Status Pembayaran</div>
            <div class="card-body">
                <canvas id="chartBayar"></canvas>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-6 mb-4">
        <div class="card h-100 shadow-sm">
            <div class="card-header bg-white fw-bold">Detail Pengeluaran</div>
            <div class="card-body">
                <canvas id="chartPengeluaran"></canvas>
            </div>
        </div>
    </div>

    <div class="col-md-6 mb-4">
        <div class="card h-100 shadow-sm border-primary">
            <div class="card-header bg-primary text-white fw-bold">Analisis Cash Flow</div>
            <div class="card-body">
                <canvas id="chartComparison"></canvas>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    const formatIDR = (value) => 'Rp ' + value.toLocaleString('id-ID');

    // 1. Grafik Status PROSES
    new Chart(document.getElementById('chartProses'), {
        type: 'doughnut',
        data: {
            labels: ['Proses', 'Selesai', 'Diambil'],
            datasets: [{
                data: [{{ $statusProses['proses'] }}, {{ $statusProses['selesai'] }}, {{ $statusProses['diambil'] }}],
                backgroundColor: ['#ffc107', '#198754', '#0d6efd']
            }]
        },
        options: { plugins: { legend: { position: 'bottom' } } }
    });

    // 2. Grafik Status BAYAR
    new Chart(document.getElementById('chartBayar'), {
        type: 'pie',
        data: {
            labels: ['Lunas', 'Belum Lunas'],
            datasets: [{
                data: [{{ $statusBayar['lunas'] }}, {{ $statusBayar['belum_lunas'] }}],
                backgroundColor: ['#198754', '#dc3545']
            }]
        },
        options: { plugins: { legend: { position: 'bottom' } } }
    });

    // 3. Grafik Detail Pengeluaran
    new Chart(document.getElementById('chartPengeluaran'), {
        type: 'bar',
        data: {
            labels: ['Gaji', 'Inventaris'],
            datasets: [{
                label: 'Total (Rp)',
                data: [{{ $totalGaji }}, {{ $totalBelanjaInventaris }}],
                backgroundColor: ['#dc3545', '#ffc107'],
                borderRadius: 5
            }]
        },
        options: {
            scales: { y: { beginAtZero: true, ticks: { callback: (v) => formatIDR(v) } } }
        }
    });

    // 4. Grafik Comparison
    new Chart(document.getElementById('chartComparison'), {
        type: 'bar',
        data: {
            labels: ['Perbandingan'],
            datasets: [
                {
                    label: 'Pemasukan',
                    data: [{{ $totalPemasukan }}],
                    backgroundColor: '#198754',
                    borderRadius: 5
                },
                {
                    label: 'Pengeluaran',
                    data: [{{ $totalGaji + $totalBelanjaInventaris }}],
                    backgroundColor: '#dc3545',
                    borderRadius: 5
                }
            ]
        },
        options: {
            scales: { y: { beginAtZero: true, ticks: { callback: (v) => formatIDR(v) } } },
            plugins: {
                tooltip: { callbacks: { label: (ctx) => ctx.dataset.label + ': ' + formatIDR(ctx.parsed.y) } }
            }
        }
    });
    
</script>
@endsection