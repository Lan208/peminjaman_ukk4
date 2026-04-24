@extends('layouts.app')
@section('content')

<div class="p-6">

    {{-- HEADER --}}
    <div class="bg-white/10 backdrop-blur-md rounded-2xl p-6 mb-8 border border-white/20 shadow-xl">
        <div class="flex items-center gap-4">
            <div class="w-14 h-14 bg-gradient-to-br from-cyan-400 to-blue-500 rounded-2xl flex items-center justify-center shadow-lg">
                <i class="fas fa-clipboard-list text-white text-2xl"></i>
            </div>
            <div>
                <h2 class="text-2xl font-bold text-white">
                    Permintaan Peminjaman
                </h2>
                <p class="text-cyan-200 text-sm mt-1">
                    Kelola dan verifikasi permintaan peminjaman buku dari anggota
                </p>
            </div>
            <span class="bg-yellow-500/30 text-yellow-200 px-3 py-1 rounded-full text-sm ml-2">
                {{ $loans->where('status', 'pending')->count() }} Menunggu
            </span>
        </div>
    </div>

    {{-- NOTIFIKASI --}}
    @if(session('success'))
        <div class="mb-6 bg-gradient-to-r from-green-500/20 to-emerald-500/20 backdrop-blur-md border border-green-500/30 text-green-200 px-5 py-3 rounded-xl flex items-center gap-3">
            <i class="fas fa-check-circle text-green-400 text-lg"></i>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    @if(session('error'))
        <div class="mb-6 bg-gradient-to-r from-red-500/20 to-rose-500/20 backdrop-blur-md border border-red-500/30 text-red-200 px-5 py-3 rounded-xl flex items-center gap-3">
            <i class="fas fa-exclamation-circle text-red-400 text-lg"></i>
            <span>{{ session('error') }}</span>
        </div>
    @endif

    {{-- TABLE CARD --}}
    <div class="bg-white/10 backdrop-blur-md rounded-2xl border border-white/20 shadow-xl overflow-hidden">
        
        @if($loans->count() > 0)
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="border-b border-white/20 bg-white/5">
                            <th class="px-5 py-4 text-left text-cyan-200 font-medium">User</th>
                            <th class="px-5 py-4 text-left text-cyan-200 font-medium">Buku</th>
                            <th class="px-5 py-4 text-left text-cyan-200 font-medium">Jumlah</th>
                            <th class="px-5 py-4 text-left text-cyan-200 font-medium">Tanggal Pinjam</th>
                            <th class="px-5 py-4 text-left text-cyan-200 font-medium">Tanggal Kembali</th>
                            <th class="px-5 py-4 text-center text-cyan-200 font-medium">Status</th>
                            <th class="px-5 py-4 text-center text-cyan-200 font-medium">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($loans as $l)
                            <tr class="border-b border-white/10 hover:bg-white/5 transition-all duration-200">
                                {{-- USER --}}
                                <td class="px-5 py-4">
                                    <div class="flex items-center gap-2">
                                        <div class="w-8 h-8 bg-gradient-to-r from-cyan-500 to-blue-500 rounded-full flex items-center justify-center">
                                            <i class="fas fa-user text-white text-xs"></i>
                                        </div>
                                        <span class="text-white font-medium">{{ $l->user->name }}</span>
                                    </div>
                                </td>

                                {{-- BUKU --}}
                                <td class="px-5 py-4">
                                    <div class="flex items-center gap-2">
                                        <i class="fas fa-book text-cyan-300 text-sm"></i>
                                        <span class="text-cyan-200">{{ $l->book->judul }}</span>
                                    </div>
                                </td>

                                {{-- JUMLAH --}}
                                <td class="px-5 py-4">
                                    <span class="bg-cyan-500/20 text-cyan-200 px-2 py-1 rounded-full text-xs">
                                        {{ $l->jumlah }} Buku
                                    </span>
                                </td>

                                {{-- TANGGAL PINJAM --}}
                                <td class="px-5 py-4">
                                    <div class="flex items-center gap-2">
                                        <i class="fas fa-calendar-alt text-cyan-300 text-xs"></i>
                                        <span class="text-cyan-200">
                                            {{ \Carbon\Carbon::parse($l->tanggal_pinjam)->format('d/m/Y') }}
                                        </span>
                                    </div>
                                </td>

                                {{-- TANGGAL KEMBALI --}}
                                <td class="px-5 py-4">
                                    <div class="flex items-center gap-2">
                                        <i class="fas fa-calendar-check text-cyan-300 text-xs"></i>
                                        <span class="text-cyan-200">
                                            {{ \Carbon\Carbon::parse($l->tanggal_kembali)->format('d/m/Y') }}
                                        </span>
                                    </div>
                                </td>

                                {{-- STATUS --}}
                                <td class="px-5 py-4 text-center">
                                    @if($l->status == 'pending')
                                        <span class="bg-yellow-500/30 text-yellow-200 px-3 py-1 rounded-full text-xs flex items-center gap-1 w-fit mx-auto">
                                            <i class="fas fa-clock"></i> Menunggu
                                        </span>
                                    @elseif($l->status == 'approved')
                                        <span class="bg-green-500/30 text-green-200 px-3 py-1 rounded-full text-xs flex items-center gap-1 w-fit mx-auto">
                                            <i class="fas fa-check-circle"></i> Disetujui
                                        </span>
                                    @elseif($l->status == 'rejected')
                                        <span class="bg-red-500/30 text-red-200 px-3 py-1 rounded-full text-xs flex items-center gap-1 w-fit mx-auto">
                                            <i class="fas fa-times-circle"></i> Ditolak
                                        </span>
                                    @elseif($l->status == 'returned')
                                        <span class="bg-blue-500/30 text-blue-200 px-3 py-1 rounded-full text-xs flex items-center gap-1 w-fit mx-auto">
                                            <i class="fas fa-check-double"></i> Dikembalikan
                                        </span>
                                    @else
                                        <span class="bg-gray-500/30 text-gray-200 px-3 py-1 rounded-full text-xs">
                                            {{ $l->status }}
                                        </span>
                                    @endif
                                </td>

                                {{-- AKSI --}}
                                <td class="px-5 py-4 text-center">
                                    @if($l->status == 'pending')
                                        <div class="flex gap-2 justify-center">
                                            <form action="/loans/{{ $l->id }}/approve" method="POST" class="inline">
                                                @csrf
                                                <button class="bg-gradient-to-r from-green-500 to-emerald-600 hover:from-green-600 hover:to-emerald-700 text-white px-4 py-1.5 rounded-xl transition-all duration-300 flex items-center gap-1 shadow-md text-xs">
                                                    <i class="fas fa-check"></i>
                                                    Approve
                                                </button>
                                            </form>

                                            <form action="/loans/{{ $l->id }}/reject" method="POST" class="inline" 
                                                  onsubmit="return confirm('Yakin ingin menolak permintaan peminjaman dari {{ $l->user->name }}?')">
                                                @csrf
                                                <button class="bg-gradient-to-r from-red-500 to-rose-600 hover:from-red-600 hover:to-rose-700 text-white px-4 py-1.5 rounded-xl transition-all duration-300 flex items-center gap-1 shadow-md text-xs">
                                                    <i class="fas fa-times"></i>
                                                    Reject
                                                </button>
                                            </form>
                                        </div>
                                    @elseif($l->status == 'approved')
                                        <span class="text-green-300/70 text-xs flex items-center justify-center gap-1">
                                            <i class="fas fa-check-circle"></i>
                                            Disetujui
                                        </span>
                                    @elseif($l->status == 'rejected')
                                        <span class="text-red-300/70 text-xs flex items-center justify-center gap-1">
                                            <i class="fas fa-times-circle"></i>
                                            Ditolak
                                        </span>
                                    @else
                                        <span class="text-cyan-300/50 text-xs">Selesai</span>
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
                <i class="fas fa-inbox text-6xl text-cyan-300/30 mb-4"></i>
                <h3 class="text-white text-lg font-medium mb-2">Tidak Ada Permintaan</h3>
                <p class="text-cyan-200 text-sm">Belum ada permintaan peminjaman buku dari anggota.</p>
            </div>
        @endif

    </div>

    {{-- INFO CARD --}}
    <div class="mt-6 bg-white/5 backdrop-blur-md rounded-2xl p-4 border border-white/10">
        <div class="flex items-center gap-3">
            <i class="fas fa-info-circle text-cyan-300 text-lg"></i>
            <p class="text-cyan-200 text-sm">
                <span class="font-semibold text-white">Informasi:</span> 
                Approve = menyetujui peminjaman, Reject = menolak peminjaman.
                Peminjaman yang disetujui akan mengurangi stok buku secara otomatis.
            </p>
        </div>
    </div>

</div>

@endsection