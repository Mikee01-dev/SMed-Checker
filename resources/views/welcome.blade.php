@extends('layouts.master')

@section('title', 'Home')

@section('nav-links')
    <a href="{{ route('diagnosis.index') }}" class="block md:inline-block px-5 py-2.5 text-center text-sm font-semibold text-white bg-indigo-600 rounded-xl hover:bg-indigo-700 shadow-sm hover:shadow-indigo-200 hover:shadow-lg transition-all duration-300">
        <i class="fa-solid fa-stethoscope mr-1.5 animate-pulse"></i> Diagnosis
    </a>
    <a href="{{ route('diagnosis.about') }}" class="block md:inline-block px-5 py-2.5 text-center text-sm font-semibold text-white bg-indigo-600 rounded-xl hover:bg-indigo-700 shadow-sm hover:shadow-indigo-200 hover:shadow-lg transition-all duration-300">
        <i class="fa-solid fa-info-circle mr-1"></i> Tentang
    </a>
    <a href="{{ route('login') }}" class="block md:inline-block px-5 py-2.5 text-center text-sm font-medium text-gray-600 hover:text-indigo-600 rounded-xl hover:bg-indigo-50/50 transition-all duration-300">
        <i class="fa-solid fa-lock mr-1.5"></i> Admin
    </a>
@endsection

@section('content')
<section class="relative overflow-hidden bg-gradient-to-br from-slate-900 via-indigo-950 to-purple-950 text-white py-20 md:py-32">
    <div class="absolute inset-0 bg-[radial-gradient(circle_at_top_right,rgba(99,102,241,0.15),transparent_45%)]"></div>
    <div class="absolute -top-40 -left-40 w-96 h-96 bg-purple-600/10 rounded-full blur-3xl"></div>
    
    <div class="relative max-w-7xl mx-auto px-6 text-center z-10">
        <div class="inline-flex items-center space-x-2 bg-indigo-500/10 border border-indigo-400/20 backdrop-blur-md rounded-full px-4 py-1.5 mb-8 tracking-wide text-indigo-200">
            <i class="fa-solid fa-brain text-xs text-indigo-400 animate-pulse"></i>
            <span class="text-xs font-semibold uppercase tracking-wider">Sistem Pakar Berbasis AI</span>
        </div>
        
        <h1 class="text-5xl md:text-6xl lg:text-7xl font-black tracking-tight mb-6 leading-none">
            SMed <span class="bg-gradient-to-r from-indigo-400 via-purple-400 to-pink-400 bg-clip-text text-transparent">Checker</span>
        </h1>
        
        <p class="text-xl md:text-2xl font-medium text-indigo-100/90 max-w-3xl mx-auto mb-3">
            Sistem Pakar Diagnosis Kecanduan Media Sosial
        </p>
        
        <p class="text-base md:text-lg text-slate-300 max-w-2xl mx-auto mb-10 leading-relaxed">
            Menggunakan metode <span class="text-white font-semibold underline decoration-indigo-400 decoration-2 underline-offset-4">Forward Chaining</span> untuk mendeteksi tingkat kecanduan media sosial Anda secara akurat.
        </p>
        
        <div class="flex flex-col sm:flex-row justify-center items-center gap-4">
            <a href="{{ route('diagnosis.index') }}" class="group inline-flex items-center justify-center space-x-2.5 bg-white text-indigo-950 px-8 py-4 rounded-xl font-bold hover:bg-indigo-50 shadow-xl shadow-indigo-950/20 hover:shadow-white/10 hover:-translate-y-0.5 transition-all duration-300 w-full sm:w-auto">
                <i class="fa-solid fa-microscope text-indigo-600 group-hover:scale-110 transition-transform"></i>
                <span>Mulai Diagnosis</span>
            </a>
            <a href="#info" class="inline-flex items-center justify-center space-x-2.5 border border-slate-700 bg-slate-900/40 backdrop-blur-sm text-slate-200 px-8 py-4 rounded-xl font-semibold hover:bg-slate-800/60 hover:text-white hover:border-slate-500 transition-all duration-300 w-full sm:w-auto">
                <i class="fa-solid fa-circle-info text-slate-400"></i>
                <span>Pelajari</span>
            </a>
        </div>
    </div>
