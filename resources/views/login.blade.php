<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
        @keyframes wave {
            0% { transform: translateX(0); }
            100% { transform: translateX(-50%); }
        }
        .wave-animation {
            animation: wave 20s linear infinite;
        }
    </style>
</head>
<body class="relative min-h-screen bg-gradient-to-br from-blue-900 via-blue-800 to-cyan-700 overflow-hidden">
    
    <!-- Background Elements - Lautan -->
    <div class="absolute inset-0 overflow-hidden">
        <!-- Gelombang Latar Belakang -->
        <div class="absolute bottom-0 left-0 w-full">
            <svg class="relative w-full h-48 text-blue-600 opacity-30 wave-animation" viewBox="0 0 1440 320" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M0,192 L48,186.7 C96,181 192,171 288,170.7 C384,171 480,181 576,186.7 C672,192 768,192 864,186.7 C960,181 1056,171 1152,165.3 C1248,160 1344,160 1392,160 L1440,160 L1440,320 L1392,320 C1344,320 1248,320 1152,320 C1056,320 960,320 864,320 C768,320 672,320 576,320 C480,320 384,320 288,320 C192,320 96,320 48,320 L0,320 Z" fill="currentColor" opacity="0.5"/>
            </svg>
        </div>
        <div class="absolute bottom-0 left-0 w-full">
            <svg class="relative w-full h-64 text-cyan-500 opacity-20 wave-animation" style="animation-duration: 15s; animation-direction: reverse;" viewBox="0 0 1440 320" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M0,256 L48,245.3 C96,235 192,213 288,213.3 C384,213 480,235 576,245.3 C672,256 768,256 864,245.3 C960,235 1056,213 1152,202.7 C1248,192 1344,192 1392,192 L1440,192 L1440,320 L1392,320 C1344,320 1248,320 1152,320 C1056,320 960,320 864,320 C768,320 672,320 576,320 C480,320 384,320 288,320 C192,320 96,320 48,320 L0,320 Z" fill="currentColor"/>
            </svg>
        </div>
        
        <!-- Partikel Air -->
        <div class="absolute inset-0">
            <div class="absolute w-2 h-2 bg-white rounded-full opacity-30 top-1/4 left-1/6 animate-ping" style="animation-duration: 3s;"></div>
            <div class="absolute w-3 h-3 bg-white rounded-full opacity-20 top-1/3 left-1/3 animate-ping" style="animation-duration: 4s;"></div>
            <div class="absolute w-1 h-1 bg-white rounded-full opacity-40 top-2/3 left-2/3 animate-ping" style="animation-duration: 2s;"></div>
            <div class="absolute w-2 h-2 bg-white rounded-full opacity-25 top-1/2 left-3/4 animate-ping" style="animation-duration: 3.5s;"></div>
            <div class="absolute w-1.5 h-1.5 bg-white rounded-full opacity-35 top-3/4 left-1/4 animate-ping" style="animation-duration: 2.8s;"></div>
        </div>
    </div>
    
    <!-- Floating Elements - Ikan & Gelembung -->
    <div class="absolute inset-0 pointer-events-none">
        <div class="absolute top-20 left-10 text-4xl animate-bounce opacity-20" style="animation-duration: 6s;">
            🐟
        </div>
        <div class="absolute bottom-32 right-20 text-5xl animate-bounce opacity-20" style="animation-duration: 7s; animation-delay: 1s;">
            🐠
        </div>
        <div class="absolute top-1/2 right-1/4 text-3xl animate-pulse opacity-20" style="animation-duration: 4s;">
            🐡
        </div>
        <div class="absolute bottom-40 left-1/3 text-4xl animate-bounce opacity-15" style="animation-duration: 5s; animation-delay: 2s;">
            🐙
        </div>
        
        <!-- Gelembung -->
        <div class="absolute bottom-0 left-1/4 w-2 h-2 bg-white rounded-full animate-ping opacity-30" style="animation-duration: 2s;"></div>
        <div class="absolute bottom-10 left-1/2 w-3 h-3 bg-white rounded-full animate-ping opacity-25" style="animation-duration: 2.5s;"></div>
        <div class="absolute bottom-20 right-1/3 w-1.5 h-1.5 bg-white rounded-full animate-ping opacity-35" style="animation-duration: 1.8s;"></div>
    </div>
    
    <!-- Form Container -->
    <div class="relative z-10 flex items-center justify-center min-h-screen p-4">
        <div class="w-full max-w-md">
            <!-- Card Form -->
            <div class="bg-white/10 backdrop-blur-lg rounded-2xl shadow-2xl border border-white/20 p-8">
                <!-- Header -->
                <div class="text-center mb-8">
                    <div class="inline-flex items-center justify-center w-20 h-20 bg-gradient-to-br from-blue-500 to-cyan-500 rounded-full shadow-lg mb-4">
                        <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path>
                        </svg>
                    </div>
                    <h2 class="text-3xl font-bold text-white mb-2">Selamat Datang</h2>
                    <p class="text-blue-100">Silakan login untuk melanjutkan</p>
                </div>
                
                <!-- Form Login -->
                <form method="POST" action="/login" class="space-y-6">
                    @csrf
                    
                    <!-- Email Field -->
                    <div>
                        <label for="email" class="block text-sm font-medium text-white mb-2">Alamat Email</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-blue-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207"></path>
                                </svg>
                            </div>
                            <input type="email" name="email" id="email" required
                                class="w-full pl-10 pr-3 py-3 bg-white/20 border border-white/30 rounded-lg text-white placeholder-blue-200 focus:outline-none focus:ring-2 focus:ring-cyan-400 focus:border-transparent transition duration-200"
                                placeholder="nama@example.com">
                        </div>
                    </div>
                    
                    <!-- Password Field -->
                    <div>
                        <label for="password" class="block text-sm font-medium text-white mb-2">Kata Sandi</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-blue-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                                </svg>
                            </div>
                            <input type="password" name="password" id="password" required
                                class="w-full pl-10 pr-3 py-3 bg-white/20 border border-white/30 rounded-lg text-white placeholder-blue-200 focus:outline-none focus:ring-2 focus:ring-cyan-400 focus:border-transparent transition duration-200"
                                placeholder="Masukkan kata sandi">
                        </div>
                    </div>            
                    
                    <!-- Submit Button -->
                    <button type="submit" 
                        class="w-full py-3 px-4 bg-gradient-to-r from-blue-600 to-cyan-600 hover:from-blue-700 hover:to-cyan-700 text-white font-semibold rounded-lg shadow-lg transform transition duration-200 hover:scale-105 focus:outline-none focus:ring-2 focus:ring-cyan-400 focus:ring-offset-2 focus:ring-offset-blue-900">
                        Masuk
                    </button>
                </form>
                
                <!-- Error Message -->
                @if(session('error'))
                    <div class="mt-6 p-4 bg-red-500/20 border border-red-500/50 rounded-lg backdrop-blur-sm">
                        <div class="flex items-center">
                            <svg class="w-5 h-5 text-red-300 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <p class="text-red-200 text-sm">{{ session('error') }}</p>
                        </div>
                    </div>
                @endif
                
                <!-- Register Link -->
                <div class="mt-6 text-center">
                    <p class="text-blue-100">
                    </p>
                </div>
            </div>
            
            <!-- Footer Decoration -->
            <div class="text-center mt-6 text-blue-200 text-sm">
                © 2024 Lautan Nusantara. All rights reserved.
            </div>
        </div>
    </div>
    
</body>
</html>