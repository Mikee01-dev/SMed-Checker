<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\RiwayatDiagnosis;
use App\Models\Gejala;
use App\Models\TingkatKecanduan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('admin');
    }

    public function dashboard()
    {
        $totalDiagnosis = RiwayatDiagnosis::count();
        $totalHariIni = RiwayatDiagnosis::whereDate('created_at', today())->count();
        $totalGejala = Gejala::count();
        
        $jumlahHari = RiwayatDiagnosis::where('created_at', '>=', now()->subDays(30))->count();
        $rataPerHari = round($jumlahHari / 30, 1);
        
        $statistikTingkat = RiwayatDiagnosis::select('tingkat_kecanduan_id', DB::raw('count(*) as total'))
            ->with('tingkatKecanduan')
            ->groupBy('tingkat_kecanduan_id')
            ->get();
        
        $grafikMingguan = collect();
        for ($i = 6; $i >= 0; $i--) {
            $tanggal = now()->subDays($i);
            $jumlah = RiwayatDiagnosis::whereDate('created_at', $tanggal)->count();
            $grafikMingguan->push([
                'tanggal' => $tanggal->format('d/m'),
                'jumlah' => $jumlah
            ]);
        }
        
        $riwayatTerbaru = RiwayatDiagnosis::with('tingkatKecanduan')
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();
        
        return view('admin.dashboard', compact(
            'totalDiagnosis', 'totalHariIni', 'totalGejala', 'rataPerHari',
            'statistikTingkat', 'grafikMingguan', 'riwayatTerbaru'
        ));
    }

    public function history()
    {
        $riwayat = RiwayatDiagnosis::with('tingkatKecanduan')
            ->orderBy('created_at', 'desc')
            ->paginate(20);
        
        return view('admin.history', compact('riwayat'));
    }

    public function historyDetail($id)
    {
        $riwayat = RiwayatDiagnosis::with('tingkatKecanduan')->findOrFail($id);
        $gejalaDipilih = Gejala::whereIn('id', $riwayat->gejala_terpilih)->get();
        
        return view('admin.history-detail', compact('riwayat', 'gejalaDipilih'));
    }

    public function historyDestroy($id)
    {
        $riwayat = RiwayatDiagnosis::findOrFail($id);
        $riwayat->delete();
        
        return redirect()->route('admin.history')
            ->with('success', 'Riwayat diagnosis berhasil dihapus');
    }
}