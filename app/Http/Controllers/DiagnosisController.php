<?php
namespace App\Http\Controllers;

use App\Services\ForwardChainingService;
use App\Models\RiwayatDiagnosis;
use App\Models\Gejala;
use App\Models\JenisPerilaku;
use App\Models\TingkatKecanduan;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class DiagnosisController extends Controller
{
    protected ForwardChainingService $fcService;

    public function __construct(ForwardChainingService $fcService)
    {
        $this->fcService = $fcService;
    }

    public function index()
    {
        $gejala = $this->fcService->getAllGejala();
        return view('diagnosis.index', compact('gejala'));
    }

    public function process(Request $request)
    {
        $request->validate([
            'nama' => 'nullable|string|max:100',
            'gejala' => 'required|array|min:1',
            'gejala.*' => 'exists:gejala,id',
        ]);

        $gejalaIds = $request->input('gejala');
        $nama = $request->input('nama');

        $hasil = $this->fcService->diagnose($gejalaIds, $nama);

        return redirect()->route('diagnosis.result', $hasil['riwayat_id']);
    }

    public function result($riwayatId)
    {
        $riwayat = RiwayatDiagnosis::with('tingkatKecanduan')->findOrFail($riwayatId);
        
        $gejalaTerpilih = $riwayat->gejala_terpilih;
        
        $rules = \App\Models\Rule::with(['gejala', 'tingkatKecanduan'])
            ->orderBy('kode', 'desc')
            ->get();
        
        $detailHasil = [];
        $hasilFinal = null;
        $saran = null;
        $persentaseTertinggi = 0;
        $ruleTerbaik = null;
        $gejalaKurangIds = [];
        
        foreach ($rules as $rule) {
            $gejalaDibutuhkan = $rule->gejala->pluck('id')->toArray();
            $gejalaCocok = array_intersect($gejalaDibutuhkan, $gejalaTerpilih);
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
            $hasilFinal = \App\Models\TingkatKecanduan::where('kode', 'T00')->first();
            $saran = [
                'tingkat' => $ruleTerbaik?->tingkatKecanduan,
                'persentase' => $persentaseTertinggi,
                'gejala_kurang_ids' => $gejalaKurangIds,
            ];
        }
        
        $gejalaDipilih = \App\Models\Gejala::whereIn('id', $gejalaTerpilih)->get();
        $gejalaKurangDetail = [];
        
        if ($saran && isset($saran['gejala_kurang_ids'])) {
            $gejalaKurangDetail = \App\Models\Gejala::whereIn('id', $saran['gejala_kurang_ids'])->get();
        }
        
        return view('diagnosis.result', [
            'riwayat' => $riwayat,
            'hasilFinal' => $hasilFinal,
            'saran' => $saran,
            'isLengkap' => $isLengkap,
            'persentase' => $persentaseTertinggi,
            'detailHasil' => $detailHasil,
            'gejalaDipilih' => $gejalaDipilih,
            'gejalaKurangDetail' => $gejalaKurangDetail,
        ]);
    }

    public function about()
    {
        $jenisPerilaku = JenisPerilaku::all();
        $tingkatKecanduan = TingkatKecanduan::all();
        return view('diagnosis.about', compact('jenisPerilaku', 'tingkatKecanduan'));
    }

    public function downloadPdf($id)
    {
        $riwayat = RiwayatDiagnosis::with('tingkatKecanduan')->findOrFail($id);
        
        $gejalaTerpilih = $riwayat->gejala_terpilih;
        
        $rules = \App\Models\Rule::with(['gejala', 'tingkatKecanduan'])
            ->orderBy('kode', 'desc')
            ->get();
        
        $detailHasil = [];
        $hasilFinal = null;
        $saran = null;
        $persentaseTertinggi = 0;
        $ruleTerbaik = null;
        $gejalaKurangIds = [];
        
        foreach ($rules as $rule) {
            $gejalaDibutuhkan = $rule->gejala->pluck('id')->toArray();
            $gejalaCocok = array_intersect($gejalaDibutuhkan, $gejalaTerpilih);
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
            $hasilFinal = \App\Models\TingkatKecanduan::where('kode', 'T00')->first();
            $saran = [
                'tingkat' => $ruleTerbaik?->tingkatKecanduan,
                'persentase' => $persentaseTertinggi,
                'gejala_kurang_ids' => $gejalaKurangIds,
            ];
        }
        
        $gejalaDipilih = \App\Models\Gejala::whereIn('id', $gejalaTerpilih)->get();
        $gejalaKurangDetail = [];
        
        if ($saran && isset($saran['gejala_kurang_ids'])) {
            $gejalaKurangDetail = \App\Models\Gejala::whereIn('id', $saran['gejala_kurang_ids'])->get();
        }
        
        $hasil = [
            'hasil_final' => $hasilFinal,
            'saran' => $saran,
            'is_lengkap' => $isLengkap,
            'persentase' => $persentaseTertinggi,
        ];
        
        $pdf = Pdf::loadView('diagnosis.pdf', [
            'riwayat' => $riwayat,
            'hasil' => $hasil,
            'detailHasil' => $detailHasil,
            'gejalaDipilih' => $gejalaDipilih,
            'gejalaKurangDetail' => $gejalaKurangDetail,
        ]);
        
        $pdf->setPaper('A4', 'portrait');
        return $pdf->download('Hasil-Diagnosis-SMed-Checker-' . $riwayat->id . '.pdf');
    }
}