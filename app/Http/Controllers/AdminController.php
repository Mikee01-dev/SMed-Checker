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
    
    $statistikTingkat = TingkatKecanduan::leftJoin('riwayat_diagnosis', 'tingkat_kecanduan.id', '=', 'riwayat_diagnosis.tingkat_kecanduan_id')
        ->select('tingkat_kecanduan.*', DB::raw('count(riwayat_diagnosis.id) as total'))
        ->groupBy('tingkat_kecanduan.id', 'tingkat_kecanduan.kode', 'tingkat_kecanduan.nama', 'tingkat_kecanduan.deskripsi', 'tingkat_kecanduan.solusi', 'tingkat_kecanduan.created_at', 'tingkat_kecanduan.updated_at')
        ->orderByRaw("FIELD(tingkat_kecanduan.kode, 'T01', 'T02', 'T03', 'T00')")
        ->get();
    
    $jumlahHari = RiwayatDiagnosis::where('created_at', '>=', now()->subDays(30))->count();
    $rataPerHari = round($jumlahHari / max(30, 1), 1);
    
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

    public function history(Request $request)
    {
        $perPage = $request->get('per_page', 20);
        $search = $request->get('search', '');
        $filter = $request->get('filter', '');
        
        $query = RiwayatDiagnosis::with('tingkatKecanduan');
        
        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('nama_pengguna', 'like', "%{$search}%")
                  ->orWhere('session_id', 'like', "%{$search}%");
            });
        }
        
        if ($filter && $filter != 'all') {
            $tingkatIds = TingkatKecanduan::where('kode', $filter)->pluck('id');
            $query->whereIn('tingkat_kecanduan_id', $tingkatIds);
        }
        
        $riwayat = $query->orderBy('created_at', 'desc')->paginate($perPage);
        
        $tingkatList = TingkatKecanduan::orderByRaw("FIELD(kode, 'T01', 'T02', 'T03', 'T00')")->get();
        
        return view('admin.history', compact('riwayat', 'perPage', 'search', 'filter', 'tingkatList'));
    }

    public function historyDetail($id)
    {
        $riwayat = RiwayatDiagnosis::with('tingkatKecanduan')->findOrFail($id);
        $gejalaDipilih = Gejala::whereIn('id', $riwayat->gejala_terpilih)->get();
        
        $rules = \App\Models\Rule::with(['gejala', 'tingkatKecanduan'])
            ->orderBy('kode', 'desc')
            ->get();
        
        $detailHasil = [];
        foreach ($rules as $rule) {
            $gejalaDibutuhkan = $rule->gejala->pluck('id')->toArray();
            $gejalaCocok = array_intersect($gejalaDibutuhkan, $riwayat->gejala_terpilih);
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
        }
        
        return view('admin.history-detail', compact('riwayat', 'gejalaDipilih', 'detailHasil'));
    }

    public function historyDestroy($id)
    {
        $riwayat = RiwayatDiagnosis::findOrFail($id);
        $riwayat->delete();
        
        return redirect()->route('admin.history')
            ->with('success', 'Riwayat diagnosis berhasil dihapus');
    }
}