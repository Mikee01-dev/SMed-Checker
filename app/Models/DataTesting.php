<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DataTesting extends Model
{
    use HasFactory;

    protected $table = 'data_testings';
    
    protected $fillable = [
        'nama_responden',
        'gejala_terpilih',
        'hasil_diagnosis'
    ];
}