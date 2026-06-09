<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tingkat_kecanduan', function (Blueprint $table) {
            $table->id();
            $table->string('kode', 5)->unique(); 
            $table->string('nama');
            $table->text('deskripsi');
            $table->text('solusi');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tingkat_kecanduan');
    }
};