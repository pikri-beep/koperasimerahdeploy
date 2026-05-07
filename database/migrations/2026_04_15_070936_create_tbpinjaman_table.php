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
        Schema::create('tbpinjaman', function (Blueprint $table) {
    $table->id();

    // Data dirikita

    $table->string('nama_lengkap');
    $table->string('nik');
    $table->text('alamat');
    $table->string('no_hp');

    // Data pinjaman
    $table->decimal('jumlah_pinjaman', 15,2);
    $table->integer('tenor');
    $table->string('tujuan_pinjaman');
    $table->string('metode_pencairan');

    // Foto
    $table->string('foto_ktp');
    $table->string('selfie_ktp');

    // Tanggal
    $table->date('tanggal_pinjam');
    $table->date('tanggal_jatuh_tempo');

    // Status
    $table->enum('status', ['pending', 'disetujui', 'ditolak', 'lunas'])
          ->default('pending');

    $table->timestamps();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbpinjaman');
    }
};
