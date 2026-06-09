<?php

namespace App\Http\Controllers;

use App\Services\ForwardChainingService;
use App\Models\RiwayatDiagnosis;
use App\Models\Gejala;
use App\Models\JenisPerilaku;
use App\Models\TingkatKecanduan;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf as PDF;

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

        if (!$hasil['success']) {
            return redirect()->route('diagnosis.index')
                ->with('error', $hasil['message']);
        }

        return redirect()->route('diagnosis.result', $hasil['riwayat_id']);
    }

    public function result($riwayatId)
    {
        $riwayat = RiwayatDiagnosis::with('tingkatKecanduan')->findOrFail($riwayatId);
        
        if (!$riwayat->tingkatKecanduan) {
            return redirect()->route('diagnosis.index')
                ->with('error', 'Data diagnosis tidak ditemukan');
        }

        $gejalaDipilih = Gejala::whereIn('id', $riwayat->gejala_terpilih)->get();
        
        $this->fcService->setGejalaTerpilih($riwayat->gejala_terpilih);
        $semuaHasil = $this->fcService->prosesDiagnosis();
        
        return view('diagnosis.result', compact('riwayat', 'gejalaDipilih', 'semuaHasil'));
    }

public function downloadPdf($id)
{
    $riwayat = RiwayatDiagnosis::with('tingkatKecanduan')->findOrFail($id);
    $gejalaDipilih = Gejala::whereIn('id', $riwayat->gejala_terpilih)->get();
    
    $this->fcService->setGejalaTerpilih($riwayat->gejala_terpilih);
    $semuaHasil = $this->fcService->prosesDiagnosis();

    $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('diagnosis.pdf', compact('riwayat', 'gejalaDipilih', 'semuaHasil'));
    
    return $pdf->download('Hasil-Diagnosis-' . $riwayat->id . '.pdf');
}

    public function about()
    {
        $jenisPerilaku = JenisPerilaku::all();
        $tingkatKecanduan = TingkatKecanduan::all();
        
        return view('diagnosis.about', compact('jenisPerilaku', 'tingkatKecanduan'));
    }
}