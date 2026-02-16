<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Penggajian;
use App\Models\Karyawan;
use App\Models\Transaksi; // Import model Transaksi kamu di sini
use Carbon\Carbon;

class PenggajianController extends Controller
{
    public function index()
    {
        $penggajian = Penggajian::with('karyawan')->latest()->get();
        return view('penggajian.index', compact('penggajian'));
    }

    public function create()
    {
        $karyawan = Karyawan::all();
        return view('penggajian.create', compact('karyawan'));
    }

    // --- METHOD BARU UNTUK AJAX ---
    public function getTotalKg($karyawan_id)
    {
        // 1. Ubah 'berat_kg' menjadi 'berat' (sesuai Model Transaksi kamu)
        // 2. Gunakan 'tgl_transaksi' sebagai filter tanggal agar lebih akurat
        $total_kg = Transaksi::where('karyawan_id', $karyawan_id)
            ->whereDate('tgl_transaksi', Carbon::today()) 
            ->sum('berat'); 

        return response()->json([
            'total_kg' => $total_kg
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'karyawan_id' => 'required',
            'total_kg_dikerjakan' => 'required|numeric',
            'tarif_per_kg' => 'required|numeric' 
        ]);

        $total_gaji = $request->total_kg_dikerjakan * $request->tarif_per_kg;

        Penggajian::create([
            'karyawan_id' => $request->karyawan_id,
            'total_kg_dikerjakan' => $request->total_kg_dikerjakan,
            'total_gaji' => $total_gaji
            // Tambahkan kolom tarif jika tabel penggajianmu memilikinya
        ]);

        return redirect()->route('penggajian.index')
            ->with('success', 'Gaji berhasil dicatat. Total: Rp '.number_format($total_gaji, 0, ',', '.'));
    }

    public function destroy(Penggajian $penggajian)
    {
        $penggajian->delete();
        return redirect()->route('penggajian.index')->with('success', 'Data gaji dihapus');
    }
}