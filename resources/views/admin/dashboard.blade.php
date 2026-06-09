@extends('layouts.admin')

@section('title', 'Dashboard Overview')

@section('content')
<div class="bg-white rounded-2xl border border-slate-200/80 shadow-sm overflow-hidden mb-6">
    <div class="px-6 py-4 border-b border-slate-100 bg-slate-50/50 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-1 sm:gap-4">
        <div>
            <h1 class="text-xl sm:text-2xl font-black text-slate-900 tracking-tight">Dashboard</h1>
            <p class="text-xs sm:text-sm text-slate-500 font-medium mt-0.5">Selamat datang kembali, {{ Auth::user()->name }}</p>
        </div>
    </div>
</div>

<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5 mb-8">
    <div class="bg-white rounded-2xl border border-slate-200/80 p-6 shadow-[0_4px_20px_-4px_rgba(99,102,241,0.02)] flex items-center justify-between group hover:border-indigo-200 transition-all">
        <div>
            <p class="text-slate-400 text-xs font-bold uppercase tracking-wider">Total Diagnosis</p>
            <p class="text-3xl font-black text-slate-800 tracking-tight mt-1">{{ $totalDiagnosis }}</p>
        </div>
        <div class="w-12 h-12 bg-indigo-50 rounded-xl flex items-center justify-center text-indigo-500 group-hover:bg-indigo-600 group-hover:text-white transition-all duration-300">
            <i class="fa-solid fa-chart-line text-lg"></i>
        </div>
    </div>
    
    <div class="bg-white rounded-2xl border border-slate-200/80 p-6 shadow-[0_4px_20px_-4px_rgba(99,102,241,0.02)] flex items-center justify-between group hover:border-emerald-200 transition-all">
        <div>
            <p class="text-slate-400 text-xs font-bold uppercase tracking-wider">Hari Ini</p>
            <p class="text-3xl font-black text-slate-800 tracking-tight mt-1">{{ $totalHariIni }}</p>
        </div>
        <div class="w-12 h-12 bg-emerald-50 rounded-xl flex items-center justify-center text-emerald-500 group-hover:bg-emerald-600 group-hover:text-white transition-all duration-300">
            <i class="fa-solid fa-calendar-day text-lg"></i>
        </div>
    </div>
    
    <div class="bg-white rounded-2xl border border-slate-200/80 p-6 shadow-[0_4px_20px_-4px_rgba(99,102,241,0.02)] flex items-center justify-between group hover:border-amber-200 transition-all">
        <div>
            <p class="text-slate-400 text-xs font-bold uppercase tracking-wider">Total Gejala</p>
            <p class="text-3xl font-black text-slate-800 tracking-tight mt-1">{{ $totalGejala }}</p>
        </div>
        <div class="w-12 h-12 bg-amber-50 rounded-xl flex items-center justify-center text-amber-500 group-hover:bg-amber-600 group-hover:text-white transition-all duration-300">
            <i class="fa-solid fa-list-check text-lg"></i>
        </div>
    </div>
    
    <div class="bg-white rounded-2xl border border-slate-200/80 p-6 shadow-[0_4px_20px_-4px_rgba(99,102,241,0.02)] flex items-center justify-between group hover:border-purple-200 transition-all">
        <div>
            <p class="text-slate-400 text-xs font-bold uppercase tracking-wider">Rata-rata / Hari</p>
            <p class="text-3xl font-black text-slate-800 tracking-tight mt-1">{{ $rataPerHari }}</p>
        </div>
        <div class="w-12 h-12 bg-purple-50 rounded-xl flex items-center justify-center text-purple-500 group-hover:bg-purple-600 group-hover:text-white transition-all duration-300">
            <i class="fa-solid fa-chart-simple text-lg"></i>
        </div>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
    <div class="bg-white rounded-2xl border border-slate-200/80 p-5 sm:p-6 shadow-sm">
        <h2 class="font-extrabold text-slate-900 tracking-tight text-base mb-6 flex items-center">
            <span class="w-1.5 h-4 bg-indigo-600 rounded-full mr-2"></span>
            Statistik per Tingkat Kecanduan
        </h2>
        <div class="space-y-4">
            @foreach($statistikTingkat as $stat)
            <div class="group">
                <div class="flex justify-between text-xs sm:text-sm mb-1.5 font-semibold">
                    <span class="
                        @if($stat->tingkat_kecanduan && $stat->tingkat_kecanduan->kode == 'T01') text-emerald-600
                        @elseif($stat->tingkat_kecanduan && $stat->tingkat_kecanduan->kode == 'T02') text-amber-600
                        @else text-rose-600
                        @endif">
                        {{ $stat->tingkat_kecanduan->nama ?? 'Tidak Terdeteksi' }}
                    </span>
                    <span class="text-slate-400 font-medium">{{ $stat->total }} diagnosis</span>
                </div>
                <div class="w-full bg-slate-100 rounded-full h-2.5 overflow-hidden border border-slate-200/30">
                    <div class="h-full rounded-full transition-all duration-500
                        @if($stat->tingkat_kecanduan && $stat->tingkat_kecanduan->kode == 'T01') bg-gradient-to-r from-emerald-400 to-teal-500
                        @elseif($stat->tingkat_kecanduan && $stat->tingkat_kecanduan->kode == 'T02') bg-gradient-to-r from-amber-400 to-orange-500
                        @else bg-gradient-to-r from-rose-400 to-red-500
                        @endif" 
                        style="width: {{ $totalDiagnosis > 0 ? ($stat->total / $totalDiagnosis) * 100 : 0 }}%">
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>

    <div class="bg-white rounded-2xl border border-slate-200/80 p-5 sm:p-6 shadow-sm flex flex-col justify-between">
        <h2 class="font-extrabold text-slate-900 tracking-tight text-base mb-6 flex items-center">
            <span class="w-1.5 h-4 bg-purple-600 rounded-full mr-2"></span>
            Tren 7 Hari Terakhir
        </h2>
        <div class="h-56 flex items-end justify-between pt-4 px-2 space-x-2 sm:space-x-4 border-b border-slate-100">
            @foreach($grafikMingguan as $item)
            <div class="flex-1 flex flex-col items-center h-full justify-end group">
                <span class="text-[10px] font-bold text-slate-700 opacity-0 group-hover:opacity-100 mb-1 transition-opacity">{{ $item['jumlah'] }}</span>
                <div class="bg-indigo-500 rounded-t-md w-full max-w-[28px] transition-all duration-300 hover:bg-gradient-to-b hover:from-indigo-400 hover:to-indigo-600" 
                     style="height: {{ $totalDiagnosis > 0 ? ($item['jumlah'] / max($grafikMingguan->pluck('jumlah')->max(), 1)) * 100 : 0 }}%">
                </div>
                <span class="text-[9px] font-bold text-slate-400 mt-2 block tracking-tighter uppercase truncate max-w-full">
                    {{ substr($item['tanggal'], 0, 3) }}
                </span>
            </div>
            @endforeach
        </div>
    </div>
