<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Gejala extends Model
{
    protected $table = 'gejala';
    protected $fillable = ['kode', 'deskripsi'];

    public function rules(): BelongsToMany
    {
        return $this->belongsToMany(Rule::class, 'rule_gejala');
    }
}