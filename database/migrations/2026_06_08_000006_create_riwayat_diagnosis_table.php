<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('riwayat_diagnosis', function (Blueprint $table) {
            $table->id();
            $table->string('session_id');
            $table->string('nama_pengguna')->nullable();
            $table->foreignId('tingkat_kecanduan_id')->nullable()->constrained('tingkat_kecanduan');
            $table->json('gejala_terpilih');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('riwayat_diagnosis');
    }
};