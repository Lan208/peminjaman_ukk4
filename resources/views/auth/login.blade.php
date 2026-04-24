<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Perpustakaan</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Inter', sans-serif;
        }

        canvas {
            position: fixed;
            inset: 0;
            width: 100%;
            height: 100%;
            z-index: 0;
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .fade-in-up {
            animation: fadeInUp 0.8s ease-out;
        }

        .glass-card {
            background: rgba(10, 25, 47, 0.7);
            backdrop-filter: blur(12px);
            border: 1px solid rgba(56, 189, 248, 0.2);
        }

        input {
            transition: all 0.3s ease;
        }

        input:focus {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1);
        }

        @keyframes shimmer {
            0% { background-position: -1000px 0; }
            100% { background-position: 1000px 0; }
        }

        .shimmer {
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.1), transparent);
            background-size: 1000px 100%;
            animation: shimmer 3s infinite;
        }
    </style>
</head>

<body class="relative min-h-screen overflow-hidden bg-gradient-to-br from-slate-900 via-teal-900 to-slate-900">

<canvas id="oceanCanvas"></canvas>

<div class="absolute inset-0 bg-gradient-to-t from-slate-900/50 via-transparent to-slate-900/30 z-0"></div>

<div class="relative z-10 flex items-center justify-center min-h-screen p-4">
    <div class="w-full max-w-md fade-in-up">
        
        <div class="glass-card rounded-2xl p-8 shadow-2xl">
            
            <!-- Logo Buku -->
            <div class="text-center mb-8">
                <div class="relative inline-block mb-4">
                    <div class="absolute inset-0 bg-cyan-400 rounded-full blur-xl opacity-50"></div>
                    <div class="relative w-20 h-20 bg-gradient-to-br from-cyan-400 to-teal-500 rounded-2xl flex items-center justify-center transform rotate-6 shadow-2xl">
                        <svg class="w-10 h-10 text-white -rotate-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                        </svg>
                    </div>
                </div>
                <h2 class="text-2xl font-bold bg-gradient-to-r from-cyan-400 to-teal-400 bg-clip-text text-transparent">
                    Library
                </h2>
                <p class="text-slate-400 mt-2 text-sm">Masuk ke akun anda</p>
            </div>

            <form method="POST" action="/login" class="space-y-5">
                @csrf

                <!-- Email Field -->
                <div>
                    <label class="block text-sm font-medium text-slate-300 mb-2">Email</label>
                    <div class="relative">
                        <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207"></path>
                        </svg>
                        <input type="email" name="email" required
                            class="w-full pl-10 pr-4 py-3 bg-slate-800/50 border border-slate-700 rounded-xl text-white placeholder-slate-500 focus:border-cyan-500 focus:ring-2 focus:ring-cyan-500/20 outline-none"
                            placeholder="nama@perusahaan.com">
                    </div>
                </div>

                <!-- Password Field -->
                <div>
                    <label class="block text-sm font-medium text-slate-300 mb-2">Password</label>
                    <div class="relative">
                        <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                        </svg>
                        <input type="password" id="password" name="password" required
                            class="w-full pl-10 pr-20 py-3 bg-slate-800/50 border border-slate-700 rounded-xl text-white placeholder-slate-500 focus:border-cyan-500 focus:ring-2 focus:ring-cyan-500/20 outline-none"
                            placeholder="••••••••">
                        <button type="button" id="togglePassword"
                            class="absolute right-2 top-1/2 -translate-y-1/2 px-3 py-1 text-xs font-medium text-cyan-400 hover:text-cyan-300 transition">
                            👁️
                        </button>
                    </div>
                </div>

                <!-- Lupa password pake emot -->
                <div class="flex items-center justify-end">
                    <a href="#" class="text-sm text-cyan-400 hover:text-cyan-300 transition flex items-center gap-1">
                    </a>
                </div>

                <!-- Submit Button -->
                <button type="submit"
                    class="relative w-full py-3.5 bg-gradient-to-r from-cyan-500 to-teal-500 hover:from-cyan-600 hover:to-teal-600 text-white font-semibold rounded-xl transition-all duration-300 transform hover:scale-[1.02] shadow-lg overflow-hidden group">
                    <span class="relative z-10">🚀 Masuk</span>
                    <div class="absolute inset-0 bg-gradient-to-r from-cyan-400 to-teal-400 opacity-0 group-hover:opacity-100 transition-opacity duration-300 shimmer"></div>
                </button>

                <!-- Kata kata inspiratif -->
                <div class="text-center pt-4 border-t border-slate-700/50">
                    <p class="text-slate-400 text-sm italic">
                                
                    </p>
                    <p class="text-slate-500 text-xs mt-2">
                        🌊🇮🇩✨
                    </p>
                </div>
            </form>

            @if(session('error'))
                <div class="mt-4 p-3 bg-red-500/10 border border-red-500/30 rounded-xl text-red-400 text-sm">
                    ⚠️ {{ session('error') }}
                </div>
            @endif
        </div>

        <p class="text-center mt-6 text-slate-500 text-xs">
        </p>
    </div>
