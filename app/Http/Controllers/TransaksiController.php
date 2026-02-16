<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaksi;
use App\Models\Kategori; 
use App\Models\Karyawan; // Tambahkan ini

class TransaksiController extends Controller
{
    public function index()
    {
        // Menambahkan karyawan ke eager loading agar tidak boros query
        $transaksi = Transaksi::with(['kategori', 'karyawan'])
                        ->orderBy('tgl_transaksi', 'desc')
                        ->latest()
                        ->get();
                        
        return view('transaksi.index', compact('transaksi'));
    }

    public function create()
    {
        $kategori = Kategori::all();
        $karyawan = Karyawan::all();
        return view('transaksi.create', compact('kategori', 'karyawan'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'tgl_transaksi' => 'required|date', 
            'nama_customer' => 'required|string',
            'nomer_telepon' => 'required|string',
            'kategori_id'   => 'required',
            'karyawan_id'   => 'required', // Tambahkan validasi karyawan
            'berat'         => 'required|numeric',
            'status_bayar'  => 'required',
            'status_proses' => 'required',
        ]);

        $kategori = Kategori::find($request->kategori_id);
        $biaya_layanan = $kategori->biaya_layanan ?? 0;
        $total_harga = ($request->berat * $kategori->harga_per_jenis) + $biaya_layanan;

        $data = $request->all(); 
        $data['total_harga'] = $total_harga;
        
        $transaksi = Transaksi::create($data);

        $redirect = redirect()->route('transaksi.index')->with('success', 'Transaksi berhasil dibuat! Total: Rp '.number_format($total_harga));

        if ($request->has('kirim_wa')) {
            $nomor_hp = preg_replace('/[^0-9]/', '', $request->nomer_telepon);
            if (substr($nomor_hp, 0, 1) == '0') {
                $nomor_hp = '62' . substr($nomor_hp, 1);
            }

            $durasi_angka = (int) preg_replace('/[^0-9]/', '', $kategori->durasi_layanan);
            $tgl_selesai = date('d-m-Y', strtotime($request->tgl_transaksi . ' + ' . $durasi_angka . ' days'));

            $pesan = "*STRUK TRANSAKSI LAUNDRY*\n";
            $pesan .= "--------------------------------\n";
            $pesan .= "No. Transaksi : #" . $transaksi->id . "\n"; 
            $pesan .= "Tgl Masuk : " . date('d-m-Y', strtotime($request->tgl_transaksi)) . "\n";
            $pesan .= "Durasi : " . $kategori->durasi_layanan . "\n";
            $pesan .= "Est. Selesai : " . $tgl_selesai . "\n"; 
            $pesan .= "Pelanggan : " . $request->nama_customer . "\n";
            $pesan .= "--------------------------------\n";
            $pesan .= "Layanan : " . $kategori->nama_jenis . "\n";
            $pesan .= "Berat : " . $request->berat . " Kg\n";
            
            if($biaya_layanan > 0) {
                 $pesan .= "Biaya Layanan : Rp " . number_format($biaya_layanan, 0, ',', '.') . "\n";
            }

            $pesan .= "Status Bayar : " . strtoupper($request->status_bayar) . "\n";
            $pesan .= "--------------------------------\n";
            $pesan .= "*TOTAL : Rp " . number_format($total_harga, 0, ',', '.') . "*\n";
            $pesan .= "--------------------------------\n";
            $pesan .= "Simpan struk ini sebagai bukti pengambilan.\nTerima kasih!";

            $link_wa = "https://wa.me/" . $nomor_hp . "?text=" . urlencode($pesan);
            $redirect = $redirect->with('whatsapp_url', $link_wa);
        }

        return $redirect;
    }

    public function edit(Transaksi $transaksi)
    {
        $kategori = Kategori::all();
        $karyawan = Karyawan::all(); // Tambahkan data karyawan untuk dropdown edit
        return view('transaksi.edit', compact('transaksi', 'kategori', 'karyawan'));
    }

    public function update(Request $request, Transaksi $transaksi)
    {
        $request->validate([
            'tgl_transaksi' => 'required|date',
            'nama_customer' => 'required|string',
            'nomer_telepon' => 'required|string',
            'kategori_id'   => 'required',
            'karyawan_id'   => 'required', // Tambahkan validasi karyawan
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

        $redirect = redirect()->route('transaksi.index')->with('success', 'Data transaksi berhasil diperbarui.');

        if ($request->has('kirim_wa')) {
            $nomor_hp = preg_replace('/[^0-9]/', '', $request->nomer_telepon);
            if (substr($nomor_hp, 0, 1) == '0') {
                $nomor_hp = '62' . substr($nomor_hp, 1);
            }

            $durasi_angka = (int) preg_replace('/[^0-9]/', '', $kategori->durasi_layanan);
            $tgl_selesai = date('d-m-Y', strtotime($request->tgl_transaksi . ' + ' . $durasi_angka . ' days'));

            $pesan = "*REVISI STRUK TRANSAKSI*\n";
            $pesan .= "(Mohon abaikan struk sebelumnya)\n";
            $pesan .= "--------------------------------\n";
            $pesan .= "No. Transaksi : #" . $transaksi->id . "\n";
            $pesan .= "Tgl Masuk : " . date('d-m-Y', strtotime($request->tgl_transaksi)) . "\n";
            $pesan .= "Durasi : " . $kategori->durasi_layanan . "\n";
            $pesan .= "Est. Selesai : " . $tgl_selesai . "\n";
            $pesan .= "Pelanggan : " . $request->nama_customer . "\n";
            $pesan .= "--------------------------------\n";
            $pesan .= "Layanan : " . $kategori->nama_jenis . "\n";
            $pesan .= "Berat : " . $request->berat . " Kg\n";
            
            if($biaya_layanan > 0) {
                 $pesan .= "Biaya Layanan : Rp " . number_format($biaya_layanan, 0, ',', '.') . "\n";
            }

            $pesan .= "Status Bayar : " . strtoupper($request->status_bayar) . "\n";
            $pesan .= "--------------------------------\n";
            $pesan .= "*TOTAL UPDATE : Rp " . number_format($total_harga, 0, ',', '.') . "*\n";
            $pesan .= "--------------------------------\n";
            $pesan .= "Terima kasih! Data Anda telah kami perbarui. ";

            $link_wa = "https://wa.me/" . $nomor_hp . "?text=" . urlencode($pesan);
            $redirect = $redirect->with('whatsapp_url', $link_wa);
        }

        return $redirect;
    }

    public function destroy(Transaksi $transaksi)
    {
        $transaksi->delete();
        return redirect()->route('transaksi.index')->with('success', 'Transaksi dihapus');
    }
}