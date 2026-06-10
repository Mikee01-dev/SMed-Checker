@extends('layouts.master')

@section('title', 'Hasil Diagnosis')

@section('content')
<div class="max-w-4xl mx-auto px-4 py-8">

    @if($hasilFinal->kode == 'T00')
        <div class="bg-gray-100 border-l-4 border-gray-500 rounded-xl p-4 mb-6">
            <p class="text-gray-700 font-semibold flex items-center">
                <i class="fa-solid fa-circle-exclamation text-gray-500 mr-2"></i>
                {{ $hasilFinal->nama }}
            </p>
            <p class="text-sm text-gray-600 mt-1">{{ $hasilFinal->deskripsi }}</p>
        </div>

        @if($saran)
        <div class="bg-yellow-50 rounded-xl p-6 mb-6">
            <h3 class="font-bold text-gray-800 mb-3 flex items-center">
                <i class="fa-solid fa-chart-line text-yellow-600 mr-2"></i>
                Kecenderungan Berdasarkan Gejala Anda
            </h3>
            
            <div class="text-center mb-4">
                <span class="inline-block px-6 py-2 rounded-full font-bold text-white text-lg
                    @if($saran['tingkat']->kode == 'T01') bg-green-500
                    @elseif($saran['tingkat']->kode == 'T02') bg-yellow-500
                    @else bg-red-500
                    @endif">
                    {{ $saran['tingkat']->nama }}
                </span>
                <p class="text-3xl font-bold mt-3">{{ round($saran['persentase']) }}%</p>
                <p class="text-sm text-gray-500">Tingkat Kecocokan</p>
            </div>

            @if(count($gejalaKurangDetail) > 0)
            <div class="mt-4 p-4 bg-yellow-100 rounded-lg">
                <p class="text-sm font-semibold text-yellow-800 mb-2">
                    <i class="fa-solid fa-list mr-1"></i> Gejala yang kurang:
                </p>
                <ul class="space-y-1">
                    @foreach($gejalaKurangDetail as $g)
                    <li class="text-sm text-yellow-700">
                        <i class="fa-regular fa-circle-xmark mr-2"></i>
                        <span class="font-mono text-xs">{{ $g->kode }}</span> - {{ $g->deskripsi }}
                    </li>
                    @endforeach
                </ul>
            </div>
            @endif

            <div class="mt-4 p-3 bg-blue-50 rounded-lg">
                <p class="text-sm text-blue-700">
                    <i class="fa-solid fa-info-circle mr-1"></i>
                    <strong>Catatan:</strong> Ini adalah SARAN berdasarkan gejala Anda, 
                    bukan diagnosis pasti. Konsultasikan dengan psikolog untuk hasil yang akurat.
                </p>
            </div>
        </div>
        @endif

    @else
        <div class="bg-white rounded-2xl shadow-lg overflow-hidden mb-6">
            <div class="text-center py-8 
                @if($hasilFinal->kode == 'T01') bg-gradient-to-r from-green-500 to-green-600
                @elseif($hasilFinal->kode == 'T02') bg-gradient-to-r from-yellow-500 to-orange-500
                @else bg-gradient-to-r from-red-500 to-red-600
                @endif">
                
                <i class="fa-solid fa-stethoscope text-white text-5xl mb-3"></i>
                <h2 class="text-white font-bold text-3xl">{{ $hasilFinal->nama }}</h2>
                <div class="inline-block bg-white/20 rounded-full px-4 py-1 mt-3">
                    <span class="text-white text-sm">Diagnosis Pasti - 100%</span>
                </div>
            </div>

            <div class="p-6">
                @if($riwayat->nama_pengguna)
                <div class="bg-gray-50 rounded-xl px-4 py-3 mb-6">
                    <p><i class="fa-solid fa-user text-indigo-500 mr-2"></i> Nama: <span class="font-semibold">{{ $riwayat->nama_pengguna }}</span></p>
                </div>
                @endif

                <div class="mb-6">
                    <h3 class="font-semibold text-gray-800 text-lg mb-2">
                        <i class="fa-solid fa-clipboard-list text-indigo-500 mr-2"></i> Deskripsi
                    </h3>
                    <p class="text-gray-700">{{ $hasilFinal->deskripsi }}</p>
                </div>

                <div class="mb-6 p-4 bg-indigo-50 rounded-xl">
                    <h3 class="font-semibold text-gray-800 text-lg mb-2">
                        <i class="fa-solid fa-lightbulb text-yellow-500 mr-2"></i> Solusi yang Disarankan
                    </h3>
                    <div class="text-gray-700 whitespace-pre-line text-sm">
                        {!! nl2br(e($hasilFinal->solusi)) !!}
                    </div>
                </div>
            </div>
        </div>

        @if(count($detailHasil) > 0)
        <div class="bg-white rounded-2xl shadow-lg overflow-hidden mb-6">
            <div class="bg-gray-50 px-6 py-4 border-b">
                <h3 class="font-semibold text-gray-800">
                    <i class="fa-solid fa-chart-line text-indigo-500 mr-2"></i> Detail Kecocokan per Tingkat
                </h3>
            </div>
            <div class="p-6">
                <table class="w-full">
                    <thead>
                        <tr>
                            <th class="text-left p-2">Tingkat Kecanduan</th>
                            <th class="text-left p-2">Gejala Cocok</th>
                            <th class="text-left p-2">Total Gejala</th>
                            <th class="text-left p-2">Persentase</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($detailHasil as $key => $item)
                        <tr class="border-t">
                            <td class="p-2">
                                @if($key == 'R3') Kecanduan Tinggi
                                @elseif($key == 'R2') Kecanduan Sedang
                                @else Kecanduan Rendah
                                @endif
                            </td>
                            <td class="p-2">{{ $item['total_cocok'] }}</td>
                            <td class="p-2">{{ $item['total_dibutuhkan'] }}</td>
                            <td class="p-2"><strong>{{ round($item['persentase']) }}%</strong></td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        @endif
    @endif

    <div class="bg-white rounded-2xl shadow-lg overflow-hidden mb-6">
        <div class="bg-gray-50 px-6 py-4 border-b">
            <h3 class="font-semibold text-gray-800">
                <i class="fa-solid fa-circle-check text-green-500 mr-2"></i> Gejala yang Anda Pilih
            </h3>
        </div>
        <div class="p-6">
            <div class="flex flex-wrap gap-2">
                @foreach($gejalaDipilih as $g)
                <span class="bg-gray-100 text-gray-700 px-3 py-1 rounded-full text-sm">
                    <span class="font-mono text-indigo-600">{{ $g->kode }}</span>
                </span>
                @endforeach
            </div>
            <p class="text-xs text-gray-500 mt-3">Total: {{ count($gejalaDipilih) }} gejala</p>
        </div>
    </div>

    <div class="flex flex-wrap justify-center gap-4">
        <a href="{{ route('diagnosis.index') }}" class="bg-indigo-600 text-white px-6 py-3 rounded-xl font-semibold hover:bg-indigo-700 transition flex items-center gap-2">
            <i class="fa-solid fa-repeat"></i> Diagnosis Ulang
        </a>
        <a href="{{ route('diagnosis.download-pdf', $riwayat->id) }}" class="bg-red-600 text-white px-6 py-3 rounded-xl font-semibold hover:bg-red-700 transition flex items-center gap-2">
            <i class="fa-solid fa-file-pdf"></i> Download PDF
        </a>
    </div>

    <div class="mt-6 p-3 bg-yellow-50 border border-yellow-200 rounded-lg text-sm text-yellow-700 text-center">
        <i class="fa-solid fa-triangle-exclamation mr-2"></i>
        Diagnosis ini bersifat awal, bukan pengganti konsultasi dengan psikolog profesional.
    </div>
</div>
@endsection