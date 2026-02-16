<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    use HasFactory;

    protected $table = 'transaksi';

    protected $fillable = [
        'tgl_transaksi',
        'nama_customer',
        'nomer_telepon',
        'kategori_id',
        'karyawan_id', 
        'berat',
        'status_bayar',
        'status_proses',
        'total_harga'
    ];

    public function kategori()
    {
        return $this->belongsTo(Kategori::class);
    }

    // Tambahkan relasi ke Karyawan
    public function karyawan()
    {
        return $this->belongsTo(Karyawan::class, 'karyawan_id');
    }
}