</section>

<section id="info" class="py-24 bg-slate-50 relative">
    <div class="max-w-7xl mx-auto px-6">
        <div class="text-center mb-16">
            <span class="text-indigo-600 text-xs font-bold uppercase tracking-widest bg-indigo-50 px-3 py-1 rounded-md">Tentang Aplikasi</span>
            <h2 class="text-3xl md:text-4xl font-extrabold text-slate-900 mt-3 tracking-tight">Apa Itu SMed Checker?</h2>
            <div class="w-12 h-1 bg-gradient-to-r from-indigo-600 to-purple-600 mx-auto mt-4 rounded-full"></div>
            <p class="text-slate-600 max-w-2xl mx-auto mt-4 text-base md:text-lg leading-relaxed">
                Sistem pakar berbasis web yang membantu mendiagnosis kecanduan media sosial 
                menggunakan metode Forward Chaining dengan 20 gejala yang sudah terstandar.
            </p>
        </div>

        <div class="grid md:grid-cols-3 gap-8">
            <div class="group bg-white rounded-2xl p-8 border border-slate-100 shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all duration-300">
                <div class="bg-indigo-50 rounded-xl w-14 h-14 flex items-center justify-center mb-6 group-hover:bg-indigo-600 transition-colors duration-300">
                    <i class="fa-solid fa-chart-line text-indigo-600 text-xl group-hover:text-white transition-colors duration-300"></i>
                </div>
                <h3 class="font-bold text-xl text-slate-900 mb-3">Deteksi Dini</h3>
                <p class="text-slate-600 text-sm leading-relaxed">Mendeteksi kecanduan sejak dini dengan 20 gejala yang sudah terstandar secara klinis.</p>
            </div>
            
            <div class="group bg-white rounded-2xl p-8 border border-slate-100 shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all duration-300">
                <div class="bg-indigo-50 rounded-xl w-14 h-14 flex items-center justify-center mb-6 group-hover:bg-indigo-600 transition-colors duration-300">
                    <i class="fa-solid fa-microchip text-indigo-600 text-xl group-hover:text-white transition-colors duration-300"></i>
                </div>
                <h3 class="font-bold text-xl text-slate-900 mb-3">Forward Chaining</h3>
                <p class="text-slate-600 text-sm leading-relaxed">Metode penalaran logis berbasis fakta untuk menghasilkan hasil diagnosis yang runut dan akurat.</p>
            </div>
            
            <div class="group bg-white rounded-2xl p-8 border border-slate-100 shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all duration-300">
                <div class="bg-indigo-50 rounded-xl w-14 h-14 flex items-center justify-center mb-6 group-hover:bg-indigo-600 transition-colors duration-300">
                    <i class="fa-solid fa-hand-holding-heart text-indigo-600 text-xl group-hover:text-white transition-colors duration-300"></i>
                </div>
                <h3 class="font-bold text-xl text-slate-900 mb-3">Solusi & Saran</h3>
                <p class="text-slate-600 text-sm leading-relaxed">Memberikan rekomendasi solusi tindakan dan saran preventif sesuai tingkat kecanduan Anda.</p>
            </div>
        </div>
    </div>
</section>

