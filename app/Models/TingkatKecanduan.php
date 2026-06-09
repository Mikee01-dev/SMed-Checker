<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TingkatKecanduan extends Model
{
    protected $table = 'tingkat_kecanduan';
    protected $fillable = ['kode', 'nama', 'deskripsi', 'solusi'];

    public function rules(): HasMany
    {
        return $this->hasMany(Rule::class);
    }

    public function riwayatDiagnosis(): HasMany
    {
        return $this->hasMany(RiwayatDiagnosis::class);
    }
}