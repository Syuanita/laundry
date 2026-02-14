<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaksi;
use App\Models\Penggajian;
use App\Models\Expenditure;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;

class LaporanController extends Controller
{
    
    public function index(Request $request)
    {
        
        $startDate = $request->input('start_date', Carbon::now()->startOfMonth()->toDateString());
        $endDate = $request->input('end_date', Carbon::now()->endOfMonth()->toDateString());

        $transaksi = Transaksi::whereBetween('tgl_transaksi', [$startDate, $endDate])->get();
        
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
        

        $totalGaji = Penggajian::whereBetween('created_at', [$startDate . ' 00:00:00', $endDate . ' 23:59:59'])
            ->sum('total_gaji');
        

        $totalBelanjaInventaris = Expenditure::whereBetween('date', [$startDate, $endDate])
            ->sum('price');


        $topCustomers = Transaksi::selectRaw('nama_customer, nomer_telepon, COUNT(*) as total_transaksi')
            ->whereBetween('tgl_transaksi', [$startDate, $endDate])
            ->groupBy('nama_customer', 'nomer_telepon')
            ->orderByDesc('total_transaksi')
            ->limit(5)
            ->get();


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

 
    public function exportPdf(Request $request)
    {
        $startDate = $request->input('start_date', Carbon::now()->startOfMonth()->toDateString());
        $endDate = $request->input('end_date', Carbon::now()->endOfMonth()->toDateString());

 
        $dataTransaksi = Transaksi::whereBetween('tgl_transaksi', [$startDate, $endDate])
            ->get()
            ->map(function($item) {
                return [
                    'tanggal' => $item->tgl_transaksi, 
                    'keterangan' => "Order: " . $item->nama_customer . " (" . $item->kategori->nama_jenis . ")",
                    'jenis' => 'masuk',
                    'nominal' => $item->total_harga,
                    'unix_time' => strtotime($item->tgl_transaksi) 
                ];
            });


        $dataGaji = Penggajian::whereBetween('created_at', [$startDate . ' 00:00:00', $endDate . ' 23:59:59'])
            ->get()
            ->map(function($item) {
                return [
                    'tanggal' => $item->created_at->format('Y-m-d'),
                    'keterangan' => "Gaji Karyawan: " . ($item->karyawan->nama ?? 'Pegawai'),
                    'jenis' => 'keluar',
                    'nominal' => $item->total_gaji,
                    'unix_time' => strtotime($item->created_at)
                ];
            });


        $dataBelanja = Expenditure::whereBetween('date', [$startDate, $endDate])
            ->get()
            ->map(function($item) {
                return [
                    'tanggal' => $item->date,
                    'keterangan' => "Belanja: " . ($item->description ?? 'Pengeluaran Lain'), 
                    'jenis' => 'keluar',
                    'nominal' => $item->price,
                    'unix_time' => strtotime($item->date)
                ];
            });

 
        $laporan = $dataTransaksi
                    ->concat($dataGaji)
                    ->concat($dataBelanja)
                    ->sortBy('unix_time');


        $pdf = Pdf::loadView('laporan.pdf', [
            'laporan' => $laporan,
            'startDate' => $startDate,
            'endDate' => $endDate
        ]);

 
        return $pdf->stream('Laporan_Keuangan_'.$startDate.'_sd_'.$endDate.'.pdf');
    }
}