<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Inventaris;

class InventarisController extends Controller
{
    public function index()
    {
        $inventaris = Inventaris::all();
        return view('inventaris.index', compact('inventaris'));
    }

    public function create()
    {
        return view('inventaris.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_barang' => 'required',
            'harga' => 'required|numeric',
            'stok' => 'required|integer'
        ]);
        
        Inventaris::create($request->all());

        return redirect()->route('inventaris.index')->with('success', 'Barang berhasil ditambahkan');
    }

    public function edit(Inventaris $inventaris)
    {
        return view('inventaris.edit', compact('inventaris')); 
    }

    public function update(Request $request, Inventaris $inventaris)
    {
        $request->validate([
            'nama_barang' => 'required',
            'harga' => 'required|numeric',
            'stok' => 'required|integer'
        ]);
        
        $inventaris->update($request->all());

        return redirect()->route('inventaris.index')->with('success', 'Barang berhasil diupdate');
    }

    public function destroy(Inventaris $inventaris)
    {
        $inventaris->delete();
        return redirect()->route('inventaris.index')->with('success', 'Barang berhasil dihapus');
    }
}