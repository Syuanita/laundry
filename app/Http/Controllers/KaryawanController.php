<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Karyawan;

class KaryawanController extends Controller
{
    public function index()
    {
        $karyawan = Karyawan::all();
        return view('karyawan.index', compact('karyawan'));
    }

    public function create()
    {
        return view('karyawan.create');
    }

    public function store(Request $request)
    {
        $request->validate(['nama_karyawan' => 'required']);
        
        Karyawan::create($request->all());

        return redirect()->route('karyawan.index')->with('success', 'Data Karyawan berhasil disimpan');
    }

    public function edit(Karyawan $karyawan)
    {
        return view('karyawan.edit', compact('karyawan'));
    }

    public function update(Request $request, Karyawan $karyawan)
    {
        $request->validate(['nama_karyawan' => 'required']);
        
        $karyawan->update($request->all());

        return redirect()->route('karyawan.index')->with('success', 'Data Karyawan berhasil diupdate');
    }

    public function destroy(Karyawan $karyawan)
    {
        $karyawan->delete();
        return redirect()->route('karyawan.index')->with('success', 'Data Karyawan berhasil dihapus');
    }
}