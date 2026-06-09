@extends('layouts.admin')

@section('title', 'Riwayat Diagnosis')

@section('content')
<div class="bg-white rounded-2xl border border-slate-200/80 shadow-sm overflow-hidden mb-6">
    <div class="px-6 py-4 border-b border-slate-100 bg-slate-50/50 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-1 sm:gap-4">
        <div>
            <h1 class="text-xl sm:text-2xl font-black text-slate-900 tracking-tight">Riwayat Diagnosis</h1>
            <p class="text-xs sm:text-sm text-slate-500 font-medium mt-0.5">Semua data diagnosis yang pernah dilakukan oleh pengguna dalam sistem</p>
        </div>
    </div>
</div>

<div class="bg-white rounded-2xl border border-slate-200/80 shadow-sm overflow-hidden">
    <div class="px-6 py-4 border-b border-slate-100 bg-slate-50/50 flex justify-between items-center">
        <h2 class="font-bold text-slate-800 text-base">Data Diagnosis</h2>
        <span class="text-xs font-bold text-indigo-600 bg-indigo-50 px-2.5 py-1 rounded-xl border border-indigo-100">
            Total: {{ $riwayat->total() }} data
        </span>
    </div>

    <div class="w-full overflow-x-auto block">
        <table class="w-full min-w-[850px] border-collapse align-middle">
            <thead>
                <tr class="bg-slate-50/70 border-b border-slate-200/80">
                    <th class="px-6 py-3.5 text-left text-xs font-bold text-slate-400 uppercase tracking-wider w-16">ID</th>
                    <th class="px-6 py-3.5 text-left text-xs font-bold text-slate-400 uppercase tracking-wider">Tanggal</th>
                    <th class="px-6 py-3.5 text-left text-xs font-bold text-slate-400 uppercase tracking-wider">Nama</th>
                    <th class="px-6 py-3.5 text-left text-xs font-bold text-slate-400 uppercase tracking-wider">Session ID</th>
                    <th class="px-6 py-3.5 text-left text-xs font-bold text-slate-400 uppercase tracking-wider">Hasil</th>
                    <th class="px-6 py-3.5 text-left text-xs font-bold text-slate-400 uppercase tracking-wider w-24">Kecocokan</th>
                    <th class="px-6 py-3.5 text-center text-xs font-bold text-slate-400 uppercase tracking-wider w-28">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @forelse($riwayat as $item)
                <tr class="hover:bg-slate-50/80 transition-colors">
                    <td class="px-6 py-4 text-xs font-bold text-slate-400">#{{ $item->id }}</td>
                    <td class="px-6 py-4 text-xs font-medium text-slate-500">
                        {{ $item->created_at->format('d/m/Y H:i') }}
                    </td>
                    <td class="px-6 py-4 text-sm font-bold text-slate-800">
                        {{ $item->nama_pengguna ?? 'Anonim' }}
                    </td>
                    <td class="px-6 py-4 text-xs font-mono text-slate-400">
                        {{ substr($item->session_id, 0, 8) }}...
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
                            <span>{{ $item->tingkatKecanduan->nama ?? 'Tidak Terdeteksi' }}</span>
                        </span>
                    </td>
                    <td class="px-6 py-4 text-sm font-semibold text-slate-600">
                        {{ round($item->persentase) }}%
                    </td>
                    <td class="px-6 py-4 text-center whitespace-nowrap">
                        <div class="inline-flex items-center space-x-2">
                            <a href="{{ route('admin.history.detail', $item->id) }}" class="inline-flex items-center justify-center w-8 h-8 bg-white border border-slate-200 text-slate-500 hover:text-indigo-600 hover:border-indigo-200 rounded-xl shadow-sm transition-all active:scale-95" title="Lihat Detail">
                                <i class="fa-solid fa-eye text-xs"></i>
                            </a>
                            <form method="POST" action="{{ route('admin.history.destroy', $item->id) }}" class="inline" onsubmit="return confirm('Yakin hapus data ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="inline-flex items-center justify-center w-8 h-8 bg-white border border-slate-200 text-slate-400 hover:text-rose-600 hover:border-rose-200 rounded-xl shadow-sm transition-all active:scale-95" title="Hapus Data">
                                    <i class="fa-solid fa-trash text-xs"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="px-6 py-12 text-center text-slate-400">
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

    @if($riwayat->hasPages())
    <div class="px-6 py-4 border-t border-slate-100 bg-slate-50/30">
        {{ $riwayat->links() }}
    </div>
    @endif
</div>
@endsection