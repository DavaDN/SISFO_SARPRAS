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
        Schema::table('pengembalian', function (Blueprint $table) {
            $table->string('kondisi')->nullable()->after('tanggal_kembali'); 
            $table->string('jumlah')->nullable();// menambahkan kolom gambar setelah stok
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pengembalian', function (Blueprint $table) {
            $table->dropColumn('kondisi'); // menghapus kolom gambar
            $table->dropColumn('jumlah'); // menghapus kolom gambar
        });
    }
};
