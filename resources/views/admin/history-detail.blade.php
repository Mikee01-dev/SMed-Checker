@extends('layouts.admin')

@section('title', 'Detail Diagnosis')

@section('content')
<div class="mb-4 md:mb-6">
    <a href="{{ route('admin.history', request()->query()) }}" class="text-indigo-600 hover:text-indigo-800 mb-4 inline-block text-sm md:text-base">
        <i class="fa-solid fa-arrow-left mr-1"></i> Kembali ke Riwayat
    </a>
    <h1 class="text-xl md:text-2xl font-bold text-gray-800">Detail Diagnosis</h1>
</div>

<div class="bg-white rounded-xl shadow-sm overflow-hidden">
    <div class="text-center py-6 md:py-8 
        @if($riwayat->tingkatKecanduan && $riwayat->tingkatKecanduan->kode == 'T01') bg-gradient-to-r from-green-500 to-green-600
        @elseif($riwayat->tingkatKecanduan && $riwayat->tingkatKecanduan->kode == 'T02') bg-gradient-to-r from-yellow-500 to-orange-500
        @elseif($riwayat->tingkatKecanduan && $riwayat->tingkatKecanduan->kode == 'T03') bg-gradient-to-r from-red-500 to-red-600
        @else bg-gradient-to-r from-gray-500 to-gray-600
        @endif">
        
        <i class="fa-solid fa-file-alt text-white text-4xl md:text-5xl mb-2 md:mb-3"></i>
        <h2 class="text-white font-bold text-xl md:text-2xl">{{ $riwayat->tingkatKecanduan->nama ?? 'Tidak Terdeteksi' }}</h2>
        @if($riwayat->tingkatKecanduan && $riwayat->tingkatKecanduan->kode == 'T00')
        <div class="mt-2 text-white/80 text-xs md:text-sm">
            <i class="fa-solid fa-chart-line mr-1"></i> Tidak ada rule yang terpenuhi 100%
        </div>
        @endif
    </div>

    <div class="p-4 md:p-6">
        <div class="grid grid-cols-2 gap-3 md:gap-4 mb-6 pb-4 border-b">
            <div>
                <p class="text-gray-500 text-[10px] md:text-xs">ID Diagnosis</p>
                <p class="font-semibold text-sm md:text-base">#{{ $riwayat->id }}</p>
            </div>
            <div>
                <p class="text-gray-500 text-[10px] md:text-xs">Tanggal</p>
                <p class="font-semibold text-sm md:text-base">{{ $riwayat->created_at->format('d/m/Y H:i') }}</p>
            </div>
            <div>
                <p class="text-gray-500 text-[10px] md:text-xs">Nama Pengguna</p>
                <p class="font-semibold text-sm md:text-base">{{ $riwayat->nama_pengguna ?? 'Anonim' }}</p>
            </div>
            <div>
                <p class="text-gray-500 text-[10px] md:text-xs">Session ID</p>
                <p class="font-mono text-[10px] md:text-xs">{{ substr($riwayat->session_id, 0, 12) }}...</p>
            </div>
        </div>

        @if($riwayat->tingkatKecanduan)
        <div class="mb-6">
            <h3 class="font-semibold text-gray-800 text-sm md:text-lg mb-2 flex items-center">
                <i class="fa-solid fa-clipboard-list text-indigo-500 mr-2 text-sm md:text-base"></i> Deskripsi
            </h3>
            <p class="text-gray-700 text-xs md:text-sm leading-relaxed">{{ $riwayat->tingkatKecanduan->deskripsi }}</p>
        </div>

        <div class="mb-6 p-3 md:p-4 bg-indigo-50 rounded-xl">
            <h3 class="font-semibold text-gray-800 text-sm md:text-lg mb-2 flex items-center">
                <i class="fa-solid fa-lightbulb text-yellow-500 mr-2 text-sm md:text-base"></i> Solusi yang Disarankan
            </h3>
            <div class="text-gray-700 whitespace-pre-line text-xs md:text-sm">
                {!! nl2br(e($riwayat->tingkatKecanduan->solusi)) !!}
            </div>
        </div>
        @endif

        <div class="mb-6">
            <h3 class="font-semibold text-gray-800 text-sm md:text-lg mb-2 flex items-center">
                <i class="fa-solid fa-chart-line text-indigo-500 mr-2 text-sm md:text-base"></i> Detail Kecocokan per Tingkat
            </h3>
            <div class="table-container">
                <table class="w-full min-w-[500px] text-xs md:text-sm">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-2 md:px-4 py-2 text-left">Tingkat</th>
                            <th class="px-2 md:px-4 py-2 text-left">Cocok</th>
                            <th class="px-2 md:px-4 py-2 text-left">Total</th>
                            <th class="px-2 md:px-4 py-2 text-left">Persentase</th>
                            <th class="px-2 md:px-4 py-2 text-left">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($detailHasil as $key => $item)
                        <tr class="border-b">
                            <td class="px-2 md:px-4 py-2 font-semibold
                                @if($key == 'R3') text-red-600
                                @elseif($key == 'R2') text-yellow-600
                                @else text-green-600
                                @endif">
                                @if($key == 'R3') Kecanduan Tinggi
                                @elseif($key == 'R2') Kecanduan Sedang
                                @else Kecanduan Rendah
                                @endif
                            </td>
                            <td class="px-2 md:px-4 py-2">{{ $item['total_cocok'] }}</td>
                            <td class="px-2 md:px-4 py-2">{{ $item['total_dibutuhkan'] }}</td>
                            <td class="px-2 md:px-4 py-2 font-bold">{{ round($item['persentase']) }}%</td>
                            <td class="px-2 md:px-4 py-2">
                                @if($item['status_lengkap'])
                                    <span class="text-green-600 text-[10px] md:text-xs">Lengkap</span>
                                @else
                                    <span class="text-yellow-600 text-[10px] md:text-xs">Kurang</span>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <div class="mb-6">
            <h3 class="font-semibold text-gray-800 text-sm md:text-lg mb-2 flex items-center">
                <i class="fa-solid fa-circle-check text-green-500 mr-2 text-sm md:text-base"></i> Gejala yang Dipilih 
                <span class="ml-2 text-xs text-gray-500">({{ count($gejalaDipilih) }} gejala)</span>
            </h3>
            <div class="grid grid-cols-1 gap-2 max-h-96 overflow-y-auto">
                @foreach($gejalaDipilih as $g)
                <div class="flex flex-col md:flex-row md:items-start p-2 md:p-3 bg-gray-50 rounded-lg">
                    <span class="font-mono text-xs text-indigo-600 bg-indigo-100 px-2 py-0.5 rounded mr-0 md:mr-3 mb-1 md:mb-0 self-start">
                        {{ $g->kode }}
                    </span>
                    <p class="text-gray-700 text-xs md:text-sm">{{ $g->deskripsi }}</p>
                </div>
                @endforeach
            </div>
        </div>

        @if(isset($gejalaKurang) && count($gejalaKurang) > 0)
        <div class="mb-6 p-3 md:p-4 bg-yellow-50 rounded-xl">
            <h3 class="font-semibold text-gray-800 text-sm md:text-lg mb-2 flex items-center">
                <i class="fa-solid fa-circle-exclamation text-yellow-600 mr-2"></i> Gejala yang Kurang
            </h3>
            <p class="text-xs md:text-sm text-gray-600 mb-3">Untuk mendapatkan diagnosis pasti, lengkapi gejala berikut:</p>
            <div class="grid grid-cols-1 gap-2">
                @foreach($gejalaKurang as $g)
                <div class="flex flex-col md:flex-row md:items-start p-2 bg-white rounded-lg border border-yellow-200">
                    <span class="font-mono text-xs text-yellow-600 bg-yellow-100 px-2 py-0.5 rounded mr-0 md:mr-3 mb-1 md:mb-0">
                        {{ $g->kode }}
                    </span>
                    <p class="text-gray-700 text-xs md:text-sm">{{ $g->deskripsi }}</p>
                </div>
                @endforeach
            </div>
        </div>
        @endif

        @if($riwayat->tingkatKecanduan && $riwayat->tingkatKecanduan->kode == 'T00' && isset($rekomendasi))
        <div class="mb-6 p-3 md:p-4 bg-blue-50 rounded-xl">
            <h3 class="font-semibold text-gray-800 text-sm md:text-lg mb-2 flex items-center">
                <i class="fa-solid fa-chart-simple text-blue-500 mr-2"></i> Rekomendasi
            </h3>
            <p class="text-xs md:text-sm text-gray-700">{{ $rekomendasi }}</p>
        </div>
        @endif

        <div class="flex justify-end pt-4 border-t">
            <form method="POST" action="{{ route('admin.history.destroy', $riwayat->id) }}" onsubmit="return confirm('Yakin hapus data ini?')">
                @csrf
                @method('DELETE')
                <button type="submit" class="bg-red-600 text-white px-3 md:px-4 py-1.5 md:py-2 rounded-lg text-sm md:text-base hover:bg-red-700 transition">
                    <i class="fa-solid fa-trash mr-1 md:mr-2"></i> Hapus Data
                </button>
            </form>
        </div>
    </div>
</div>
@endsection