</div>

<div class="bg-white rounded-2xl border border-slate-200/80 shadow-sm overflow-hidden">
    <div class="px-5 py-4 border-b border-slate-100 bg-slate-50/50 flex items-center justify-between">
        <h2 class="font-extrabold text-slate-900 tracking-tight text-sm sm:text-base">Diagnosis Terbaru</h2>
        <span class="text-[11px] font-bold text-indigo-600 bg-indigo-50 px-2 py-1 rounded-lg border border-indigo-100">Live Data</span>
    </div>
    
    <div class="w-full overflow-x-auto block">
        <table class="w-full min-w-[600px] border-collapse align-middle">
            <thead>
                <tr class="bg-slate-50/70 border-b border-slate-200/80">
                    <th class="px-6 py-3.5 text-left text-xs font-bold text-slate-400 uppercase tracking-wider">Tanggal</th>
                    <th class="px-6 py-3.5 text-left text-xs font-bold text-slate-400 uppercase tracking-wider">Nama Pengguna</th>
                    <th class="px-6 py-3.5 text-left text-xs font-bold text-slate-400 uppercase tracking-wider">Hasil Diagnosis</th>
                    <th class="px-6 py-3.5 text-left text-xs font-bold text-slate-400 uppercase tracking-wider">Kecocokan</th>
                    <th class="px-6 py-3.5 text-center text-xs font-bold text-slate-400 uppercase tracking-wider w-20">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @forelse($riwayatTerbaru as $item)
                <tr class="hover:bg-slate-50/80 transition-colors">
                    <td class="px-6 py-4 text-xs font-medium text-slate-500">
                        {{ $item->created_at->format('d/m/Y H:i') }}
                    </td>
                    <td class="px-6 py-4 text-sm font-bold text-slate-800">
                        {{ $item->nama_pengguna ?? ($item->nama ?? 'Anonim') }}
                    </td>
                    <td class="px-6 py-4">
                        <span class="px-2.5 py-1 rounded-xl text-xs font-bold inline-flex items-center space-x-1.5
                            @if($item->tingkatKecanduan && $item->tingkatKecanduan->kode == 'T01') bg-emerald-50 text-emerald-700 border border-emerald-200/50
                            @elseif($item->tingkatKecanduan && $item->tingkatKecanduan->kode == 'T02') bg-amber-50 text-amber-700 border border-amber-200/50
                            @elseif($item->tingkatKecanduan && $item->tingkatKecanduan->kode == 'T03') bg-rose-50 text-rose-700 border border-rose-200/50
                            @else bg-slate-100 text-slate-600 border border-slate-200
                            @endif">
                            <span class="w-1.5 h-1.5 rounded-full 
                                @if($item->tingkatKecanduan && $item->tingkatKecanduan->kode == 'T01') bg-emerald-500
                                @elseif($item->tingkatKecanduan && $item->tingkatKecanduan->kode == 'T02') bg-amber-500
                                @else bg-rose-500
                                @endif"></span>
                            <span class="truncate max-w-[150px] sm:max-w-none">{{ $item->tingkatKecanduan->nama ?? 'Tidak Terdeteksi' }}</span>
                        </span>
                    </td>
                    <td class="px-6 py-4 text-sm font-semibold text-slate-600">
                        {{ round($item->persentase) }}%
                    </td>
                    <td class="px-6 py-4 text-center">
                        <a href="{{ route('admin.history.detail', $item->id) }}" class="inline-flex items-center justify-center w-8 h-8 bg-white border border-slate-200 text-slate-500 hover:text-indigo-600 hover:border-indigo-200 rounded-xl shadow-sm transition-all active:scale-95">
                            <i class="fa-solid fa-eye text-xs"></i>
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="px-6 py-12 text-center text-slate-400">
                        <div class="w-12 h-12 bg-slate-50 border border-slate-200/60 rounded-xl flex items-center justify-center mx-auto mb-3 shadow-sm">
                            <i class="fa-solid fa-folder-open text-slate-400 text-base"></i>
                        </div>
                        <p class="text-sm font-bold text-slate-700">Belum Ada Riwayat</p>
                        <p class="text-xs text-slate-400 mt-0.5">Sesi pemeriksaan sistem pakar belum terekam.</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection