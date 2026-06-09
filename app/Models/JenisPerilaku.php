<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JenisPerilaku extends Model
{
    protected $table = 'jenis_perilaku';
    protected $fillable = ['kode', 'nama', 'deskripsi'];
}