<?php

namespace App\Http\Controllers;

use App\Models\Expenditure;
use Illuminate\Http\Request;

class ExpenditureController extends Controller
{
    public function index()
    {
        $expenditures = Expenditure::latest()->get(); 
        
        return view('expenditures.index', compact('expenditures'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_pengeluaran' => 'required|string|max:255',
            'keterangan'       => 'nullable|string',
            'price'            => 'required|numeric|min:0',
            'date'             => 'required|date',
        ]);

        try {
            Expenditure::create($request->all());

            return redirect()->back()->with('success', 'Pengeluaran berhasil dicatat.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal: ' . $e->getMessage());
        }
    }

    public function edit(Expenditure $expenditure)
    {
        return view('expenditures.edit', compact('expenditure'));
    }

    public function update(Request $request, Expenditure $expenditure)
    {
        $request->validate([
            'nama_pengeluaran' => 'required|string|max:255',
            'keterangan'       => 'nullable|string',
            'price'            => 'required|numeric|min:0',
            'date'             => 'required|date',
        ]);

        try {
            $expenditure->update($request->all());

            return redirect()->route('expenditures.index')->with('success', 'Pengeluaran berhasil diperbarui.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal: ' . $e->getMessage());
        }
    }

    public function destroy(Expenditure $expenditure)
    {
        try {
            $expenditure->delete();

            return redirect()->back()->with('success', 'Pengeluaran berhasil dihapus.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal: ' . $e->getMessage());
        }
    }
}