<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaksi;
use App\Models\Penggajian;
use App\Models\Inventaris;
use Carbon\Carbon;

class LaporanController extends Controller
{
    public function index(Request $request)
    {
        
        $startDate = $request->input('start_date', Carbon::now()->startOfMonth()->toDateString());
        $endDate = $request->input('end_date', Carbon::now()->endOfMonth()->toDateString());

        
        $transaksi = Transaksi::whereBetween('created_at', [$startDate . ' 00:00:00', $endDate . ' 23:59:59'])->get();
        
        
        $statusProses = [
            'proses' => $transaksi->where('status_proses', 'proses')->count(),
            'selesai' => $transaksi->where('status_proses', 'selesai')->count(),
            'diambil' => $transaksi->where('status_proses', 'diambil')->count(),
        ];

        
        $statusBayar = [
            'lunas' => $transaksi->where('status_bayar', 'lunas')->count(),
            'belum_lunas' => $transaksi->where('status_bayar', 'belum_lunas')->count(),
        ];

        
        $totalPemasukan = $transaksi->sum('total_harga');
        
        
        $totalGaji = Penggajian::whereBetween('created_at', [$startDate . ' 00:00:00', $endDate . ' 23:59:59'])->sum('total_gaji');
        
        
        $barangBaru = Inventaris::whereBetween('created_at', [$startDate . ' 00:00:00', $endDate . ' 23:59:59'])->get();
        $totalBelanjaInventaris = 0;
        foreach($barangBaru as $b){
            $totalBelanjaInventaris += ($b->harga * $b->stok);
        }

        return view('laporan.index', compact(
            'startDate', 'endDate', 
            'statusProses', 'statusBayar', 
            'totalPemasukan', 'totalGaji', 'totalBelanjaInventaris'
        ));
    }
}