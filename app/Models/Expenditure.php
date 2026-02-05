<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Expenditure extends Model
{
    protected $fillable = ['nama_pengeluaran', 'keterangan', 'price', 'date'];

    protected $casts = [
        'date' => 'datetime',
    ];
}