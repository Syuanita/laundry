<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
{
    Schema::table('transaksi', function (Blueprint $table) {
        // Tambahkan kolom karyawan_id sebagai Foreign Key
        $table->unsignedBigInteger('karyawan_id')->after('kategori_id')->nullable();
        
        // Opsional: Buat relasi formal agar integritas data terjaga
        $table->foreign('karyawan_id')->references('id')->on('karyawan')->onDelete('cascade');
    });
}

public function down(): void
{
    Schema::table('transaksi', function (Blueprint $table) {
        $table->dropForeign(['karyawan_id']);
        $table->dropColumn('karyawan_id');
    });
}
};
