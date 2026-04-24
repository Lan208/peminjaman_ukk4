@extends('layouts.app')

@section('content')
<div class="p-6">
    <h2 class="text-white text-2xl font-bold mb-6">Riwayat Peminjaman</h2>

    @if($loans->isEmpty())
        <p class="text-cyan-200">Belum ada riwayat peminjaman.</p>
    @else
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-cyan-100">
                <thead>
                    <tr class="border-b border-white/10 text-cyan-300 uppercase text-xs">
                        <th class="py-3 px-4 text-left">Cover</th>
                        <th class="py-3 px-4 text-left">Judul Buku</th>
                        <th class="py-3 px-4 text-left">Tgl Pinjam</th>
                        <th class="py-3 px-4 text-left">Tgl Kembali</th>
                        <th class="py-3 px-4 text-left">Kondisi</th>
                        <th class="py-3 px-4 text-left">Denda Telat</th>
                        <th class="py-3 px-4 text-left">Denda Kerusakan</th>
                        <th class="py-3 px-4 text-left">Total Denda</th>
                        <th class="py-3 px-4 text-left">Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($loans as $loan)
                    <tr class="border-b border-white/5 hover:bg-white/5">

                        {{-- GAMBAR BUKU --}}
                        <td class="py-3 px-4">
                            @if($loan->book->image)
                                <img src="{{ asset('images/' . $loan->book->image) }}"
                                     class="w-12 h-16 object-cover rounded-lg shadow">
                            @else
                                <div class="w-12 h-16 bg-white/10 rounded-lg flex items-center justify-center">
                                    <i class="fas fa-book text-cyan-300/50"></i>
                                </div>
                            @endif
                        </td>

                        {{-- JUDUL --}}
                        <td class="py-3 px-4 font-medium">{{ $loan->book->judul }}</td>

                        {{-- TANGGAL PINJAM --}}
                        <td class="py-3 px-4">{{ \Carbon\Carbon::parse($loan->tanggal_pinjam)->format('d M Y') }}</td>

                        {{-- TANGGAL KEMBALI --}}
                        <td class="py-3 px-4">{{ \Carbon\Carbon::parse($loan->tanggal_kembali)->format('d M Y') }}</td>

                        {{-- KONDISI --}}
                        <td class="py-3 px-4">
                            {{ $loan->kondisi_buku ? ucfirst(str_replace('_', ' ', $loan->kondisi_buku)) : '-' }}
                        </td>

                        {{-- DENDA TELAT --}}
                        <td class="py-3 px-4">
                            {{ $loan->denda_telat ? 'Rp ' . number_format($loan->denda_telat, 0, ',', '.') : '-' }}
                        </td>

                        {{-- DENDA KERUSAKAN --}}
                        <td class="py-3 px-4">
                            {{ $loan->denda_kerusakan ? 'Rp ' . number_format($loan->denda_kerusakan, 0, ',', '.') : '-' }}
                        </td>

                        {{-- TOTAL DENDA --}}
                        <td class="py-3 px-4 font-semibold {{ $loan->denda_total > 0 ? 'text-red-300' : 'text-cyan-300' }}">
                            {{ $loan->denda_total ? 'Rp ' . number_format($loan->denda_total, 0, ',', '.') : '-' }}
                        </td>

                        {{-- STATUS --}}
                        <td class="py-3 px-4">
                            <span class="px-2 py-1 rounded-full text-xs
                                {{ $loan->status == 'approved' ? 'bg-green-500/20 text-green-300' : '' }}
                                {{ $loan->status == 'pending' ? 'bg-yellow-500/20 text-yellow-300' : '' }}
                                {{ $loan->status == 'rejected' ? 'bg-red-500/20 text-red-300' : '' }}
                                {{ $loan->status == 'returned' ? 'bg-blue-500/20 text-blue-300' : '' }}
                                {{ $loan->status == 'return_pending' ? 'bg-orange-500/20 text-orange-300' : '' }}">
                                {{ ucfirst(str_replace('_', ' ', $loan->status)) }}
                            </span>
                        </td>

                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</div>
@endsection