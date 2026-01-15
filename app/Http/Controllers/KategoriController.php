<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kategori;

class KategoriController extends Controller
{
    
    public function index()
    {
        $kategori = Kategori::all();
        return view('kategori.index', compact('kategori'));
    }

    
    public function create()
    {
        return view('kategori.create');
    }

    
    public function store(Request $request)
    {
        
        $request->validate([
            'nama_jenis' => 'required',
            'tipe' => 'required', 
            'harga_per_jenis' => 'required|numeric',
            'durasi_layanan' => 'required', 
            'biaya_layanan' => 'required|numeric', 
        ]);

        Kategori::create($request->all());

        return redirect()->route('kategori.index')->with('success', 'Kategori berhasil ditambahkan!');
    }

    
    public function edit(Kategori $kategori)
    {
        return view('kategori.edit', compact('kategori'));
    }

    
    public function update(Request $request, Kategori $kategori)
    {
        $request->validate([
            'nama_jenis' => 'required',
            'tipe' => 'required',
            'harga_per_jenis' => 'required|numeric',
            'durasi_layanan' => 'required',
            'biaya_layanan' => 'required|numeric',
        ]);

        $kategori->update($request->all());

        return redirect()->route('kategori.index')->with('success', 'Kategori berhasil diupdate!');
    }

    
    public function destroy(Kategori $kategori)
    {
        $kategori->delete();
        return redirect()->route('kategori.index')->with('success', 'Kategori berhasil dihapus!');
    }
}