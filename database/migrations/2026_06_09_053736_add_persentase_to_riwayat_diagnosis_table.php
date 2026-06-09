<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('riwayat_diagnosis', function (Blueprint $table) {
            $table->float('persentase')->default(0)->after('gejala_terpilih');
        });
    }

    public function down(): void
    {
        Schema::table('riwayat_diagnosis', function (Blueprint $table) {
            $table->dropColumn('persentase');
        });
    }
};