<section class="py-24 bg-white">
    <div class="max-w-7xl mx-auto px-6">
        <div class="text-center mb-16">
            <span class="text-indigo-600 text-xs font-bold uppercase tracking-widest bg-indigo-50 px-3 py-1 rounded-md">Panduan</span>
            <h2 class="text-3xl md:text-4xl font-extrabold text-slate-900 mt-3 tracking-tight">Cara Menggunakan</h2>
            <div class="w-12 h-1 bg-gradient-to-r from-indigo-600 to-purple-600 mx-auto mt-4 rounded-full"></div>
        </div>

        <div class="grid md:grid-cols-3 gap-8 relative">
            <div class="bg-slate-50 rounded-2xl p-8 text-center relative border border-slate-100 shadow-sm">
                <div class="absolute -top-4 left-1/2 transform -translate-x-1/2 bg-gradient-to-r from-indigo-600 to-indigo-700 text-white w-9 h-9 rounded-full flex items-center justify-center font-bold shadow-md ring-4 ring-white">1</div>
                <div class="mt-4 mb-4 text-indigo-600">
                    <i class="fa-solid fa-list-check text-4xl"></i>
                </div>
                <h3 class="font-bold text-lg text-slate-900 mb-2">Pilih Gejala</h3>
                <p class="text-slate-600 text-sm leading-relaxed">Pilih kondisi atau gejala yang sedang Anda alami dari daftar 20 opsi gejala yang tersedia.</p>
            </div>
            
            <div class="bg-slate-50 rounded-2xl p-8 text-center relative border border-slate-100 shadow-sm">
                <div class="absolute -top-4 left-1/2 transform -translate-x-1/2 bg-gradient-to-r from-indigo-600 to-indigo-700 text-white w-9 h-9 rounded-full flex items-center justify-center font-bold shadow-md ring-4 ring-white">2</div>
                <div class="mt-4 mb-4 text-indigo-600">
                    <i class="fa-solid fa-microscope text-4xl"></i>
                </div>
                <h3 class="font-bold text-lg text-slate-900 mb-2">Proses Diagnosis</h3>
                <p class="text-slate-600 text-sm leading-relaxed">Sistem kecerdasan buatan akan langsung memproses input Anda menggunakan aturan penalaran.</p>
            </div>
            
            <div class="bg-slate-50 rounded-2xl p-8 text-center relative border border-slate-100 shadow-sm">
                <div class="absolute -top-4 left-1/2 transform -translate-x-1/2 bg-gradient-to-r from-indigo-600 to-indigo-700 text-white w-9 h-9 rounded-full flex items-center justify-center font-bold shadow-md ring-4 ring-white">3</div>
                <div class="mt-4 mb-4 text-indigo-600">
                    <i class="fa-solid fa-file-waveform text-4xl"></i>
                </div>
                <h3 class="font-bold text-lg text-slate-900 mb-2">Lihat Hasil</h3>
                <p class="text-slate-600 text-sm leading-relaxed">Dapatkan lembar hasil diagnosis akhir beserta rincian tingkat kecanduan dan saran medisnya.</p>
            </div>
        </div>
    </div>
</section>

<section class="py-12 bg-white">
    <div class="max-w-5xl mx-auto px-6">
        <div class="relative overflow-hidden bg-gradient-to-r from-indigo-600 via-indigo-700 to-purple-700 rounded-3xl p-10 md:p-14 text-center text-white shadow-2xl shadow-indigo-900/20">
            <div class="absolute inset-0 bg-[radial-gradient(circle_at_bottom_left,rgba(255,255,255,0.1),transparent_40%)]"></div>
            
            <div class="relative z-10 max-w-2xl mx-auto">
                <h2 class="text-3xl md:text-4xl font-extrabold mb-4 tracking-tight">Siap Melakukan Diagnosis?</h2>
                <p class="mb-8 text-indigo-100 text-base md:text-lg opacity-90 leading-relaxed">
                    Hanya butuh beberapa menit. Jawab beberapa pertanyaan sederhana secara jujur untuk mendeteksi tingkat kesehatan penggunaan media sosial Anda.
                </p>
                <a href="{{ route('diagnosis.index') }}" class="group inline-flex items-center space-x-2.5 bg-white text-indigo-700 px-8 py-4 rounded-xl font-bold hover:bg-indigo-50 shadow-lg hover:shadow-xl hover:-translate-y-0.5 transition-all duration-300 w-full sm:w-auto justify-center">
                    <i class="fa-solid fa-microscope text-indigo-600"></i>
                    <span>Mulai Diagnosis Sekarang</span>
                    <i class="fa-solid fa-arrow-right text-xs group-hover:translate-x-1 transition-transform"></i>
                </a>
            </div>
        </div>
    </div>
</section>
@endsection