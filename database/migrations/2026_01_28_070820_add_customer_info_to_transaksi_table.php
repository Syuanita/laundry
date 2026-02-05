<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('transaksi', function (Blueprint $table) {
            // Kita tambahkan setelah ID agar struktur tabel rapi
            $table->string('nama_customer')->after('id');
            $table->string('nomer_telepon')->after('nama_customer');
            $table->text('alamat')->nullable()->after('nomer_telepon'); 
        });
    }

    public function down(): void
    {
        Schema::table('transaksi', function (Blueprint $table) {
            // Untuk menghapus kolom jika dilakukan rollback
            $table->dropColumn(['nama_customer', 'nomer_telepon', 'alamat']);
        });
    }
};