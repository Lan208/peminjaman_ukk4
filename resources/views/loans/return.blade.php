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
                    Approval Pengembalian Buku
                </h2>
                <p class="text-cyan-200 text-sm mt-1">
                    Verifikasi dan konfirmasi pengembalian buku oleh anggota
                </p>
            </div>
            <span class="bg-cyan-500/30 text-cyan-200 px-3 py-1 rounded-full text-sm ml-2">
                {{ $loans->count() }} Menunggu
            </span>
        </div>
    </div>

    {{-- NOTIFIKASI SUCCESS --}}
    @if(session('success'))
        <div class="mb-6 bg-gradient-to-r from-green-500/20 to-emerald-500/20 backdrop-blur-md border border-green-500/30 text-green-200 px-5 py-3 rounded-xl flex items-center gap-3">
            <i class="fas fa-check-circle text-green-400 text-lg"></i>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    {{-- NOTIFIKASI ERROR --}}
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
                            <th class="px-5 py-4 text-center text-cyan-200 font-medium">Jml</th>
                            <th class="px-5 py-4 text-left text-cyan-200 font-medium">Tgl Kembali (Rencana)</th>
                            <th class="px-5 py-4 text-left text-cyan-200 font-medium">Kondisi Buku</th>
                            <th class="px-5 py-4 text-center text-cyan-200 font-medium">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($loans as $loan)
                            <tr class="border-b border-white/10 hover:bg-white/5 transition-all duration-200">
                                {{-- USER --}}
                                <td class="px-5 py-4">
                                    <div class="flex items-center gap-2">
                                        <div class="w-8 h-8 bg-gradient-to-r from-cyan-500 to-blue-500 rounded-full flex items-center justify-center">
                                            <i class="fas fa-user text-white text-xs"></i>
                                        </div>
                                        <span class="text-white font-medium">{{ $loan->user->name }}</span>
                                    </div>
                                </td>

                                {{-- BUKU --}}
                                <td class="px-5 py-4">
                                    <div class="flex items-center gap-2">
                                        <i class="fas fa-book text-cyan-300 text-sm"></i>
                                        <span class="text-cyan-200">{{ $loan->book->judul }}</span>
                                    </div>
                                </td>

                                {{-- JUMLAH --}}
                                <td class="px-5 py-4 text-center">
                                    <span class="bg-cyan-500/20 text-cyan-200 px-2 py-1 rounded-full text-xs">
                                        {{ $loan->jumlah }}
                                    </span>
                                </td>

                                {{-- TANGGAL KEMBALI --}}
                                <td class="px-5 py-4">
                                    @php
                                        $telat = max(0, now()->diffInDays($loan->tanggal_kembali, false) * -1);
                                    @endphp
                                    <div class="flex flex-col">
                                        <span class="text-white">
                                            {{ \Carbon\Carbon::parse($loan->tanggal_kembali)->format('d/m/Y') }}
                                        </span>
                                        @if($telat > 0)
                                            <span class="text-red-300 text-xs mt-1 flex items-center gap-1">
                                                <i class="fas fa-exclamation-triangle text-xs"></i>
                                                Telat {{ $telat }} hari
                                            </span>
                                        @else
                                            <span class="text-green-300 text-xs mt-1 flex items-center gap-1">
                                                <i class="fas fa-check-circle text-xs"></i>
                                                Tepat waktu
                                            </span>
                                        @endif
                                    </div>
                                </td>

                                {{-- FORM KONDISI & APPROVE --}}
                                <td class="px-5 py-4">
                                    <form action="/approve-return/{{ $loan->id }}" method="POST" class="flex flex-col gap-2">
                                        @csrf
                                        <select name="kondisi_buku" 
                                            class="bg-white/20 border border-white/30 rounded-xl px-3 py-2 text-sm text-white focus:outline-none focus:ring-2 focus:ring-cyan-400">
                                            <option value="baik" class="bg-blue-900 text-white">✅ Baik</option>
                                            <option value="rusak_ringan" class="bg-blue-900 text-white">🟡 Rusak ringan</option>
                                            <option value="rusak_berat" class="bg-blue-900 text-white">🔴 Rusak berat</option>
                                            <option value="hilang" class="bg-blue-900 text-white">⬛ Hilang</option>
                                        </select>
                                        
                                        <button type="submit"
                                            class="bg-gradient-to-r from-green-500 to-emerald-600 hover:from-green-600 hover:to-emerald-700 text-white px-4 py-2 rounded-xl transition-all duration-300 flex items-center justify-center gap-2 shadow-md">
                                            <i class="fas fa-check-circle"></i>
                                            Approve
                                        </button>
                                    </form>
                                </td>

                                {{-- KOLOM KOSONG (aksi sudah di kolom sebelumnya) --}}
                                <td class="px-5 py-4 text-center">
                                    <div class="flex justify-center">
                                        <i class="fas fa-arrow-right text-cyan-300/50"></i>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            {{-- KOSONG --}}
            <div class="text-center py-16">
                <i class="fas fa-check-circle text-6xl text-cyan-300/30 mb-4"></i>
                <h3 class="text-white text-lg font-medium mb-2">Tidak Ada Pengembalian</h3>
                <p class="text-cyan-200 text-sm">Semua peminjaman sudah selesai. Tidak ada yang perlu diapprove.</p>
            </div>
        @endif

    </div>

    {{-- INFO CARD --}}
    <div class="mt-6 bg-white/5 backdrop-blur-md rounded-2xl p-4 border border-white/10">
        <div class="flex items-center gap-3">
            <i class="fas fa-info-circle text-cyan-300 text-lg"></i>
            <p class="text-cyan-200 text-sm">
                <span class="font-semibold text-white">Informasi:</span> 
                Pilih kondisi buku terlebih dahulu sebelum melakukan approve pengembalian.
                Denda akan dihitung otomatis berdasarkan keterlambatan.
            </p>
        </div>
    </div>

</div>

<style>
    select option {
        background-color: #1e3a5f;
    }
</style>

@endsection