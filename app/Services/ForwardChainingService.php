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

    /**
     * Proses diagnosis lengkap
     * @return array
     */
    public function diagnose(array $gejalaIds, ?string $namaPengguna = null): array
    {
        $this->setGejalaTerpilih($gejalaIds);
        
        $rules = Rule::with(['gejala', 'tingkatKecanduan'])
            ->orderBy('kode', 'desc')
            ->get();
        
        $hasilFinal = null; 
        $saran = null;            
        $persentaseTertinggi = 0;
        $ruleTerbaik = null;
        $gejalaKurangIds = [];
        $detailHasil = [];
        
        foreach ($rules as $rule) {
            $gejalaDibutuhkan = $rule->gejala->pluck('id')->toArray();
            $gejalaCocok = array_intersect($gejalaDibutuhkan, $this->gejalaTerpilih);
            $gejalaKurang = array_diff($gejalaDibutuhkan, $gejalaCocok);
            
            $totalCocok = count($gejalaCocok);
            $totalDibutuhkan = count($gejalaDibutuhkan);
            $persentase = $totalDibutuhkan > 0 ? round(($totalCocok / $totalDibutuhkan) * 100, 2) : 0;
            
            $detailHasil[$rule->kode] = [
                'nama' => $rule->tingkatKecanduan->nama,
                'kode' => $rule->tingkatKecanduan->kode,
                'total_cocok' => $totalCocok,
                'total_dibutuhkan' => $totalDibutuhkan,
                'persentase' => $persentase,
                'status_lengkap' => $totalCocok == $totalDibutuhkan,
            ];
            
            if ($totalCocok == $totalDibutuhkan && !$hasilFinal) {
                $hasilFinal = $rule->tingkatKecanduan;
                $persentaseTertinggi = 100;
                $ruleTerbaik = $rule;
                $gejalaKurangIds = [];
            }
            
            if ($persentase > $persentaseTertinggi && $totalCocok != $totalDibutuhkan) {
                $persentaseTertinggi = $persentase;
                $ruleTerbaik = $rule;
                $gejalaKurangIds = $gejalaKurang;
            }
        }

        $isLengkap = $hasilFinal !== null;
        
        if (!$hasilFinal) {
            $hasilFinal = TingkatKecanduan::where('kode', 'T00')->first();
            $saran = [
                'tingkat' => $ruleTerbaik?->tingkatKecanduan,
                'persentase' => $persentaseTertinggi,
                'gejala_kurang_ids' => $gejalaKurangIds,
            ];
        }
        
        $riwayat = RiwayatDiagnosis::create([
            'session_id' => Str::uuid(),
            'nama_pengguna' => $namaPengguna,
            'tingkat_kecanduan_id' => $hasilFinal->id,
            'gejala_terpilih' => $gejalaIds,
            'persentase' => $persentaseTertinggi,
        ]);
        
        return [
            'success' => true,
            'hasil_final' => $hasilFinal,
            'saran' => $saran,
            'is_lengkap' => $isLengkap,
            'persentase' => $persentaseTertinggi,
            'detail_hasil' => $detailHasil,
            'riwayat_id' => $riwayat->id,
        ];
    }

    public function getGejalaByIds(array $ids): array
    {
        if (empty($ids)) return [];
        return Gejala::whereIn('id', $ids)->get()->toArray();
    }

    public function getAllGejala()
    {
        return Gejala::orderBy('kode')->get();
    }

    public function getAllTingkatKecanduan()
    {
        return TingkatKecanduan::all();
    }
}