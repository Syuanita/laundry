<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaksi;
use App\Models\Kategori; // Kita butuh ini untuk ambil harga

class TransaksiController extends Controller
{
    public function index()
    {
        
        $transaksi = Transaksi::with('kategori')->latest()->get();
        return view('transaksi.index', compact('transaksi'));
    }

    public function create()
    {
        
        $kategori = Kategori::all();
        return view('transaksi.create', compact('kategori'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'kategori_id' => 'required',
            'berat' => 'required|numeric',
            'status_bayar' => 'required',
            'status_proses' => 'required',
        ]);

        
        $kategori = Kategori::find($request->kategori_id);

       
        $total_harga = ($request->berat * $kategori->harga_per_jenis) + $kategori->biaya_layanan;

        
        $data = $request->all();
        $data['total_harga'] = $total_harga;
        

        Transaksi::create($data);

        return redirect()->route('transaksi.index')->with('success', 'Transaksi berhasil dibuat! Total: Rp '.number_format($total_harga));
    }

    public function edit(Transaksi $transaksi)
    {
        $kategori = Kategori::all();
        return view('transaksi.edit', compact('transaksi', 'kategori'));
    }

    public function update(Request $request, Transaksi $transaksi)
    {
        
        $kategori = Kategori::find($request->kategori_id);
        $total_harga = ($request->berat * $kategori->harga_per_jenis) + $kategori->biaya_layanan;

        $data = $request->all();
        $data['total_harga'] = $total_harga;

        $transaksi->update($data);

        return redirect()->route('transaksi.index')->with('success', 'Transaksi diperbarui');
    }

    public function destroy(Transaksi $transaksi)
    {
        $transaksi->delete();
        return redirect()->route('transaksi.index')->with('success', 'Transaksi dihapus');
    }
}