@extends('layouts.admin')

@section('title', 'Detail Diagnosis')

@section('content')
<div class="mb-6">
    <a href="{{ route('admin.history') }}" class="text-indigo-600 hover:text-indigo-800 mb-4 inline-block">
        <i class="fa-solid fa-arrow-left mr-1"></i> Kembali ke Riwayat
    </a>
    <h1 class="text-2xl font-bold text-gray-800">Detail Diagnosis</h1>
</div>

<div class="bg-white rounded-xl shadow-sm overflow-hidden">
    <div class="text-center py-6 
        @if($riwayat->tingkatKecanduan && $riwayat->tingkatKecanduan->kode == 'T01') bg-gradient-to-r from-green-500 to-green-600
        @elseif($riwayat->tingkatKecanduan && $riwayat->tingkatKecanduan->kode == 'T02') bg-gradient-to-r from-yellow-500 to-orange-500
        @elseif($riwayat->tingkatKecanduan && $riwayat->tingkatKecanduan->kode == 'T03') bg-gradient-to-r from-red-500 to-red-600
        @else bg-gray-500
        @endif">
        
        <i class="fa-solid fa-file-alt text-white text-5xl mb-3"></i>
        <h2 class="text-white font-bold text-2xl">{{ $riwayat->tingkatKecanduan->nama ?? 'Tidak Terdeteksi' }}</h2>
        <div class="inline-block bg-white/20 rounded-full px-4 py-1 mt-3">
            <span class="text-white text-sm">Tingkat Kecocokan: {{ round($riwayat->persentase) }}%</span>
        </div>
    </div>

    <div class="p-6">
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6 pb-4 border-b">
            <div>
                <p class="text-gray-500 text-xs">ID Diagnosis</p>
                <p class="font-semibold text-sm">#{{ $riwayat->id }}</p>
            </div>
            <div>
                <p class="text-gray-500 text-xs">Tanggal</p>
                <p class="font-semibold text-sm">{{ $riwayat->created_at->format('d/m/Y H:i') }}</p>
            </div>
            <div>
                <p class="text-gray-500 text-xs">Nama Pengguna</p>
                <p class="font-semibold text-sm">{{ $riwayat->nama_pengguna ?? 'Anonim' }}</p>
            </div>
            <div>
                <p class="text-gray-500 text-xs">Session ID</p>
                <p class="font-mono text-xs">{{ $riwayat->session_id }}</p>
            </div>
        </div>

        @if($riwayat->tingkatKecanduan)
        <div class="mb-6">
            <h3 class="font-semibold text-gray-800 text-lg mb-2">
                <i class="fa-solid fa-clipboard-list text-indigo-500 mr-2"></i> Deskripsi
            </h3>
            <p class="text-gray-700">{{ $riwayat->tingkatKecanduan->deskripsi }}</p>
        </div>

        <div class="mb-6 p-4 bg-indigo-50 rounded-xl">
            <h3 class="font-semibold text-gray-800 text-lg mb-2">
                <i class="fa-solid fa-lightbulb text-yellow-500 mr-2"></i> Solusi yang Disarankan
            </h3>
            <div class="text-gray-700 whitespace-pre-line text-sm">
                {!! nl2br(e($riwayat->tingkatKecanduan->solusi)) !!}
            </div>
        </div>
        @endif

        <div class="mb-6">
            <h3 class="font-semibold text-gray-800 text-lg mb-2">
                <i class="fa-solid fa-circle-check text-green-500 mr-2"></i> Gejala yang Dipilih ({{ count($gejalaDipilih) }})
            </h3>
            <div class="space-y-2">
                @foreach($gejalaDipilih as $g)
                <div class="flex items-start p-2 bg-gray-50 rounded-lg">
                    <span class="font-mono text-xs text-indigo-600 bg-indigo-100 px-2 py-0.5 rounded mr-3">{{ $g->kode }}</span>
                    <p class="text-gray-700 text-sm">{{ $g->deskripsi }}</p>
                </div>
                @endforeach
            </div>
        </div>

        <div class="flex justify-end pt-4 border-t">
            <form method="POST" action="{{ route('admin.history.destroy', $riwayat->id) }}" onsubmit="return confirm('Yakin hapus data ini?')">
                @csrf
                @method('DELETE')
                <button type="submit" class="bg-red-600 text-white px-4 py-2 rounded-lg hover:bg-red-700 transition">
                    <i class="fa-solid fa-trash mr-2"></i> Hapus Data
                </button>
            </form>
        </div>
    </div>
</div>
@endsection