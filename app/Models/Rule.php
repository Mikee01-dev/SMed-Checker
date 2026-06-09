<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Rule extends Model
{
    protected $table = 'rules';
    protected $fillable = ['kode', 'tingkat_kecanduan_id'];

    public function tingkatKecanduan(): BelongsTo
    {
        return $this->belongsTo(TingkatKecanduan::class);
    }

    public function gejala(): BelongsToMany
    {
        return $this->belongsToMany(Gejala::class, 'rule_gejala');
    }
}