<!DOCTYPE html>
<html lang="id" class="h-full">
<head>
    {!! getFavicon() !!}
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SMed Checker - Admin @yield('title')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        * { font-family: 'Inter', sans-serif; }

        #sidebar-toggle { display: none; }
        @media (max-width: 767px) {
            #sidebar-target {
                transform: translateX(-100%);
                transition: transform 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            }
            #sidebar-toggle:checked ~ div #sidebar-target {
                transform: translateX(0);
            }
            #sidebar-toggle:checked ~ div #sidebar-overlay {
                opacity: 1;
                pointer-events: auto;
            }
        }
    </style>
    @stack('styles')
</head>
<body class="bg-slate-50 text-slate-800 h-full antialiased">

    <input type="checkbox" id="sidebar-toggle" class="peer">

    <div class="flex h-full overflow-hidden relative">
        
        <div id="sidebar-overlay" class="fixed inset-0 bg-slate-900/40 opacity-0 pointer-events-none transition-opacity duration-300 z-30 md:hidden">
            <label for="sidebar-toggle" class="absolute inset-0 cursor-pointer"></label>
        </div>
        
        <aside id="sidebar-target" class="fixed inset-y-0 left-0 w-64 bg-white border-r border-slate-200/80 flex flex-col z-40 md:static md:translate-x-0 flex-shrink-0">
 
            <div class="p-5 border-b border-slate-100 flex items-center justify-between">
                <div class="flex items-center space-x-2.5">
                    <div class="bg-gradient-to-br from-indigo-500 to-purple-600 rounded-xl w-9 h-9 flex items-center justify-center shadow-md shadow-indigo-500/10">
                        <i class="fa-solid fa-brain text-white text-sm"></i>
                    </div>
                    <div>
                        <span class="font-black text-lg text-slate-900 tracking-tight block leading-none">SMed<span class="text-indigo-600">Checker</span></span>
                        <span class="text-[10px] text-slate-400 font-bold uppercase tracking-wider mt-0.5 block">Admin Panel</span>
                    </div>
                </div>
                <label for="sidebar-toggle" class="p-1 text-slate-400 hover:text-slate-600 cursor-pointer md:hidden">
                    <i class="fa-solid fa-xmark text-lg"></i>
                </label>
            </div>
            
            <nav class="flex-1 p-4 space-y-1.5 overflow-y-auto">
                <a href="{{ route('admin.dashboard') }}" 
                   class="flex items-center space-x-3 px-3.5 py-2.5 rounded-xl text-sm font-semibold transition-all duration-200 group
                    {{ request()->routeIs('admin.dashboard') ? 'bg-indigo-600 text-white shadow-md shadow-indigo-600/10' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }}">
                    <i class="fa-solid fa-gauge-high text-base w-5 transition-colors {{ request()->routeIs('admin.dashboard') ? 'text-white' : 'text-slate-400 group-hover:text-indigo-500' }}"></i>
                    <span>Dashboard</span>
                </a>

                <a href="{{ route('admin.history') }}" 
                   class="flex items-center space-x-3 px-3.5 py-2.5 rounded-xl text-sm font-semibold transition-all duration-200 group
                    {{ request()->routeIs('admin.history') ? 'bg-indigo-600 text-white shadow-md shadow-indigo-600/10' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }}">
                    <i class="fa-solid fa-clock-rotate-left text-base w-5 transition-colors {{ request()->routeIs('admin.history') ? 'text-white' : 'text-slate-400 group-hover:text-indigo-500' }}"></i>
                    <span>Riwayat Diagnosis</span>
                </a>

            </nav>
            
            <div class="p-4 border-t border-slate-100 bg-slate-50/50">
                <div class="flex items-center space-x-3 mb-4 p-1.5">
                    <div class="bg-gradient-to-br from-indigo-100 to-slate-100 border border-indigo-200 rounded-xl w-9 h-9 flex items-center justify-center flex-shrink-0">
                        <i class="fa-solid fa-user-shield text-indigo-600 text-sm"></i>
                    </div>
                    <div class="truncate">
                        <p class="text-xs font-bold text-slate-800 truncate leading-tight">{{ Auth::user()->name }}</p>
                        <p class="text-[10px] font-medium text-slate-400 tracking-wide mt-0.5">{{ Auth::user()->role }}</p>
                    </div>
                </div>
                
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="w-full flex items-center justify-center space-x-2 px-3 py-2.5 rounded-xl text-xs font-bold text-rose-600 bg-white border border-rose-100 hover:bg-rose-50 hover:border-rose-200 active:scale-[0.98] transition-all shadow-sm">
                        <i class="fa-solid fa-arrow-right-from-bracket"></i>
                        <span>Keluar Panel</span>
                    </button>
                </form>
            </div>
        </aside>

        <div class="flex-1 flex flex-col min-w-0 overflow-hidden">
            
            <header class="bg-white border-b border-slate-200/80 h-16 flex items-center justify-between px-4 sm:px-6 z-10 flex-shrink-0">
                <div class="flex items-center space-x-3">
                    <label for="sidebar-toggle" class="p-2 -ml-2 rounded-xl text-slate-500 hover:bg-slate-100 hover:text-slate-700 cursor-pointer md:hidden transition-colors">
                        <i class="fa-solid fa-bars-staggered text-lg"></i>
                    </label>
                    <h2 class="text-sm sm:text-base font-bold text-slate-800 tracking-tight">@yield('title', 'Overview')</h2>
                </div>
                <div class="text-[11px] sm:text-xs font-medium text-slate-500 bg-slate-50 border border-slate-200/60 rounded-xl px-2.5 py-1.5 shadow-sm">
                    <i class="fa-regular fa-calendar-days mr-1.5 text-indigo-500"></i>{{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}
                </div>
            </header>

            <main class="flex-1 overflow-y-auto p-4 sm:p-6 lg:p-8">
                
                @if(session('success'))
                <div class="max-w-4xl bg-emerald-50 border border-emerald-200 text-emerald-800 p-4 rounded-2xl mb-6 shadow-sm flex items-start space-x-3 animate-fade-in">
                    <i class="fa-solid fa-circle-check text-emerald-500 mt-0.5 text-base flex-shrink-0"></i>
                    <div>
                        <p class="text-sm font-bold leading-none">Operasi Sukses</p>
                        <p class="text-xs text-emerald-700/90 mt-1 font-medium">{{ session('success') }}</p>
                    </div>
                </div>
                @endif

                @if(session('error'))
                <div class="max-w-4xl bg-rose-50 border border-rose-200 text-rose-800 p-4 rounded-2xl mb-6 shadow-sm flex items-start space-x-3 animate-fade-in">
                    <i class="fa-solid fa-circle-exclamation text-rose-500 mt-0.5 text-base flex-shrink-0"></i>
                    <div>
                        <p class="text-sm font-bold leading-none">Terjadi Kendala</p>
                        <p class="text-xs text-rose-700/90 mt-1 font-medium">{{ session('error') }}</p>
                    </div>
                </div>
                @endif

                <div class="max-w-7xl">
                    @yield('content')
                </div>
                
            </main>
        </div>
    </div>

    @stack('scripts')
</body>
</html>