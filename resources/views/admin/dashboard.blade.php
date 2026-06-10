@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')
<div class="mb-6">
    <h1 class="text-xl md:text-2xl font-bold text-gray-800">Dashboard Admin</h1>
    <p class="text-sm md:text-base text-gray-500">Selamat datang kembali, {{ Auth::user()->name }}</p>
</div>

<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 md:gap-6 mb-8">
    <div class="stat-card bg-white rounded-xl shadow-sm p-4 md:p-6 border-l-4 border-indigo-500">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-gray-500 text-xs md:text-sm">Total Diagnosis</p>
                <p class="text-2xl md:text-3xl font-bold text-gray-800">{{ $totalDiagnosis }}</p>
            </div>
            <i class="fa-solid fa-chart-line text-indigo-500 text-2xl md:text-3xl opacity-50"></i>
        </div>
    </div>
    
    <div class="stat-card bg-white rounded-xl shadow-sm p-4 md:p-6 border-l-4 border-green-500">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-gray-500 text-xs md:text-sm">Diagnosis Hari Ini</p>
                <p class="text-2xl md:text-3xl font-bold text-gray-800">{{ $totalHariIni }}</p>
            </div>
            <i class="fa-solid fa-calendar-day text-green-500 text-2xl md:text-3xl opacity-50"></i>
        </div>
    </div>
    
    <div class="stat-card bg-white rounded-xl shadow-sm p-4 md:p-6 border-l-4 border-yellow-500">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-gray-500 text-xs md:text-sm">Total Gejala</p>
                <p class="text-2xl md:text-3xl font-bold text-gray-800">{{ $totalGejala }}</p>
            </div>
            <i class="fa-solid fa-list-check text-yellow-500 text-2xl md:text-3xl opacity-50"></i>
        </div>
    </div>
    
    <div class="stat-card bg-white rounded-xl shadow-sm p-4 md:p-6 border-l-4 border-purple-500">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-gray-500 text-xs md:text-sm">Rata-rata per Hari</p>
                <p class="text-2xl md:text-3xl font-bold text-gray-800">{{ $rataPerHari }}</p>
            </div>
            <i class="fa-solid fa-chart-simple text-purple-500 text-2xl md:text-3xl opacity-50"></i>
        </div>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-4 md:gap-6 mb-8">
    <div class="bg-white rounded-xl shadow-sm p-4 md:p-6">
        <h2 class="font-bold text-gray-800 text-base md:text-lg mb-4">Statistik per Tingkat Kecanduan</h2>
        <div class="space-y-4">
            @foreach($statistikTingkat as $stat)
            <div>
                <div class="flex flex-wrap justify-between text-xs md:text-sm mb-1">
                    <span class="font-medium
                        @if($stat->kode == 'T01') text-green-600
                        @elseif($stat->kode == 'T02') text-yellow-600
                        @elseif($stat->kode == 'T03') text-red-600
                        @else text-gray-600
                        @endif">
                        {{ $stat->nama }}
                    </span>
                    <span class="text-gray-500">{{ $stat->total }} diagnosis</span>
                </div>
                <div class="w-full bg-gray-200 rounded-full h-2">
                    <div class="h-2 rounded-full 
                        @if($stat->kode == 'T01') bg-green-500
                        @elseif($stat->kode == 'T02') bg-yellow-500
                        @elseif($stat->kode == 'T03') bg-red-500
                        @else bg-gray-500
                        @endif" 
                        style="width: {{ $totalDiagnosis > 0 ? ($stat->total / $totalDiagnosis) * 100 : 0 }}%">
                    </div>
                </div>
                <div class="text-right text-xs text-gray-400 mt-1">
                    {{ round(($stat->total / max($totalDiagnosis, 1)) * 100) }}%
                </div>
            </div>
            @endforeach
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-sm p-4 md:p-6">
        <h2 class="font-bold text-gray-800 text-base md:text-lg mb-4">Grafik 7 Hari Terakhir</h2>
        <div class="h-48 md:h-64 flex items-end space-x-1 md:space-x-2">
            @php
                $maxJumlah = max($grafikMingguan->pluck('jumlah')->max(), 1);
            @endphp
            @foreach($grafikMingguan as $item)
            <div class="flex-1 text-center">
                <div class="bg-indigo-500 rounded-t-lg transition-all hover:bg-indigo-600" 
                     style="height: {{ ($item['jumlah'] / $maxJumlah) * 150 }}px">
                </div>
                <p class="text-[10px] md:text-xs text-gray-500 mt-1 md:mt-2">{{ $item['tanggal'] }}</p>
                <p class="text-[10px] md:text-xs font-semibold">{{ $item['jumlah'] }}</p>
            </div>
            @endforeach
        </div>
    </div>