</div>

<script>
// Toggle Password
document.getElementById('togglePassword').onclick = function() {
    const input = document.getElementById('password');
    const type = input.type === 'password' ? 'text' : 'password';
    input.type = type;
    this.textContent = type === 'password' ? '👁️' : '🙈';
};

// Canvas dengan efek aurora & gelombang modern
const canvas = document.getElementById('oceanCanvas');
const ctx = canvas.getContext('2d');
let width, height;
let time = 0;

function resize() {
    width = canvas.width = window.innerWidth;
    height = canvas.height = window.innerHeight;
}

// Gradient colors for aurora effect
const gradients = [
    { r: 0, g: 150, b: 255 },
    { r: 0, g: 200, b: 200 },
    { r: 50, g: 100, b: 255 },
    { r: 0, g: 100, b: 200 }
];

function drawAurora() {
    for(let i = 0; i < gradients.length; i++) {
        const grad = ctx.createLinearGradient(0, 0, width, height);
        grad.addColorStop(0, `rgba(${gradients[i].r}, ${gradients[i].g}, ${gradients[i].b}, 0.3)`);
        grad.addColorStop(0.5, `rgba(${gradients[i].r}, ${gradients[i].g}, ${gradients[i].b}, 0.1)`);
        grad.addColorStop(1, `rgba(${gradients[i].r}, ${gradients[i].g}, ${gradients[i].b}, 0)`);
        
        ctx.fillStyle = grad;
        ctx.fillRect(0, 0, width, height);
    }
}

function drawWaves() {
    // Wave 1
    ctx.beginPath();
    for(let x = 0; x <= width; x += 5) {
        const y = height * 0.7 + 
                  Math.sin(x * 0.008 + time * 0.008) * 40 +
                  Math.sin(x * 0.02 + time * 0.015) * 20;
        if(x === 0) ctx.moveTo(x, y);
        else ctx.lineTo(x, y);
    }
    ctx.lineTo(width, height);
    ctx.lineTo(0, height);
    ctx.fillStyle = 'rgba(56, 189, 248, 0.15)';
    ctx.fill();
    
    // Wave 2
    ctx.beginPath();
    for(let x = 0; x <= width; x += 5) {
        const y = height * 0.75 + 
                  Math.sin(x * 0.012 + time * 0.012) * 35 +
                  Math.cos(x * 0.015 + time * 0.01) * 15;
        if(x === 0) ctx.moveTo(x, y);
        else ctx.lineTo(x, y);
    }
    ctx.lineTo(width, height);
    ctx.lineTo(0, height);
    ctx.fillStyle = 'rgba(20, 184, 166, 0.12)';
    ctx.fill();
    
    // Wave 3
    ctx.beginPath();
    for(let x = 0; x <= width; x += 5) {
        const y = height * 0.8 + 
                  Math.sin(x * 0.02 + time * 0.02) * 25 +
                  Math.sin(x * 0.03 + time * 0.025) * 10;
        if(x === 0) ctx.moveTo(x, y);
        else ctx.lineTo(x, y);
    }
    ctx.lineTo(width, height);
    ctx.lineTo(0, height);
    ctx.fillStyle = 'rgba(6, 182, 212, 0.1)';
    ctx.fill();
}

// Floating particles
let particles = [];

function initParticles() {
    for(let i = 0; i < 80; i++) {
        particles.push({
            x: Math.random() * width,
            y: Math.random() * height,
            radius: Math.random() * 2 + 0.5,
            speedX: (Math.random() - 0.5) * 0.3,
            speedY: Math.random() * 0.2 + 0.1,
            alpha: Math.random() * 0.3 + 0.1
        });
    }
}

function drawParticles() {
    for(let p of particles) {
        ctx.beginPath();
        ctx.arc(p.x, p.y, p.radius, 0, Math.PI * 2);
        ctx.fillStyle = `rgba(255, 255, 255, ${p.alpha})`;
        ctx.fill();
        
        p.x += p.speedX;
        p.y += p.speedY;
        
        if(p.x < 0) p.x = width;
        if(p.x > width) p.x = 0;
        if(p.y < 0) p.y = height;
        if(p.y > height) p.y = 0;
    }
}

function animate() {
    time += 0.5;
    
    const grad = ctx.createLinearGradient(0, 0, 0, height);
    grad.addColorStop(0, '#0f172a');
    grad.addColorStop(0.5, '#0f2e3d');
    grad.addColorStop(1, '#0a1a2a');
    ctx.fillStyle = grad;
    ctx.fillRect(0, 0, width, height);
    
    drawAurora();
    drawWaves();
    drawParticles();
    
    requestAnimationFrame(animate);
}

window.addEventListener('resize', () => {
    resize();
    particles = [];
    initParticles();
});

resize();
initParticles();
animate();
</script>

</body>
</html>