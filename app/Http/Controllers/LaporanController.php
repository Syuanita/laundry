<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaksi;
use App\Models\Penggajian;
use App\Models\Inventaris;
use App\Models\Expenditure;
use Carbon\Carbon;

class LaporanController extends Controller
{
    public function index(Request $request)
    {
        // Ambil tanggal dari request atau default ke bulan ini
        $startDate = $request->input('start_date', Carbon::now()->startOfMonth()->toDateString());
        $endDate = $request->input('end_date', Carbon::now()->endOfMonth()->toDateString());

        // Query transaksi berdasarkan tanggal
        $transaksi = Transaksi::whereBetween('created_at', [$startDate . ' 00:00:00', $endDate . ' 23:59:59'])->get();
        
        // Status Proses (Doughnut Chart)
        $statusProses = [
            'proses' => $transaksi->where('status_proses', 'proses')->count(),
            'selesai' => $transaksi->where('status_proses', 'selesai')->count(),
            'diambil' => $transaksi->where('status_proses', 'diambil')->count(),
        ];

        // Status Pembayaran (Pie Chart)
        $statusBayar = [
            'lunas' => $transaksi->where('status_bayar', 'lunas')->count(),
            'belum_lunas' => $transaksi->where('status_bayar', 'belum_lunas')->count(),
        ];

        // Total Pemasukan dari Transaksi
        $totalPemasukan = $transaksi->sum('total_harga');
        
        // Total Gaji Karyawan
        $totalGaji = Penggajian::whereBetween('created_at', [$startDate . ' 00:00:00', $endDate . ' 23:59:59'])
            ->sum('total_gaji');
        
        // Total Belanja Inventaris (dari tabel expenditures)
        $totalBelanjaInventaris = Expenditure::whereBetween('date', [$startDate, $endDate])
            ->sum('price');

        // Top Customers (Customer Terloyal) - 5 Customer Teratas
        $topCustomers = Transaksi::selectRaw('nama_customer, nomer_telepon, COUNT(*) as total_transaksi')
            ->whereBetween('created_at', [$startDate . ' 00:00:00', $endDate . ' 23:59:59'])
            ->groupBy('nama_customer', 'nomer_telepon')
            ->orderByDesc('total_transaksi')
            ->limit(5)
            ->get();

        // Return view dengan semua data
        return view('laporan.index', compact(
            'startDate', 
            'endDate', 
            'statusProses', 
            'statusBayar', 
            'totalPemasukan', 
            'totalGaji', 
            'totalBelanjaInventaris',
            'topCustomers'
        ));
    }
}