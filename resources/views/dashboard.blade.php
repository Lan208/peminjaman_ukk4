@extends('layouts.app')

@section('content')

    {{-- GREETING CARD --}}
    <div class="bg-white/10 backdrop-blur-md rounded-2xl p-6 mb-8 border border-white/20 shadow-xl">
        <div class="flex items-center gap-4">
            <div class="w-14 h-14 bg-gradient-to-br from-cyan-400 to-blue-500 rounded-2xl flex items-center justify-center shadow-lg">
                <i class="fas fa-hand-peace text-white text-2xl"></i>
            </div>
            <div>
                <h2 class="text-2xl font-bold text-white">
                    Halo, {{ Auth::user()->name }}! 👋
                </h2>
                <p class="text-cyan-200 text-sm mt-1">
                    Selamat datang di Perpustakaan Laut. Semoga harimu menyenangkan!
                </p>
            </div>
        </div>
    </div>

    {{-- ===================== DASHBOARD ADMIN ===================== --}}
    @auth
        @if(auth()->user()->role == 'admin')
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                
                {{-- CARD TOTAL BUKU --}}
                <div class="bg-white/10 backdrop-blur-md rounded-2xl p-6 border border-white/20 shadow-xl hover:scale-105 transition-transform duration-300">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-cyan-200 text-sm">Total Buku</p>
                            <p class="text-white text-3xl font-bold mt-2">{{ $totalBooks ?? 0 }}</p>
                        </div>
                        <div class="w-12 h-12 bg-cyan-500/30 rounded-xl flex items-center justify-center">
                            <i class="fas fa-book text-cyan-200 text-xl"></i>
                        </div>
                    </div>
                </div>

                {{-- CARD ANGGOTA --}}
                <div class="bg-white/10 backdrop-blur-md rounded-2xl p-6 border border-white/20 shadow-xl hover:scale-105 transition-transform duration-300">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-cyan-200 text-sm">Anggota</p>
                            <p class="text-white text-3xl font-bold mt-2">{{ $totalMembers ?? 0 }}</p>
                        </div>
                        <div class="w-12 h-12 bg-blue-500/30 rounded-xl flex items-center justify-center">
                            <i class="fas fa-users text-cyan-200 text-xl"></i>
                        </div>
                    </div>
                </div>

                {{-- CARD TRANSAKSI --}}
                <div class="bg-white/10 backdrop-blur-md rounded-2xl p-6 border border-white/20 shadow-xl hover:scale-105 transition-transform duration-300">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-cyan-200 text-sm">Transaksi Aktif</p>
                            <p class="text-white text-3xl font-bold mt-2">{{ $activeLoans ?? 0 }}</p>
                        </div>
                        <div class="w-12 h-12 bg-teal-500/30 rounded-xl flex items-center justify-center">
                            <i class="fas fa-clipboard-list text-cyan-200 text-xl"></i>
                        </div>
                    </div>
                </div>

            </div>

            {{-- TAMBAHAN: GRAFIK SEDERHANA UNTUK ADMIN --}}
            <div class="mt-8 bg-white/10 backdrop-blur-md rounded-2xl p-6 border border-white/20 shadow-xl">
                <h3 class="text-white font-semibold mb-4 flex items-center gap-2">
                    <i class="fas fa-chart-line text-cyan-300"></i>
                    Statistik Peminjaman
                </h3>
                <div class="text-cyan-200 text-sm text-center py-8">
                    <i class="fas fa-chart-simple text-4xl mb-2 opacity-50"></i>
                    <p>Grafik peminjaman akan tampil di sini</p>
                </div>
            </div>
        @endif
    @endauth


    {{-- ===================== DASHBOARD USER ===================== --}}
    @auth
        @if(auth()->user()->role != 'admin')

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">

                @foreach($books as $b)
                    <div class="bg-white/10 backdrop-blur-md rounded-2xl border border-white/20 shadow-xl overflow-hidden hover:scale-[1.02] transition-all duration-300">

                        {{-- GAMBAR --}}
                        @if($b->image)
                            <img src="{{ asset('images/' . $b->image) }}" class="w-full h-44 object-cover">
                        @else
                            <div class="w-full h-44 bg-gradient-to-br from-cyan-500/20 to-blue-500/20 flex flex-col items-center justify-center text-cyan-200">
                                <i class="fas fa-book-open text-4xl mb-2 opacity-50"></i>
                                <p class="text-xs">No Image</p>
                            </div>
                        @endif

                        <div class="p-5">

                            {{-- TITLE --}}
                            <h3 class="font-semibold text-white text-lg mb-1 line-clamp-1">
                                {{ $b->judul }}
                            </h3>

                            {{-- STOK --}}
                            <div class="flex items-center gap-2 mb-3">
                                <i class="fas fa-boxes text-cyan-300 text-xs"></i>
                                <p class="text-cyan-200 text-sm">
                                    Stok: <span class="text-white font-medium">{{ $b->stok }}</span>
                                </p>
                            </div>

                            {{-- STATUS & BUTTON --}}
                            @php $loan = $loans[$b->id] ?? null; @endphp

                            <div class="flex justify-between items-center mt-4">

                                @if($loan && in_array($loan->status, ['approved', 'return_pending']))
                                    <span class="text-xs bg-yellow-500/30 text-yellow-200 px-3 py-1.5 rounded-full flex items-center gap-1">
                                        <i class="fas fa-clock"></i> Dipinjam
                                    </span>
                                @else
                                    <span class="text-xs bg-green-500/30 text-green-200 px-3 py-1.5 rounded-full flex items-center gap-1">
                                        <i class="fas fa-check-circle"></i> Tersedia
                                    </span>
                                @endif

                                {{-- BUTTON --}}
                                @if($loan && in_array($loan->status, ['approved', 'return_pending']))
                                    <button disabled class="bg-gray-500/50 text-white/70 px-4 py-1.5 text-sm rounded-xl cursor-not-allowed">
                                        Dipinjam
                                    </button>
                                @else
                                    <button onclick="openModal('pinjamModal{{ $b->id }}')"
                                        class="bg-gradient-to-r from-cyan-500 to-blue-500 hover:from-cyan-600 hover:to-blue-600 text-white px-5 py-1.5 text-sm rounded-xl transition-all duration-300 shadow-md">
                                        <i class="fas fa-hand-holding-heart mr-1"></i> Pinjam
                                    </button>
                                @endif

                            </div>

                        </div>
                    </div>

                    {{-- MODAL PINJAM --}}
                    <div id="pinjamModal{{ $b->id }}" class="hidden fixed inset-0 bg-black/50 backdrop-blur-sm flex justify-center items-center z-50">
                        <div class="bg-gradient-to-br from-white to-cyan-50 rounded-2xl w-96 shadow-2xl animate-fade-in">

                            <div class="p-6">
                                <div class="flex items-center gap-3 mb-4 border-b border-cyan-200 pb-3">
                                    <div class="w-10 h-10 bg-gradient-to-r from-cyan-500 to-blue-500 rounded-xl flex items-center justify-center">
                                        <i class="fas fa-book-open text-white"></i>
                                    </div>
                                    <h3 class="font-bold text-cyan-800 text-lg">Pinjam Buku</h3>
                                </div>

                                <form action="/pinjam/{{ $b->id }}" method="POST">
                                    @csrf

                                    <div class="mb-4">
                                        <label class="text-xs text-cyan-700 font-medium block mb-1">
                                            <i class="fas fa-calendar-alt mr-1"></i> Tanggal Pinjam
                                        </label>
                                        <input type="date" name="tanggal_pinjam" 
                                               class="w-full border border-cyan-200 rounded-xl p-2.5 focus:outline-none focus:ring-2 focus:ring-cyan-400">
                                    </div>

                                    <div class="mb-4">
                                        <label class="text-xs text-cyan-700 font-medium block mb-1">
                                            <i class="fas fa-calendar-check mr-1"></i> Tanggal Kembali
                                        </label>
                                        <input type="date" name="tanggal_kembali" 
                                               class="w-full border border-cyan-200 rounded-xl p-2.5 focus:outline-none focus:ring-2 focus:ring-cyan-400">
                                    </div>

                                    <div class="mb-5">
                                        <label class="text-xs text-cyan-700 font-medium block mb-1">
                                            <i class="fas fa-sort-amount-up mr-1"></i> Jumlah (Maks: {{ $b->stok }})
                                        </label>
                                        <input type="number" name="jumlah" max="{{ $b->stok }}" value="1"
                                               class="w-full border border-cyan-200 rounded-xl p-2.5 focus:outline-none focus:ring-2 focus:ring-cyan-400">
                                    </div>

                                    <div class="flex justify-end gap-3">
                                        <button type="button" onclick="closeModal('pinjamModal{{ $b->id }}')" 
                                                class="text-gray-500 hover:text-gray-700 px-4 py-2 rounded-xl transition">
                                            Batal
                                        </button>
                                        <button class="bg-gradient-to-r from-cyan-500 to-blue-500 hover:from-cyan-600 hover:to-blue-600 text-white px-5 py-2 rounded-xl transition shadow-md">
                                            <i class="fas fa-paper-plane mr-1"></i> Kirim
                                        </button>
                                    </div>
                                </form>

                            </div>
                        </div>
                    </div>

                @endforeach

            </div>

        @endif
    @endauth


    <script>
        function openModal(id) {
            document.getElementById(id).classList.remove('hidden')
        }
        function closeModal(id) {
            document.getElementById(id).classList.add('hidden')
        }

        // Tutup modal klik di luar
        window.onclick = function(event) {
            if (event.target.classList.contains('bg-black/50')) {
                event.target.classList.add('hidden')
            }
        }
    </script>

    <style>
        @keyframes fade-in {
            from {
                opacity: 0;
                transform: scale(0.95);
            }
            to {
                opacity: 1;
                transform: scale(1);
            }
        }
        
        .animate-fade-in {
            animation: fade-in 0.2s ease-out;
        }
        
        .line-clamp-1 {
            display: -webkit-box;
            -webkit-line-clamp: 1;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
    </style>

@endsection