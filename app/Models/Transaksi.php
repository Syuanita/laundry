<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    use HasFactory;

    protected $table = 'transaksi';

    protected $fillable = [
        'berat',
        'kategori_id', 
        'total_harga',
        'status_bayar',
        'status_proses'
    ];

    
    public function kategori()
    {
        return $this->belongsTo(Kategori::class, 'kategori_id');
    }
}