@extends('layouts.app')

@section('content')
    <h2 class="text-xl font-bold mb-4">📦 Pengembalian Buku</h2>

    <table class="w-full bg-white shadow rounded">
        <thead>
            <tr class="bg-gray-200">
                <th class="p-2">User</th>
                <th class="p-2">Buku</th>
                <th class="p-2">Jumlah</th>
                <th class="p-2">Tanggal Pinjam</th>
                <th class="p-2">Aksi</th>
            </tr>
        </thead>

        <tbody>
            @foreach($loans as $loan)
                <tr>
                    <td class="p-2">{{ $loan->user->name }}</td>
                    <td class="p-2">{{ $loan->book->judul }}</td>
                    <td class="p-2">{{ $loan->jumlah }}</td>
                    <td class="p-2">{{ $loan->tanggal_pinjam }}</td>
                    <td class="p-2">
                        <form action="/approve-return/{{ $loan->id }}" method="POST">
                            @csrf
                            <button class="bg-green-500 text-white px-3 py-1 rounded text-xs">
                                Approve
                            </button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection