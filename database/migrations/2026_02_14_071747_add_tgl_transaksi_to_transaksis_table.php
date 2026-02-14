<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::table('transaksi', function (Blueprint $table) {
       
        $table->date('tgl_transaksi')->nullable()->after('id'); 
    });
}

public function down()
{
    Schema::table('transaksi', function (Blueprint $table) {
        $table->dropColumn('tgl_transaksi');
    });
}
};
