<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaksi;
use App\Models\Kategori; 

class TransaksiController extends Controller
{
    public function index()
    {
  
        $transaksi = Transaksi::with('kategori')
                        ->orderBy('tgl_transaksi', 'desc')
                        ->latest()
                        ->get();
                        
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
            'tgl_transaksi' => 'required|date', 
            'nama_customer' => 'required|string',
            'nomer_telepon' => 'required|string',
            'kategori_id'   => 'required',
            'berat'         => 'required|numeric',
            'status_bayar'  => 'required',
            'status_proses' => 'required',
        ]);

 
        $kategori = Kategori::find($request->kategori_id);

        $biaya_layanan = $kategori->biaya_layanan ?? 0;
        $total_harga = ($request->berat * $kategori->harga_per_jenis) + $biaya_layanan;

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
      
        $request->validate([
            'tgl_transaksi' => 'required|date',
            'nama_customer' => 'required|string',
            'nomer_telepon' => 'required|string',
            'kategori_id'   => 'required',
            'berat'         => 'required|numeric',
            'status_bayar'  => 'required',
            'status_proses' => 'required',
        ]);

  
        $kategori = Kategori::find($request->kategori_id);
        
        $biaya_layanan = $kategori->biaya_layanan ?? 0;
        $total_harga = ($request->berat * $kategori->harga_per_jenis) + $biaya_layanan;

        
        $data = $request->all();
        $data['total_harga'] = $total_harga;

        $transaksi->update($data);

        return redirect()->route('transaksi.index')->with('success', 'Transaksi berhasil diperbarui');
    }

    public function destroy(Transaksi $transaksi)
    {
        $transaksi->delete();
        return redirect()->route('transaksi.index')->with('success', 'Transaksi dihapus');
    }
}