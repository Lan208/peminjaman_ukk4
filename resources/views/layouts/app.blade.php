<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perpustakaan Laut</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:opsz,wght@14..32,300;14..32,400;14..32,500;14..32,600;14..32,700&display=swap');
        
        * {
            font-family: 'Inter', sans-serif;
        }
        
        /* Custom scrollbar */
        ::-webkit-scrollbar {
            width: 6px;
        }
        
        ::-webkit-scrollbar-track {
            background: rgba(255,255,255,0.1);
        }
        
        ::-webkit-scrollbar-thumb {
            background: rgba(6, 182, 212, 0.5);
            border-radius: 10px;
        }
        
        ::-webkit-scrollbar-thumb:hover {
            background: rgba(6, 182, 212, 0.8);
        }
    </style>
</head>

<body class="bg-gradient-to-br from-slate-900 via-blue-900 to-cyan-900 min-h-screen">

    <!-- 🌊 NAVBAR MODERN -->
    <nav class="sticky top-0 z-50 bg-white/10 backdrop-blur-xl border-b border-white/20 shadow-2xl">
        <div class="flex justify-between items-center px-8 py-4">
            
            {{-- LOGO --}}
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 bg-gradient-to-br from-cyan-400 to-blue-500 rounded-xl flex items-center justify-center shadow-lg">
                    <i class="fas fa-book-open text-white text-lg"></i>
                </div>
                <div>
                    <h1 class="text-xl font-bold text-white tracking-wide">
                        Perpustakaan Laut
                    </h1>
                    <p class="text-xs text-cyan-200">Samudra Ilmu Pengetahuan</p>
                </div>
            </div>

            {{-- RIGHT SECTION --}}
            <div class="flex items-center gap-4">
                
                {{-- USER INFO --}}
                <div class="hidden md:flex items-center gap-3 bg-white/10 rounded-full px-4 py-2 backdrop-blur-sm">
                    <div class="w-8 h-8 bg-gradient-to-r from-cyan-400 to-blue-500 rounded-full flex items-center justify-center">
                        <i class="fas fa-user text-white text-sm"></i>
                    </div>
                    <span class="text-white text-sm font-medium">
                        {{ Auth::user()->name }}
                    </span>
                </div>

                {{-- LOGOUT BUTTON --}}
                <form method="POST" action="/logout">
                    @csrf
                    <button class="flex items-center gap-2 bg-red-500/20 hover:bg-red-500/30 backdrop-blur-sm 
                                   text-white px-5 py-2 rounded-xl text-sm font-medium 
                                   transition-all duration-300 hover:scale-105 border border-red-400/30">
                        <i class="fas fa-sign-out-alt"></i>
                        <span class="hidden sm:inline">Logout</span>
                    </button>
                </form>

            </div>

        </div>
        
        {{-- DECORATIVE WAVE --}}
        <div class="h-0.5 bg-gradient-to-r from-cyan-400 via-blue-400 to-cyan-400"></div>
    </nav>

    {{-- NOTIFICATION --}}
    @if(session('success'))
        <div class="fixed top-20 right-6 z-50 animate-slide-down">
            <div class="bg-gradient-to-r from-green-500 to-emerald-600 text-white px-6 py-3 rounded-xl shadow-2xl flex items-center gap-3">
                <i class="fas fa-check-circle text-xl"></i>
                <span>{{ session('success') }}</span>
            </div>
        </div>
    @endif

    @if(session('error'))
        <div class="fixed top-20 right-6 z-50 animate-slide-down">
            <div class="bg-gradient-to-r from-red-500 to-rose-600 text-white px-6 py-3 rounded-xl shadow-2xl flex items-center gap-3">
                <i class="fas fa-exclamation-circle text-xl"></i>
                <span>{{ session('error') }}</span>
            </div>
        </div>
    @endif

    {{-- MAIN LAYOUT --}}
    <div class="flex">
        {{-- SIDEBAR --}}
        @include('layouts.sidebar')

        {{-- CONTENT --}}
        <main class="flex-1 p-8 overflow-y-auto h-[calc(100vh-73px)]">
            <div class="animate-fade-in">
                @yield('content')
            </div>
        </main>
    </div>

    <style>
        @keyframes slide-down {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        @keyframes fade-in {
            from {
                opacity: 0;
                transform: translateY(10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        .animate-slide-down {
            animation: slide-down 0.3s ease-out;
        }
        
        .animate-fade-in {
            animation: fade-in 0.4s ease-out;
        }
    </style>

</body>

</html>