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
        // Drop tabel lama yang kosong, buat ulang dengan kolom lengkap
        Schema::dropIfExists('tbcicilans');

        Schema::create('tbcicilans', function (Blueprint $table) {
            $table->id();

            // Relasi ke pinjaman
            $table->foreignId('pinjaman_id')
                  ->constrained('tbpinjaman')
                  ->onDelete('cascade');

            // Relasi ke user
            $table->foreignId('user_id')
                  ->constrained('users')
                  ->onDelete('cascade');

            // Detail cicilan
            $table->integer('bulan_ke');                       // cicilan ke-1, ke-2, dst
            $table->decimal('jumlah_cicilan', 15, 2);          // pokok + bunga per bulan
            $table->decimal('pokok', 15, 2);                   // bagian pokok
            $table->decimal('bunga', 15, 2);                   // bagian bunga (2% flat)
            $table->decimal('denda', 15, 2)->default(0);       // denda keterlambatan

            $table->date('tanggal_jatuh_tempo');               // tanggal wajib bayar
            $table->date('tanggal_bayar')->nullable();         // tanggal sudah bayar

            // Bukti pembayaran (upload oleh user)
            $table->string('foto_bukti')->nullable();

            // Status: belum_bayar | sudah_bayar | terlambat | dikonfirmasi
            $table->enum('status', ['belum_bayar', 'sudah_bayar', 'terlambat', 'dikonfirmasi'])
                  ->default('belum_bayar');

            // Catatan dari admin
            $table->text('catatan')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbcicilans');
    }
};