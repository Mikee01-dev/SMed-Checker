<!DOCTYPE html>
<html lang="id">
<head>
    {!! getFavicon() !!}
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    
    <title>SMed Checker - Login Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        * { font-family: 'Plus Jakarta Sans', sans-serif; }
    </style>
</head>
<body class="bg-slate-50 min-h-screen flex items-center justify-center p-4 sm:p-6 md:p-10 overflow-x-hidden relative">

    <div class="absolute top-0 right-0 w-[300px] sm:w-[500px] h-[300px] sm:h-[500px] bg-indigo-100/40 rounded-full blur-[80px] sm:blur-[120px] pointer-events-none"></div>
    <div class="absolute bottom-0 left-0 w-[250px] sm:w-[400px] h-[250px] sm:h-[400px] bg-purple-100/40 rounded-full blur-[70px] sm:blur-[100px] pointer-events-none"></div>

    <div class="w-full max-w-md relative z-10 mx-auto">
        
        <div class="bg-white/80 backdrop-blur-md border border-slate-200/60 rounded-3xl p-6 sm:p-8 shadow-[0_20px_40px_-15px_rgba(99,102,241,0.1)]">
            
            <div class="flex items-center space-x-3 mb-8">
                <div class="w-10 h-10 rounded-xl bg-gradient-to-tr from-indigo-600 to-purple-600 flex items-center justify-center shadow-lg shadow-indigo-600/20 flex-shrink-0">
                    <i class="fa-solid fa-brain text-white text-lg"></i>
                </div>
                <div>
                    <h1 class="text-slate-900 text-xl font-bold tracking-tight">
                        SMed <span class="text-indigo-600">Checker</span>
                    </h1>
                    <p class="text-slate-500 text-xs tracking-wide font-medium">Sistem Pakar / Panel Admin</p>
                </div>
            </div>

            <div class="mb-6">
                <h2 class="text-slate-900 text-xl sm:text-2xl font-extrabold tracking-tight">Selamat Datang Kembali</h2>
                <p class="text-slate-500 text-xs sm:text-sm mt-1">Silakan masuk untuk mengelola data gejala dan rules.</p>
            </div>

            @if($errors->any())
                <div class="bg-rose-50 border border-rose-200 rounded-xl p-4 mb-6">
                    <div class="flex items-start space-x-3">
                        <i class="fa-solid fa-circle-exclamation text-rose-500 mt-0.5 text-sm flex-shrink-0"></i>
                        <div>
                            <h4 class="text-rose-800 text-sm font-bold">Otentikasi Gagal</h4>
                            <p class="text-rose-600 text-xs mt-0.5 leading-relaxed">Email atau password salah. Silakan coba lagi.</p>
                        </div>
                    </div>
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}" class="space-y-5">
                @csrf

                <div>
                    <label class="block text-slate-700 text-xs font-bold uppercase tracking-wider mb-2">Alamat Email</label>
                    <div class="relative group">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-4 text-slate-400 group-focus-within:text-indigo-600 transition-colors">
                            <i class="fa-regular fa-envelope text-sm"></i>
                        </span>
                        <input type="email" name="email" value="{{ old('email') }}" required autofocus
                               class="w-full pl-11 pr-4 py-3.5 bg-slate-50 border border-slate-200 rounded-xl text-slate-800 placeholder-slate-400 text-sm focus:outline-none focus:border-indigo-600 focus:ring-2 focus:ring-indigo-500/10 focus:bg-white transition-all duration-200 font-medium"
                               placeholder="nama@email.com">
                    </div>
                </div>

                <div>
                    <label class="block text-slate-700 text-xs font-bold uppercase tracking-wider mb-2">Kata Sandi</label>
                    <div class="relative group">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-4 text-slate-400 group-focus-within:text-indigo-600 transition-colors">
                            <i class="fa-solid fa-lock text-sm"></i>
                        </span>
                        <input type="password" name="password" required
                               class="w-full pl-11 pr-4 py-3.5 bg-slate-50 border border-slate-200 rounded-xl text-slate-800 placeholder-slate-400 text-sm focus:outline-none focus:border-indigo-600 focus:ring-2 focus:ring-indigo-500/10 focus:bg-white transition-all duration-200 font-medium"
                               placeholder="••••••••">
                    </div>
                </div>

                <button type="submit" 
                        class="w-full bg-gradient-to-r from-indigo-600 to-purple-600 text-white font-bold py-3.5 px-4 rounded-xl hover:shadow-lg hover:shadow-indigo-600/20 active:scale-[0.99] transition-all duration-200 text-sm flex items-center justify-center space-x-2 mt-2">
                    <span>Masuk ke Dashboard</span>
                    <i class="fa-solid fa-arrow-right text-xs"></i>
                </button>
            </form>

            <div class="relative my-6">
                <div class="absolute inset-0 flex items-center"><div class="w-full border-t border-slate-200/80"></div></div>
                <div class="relative flex justify-center text-xs uppercase"><span class="px-3 bg-white text-slate-400 font-bold tracking-widest text-[10px] sm:text-xs">Akses Kredensial</span></div>
            </div>

            <div class="mt-6 text-center">
                <a href="{{ route('landing') }}" class="inline-flex items-center space-x-2 text-xs font-bold text-slate-400 hover:text-indigo-600 uppercase tracking-wider transition-colors duration-200 group">
                    <i class="fa-solid fa-arrow-left group-hover:-translate-x-0.5 transition-transform"></i>
                    <span>Kembali ke Beranda Utama</span>
                </a>
            </div>

        </div>

        <p class="text-center mt-6 text-slate-400 text-xs font-medium">
            &copy; {{ date('Y') }} SMed Checker. All rights reserved.
        </p>
    </div>

</body>
</html>