@extends('layouts.master')

@section('title', 'Form Diagnosis')

@section('nav-links')
    <a href="{{ route('diagnosis.about') }}" class="block md:inline-block px-5 py-2.5 text-center text-sm font-semibold text-white bg-indigo-600 rounded-xl hover:bg-indigo-700 shadow-sm hover:shadow-indigo-200 hover:shadow-lg transition-all duration-300">
        <i class="fa-solid fa-info-circle mr-1"></i> Tentang
    </a>
@endsection

@section('content')
<div class="max-w-4xl mx-auto px-4 py-8 sm:py-12 relative z-10">
    
    <div class="bg-white border border-slate-200/60 rounded-3xl p-6 sm:p-8 mb-6 text-center shadow-[0_15px_30px_-15px_rgba(99,102,241,0.05)] relative overflow-hidden">
        <div class="absolute inset-0 bg-[radial-gradient(circle_at_top_right,rgba(99,102,241,0.03),transparent_45%)]"></div>
        
        <div class="bg-indigo-50 rounded-2xl w-14 h-14 flex items-center justify-center mx-auto mb-4 border border-indigo-100">
            <i class="fa-solid fa-notes-medical text-indigo-600 text-xl"></i>
        </div>
        <h1 class="text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight">Form Diagnosis</h1>
        <p class="text-slate-500 text-sm max-w-xl mx-auto mt-2 leading-relaxed">
            Pilih gejala yang Anda rasakan secara jujur untuk mendeteksi tingkat kecanduan media sosial secara akurat.
        </p>
    </div>

    <div class="bg-white border border-slate-200/60 rounded-3xl shadow-[0_20px_40px_-15px_rgba(99,102,241,0.08)] overflow-hidden">
        <form action="{{ route('diagnosis.process') }}" method="POST">
            @csrf

            <div class="p-6 sm:p-8 border-b border-slate-100 bg-slate-50/50">
                <label class="block text-slate-700 text-xs font-bold uppercase tracking-wider mb-2">
                    Nama Pasien (Opsional)
                </label>
                <div class="relative group max-w-md">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-4 text-slate-400 group-focus-within:text-indigo-600 transition-colors">
                        <i class="fa-regular fa-user text-sm"></i>
                    </span>
                    <input type="text" name="nama" value="{{ old('nama') }}" 
                           class="w-full pl-11 pr-4 py-3 bg-white border border-slate-200 rounded-xl text-slate-800 placeholder-slate-400 text-sm focus:outline-none focus:border-indigo-600 focus:ring-2 focus:ring-indigo-500/10 transition-all duration-200 font-medium"
                           placeholder="Masukkan nama Anda (Bisa dikosongkan)">
                </div>
                <p class="text-xs text-slate-400 mt-2 flex items-center">
                    <i class="fa-solid fa-circle-info mr-1 text-slate-300"></i> Isi jika Anda ingin nama Anda tercetak di lembar hasil riwayat.
                </p>
            </div>

            <div class="p-6 sm:p-8">
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-4 gap-1">
                    <label class="block text-slate-800 text-sm font-extrabold tracking-tight">
                        <i class="fa-solid fa-list-check mr-1.5 text-indigo-500"></i> Daftar Gejala yang Tersedia
                    </label>
                    <span class="text-xs text-slate-400 font-medium">Scroll ke bawah untuk melihat semua opsi</span>
                </div>
                
                <div class="space-y-3 max-h-[420px] overflow-y-auto pr-2 scrollbar-thin scrollbar-thumb-slate-200 scrollbar-track-transparent">
                    @foreach($gejala as $item)
                    <label class="group flex items-start p-4 border border-slate-100 hover:border-indigo-200 rounded-2xl cursor-pointer hover:bg-indigo-50/30 transition-all duration-200 relative">
                        
                        <div class="flex items-center h-5 mt-0.5">
                            <input type="checkbox" name="gejala[]" value="{{ $item->id }}" 
                                   class="w-5 h-5 text-indigo-600 border-slate-200 rounded-lg focus:ring-indigo-500/20 focus:ring-offset-0 focus:ring-2 cursor-pointer transition-all">
                        </div>
                        
                        <div class="ml-4 pr-2">
                            <div class="flex items-center space-x-2">
                                <span class="text-[11px] font-mono font-bold text-indigo-600 bg-indigo-50 border border-indigo-100 px-2 py-0.5 rounded-md">
                                    {{ $item->kode }}
                                </span>
                            </div>
                            <p class="text-slate-700 text-sm font-medium mt-1.5 leading-relaxed group-hover:text-slate-900 transition-colors">
                                {{ $item->deskripsi }}
                            </p>
                        </div>
                    </label>
                    @endforeach
                </div>
            </div>

            <div class="p-6 sm:p-8 border-t border-slate-100 bg-slate-50/40 flex justify-center">
                <button type="submit" class="group w-full sm:w-auto bg-gradient-to-r from-indigo-600 to-purple-600 text-white px-10 py-4 rounded-xl font-bold hover:shadow-xl hover:shadow-indigo-600/20 active:scale-[0.99] transition-all duration-200 text-sm flex items-center justify-center space-x-2.5">
                    <i class="fa-solid fa-microscope text-indigo-200 group-hover:scale-110 transition-transform"></i>
                    <span>Proses Diagnosis Sekarang</span>
                    <i class="fa-solid fa-arrow-right text-xs opacity-70 group-hover:translate-x-0.5 transition-transform"></i>
                </button>
            </div>
        </form>
    </div>
</div>

<style>
    .max-h-\[420px\]::-webkit-scrollbar {
        width: 6px;
    }
    .max-h-\[420px\]::-webkit-scrollbar-track {
        background: transparent;
    }
    .max-h-\[420px\]::-webkit-scrollbar-thumb {
        background-color: rgb(226, 232, 240);
        border-radius: 20px;
    }
    .max-h-\[420px\]::-webkit-scrollbar-thumb:hover {
        background-color: rgb(203, 213, 225);
    }
</style>
@endsection