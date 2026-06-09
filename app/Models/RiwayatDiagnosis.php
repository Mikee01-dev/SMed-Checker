<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RiwayatDiagnosis extends Model
{
    protected $table = 'riwayat_diagnosis';
    
    protected $fillable = [
        'session_id',
        'nama_pengguna',
        'tingkat_kecanduan_id',
        'gejala_terpilih',
        'persentase',
    ];

    protected $casts = [
        'gejala_terpilih' => 'array',
    ];

    public function tingkatKecanduan()
    {
        return $this->belongsTo(TingkatKecanduan::class);
    }
}