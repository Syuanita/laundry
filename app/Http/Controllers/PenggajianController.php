<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Penggajian;
use App\Models\Karyawan;

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
        ]);

        return redirect()->route('penggajian.index')->with('success', 'Gaji berhasil dicatat. Total: Rp '.number_format($total_gaji));
    }

    public function destroy(Penggajian $penggajian)
    {
        $penggajian->delete();
        return redirect()->route('penggajian.index')->with('success', 'Data gaji dihapus');
    }
}