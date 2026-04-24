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
                Halo, Selamat datang {{ Auth::user()->name }} Imoet! 👋
            </h2>
            <p class="text-cyan-200 text-sm mt-1">
                Selamat datang di Perpustakaan Laut. Semoga harimu menyenangkan!
            </p>
        </div>
    </div>
</div>

{{-- ADMIN DASHBOARD --}}
@auth
@if(auth()->user()->role == 'admin')

<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">

    <div class="bg-white/10 backdrop-blur-md p-5 rounded-2xl border border-white/20 shadow-xl">
        <p class="text-cyan-200 text-sm">Total Buku</p>
        <h2 class="text-3xl font-bold text-white">{{ $totalBooks }}</h2>
    </div>

    <div class="bg-white/10 backdrop-blur-md p-5 rounded-2xl border border-white/20 shadow-xl">
        <p class="text-cyan-200 text-sm">Total User</p>
        <h2 class="text-3xl font-bold text-white">{{ $totalUsers }}</h2>
    </div>

    <div class="bg-white/10 backdrop-blur-md p-5 rounded-2xl border border-white/20 shadow-xl">
        <p class="text-cyan-200 text-sm">Total Peminjaman</p>
        <h2 class="text-3xl font-bold text-white">{{ $totalLoans }}</h2>
    </div>

    <div class="bg-white/10 backdrop-blur-md p-5 rounded-2xl border border-white/20 shadow-xl">
        <p class="text-cyan-200 text-sm">Sedang Dipinjam</p>
        <h2 class="text-3xl font-bold text-white">{{ $totalDipinjam }}</h2>
    </div>

</div>

@endif
@endauth

{{-- USER DASHBOARD --}}
@auth
@if(auth()->user()->role != 'admin')

{{-- 🔥 SYARAT PEMINJAMAN (BARU - USER ONLY) --}}
<div class="bg-white/10 backdrop-blur-md rounded-2xl p-6 mb-6 border border-white/20 shadow-xl">
    <div class="flex items-start gap-4">
        
        <div class="w-12 h-12 bg-gradient-to-br from-yellow-400 to-orange-500 rounded-xl flex items-center justify-center shadow-lg">
            <i class="fas fa-exclamation text-white"></i>
        </div>

        <div>
            <h3 class="text-white font-semibold text-lg mb-2">
                Syarat Peminjaman Buku
            </h3>

            <ul class="text-cyan-200 text-sm space-y-1 list-disc ml-4">
                <li>Maksimal peminjaman 3 buku</li>
                <li>Durasi peminjaman maksimal 7 hari</li>
                <li>Dilarang merusak atau menghilangkan buku</li>
                <li>Harus mengembalikan tepat waktu</li>
                <li>Keterlambatan akan dikenakan sanksi</li>
            </ul>
        </div>

    </div>
</div>

<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">

@foreach($books as $b)
<div class="bg-white/10 backdrop-blur-md rounded-2xl border border-white/20 shadow-xl overflow-hidden hover:scale-[1.02] transition">

    {{-- IMAGE --}}
    @if($b->image)
        <div class="flex justify-center mt-5">
            <img src="{{ asset('images/' . $b->image) }}" class="w-32 aspect-[2/3] object-cover rounded-xl">
        </div>
    @else
        <div class="flex justify-center mt-5">
            <div class="w-32 aspect-[2/3] bg-gradient-to-br from-cyan-500/20 to-blue-500/20 flex items-center justify-center text-cyan-200 rounded-xl">
                <i class="fas fa-book-open text-2xl opacity-50"></i>
            </div>
        </div>
    @endif

    {{-- CONTENT --}}
    <div class="p-5">

        <h3 class="font-semibold text-white text-base text-center mb-2">
            {{ $b->judul }}
        </h3>

        <div class="flex items-center justify-center gap-2 mb-3">
            <p class="text-cyan-200 text-sm">
                Stok: <span class="text-white font-medium">{{ $b->stok }}</span>
            </p>
        </div>

        @php $loan = $loans[$b->id] ?? null; @endphp

        <div class="flex justify-between items-center mt-4">

            @if($loan && in_array($loan->status, ['approved', 'return_pending']))
                <span class="text-xs bg-yellow-500/30 text-yellow-200 px-3 py-1 rounded-full">
                    Dipinjam
                </span>
            @else
                <span class="text-xs bg-green-500/30 text-green-200 px-3 py-1 rounded-full">
                    Tersedia
                </span>
            @endif

            @if($loan && in_array($loan->status, ['approved', 'return_pending']))
                <button disabled class="bg-gray-500/50 text-white px-3 py-1 text-xs rounded-xl">
                    Dipinjam
                </button>
            @else
                <button onclick="openModal('pinjamModal{{ $b->id }}')"
                    class="bg-gradient-to-r from-cyan-500 to-blue-500 text-white px-4 py-1 text-xs rounded-xl">
                    Pinjam
                </button>
            @endif

        </div>

    </div>
</div>

{{-- MODAL --}}
<div id="pinjamModal{{ $b->id }}"
     class="hidden fixed inset-0 bg-black/50 flex justify-center items-center z-50"
     onclick="closeModal('pinjamModal{{ $b->id }}')">

    <div class="bg-white rounded-2xl w-80 p-6"
         onclick="event.stopPropagation()">

        <h3 class="font-bold mb-2">Pinjam Buku</h3>

        {{-- 🔥 INFO SYARAT DI MODAL --}}
        <div class="bg-yellow-100 text-yellow-700 text-xs p-3 rounded-xl mb-3">
            ⚠ Maksimal 3 buku & 7 hari peminjaman
        </div>

        <form action="/pinjam/{{ $b->id }}" method="POST">
            @csrf

            <input type="date" name="tanggal_pinjam" class="w-full mb-3 p-2 border rounded-xl" required>
            <input type="date" name="tanggal_kembali" class="w-full mb-3 p-2 border rounded-xl" required>
            <input type="number" name="jumlah" max="{{ $b->stok }}" value="1"
                   class="w-full mb-4 p-2 border rounded-xl" required>

            <div class="flex justify-end gap-2">
                <button type="button" onclick="closeModal('pinjamModal{{ $b->id }}')">Batal</button>
                <button class="bg-blue-500 text-white px-4 py-2 rounded-xl">Kirim</button>
            </div>

        </form>

    </div>
</div>

@endforeach

</div>

@endif
@endauth

{{-- JAVASCRIPT --}}
<script>
function openModal(id) {
    document.getElementById(id).classList.remove('hidden');
}

function closeModal(id) {
    document.getElementById(id).classList.add('hidden');
}
</script>

@endsection