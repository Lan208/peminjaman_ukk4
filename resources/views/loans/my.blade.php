@extends('layouts.app')
@section('content')

<div class="p-6">

    {{-- HEADER --}}
    <div class="bg-white/10 backdrop-blur-md rounded-2xl p-6 mb-8 border border-white/20 shadow-xl">
        <div class="flex items-center gap-4">
            <div class="w-14 h-14 bg-gradient-to-br from-cyan-400 to-blue-500 rounded-2xl flex items-center justify-center shadow-lg">
                <i class="fas fa-book-reader text-white text-2xl"></i>
            </div>
            <div>
                <h2 class="text-2xl font-bold text-white">
                    Peminjaman Saya
                </h2>
                <p class="text-cyan-200 text-sm mt-1">
                    Riwayat peminjaman buku Anda di Perpustakaan Laut
                </p>
            </div>
            <span class="bg-cyan-500/30 text-cyan-200 px-3 py-1 rounded-full text-sm ml-2">
                {{ $loans->count() }} Peminjaman
            </span>
        </div>
    </div>

    {{-- TABLE CARD --}}
    <div class="bg-white/10 backdrop-blur-md rounded-2xl border border-white/20 shadow-xl overflow-hidden">
        
        @if($loans->count() > 0)
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="border-b border-white/20 bg-white/5">
                            <th class="px-5 py-4 text-left text-cyan-200 font-medium">Buku</th>
                            <th class="px-5 py-4 text-center text-cyan-200 font-medium">Jumlah</th>
                            <th class="px-5 py-4 text-left text-cyan-200 font-medium">Tanggal Pinjam</th>
                            <th class="px-5 py-4 text-left text-cyan-200 font-medium">Tanggal Kembali</th>
                            <th class="px-5 py-4 text-center text-cyan-200 font-medium">Status</th>
                            <th class="px-5 py-4 text-center text-cyan-200 font-medium">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($loans as $loan)
                            <tr class="border-b border-white/10 hover:bg-white/5 transition-all duration-200">
                                {{-- BUKU --}}
                                <td class="px-5 py-4">
                                    <div class="flex items-center gap-3">
                                        <div class="w-10 h-10 bg-gradient-to-br from-cyan-500/30 to-blue-500/30 rounded-xl flex items-center justify-center">
                                            <i class="fas fa-book text-cyan-300 text-sm"></i>
                                        </div>
                                        <span class="text-white font-medium">{{ $loan->book->judul }}</span>
                                    </div>
                                </td>

                                {{-- JUMLAH --}}
                                <td class="px-5 py-4 text-center">
                                    <span class="bg-cyan-500/20 text-cyan-200 px-3 py-1 rounded-full text-xs">
                                        {{ $loan->jumlah }} Buku
                                    </span>
                                </td>

                                {{-- TANGGAL PINJAM --}}
                                <td class="px-5 py-4">
                                    <div class="flex items-center gap-2">
                                        <i class="fas fa-calendar-alt text-cyan-300 text-xs"></i>
                                        <span class="text-cyan-200">
                                            {{ \Carbon\Carbon::parse($loan->tanggal_pinjam)->format('d/m/Y') }}
                                        </span>
                                    </div>
                                </td>

                                {{-- TANGGAL KEMBALI --}}
                                <td class="px-5 py-4">
                                    <div class="flex items-center gap-2">
                                        <i class="fas fa-calendar-check text-cyan-300 text-xs"></i>
                                        <span class="text-cyan-200">
                                            {{ \Carbon\Carbon::parse($loan->tanggal_kembali)->format('d/m/Y') }}
                                        </span>
                                    </div>
                                    @php
                                        $telat = max(0, now()->diffInDays($loan->tanggal_kembali, false) * -1);
                                    @endphp
                                    @if($telat > 0 && $loan->status == 'approved')
                                        <span class="text-red-300 text-xs mt-1 flex items-center gap-1">
                                            <i class="fas fa-exclamation-triangle text-xs"></i>
                                            Telat {{ $telat }} hari
                                        </span>
                                    @endif
                                </td>

                                {{-- STATUS --}}
                                <td class="px-5 py-4 text-center">
                                    @if($loan->status == 'pending')
                                        <span class="bg-yellow-500/30 text-yellow-200 px-3 py-1 rounded-full text-xs flex items-center gap-1 w-fit mx-auto">
                                            <i class="fas fa-clock"></i> Menunggu
                                        </span>
                                    @elseif($loan->status == 'approved')
                                        <span class="bg-green-500/30 text-green-200 px-3 py-1 rounded-full text-xs flex items-center gap-1 w-fit mx-auto">
                                            <i class="fas fa-check-circle"></i> Dipinjam
                                        </span>
                                    @elseif($loan->status == 'return_pending')
                                        <span class="bg-orange-500/30 text-orange-200 px-3 py-1 rounded-full text-xs flex items-center gap-1 w-fit mx-auto">
                                            <i class="fas fa-hourglass-half"></i> Menunggu Approve
                                        </span>
                                    @elseif($loan->status == 'returned')
                                        <span class="bg-blue-500/30 text-blue-200 px-3 py-1 rounded-full text-xs flex items-center gap-1 w-fit mx-auto">
                                            <i class="fas fa-check-double"></i> Dikembalikan
                                        </span>
                                    @elseif($loan->status == 'rejected')
                                        <span class="bg-red-500/30 text-red-200 px-3 py-1 rounded-full text-xs flex items-center gap-1 w-fit mx-auto">
                                            <i class="fas fa-times-circle"></i> Ditolak
                                        </span>
                                    @endif
                                </td>

                                {{-- AKSI --}}
                                <td class="px-5 py-4 text-center">
                                    @if($loan->status == 'approved')
                                        <form action="/return-request/{{ $loan->id }}" method="POST" class="inline">
                                            @csrf
                                            <button class="bg-gradient-to-r from-yellow-500 to-orange-500 hover:from-yellow-600 hover:to-orange-600 text-white px-4 py-1.5 rounded-xl transition-all duration-300 flex items-center gap-1 shadow-md text-xs mx-auto">
                                                <i class="fas fa-undo-alt"></i>
                                                Kembalikan
                                            </button>
                                        </form>
                                    @elseif($loan->status == 'return_pending')
                                        <span class="text-cyan-300/70 text-xs flex items-center justify-center gap-1">
                                            <i class="fas fa-spinner fa-pulse"></i>
                                            Menunggu Approval
                                        </span>
                                    @elseif($loan->status == 'returned')
                                        <span class="text-green-300/70 text-xs flex items-center justify-center gap-1">
                                            <i class="fas fa-check-circle"></i>
                                            Selesai
                                        </span>
                                    @elseif($loan->status == 'rejected')
                                        <span class="text-red-300/70 text-xs flex items-center justify-center gap-1">
                                            <i class="fas fa-times-circle"></i>
                                            Ditolak
                                        </span>
                                    @else
                                        <span class="text-cyan-300/50 text-xs flex items-center justify-center gap-1">
                                            <i class="fas fa-hourglass-start"></i>
                                            Menunggu
                                        </span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            {{-- KOSONG --}}
            <div class="text-center py-16">
                <i class="fas fa-book-open text-6xl text-cyan-300/30 mb-4"></i>
                <h3 class="text-white text-lg font-medium mb-2">Belum Ada Peminjaman</h3>
                <p class="text-cyan-200 text-sm">Anda belum pernah meminjam buku. Yuk, pinjam buku sekarang!</p>
                <a href="/books" class="inline-block mt-4 bg-gradient-to-r from-cyan-500 to-blue-500 hover:from-cyan-600 hover:to-blue-600 text-white px-5 py-2 rounded-xl transition shadow-md">
                    <i class="fas fa-book mr-2"></i>
                    Lihat Buku
                </a>
            </div>
        @endif

    </div>

    {{-- INFO CARD --}}
    <div class="mt-6 bg-white/5 backdrop-blur-md rounded-2xl p-4 border border-white/10">
        <div class="flex items-center gap-3">
            <i class="fas fa-info-circle text-cyan-300 text-lg"></i>
            <p class="text-cyan-200 text-sm">
                <span class="font-semibold text-white">Informasi:</span> 
                Status "Dipinjam" berarti buku sedang Anda pinjam. Klik "Kembalikan" untuk mengembalikan buku.
                Pengembalian akan diproses oleh admin.
            </p>
        </div>
    </div>

</div>

@endsection