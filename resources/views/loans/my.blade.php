@extends('layouts.app')
@section('content')

    <h2 class="text-xl font-bold mb-4">📚 Peminjaman Saya</h2>

    <table class="w-full bg-white shadow rounded">
        <thead>
            <tr class="bg-gray-200">
                <th class="p-2">Buku</th>
                <th class="p-2">Jumlah</th>
                <th class="p-2">Tanggal Pinjam</th>
                <th class="p-2">Kembali</th>
                <th class="p-2">Status</th>
                <th class="p-2">Aksi</th>
            </tr>
        </thead>

        <tbody>
            @foreach($loans as $loan)
                <tr>
                    <td>{{ $loan->book->judul }}</td>
                    <td>{{ $loan->tanggal_pinjam }}</td>
                    <td>{{ $loan->status }}</td>

                    <td>
                        @if($loan->status == 'approved')
                            <form action="/return-request/{{ $loan->id }}" method="POST">
                                @csrf
                                <button class="bg-yellow-500 text-white px-2 py-1 text-xs rounded">
                                    Kembalikan
                                </button>
                            </form>
                        @endif

                        @if($loan->status == 'return_pending')
                            <span class="text-xs text-gray-500">Menunggu approval</span>
                        @endif

                        @if($loan->status == 'returned')
                            <span class="text-xs text-green-600">Sudah dikembalikan</span>
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

@endsection