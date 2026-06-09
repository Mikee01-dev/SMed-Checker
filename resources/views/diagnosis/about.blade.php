@extends('layouts.master')

@section('title', 'Tentang SMed Checker')

@section('nav-links')
    <a href="{{ route('diagnosis.index') }}" class="block md:inline-block px-5 py-2.5 text-center text-sm font-semibold text-white bg-indigo-600 rounded-xl hover:bg-indigo-700 shadow-sm hover:shadow-indigo-200 hover:shadow-lg transition-all duration-300">
        <i class="fa-solid fa-stethoscope mr-1.5 animate-pulse"></i> Diagnosis
    </a>
@endsection

@section('content')
<div class="max-w-4xl mx-auto px-4 py-6 sm:py-10 space-y-8 relative z-10">
    
    <div class="bg-white border border-slate-200/70 rounded-3xl shadow-[0_20px_50px_-20px_rgba(99,102,241,0.05)] overflow-hidden">
        <div class="p-6 sm:p-8 flex flex-col sm:flex-row items-center gap-6">
            <div class="w-16 h-16 bg-gradient-to-br from-indigo-500 to-purple-600 rounded-2xl flex items-center justify-center flex-shrink-0 shadow-md shadow-indigo-500/20">
                <i class="fa-solid fa-circle-info text-white text-3xl"></i>
            </div>
            <div>
                <h1 class="text-2xl sm:text-3xl font-black text-slate-900 tracking-tight">Tentang SMed Checker</h1>
                <p class="text-slate-600 text-sm sm:text-base mt-1 leading-relaxed font-medium">
                    SMed Checker adalah sistem pakar diagnosis kecanduan media sosial berbasis web 
                    yang mengadopsi metode logika <span class="text-indigo-600 font-bold bg-indigo-50 px-2 py-0.5 rounded-lg border border-indigo-100">Forward Chaining</span> untuk menarik kesimpulan berdasarkan indikasi gejala perilaku Anda.
                </p>
            </div>
        </div>
    </div>

    <div class="bg-white border border-slate-200/70 rounded-3xl shadow-[0_20px_50px_-20px_rgba(99,102,241,0.05)] p-6 sm:p-8">
        <h2 class="text-lg font-extrabold text-slate-900 mb-6 flex items-center tracking-tight">
            <span class="w-1.5 h-4 bg-indigo-600 rounded-full mr-2.5"></span>
            Jenis Perilaku Kecanduan Media Sosial
        </h2>
        
        <div class="divide-y divide-slate-100">
            @foreach($jenisPerilaku as $jp)
            <div class="py-4 first:pt-0 last:pb-0 group">
                <div class="flex items-center gap-3 mb-1.5">
                    <span class="bg-slate-50 border border-slate-200 text-slate-700 px-2.5 py-1 rounded-xl text-xs font-mono font-bold shadow-sm group-hover:border-indigo-200 group-hover:bg-indigo-50/50 transition-colors">
                        {{ $jp->kode }}
                    </span>
                    <h3 class="font-bold text-slate-800 group-hover:text-indigo-600 transition-colors tracking-tight text-sm sm:text-base">
                        {{ $jp->nama }}
                    </h3>
                </div>
                <p class="text-slate-600 text-sm leading-relaxed font-medium pl-2 sm:pl-4 border-l-2 border-transparent group-hover:border-slate-200 transition-colors">
                    {{ $jp->deskripsi }}
                </p>
            </div>
            @endforeach
        </div>
    </div>

    <div class="bg-white border border-slate-200/70 rounded-3xl shadow-[0_20px_50px_-20px_rgba(99,102,241,0.05)] p-6 sm:p-8">
        <h2 class="text-lg font-extrabold text-slate-900 mb-6 flex items-center tracking-tight">
            <span class="w-1.5 h-4 bg-emerald-500 rounded-full mr-2.5"></span>
            Tingkat Kecanduan Analisis Pakar
        </h2>
        
        <div class="grid md:grid-cols-3 gap-5">
            @foreach($tingkatKecanduan as $tk)
            <div class="border rounded-2xl p-5 text-center flex flex-col items-center justify-start transition-all duration-300 hover:shadow-md
                @if($tk->kode == 'T01') border-emerald-100 bg-emerald-50/40 hover:border-emerald-200
                @elseif($tk->kode == 'T02') border-amber-100 bg-amber-50/40 hover:border-amber-200
                @else border-rose-100 bg-rose-50/40 hover:border-rose-200
                @endif">
                
                <div class="w-12 h-12 rounded-xl flex items-center justify-center mb-4 shadow-sm
                    @if($tk->kode == 'T01') bg-gradient-to-br from-emerald-400 to-teal-500 text-white
                    @elseif($tk->kode == 'T02') bg-gradient-to-br from-amber-400 to-orange-500 text-white
                    @else bg-gradient-to-br from-rose-400 to-red-500 text-white
                    @endif">
                    @if($tk->kode == 'T01')
                        <i class="fa-solid fa-face-smile text-xl"></i>
                    @elseif($tk->kode == 'T02')
                        <i class="fa-solid fa-face-meh text-xl"></i>
                    @else
                        <i class="fa-solid fa-triangle-exclamation text-xl"></i>
                    @endif
                </div>
                
                <h3 class="font-extrabold tracking-tight text-sm sm:text-base
                    @if($tk->kode == 'T01') text-emerald-800
                    @elseif($tk->kode == 'T02') text-amber-800
                    @else text-rose-800
                    @endif">
                    {{ $tk->nama }}
                </h3>
                
                <p class="text-xs text-slate-600 mt-2 leading-relaxed font-medium">
                    {{ $tk->deskripsi }}
                </p>
            </div>
            @endforeach
        </div>
    </div>

</div>
@endsection