</div>

<div class="bg-white rounded-xl shadow-sm overflow-hidden">
    <div class="px-4 md:px-6 py-3 md:py-4 border-b bg-gray-50 flex justify-between items-center">
        <h2 class="font-bold text-gray-800 text-sm md:text-base">Diagnosis Terbaru</h2>
        <a href="{{ route('admin.history') }}" class="text-xs md:text-sm text-indigo-600 hover:text-indigo-800">
            Lihat semua →
        </a>
    </div>
    
    <div class="table-container">
        <table class="w-full min-w-[640px]">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-3 md:px-6 py-2 md:py-3 text-left text-[10px] md:text-xs font-medium text-gray-500 uppercase">Tanggal</th>
                    <th class="px-3 md:px-6 py-2 md:py-3 text-left text-[10px] md:text-xs font-medium text-gray-500 uppercase">Nama</th>
                    <th class="px-3 md:px-6 py-2 md:py-3 text-left text-[10px] md:text-xs font-medium text-gray-500 uppercase">Hasil</th>
                    <th class="px-3 md:px-6 py-2 md:py-3 text-left text-[10px] md:text-xs font-medium text-gray-500 uppercase">Kecocokan</th>
                    <th class="px-3 md:px-6 py-2 md:py-3 text-left text-[10px] md:text-xs font-medium text-gray-500 uppercase">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @forelse($riwayatTerbaru as $item)
                <tr class="hover:bg-gray-50">
                    <td class="px-3 md:px-6 py-2 md:py-4 text-[11px] md:text-sm text-gray-500">
                        {{ $item->created_at->format('d/m/Y H:i') }}
                    </td>
                    <td class="px-3 md:px-6 py-2 md:py-4 text-[11px] md:text-sm font-medium text-gray-800">
                        {{ $item->nama_pengguna ?? 'Anonim' }}
                    </td>
                    <td class="px-3 md:px-6 py-2 md:py-4">
                        <span class="px-1.5 md:px-2 py-0.5 md:py-1 rounded-full text-[10px] md:text-xs font-semibold
                            @if($item->tingkatKecanduan && $item->tingkatKecanduan->kode == 'T01') bg-green-100 text-green-700
                            @elseif($item->tingkatKecanduan && $item->tingkatKecanduan->kode == 'T02') bg-yellow-100 text-yellow-700
                            @elseif($item->tingkatKecanduan && $item->tingkatKecanduan->kode == 'T03') bg-red-100 text-red-700
                            @else bg-gray-100 text-gray-700
                            @endif">
                            {{ $item->tingkatKecanduan->nama ?? 'Tidak Terdeteksi' }}
                        </span>
                    </td>
                    <td class="px-3 md:px-6 py-2 md:py-4 text-[11px] md:text-sm text-gray-500">
                        {{ round($item->persentase) }}%
                    </td>
                    <td class="px-3 md:px-6 py-2 md:py-4">
                        <a href="{{ route('admin.history.detail', $item->id) }}" class="text-indigo-600 hover:text-indigo-800">
                            <i class="fa-solid fa-eye"></i>
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="px-4 md:px-6 py-8 text-center text-gray-500">
                        <i class="fa-solid fa-inbox text-3xl md:text-4xl mb-2 block"></i>
                        Belum ada data diagnosis
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection