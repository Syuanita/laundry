<!DOCTYPE html>
<html>
<head>
    <title>Laporan Keuangan</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; }
        .header { text-align: center; margin-bottom: 20px; }
        .header h2 { margin: 0; }
        .header p { margin: 5px 0; color: #555; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
        .text-right { text-align: right; }
        .text-center { text-align: center; }
        .bg-masuk { background-color: #e8f5e9; } 
        .bg-keluar { background-color: #ffebee; } 
        .total-row { font-weight: bold; background-color: #eee; }
    </style>
</head>
<body>

    <div class="header">
        <h2>LAUNDRY APP - LAPORAN KEUANGAN</h2>
        <p>Periode: {{ date('d M Y', strtotime($startDate)) }} s/d {{ date('d M Y', strtotime($endDate)) }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th class="text-center" width="15%">Tanggal</th>
                <th width="35%">Keterangan</th>
                <th class="text-right" width="15%">Pemasukan (Debit)</th>
                <th class="text-right" width="15%">Pengeluaran (Kredit)</th>
                <th class="text-right" width="20%">Saldo Berjalan</th>
            </tr>
        </thead>
        <tbody>
            @php 
                $saldo = 0; 
                $totalMasuk = 0;
                $totalKeluar = 0;
            @endphp

            @foreach($laporan as $row)
                @php
                    if($row['jenis'] == 'masuk') {
                        $saldo += $row['nominal'];
                        $totalMasuk += $row['nominal'];
                        $class = 'bg-masuk';
                    } else {
                        $saldo -= $row['nominal'];
                        $totalKeluar += $row['nominal'];
                        $class = 'bg-keluar';
                    }
                @endphp
                <tr class="{{ $class }}">
                    <td class="text-center">{{ date('d/m/Y', strtotime($row['tanggal'])) }}</td>
                    <td>{{ $row['keterangan'] }}</td>
                    
                    <td class="text-right">
                        @if($row['jenis'] == 'masuk')
                            Rp {{ number_format($row['nominal'], 0, ',', '.') }}
                        @else
                            -
                        @endif
                    </td>

                    <td class="text-right">
                        @if($row['jenis'] == 'keluar')
                            Rp {{ number_format($row['nominal'], 0, ',', '.') }}
                        @else
                            -
                        @endif
                    </td>

                    <td class="text-right">
                        Rp {{ number_format($saldo, 0, ',', '.') }}
                    </td>
                </tr>
            @endforeach
            
            <tr class="total-row">
                <td colspan="2" class="text-center">TOTAL AKHIR</td>
                <td class="text-right text-success">Rp {{ number_format($totalMasuk, 0, ',', '.') }}</td>
                <td class="text-right text-danger">Rp {{ number_format($totalKeluar, 0, ',', '.') }}</td>
                <td class="text-right">Rp {{ number_format($saldo, 0, ',', '.') }}</td>
            </tr>
        </tbody>
    </table>

</body>
</html>