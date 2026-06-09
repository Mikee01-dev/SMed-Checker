@extends('layouts.master')

@section('title', 'Hasil Diagnosis')

@section('nav-links')
    <a href="{{ route('diagnosis.about') }}" class="block md:inline-block px-5 py-2.5 text-center text-sm font-semibold text-white bg-indigo-600 rounded-xl hover:bg-indigo-700 shadow-sm hover:shadow-indigo-200 hover:shadow-lg transition-all duration-300">
        <i class="fa-solid fa-info-circle mr-1"></i> Tentang
    </a>
@endsection

@section('content')
<div class="max-w-3xl mx-auto px-4 py-8 sm:py-12 relative z-10 print:py-0 print:px-0">
    <div class="bg-white border border-slate-200/70 rounded-3xl shadow-[0_20px_50px_-20px_rgba(99,102,241,0.08)] overflow-hidden print:shadow-none print:border-none">
        
        <div class="text-center py-10 px-6 relative overflow-hidden
            @if($riwayat->tingkatKecanduan->kode == 'T01') bg-gradient-to-br from-emerald-500 to-teal-600
            @elseif($riwayat->tingkatKecanduan->kode == 'T02') bg-gradient-to-br from-amber-500 to-orange-500
            @else bg-gradient-to-br from-rose-500 to-red-600
            @endif">
            
            <div class="absolute inset-0 bg-[radial-gradient(circle_at_center,rgba(255,255,255,0.15),transparent_70%)]"></div>
            
            <div class="relative z-10">
                <div class="w-16 h-16 bg-white/20 backdrop-blur-md rounded-2xl flex items-center justify-center mx-auto mb-4 shadow-inner">
                    <i class="fa-solid fa-chart-pie text-white text-3xl"></i>
                </div>
                <p class="text-white/80 text-xs font-bold uppercase tracking-widest">Hasil Analisis Sistem Pakar</p>
                <h2 class="text-white font-black text-3xl sm:text-4xl mt-1 tracking-tight drop-shadow-sm">
                    {{ $riwayat->tingkatKecanduan->nama }}
                </h2>
                
                <div class="inline-flex items-center space-x-2 bg-white/20 backdrop-blur-md border border-white/20 rounded-full px-4 py-1.5 mt-4 shadow-sm">
                    <span class="w-2 h-2 rounded-full bg-white animate-pulse"></span>
                    <span class="text-white text-xs font-bold tracking-wide">Tingkat Kecocokan: {{ round($riwayat->persentase) }}%</span>
                </div>
            </div>
        </div>

        <div class="p-6 sm:p-8 space-y-8">
            
            <div class="bg-slate-50 border border-slate-200/50 rounded-2xl p-4 flex flex-col sm:flex-row items-center justify-between gap-4 text-center sm:text-left">
                <div class="flex items-center space-x-3 text-slate-700">
                    <div class="p-2 bg-white border border-slate-200/60 rounded-xl hidden sm:block">
                        <i class="fa-solid fa-calculator text-indigo-500"></i>
                    </div>
                    <p class="text-sm font-medium text-slate-600">
                        Dari <span class="font-bold text-slate-900">{{ $riwayat->tingkatKecanduan->rules->first()->gejala->count() ?? 0 }}</span> gejala dasar pada indikasi ini, Anda divalidasi mengalami <span class="font-bold text-slate-900">{{ count($riwayat->gejala_terpilih) }}</span> gejala.
                    </p>
                </div>
            </div>

            @if($riwayat->persentase < 100)
            <div class="bg-amber-50/70 border border-amber-200 rounded-2xl p-4 flex items-start space-x-3">
                <i class="fa-solid fa-triangle-exclamation text-amber-500 mt-0.5 text-base flex-shrink-0"></i>
                <div>
                    <h4 class="text-amber-900 text-sm font-bold">Hasil Bersifat Indikasi Awal ({{ round($riwayat->persentase) }}%)</h4>
                    <p class="text-amber-700/90 text-xs mt-0.5 leading-relaxed font-medium">
                        Gejala yang dipilih belum memenuhi seluruh syarat mutlak *rule* utama. Untuk hasil penegakan diagnosis psikologis yang komprehensif, disarankan berkonsultasi langsung dengan konselor atau psikolog.
                    </p>
                </div>
            </div>
            @endif

            <div class="border-b border-slate-100 pb-6">
                <h3 class="font-extrabold text-slate-900 text-base mb-3 flex items-center tracking-tight">
                    <span class="w-1.5 h-4 bg-indigo-600 rounded-full mr-2.5"></span>
                    Deskripsi Kondisi
                </h3>
                <p class="text-slate-600 text-sm leading-relaxed font-medium pl-4">
                    {{ $riwayat->tingkatKecanduan->deskripsi }}
                </p>
            </div>

            <div class="bg-indigo-50/50 border border-indigo-100 rounded-2xl p-5 sm:p-6 relative overflow-hidden">
                <div class="absolute -right-6 -bottom-6 text-indigo-100/40 pointer-events-none transform -rotate-12">
                    <i class="fa-solid fa-lightbulb text-8xl"></i>
                </div>
                
                <h3 class="font-extrabold text-slate-950 text-base mb-3 flex items-center tracking-tight relative z-10">
                    <i class="fa-solid fa-lightbulb text-amber-500 mr-2"></i>
                    Rekomendasi Tindakan & Solusi
                </h3>
                <div class="text-slate-700 whitespace-pre-line text-sm leading-relaxed font-medium pl-6 relative z-10">
                    {!! nl2br(e($riwayat->tingkatKecanduan->solusi)) !!}
                </div>
            </div>

            <div>
                <h3 class="font-extrabold text-slate-900 text-base mb-3 flex items-center tracking-tight">
                    <span class="w-1.5 h-4 bg-emerald-500 rounded-full mr-2.5"></span>
                    Gejala Terkonfirmasi Anda
                </h3>
                <div class="flex flex-wrap gap-2 pl-4">
                    @foreach($gejalaDipilih as $g)
                    <span class="inline-flex items-center bg-slate-50 border border-slate-200 text-slate-700 px-3 py-1.5 rounded-xl text-xs font-mono font-bold shadow-sm group hover:border-slate-300 transition-colors">
                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 mr-2"></span>
                        {{ $g->kode }}
                    </span>
                    @endforeach
                </div>
            </div>

            <div>
                <h3 class="font-extrabold text-slate-900 text-base mb-3 flex items-center tracking-tight">
                    <span class="w-1.5 h-4 bg-purple-600 rounded-full mr-2.5"></span>
                    Detail Komparasi Kecocokan Sistem
                </h3>
                <div class="border border-slate-200/60 rounded-2xl overflow-hidden mx-0 sm:mx-4">
                    <div class="overflow-x-auto">
                        <table class="w-full text-sm text-left">
                            <thead class="bg-slate-50/70 border-b border-slate-200/60 text-slate-700 text-xs font-bold uppercase tracking-wider">
                                <tr>
                                    <th class="px-5 py-3.5">Matriks Tingkat</th>
                                    <th class="px-5 py-3.5 text-center">Kesesuaian</th>
                                    <th class="px-5 py-3.5 text-center">Total Indikator</th>
                                    <th class="px-5 py-3.5 text-right">Persentase</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100 text-slate-600 font-medium">
                                @foreach($semuaHasil as $hasil)
                                <tr class="hover:bg-slate-50/40 transition-colors">
                                    <td class="px-5 py-3.5 font-bold
                                        @if($hasil['kode'] == 'T01') text-emerald-600
                                        @elseif($hasil['kode'] == 'T02') text-amber-600
                                        @else text-rose-600
                                        @endif">
                                        {{ $hasil['nama'] }}
                                    </td>
                                    <td class="px-5 py-3.5 text-center text-slate-800 font-semibold">{{ $hasil['total_cocok'] }}</td>
                                    <td class="px-5 py-3.5 text-center text-slate-400">{{ $hasil['total_dibutuhkan'] }}</td>
                                    <td class="px-5 py-3.5 text-right font-black text-slate-900">{{ round($hasil['persentase']) }}%</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="p-3.5 bg-slate-50 border border-slate-200 rounded-xl text-[11px] text-slate-400 text-center font-medium leading-relaxed">
                <i class="fa-solid fa-shield-halved mr-1 text-slate-300"></i>
                Informasi di atas merupakan kalkulasi inferensi sistem pakar biner otomatis. Bukan rujukan berkekuatan hukum klinis medis.
            </div>

            <div class="flex flex-col sm:flex-row justify-center items-center gap-3 mt-8 print:hidden">
                <a href="{{ route('diagnosis.index') }}" 
                   class="w-full sm:w-auto text-center bg-indigo-600 hover:bg-indigo-700 text-white px-6 py-3 rounded-xl font-bold text-sm shadow-md shadow-indigo-600/15 active:scale-[0.98] transition-all flex items-center justify-center space-x-2">
                    <i class="fa-solid fa-repeat text-indigo-200"></i>
                    <span>Mulai Diagnosis Ulang</span>
                </a>
                
                <a href="{{ route('diagnosis.download-pdf', $riwayat->id) }}" target="_blank" class="w-full sm:w-auto text-center bg-slate-100 hover:bg-slate-200 text-slate-700 px-6 py-3 rounded-xl font-bold text-sm border border-slate-200 active:scale-[0.98] transition-all flex items-center justify-center space-x-2">
                    <i class="fa-solid fa-file-pdf text-rose-500"></i>
                    <span>Unduh Dokumen PDF</span>
                </a>
            </div>
            
        </div>
    </div>
</div>

<style media="print">
    body { background: white !important; color: black !important; }
    
    * {
        -webkit-print-color-adjust: exact !important;
        print-color-adjust: exact !important;
    }
    
    .print\:hidden { display: none !important; }
    .print\:shadow-none { box-shadow: none !important; }
    .print\:border-none { border: none !important; }
    .print\:py-0 { padding-top: 0 !important; padding-bottom: 0 !important; }
    .print\:px-0 { padding-left: 0 !important; padding-right: 0 !important; }
</style>

@endsection