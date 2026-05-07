<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tbmodals', function (Blueprint $table) {
            $table->id();
           $table->bigInteger('simpanan_pokok')->default(0); 
            $table->bigInteger('simpanan_wajib')->default(0);
            $table->bigInteger('simpanan_sementara')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tbmodals');
    }
};