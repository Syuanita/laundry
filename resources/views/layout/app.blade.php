<!doctype html>
<html lang="id">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Sistem Laundry</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  </head>
  <body>

    <nav class="navbar navbar-expand-lg navbar-dark bg-primary mb-4">
      <div class="container">
        <a class="navbar-brand fw-bold" href="{{ url('/') }}">LAUNDRY APP</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
          <ul class="navbar-nav ms-auto">
            <li class="nav-item">
              <a class="nav-link" href="{{ url('/') }}">Dashboard</a>
            </li>
            
            <li class="nav-item">
              <a class="nav-link fw-bold text-warning" href="{{ route('transaksi.index') }}">Transaksi</a>
            </li>

            <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                Data Master
              </a>
              <ul class="dropdown-menu">
                <li><a class="dropdown-item" href="{{ route('kategori.index') }}">Kategori & Layanan</a></li>
                <li><a class="dropdown-item" href="{{ route('karyawan.index') }}">Data Karyawan</a></li>
                {{-- <li><a class="dropdown-item" href="{{ route('inventaris.index') }}">Inventaris Barang</a></li> --}}
              </ul>
            </li>

            <li class="nav-item">
              <a class="nav-link" href="{{ route('penggajian.index') }}">Penggajian</a>
            </li>

            <li class="nav-item">
              <a class="nav-link" href="{{ route('expenditures.index') }}">Pengeluaran</a>
            </li>

            <li class="nav-item">
              <a class="nav-link fw-bold" href="{{ route('laporan.index') }}">Laporan & Grafik</a>
            </li>
          </ul>
        </div>
      </div>
    </nav>

    <div class="container">
        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        @yield('content')
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  </body>
</html>