<!DOCTYPE html>
<html lang="id">
<head>
    {!! getFavicon() !!}
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>SMed Checker - @yield('title', 'Sistem Pakar Diagnosis Kecanduan Media Sosial')</title>
    
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <style>
        * {
            font-family: 'Inter', sans-serif;
        }
        
        body.menu-open {
            overflow: hidden;
        }
    </style>
    
    @stack('styles')
</head>
<body>

    <nav class="bg-white shadow-md sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <a href="{{ route('landing') }}" class="flex items-center space-x-2 shrink-0">
                    <div class="bg-gradient-to-r from-indigo-600 to-purple-600 rounded-lg w-8 h-8 flex items-center justify-center shadow-md">
                        <i class="fa-regular fa-message text-white text-sm"></i>
                    </div>
                    <span class="font-bold text-xl text-gray-800">SMed<span class="text-indigo-600">Checker</span></span>
                </a>
                
                <div class="hidden md:flex items-center space-x-4">
                    @yield('nav-links')
                </div>
                
                <button id="mobileMenuBtn" class="md:hidden text-gray-600 hover:text-indigo-600 focus:outline-none">
                    <i id="menuIcon" class="fa-solid fa-bars text-2xl"></i>
                </button>
            </div>
        </div>
        
        <div id="mobileMenu" class="hidden md:hidden bg-white border-t border-gray-100 shadow-lg">
            <div class="flex flex-col space-y-3 p-4">
                @yield('nav-links')
            </div>
        </div>
    </nav>

    <main class="min-h-screen">
        @if(session('success'))
            <div class="max-w-7xl mx-auto px-4 pt-4">
                <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-3 rounded text-sm">
                    <i class="fa-solid fa-check-circle mr-2"></i> {{ session('success') }}
                </div>
            </div>
        @endif

        @if(session('error'))
            <div class="max-w-7xl mx-auto px-4 pt-4">
                <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-3 rounded text-sm">
                    <i class="fa-solid fa-exclamation-triangle mr-2"></i> {{ session('error') }}
                </div>
            </div>
        @endif

        @yield('content')
    </main>

    <footer class="bg-gray-900 text-white mt-16">
        <div class="max-w-7xl mx-auto px-4 py-6 text-center text-sm">
            <p>&copy; {{ date('Y') }} SMed Checker - Sistem Pakar Diagnosis Kecanduan Media Sosial</p>
            <p class="text-gray-400 mt-1">Kelompok 2 - Metode Forward Chaining</p>
        </div>
    </footer>

    <script>
        const mobileBtn = document.getElementById('mobileMenuBtn');
        const mobileMenu = document.getElementById('mobileMenu');
        const menuIcon = document.getElementById('menuIcon');
        
        mobileBtn.addEventListener('click', function() {
            if (mobileMenu.classList.contains('hidden')) {
                mobileMenu.classList.remove('hidden');
                menuIcon.classList.remove('fa-bars');
                menuIcon.classList.add('fa-times');
                document.body.classList.add('menu-open');
            } else {
                mobileMenu.classList.add('hidden');
                menuIcon.classList.remove('fa-times');
                menuIcon.classList.add('fa-bars');
                document.body.classList.remove('menu-open');
            }
        });
        
        document.querySelectorAll('#mobileMenu a').forEach(link => {
            link.addEventListener('click', () => {
                mobileMenu.classList.add('hidden');
                menuIcon.classList.remove('fa-times');
                menuIcon.classList.add('fa-bars');
                document.body.classList.remove('menu-open');
            });
        });
    </script>
    
    @stack('scripts')
</body>
</html>