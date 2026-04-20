@extends('layouts.app')
@section('content')

    <h2 class="text-xl font-bold mb-4">📚 History Peminjaman</h2>

    <table class="w-full bg-white shadow rounded">
        <thead>
            <tr class="bg-gray-200">
                <th class="p-2">Buku</th>
                <th class="p-2">Tanggal</th>
                <th class="p-2">Status</th>
            </tr>
        </thead>

        <tbody>
            @foreach($loans as $l)
                        <tr class="border-b">
                            <td class="p-2">{{ $l->book->judul }}</td>
                            <td class="p-2">{{ $l->tanggal_pinjam }}</td>
                            <td class="p-2">
                                <span class="
                                            @if($l->status == 'approved') text-green-500
                                            @elseif($l->status == 'rejected') text-red-500
                                            @else text-yellow-500
                                            @endif
                                        ">
                                    {{ $l->status }}
                                </span>
                            </td>
                            @if($l->status == 'approved')
                                <form action="/loans/{{ $l->id }}/request-return" method="POST">
                                    @csrf
                                    <button class="bg-blue-500 text-white px-2 py-1 rounded text-xs">
                                        Ajukan Pengembalian
                                    </button>
                                </form>
                            @endif

                            @if($l->status == 'return_pending')
                    <span class="text-yellow-500 text-xs">Menunggu approval</span>
                @endif
                        </tr>
            @endforeach
        </tbody>
    </table>

@endsection