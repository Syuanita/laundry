<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kategori extends Model
{
    use HasFactory;

    protected $table = 'kategori'; 

    protected $fillable = [
        'nama_jenis',
        'tipe',
        'harga_per_jenis',
        'durasi_layanan',
        'biaya_layanan'
    ];

    
    public function transaksi()
    {
        return $this->hasMany(Transaksi::class);
    }
}