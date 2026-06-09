<?php

namespace App\Services;

use App\Models\Gejala;
use App\Models\Rule;
use App\Models\TingkatKecanduan;
use App\Models\RiwayatDiagnosis;
use Illuminate\Support\Str;

class ForwardChainingService
{
    private array $gejalaTerpilih = [];

    public function setGejalaTerpilih(array $gejalaIds): void
    {
        $this->gejalaTerpilih = $gejalaIds;
    }

    public function prosesDiagnosis(): array
    {
        $rules = Rule::with(['gejala', 'tingkatKecanduan'])->get();
        
        $hasil = [];
        
        foreach ($rules as $rule) {
            $gejalaDibutuhkan = $rule->gejala->pluck('id')->toArray();
            $gejalaCocok = array_intersect($gejalaDibutuhkan, $this->gejalaTerpilih);
            
            $totalDibutuhkan = count($gejalaDibutuhkan);
            $totalCocok = count($gejalaCocok);
            
            $persentase = $totalDibutuhkan > 0 
                ? round(($totalCocok / $totalDibutuhkan) * 100, 2)
                : 0;
            
            $hasil[] = [
                'rule' => $rule,
                'tingkat_kecanduan' => $rule->tingkatKecanduan,
                'kode' => $rule->tingkatKecanduan->kode,
                'nama' => $rule->tingkatKecanduan->nama,
                'total_dibutuhkan' => $totalDibutuhkan,
                'total_cocok' => $totalCocok,
                'persentase' => $persentase,
                'gejala_cocok_ids' => $gejalaCocok,
            ];
        }
        
        usort($hasil, function($a, $b) {
            return $b['persentase'] <=> $a['persentase'];
        });
        
        return $hasil;
    }

    public function diagnose(array $gejalaIds, ?string $namaPengguna = null): array
    {
        $this->setGejalaTerpilih($gejalaIds);
        
        $hasilDiagnosis = $this->prosesDiagnosis();
        
        $terbaik = $hasilDiagnosis[0] ?? null;
        
        if (!$terbaik || $terbaik['persentase'] == 0) {
            return [
                'success' => false,
                'message' => 'Tidak dapat menentukan diagnosis. Silakan konsultasi dengan psikolog.',
            ];
        }
        
        $riwayat = RiwayatDiagnosis::create([
            'session_id' => Str::uuid(),
            'nama_pengguna' => $namaPengguna,
            'tingkat_kecanduan_id' => $terbaik['tingkat_kecanduan']->id,
            'gejala_terpilih' => $gejalaIds,
            'persentase' => $terbaik['persentase'],
        ]);
        
        return [
            'success' => true,
            'tingkat_kecanduan' => $terbaik['tingkat_kecanduan'],
            'persentase' => $terbaik['persentase'],
            'total_cocok' => $terbaik['total_cocok'],
            'total_dibutuhkan' => $terbaik['total_dibutuhkan'],
            'semua_hasil' => $hasilDiagnosis,
            'riwayat_id' => $riwayat->id,
        ];
    }

    public function getAllGejala()
    {
        return Gejala::orderBy('kode')->get();
    }

    public function getGejalaByIds(array $ids)
    {
        return Gejala::whereIn('id', $ids)->get();
    }

    public function getRuleByTingkatKecanduan(TingkatKecanduan $tingkat)
    {
        return Rule::with('gejala')
            ->where('tingkat_kecanduan_id', $tingkat->id)
            ->first();
    }
}