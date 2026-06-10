<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::table('tingkat_kecanduan')->insert([
            'kode' => 'T00',
            'nama' => 'Tidak Terdeteksi',
            'deskripsi' => 'Berdasarkan metode Forward Chaining, tidak ada rule yang terpenuhi 100%. Namun berdasarkan gejala yang Anda pilih, Anda memiliki kecenderungan ke arah tertentu.',
            'solusi' => "1. Konsultasi dengan psikolog untuk diagnosis yang lebih akurat\n2. Lengkapi gejala yang kurang\n3. Lakukan diagnosis ulang dengan gejala yang lebih lengkap",
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    public function down(): void
    {
        DB::table('tingkat_kecanduan')->where('kode', 'T00')->delete();
    }
};