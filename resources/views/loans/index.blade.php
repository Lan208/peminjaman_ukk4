@extends('layouts.app')
@section('content')

<h2 class="text-xl font-bold mb-4">📋 Permintaan Peminjaman</h2>

<table class="w-full bg-white shadow rounded">
    <thead>
        <tr class="bg-gray-200">
            <th class="p-2">User</th>
            <th class="p-2">Buku</th>
            <th class="p-2">Tanggal</th>
            <th class="p-2">Status</th>
            <th class="p-2">Aksi</th>
        </tr>
    </thead>

    <tbody>
        @foreach($loans as $l)
        <tr class="border-b">
            <td class="p-2">{{ $l->user->name }}</td>
            <td class="p-2">{{ $l->book->judul }}</td>
            <td class="p-2">{{ $l->tanggal_pinjam }}</td>
            <td class="p-2">{{ $l->status }}</td>

            <td class="p-2">
                @if($l->status == 'pending')

                <form action="/loans/{{ $l->id }}/approve" method="POST" class="inline">
                    @csrf
                    <button class="bg-green-500 text-white px-2 py-1 rounded">Approve</button>
                </form>

                <form action="/loans/{{ $l->id }}/reject" method="POST" class="inline">
                    @csrf
                    <button class="bg-red-500 text-white px-2 py-1 rounded">Reject</button>
                </form>

                @else
                    <span class="text-gray-500">Selesai</span>
                @endif
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

@endsection